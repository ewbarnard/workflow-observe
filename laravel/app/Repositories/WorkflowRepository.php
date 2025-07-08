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

    public function createWorkflowSnapshot($data)
    {
        // Generate a unique execution ID if not provided
        if (!isset($data['n8n_execution'])) {
            $data['n8n_execution'] = 'n8n_' . uniqid() . '_' . time();
        }

        return FactWorkflowSnapshot::create($data);
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
