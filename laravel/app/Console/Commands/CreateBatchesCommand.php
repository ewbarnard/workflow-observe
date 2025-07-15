<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\DimBatch;
use App\Models\DimBatchFile;
use App\Models\DimDirectory;
use App\Models\DimFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateBatchesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batches:create
                            {--limit=0 : Limit the number of directories to process}
                            {--starting-from=0 : Start processing from this directory index}
                            {--dry-run : Run without creating database records}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create batches of markdown files for LLM processing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get command options
        $limit = (int)$this->option('limit');
        $startingFrom = (int)$this->option('starting-from');
        $dryRun = $this->option('dry-run');

        // Statistics to track
        $stats = [
            'total_directories_processed' => 0,
            'total_files_processed' => 0,
            'total_batches_created' => 0,
            'total_bytes_processed' => 0,
            'start_time' => now()->toIso8601String(),
            'end_time' => null
        ];

        // Get all directories sorted by creation timestamp
        $query = DimDirectory::orderBy('creation_timestamp');

        if ($startingFrom > 0) {
            $query->skip($startingFrom);
        }

        if ($limit > 0) {
            $query->take($limit);
        }

        $directories = $query->get();

        foreach ($directories as $directory) {
            // Get all files for this directory
            $files = DimFile::where('dim_directory_id', $directory->id)
                ->orderBy('file_path')
                ->get()
            ;

            if ($files->isEmpty()) {
                continue; // Skip empty directories
            }

            $index = 0;
            $totalFiles = $files->count();

            while ($index < $totalFiles) {
                $batchFiles = [];
                $batchSize = 0;

                // Always add at least one file to the batch
                $batchFiles[] = $files[$index];
                $batchSize += $files[$index]->file_size_bytes;
                $index++;

                // Try to add more files until we reach target size
                while ($index < $totalFiles && $batchSize < 50000) {
                    // Check if adding the next file would exceed 75K
                    if ($batchSize + $files[$index]->file_size_bytes > 75000) {
                        break; // Don't add this file
                    }

                    // Add the file to the batch
                    $batchFiles[] = $files[$index];
                    $batchSize += $files[$index]->file_size_bytes;
                    $index++;
                }

                // Create the batch (unless in dry-run mode)
                if (!$dryRun) {
                    $this->createBatch($directory, $batchFiles, $batchSize);
                }

                // Update statistics
                $stats['total_batches_created']++;
                $stats['total_files_processed'] += count($batchFiles);
                $stats['total_bytes_processed'] += $batchSize;
            }

            $stats['total_directories_processed']++;
        }

        $stats['end_time'] = now()->toIso8601String();

        // Output statistics as JSON
        $this->line(json_encode($stats));

        return 0;
    }

    /**
     * Create a batch from the given files
     */
    private function createBatch($directory, $files, $totalSize)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create batch record
            $batch = new DimBatch();
            $batch->dim_directory_id = $directory->id;
            $batch->total_bytes = $totalSize;
            $batch->file_count = count($files);
            $batch->save();

            // Now that we have the batch ID, set the batch name
            $timestamp = $directory->creation_timestamp->format('Y-m-d_H-i');
            $batchName = "{$timestamp}_{$batch->id}.md";

            $batch->batch_name = $batchName;
            $batch->save();

            // Create batch file records
            foreach ($files as $index => $file) {
                $batchFile = new DimBatchFile();
                $batchFile->dim_batch_id = $batch->id;
                $batchFile->dim_file_id = $file->id;
                $batchFile->sequence_number = $index + 1;
                $batchFile->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
