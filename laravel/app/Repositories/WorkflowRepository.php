<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\DimVersion;
use App\Models\FactWorkflowSnapshot;
use Carbon\Carbon;

class WorkflowRepository
{
    public function getCurrentWorkflow()
    {
        return FactWorkflowSnapshot::with([
            'version',
            'configImportStage',
            'configImportStatus',
            // Add other relationships as needed
        ])
            ->orderBy('snapshot_timestamp', 'desc')
            ->first()
        ;
    }

    public function createWorkflowSnapshot(array $data)
    {
        return FactWorkflowSnapshot::create(array_merge($data, [
            'snapshot_timestamp' => Carbon::now(),
        ]));
    }

    public function updateWorkflowStage($workflowId, $stageName, $status, $isStart = true)
    {
        $workflow = FactWorkflowSnapshot::findOrFail($workflowId);
        $fieldPrefix = str_replace(' ', '_', strtolower($stageName));

        if ($isStart) {
            $workflow->update([
                "{$fieldPrefix}_dim_stage_id" => $stageName,
                "{$fieldPrefix}_dim_status_id" => $status,
                "{$fieldPrefix}_start_timestamp" => Carbon::now(),
            ]);
        } else {
            $workflow->update([
                "{$fieldPrefix}_dim_status_id" => $status,
                "{$fieldPrefix}_end_timestamp" => Carbon::now(),
            ]);
        }

        return $workflow;
    }

    public function getVersions()
    {
        return DimVersion::where('active_flag', 1)->get();
    }
}
