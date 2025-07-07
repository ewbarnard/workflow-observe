<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\DimBatch;
use App\Models\FactBatchFileMap;
use Carbon\Carbon;

class BatchRepository
{
    public function getBatches($filters = [])
    {
        $query = DimBatch::query();

        if (isset($filters['name'])) {
            $query->where('batch_name', 'like', "%{$filters['name']}%");
        }

        return $query->paginate(20);
    }

    public function findBatch($id)
    {
        return DimBatch::with('files')->findOrFail($id);
    }

    public function createBatch(array $data)
    {
        return DimBatch::create(array_merge($data, [
            'batch_created_timestamp' => Carbon::now(),
        ]));
    }

    public function addFileToBatch($batchId, $fileId, $sequence, $startPos, $endPos)
    {
        return FactBatchFileMap::create([
            'dim_batch_id' => $batchId,
            'dim_file_id' => $fileId,
            'file_sequence_in_batch' => $sequence,
            'file_start_position' => $startPos,
            'file_end_position' => $endPos,
        ]);
    }

    public function getBatchFiles($batchId)
    {
        return FactBatchFileMap::with('file')
            ->where('dim_batch_id', $batchId)
            ->orderBy('file_sequence_in_batch')
            ->get()
        ;
    }
}
