<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\DimBatch;
use App\Models\DimBatchFile;
use App\Models\DimFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateBatchFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batches:generate
                            {--limit=0 : Limit the number of batches to process}
                            {--starting-from=0 : Start processing from this batch index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate batch files from markdown files';

    /**
     * The base directory for output files
     *
     * @var string
     */
    protected $baseOutputDir = '/Users/ewb/PhpstormProjects/GitHub/2025/n8n/n8n-workflows-01/Batched-Files/01-Groups';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get command options
        $limit = (int)$this->option('limit');
        $startingFrom = (int)$this->option('starting-from');

        // Statistics to track
        $stats = [
            'total_batches_processed' => 0,
            'total_files_included' => 0,
            'total_bytes_written' => 0,
            'output_directory' => '',
            'start_time' => now()->toIso8601String(),
            'end_time' => null
        ];

        // Create output directory with timestamp
        $timestamp = now()->format('Y-m-d_H:i');
        $outputDir = "{$this->baseOutputDir}/{$timestamp}";

        if (!File::exists($outputDir)) {
            File::makeDirectory($outputDir, 0755, true);
        }

        $stats['output_directory'] = $outputDir;

        // Get all batches
        $query = DimBatch::query();

        if ($startingFrom > 0) {
            $query->skip($startingFrom);
        }

        if ($limit > 0) {
            $query->take($limit);
        }

        $batches = $query->get();

        foreach ($batches as $batch) {
            // Get all files for this batch with their sequence number
            $batchFiles = DimBatchFile::where('dim_batch_id', $batch->id)
                ->orderBy('sequence_number')
                ->with('file')
                ->get()
            ;

            if ($batchFiles->isEmpty()) {
                continue; // Skip empty batches
            }

            $batchContent = '';
            $filesIncluded = 0;

            foreach ($batchFiles as $batchFile) {
                $file = $batchFile->file;

                if (!$file) {
                    continue;
                }

                $filePath = $file->file_path;

                // Check if file exists
                if (!File::exists($filePath)) {
//                    $this->error("File not found: {$filePath}");
                    continue;
                }

                // Read file content
                $content = File::get($filePath);

                // Add metadata header
                $metadata = "---\nsource: {$filePath}\n---\n\n";

                // Add to batch content
                $batchContent .= $metadata . $content . "\n\n";
                $filesIncluded++;
            }

            if ($filesIncluded > 0) {
                // Write batch file
                $batchFilePath = "{$outputDir}/{$batch->batch_name}";
                File::put($batchFilePath, $batchContent);

                // Update statistics
                $stats['total_batches_processed']++;
                $stats['total_files_included'] += $filesIncluded;
                $stats['total_bytes_written'] += strlen($batchContent);
            }
        }

        $stats['end_time'] = now()->toIso8601String();

        // Output statistics as JSON
        $this->line(json_encode($stats));

        return 0;
    }
}
