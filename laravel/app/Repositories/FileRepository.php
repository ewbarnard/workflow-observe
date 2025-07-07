<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\DimFile;
use App\Models\FactFileProcessing;
use Carbon\Carbon;

class FileRepository
{
    public function getFiles($filters = [])
    {
        $query = DimFile::query();

        if (isset($filters['file_type'])) {
            $query->where('file_type', $filters['file_type']);
        }

        if (isset($filters['directory'])) {
            $query->where('directory_path', 'like', "%{$filters['directory']}%");
        }

        return $query->paginate(20);
    }

    public function findFile($id)
    {
        return DimFile::findOrFail($id);
    }

    public function createFile(array $data)
    {
        return DimFile::create($data);
    }

    public function recordFileProcessing(
        $fileId,
        $versionId,
        $stageId,
        $statusId,
        $batchId = null,
        $errorMessage = null
    ) {
        return FactFileProcessing::create([
            'dim_file_id' => $fileId,
            'dim_version_id' => $versionId,
            'dim_stage_id' => $stageId,
            'dim_status_id' => $statusId,
            'process_timestamp' => Carbon::now(),
            'dim_batch_id' => $batchId,
            'error_message' => $errorMessage,
        ]);
    }

    public function getFileProcessingHistory($fileId)
    {
        return FactFileProcessing::with(['version', 'stage', 'status', 'batch'])
            ->where('dim_file_id', $fileId)
            ->orderBy('process_timestamp', 'desc')
            ->get()
        ;
    }
}
