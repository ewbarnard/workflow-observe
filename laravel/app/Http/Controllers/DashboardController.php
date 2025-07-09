<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\DimStage;
use App\Models\DimStatus;
use App\Models\DimFile;
use App\Models\DimBatch;
use App\Models\FactWorkflowSnapshot;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the latest workflow execution
        $latestWorkflow = FactWorkflowSnapshot::orderBy('created_at', 'desc')
            ->first()
        ;

        $currentWorkflow = null;

        // If we have a workflow, accumulate all stage information
        if ($latestWorkflow) {
            // Get all snapshots for this execution
            $snapshots = FactWorkflowSnapshot::where('n8n_execution', $latestWorkflow->n8n_execution)
                ->orderBy('created_at', 'asc')
                ->get()
            ;

            // Create an accumulated view by merging all snapshots
            $currentWorkflow = (object)[
                'id' => $latestWorkflow->id,
                'n8n_execution' => $latestWorkflow->n8n_execution,
                'dim_version_id' => $latestWorkflow->dim_version_id,
                'created_at' => $snapshots->first()->created_at,
                'updated_at' => $snapshots->last()->updated_at,
                'total_files_processed' => $snapshots->max('total_files_processed'),
                'total_batches_created' => $snapshots->max('total_batches_created'),
                'total_bytes_processed' => $snapshots->max('total_bytes_processed'),
                'error_count' => $snapshots->max('error_count'),
            ];

            // Accumulate all stage information
            foreach (['config_import', 'folder_search', 'file_search', 'batch_manifest', 'batch_creation'] as $stage) {
                // Get the latest non-null values for each stage field
                $currentWorkflow->{$stage . '_dim_stage_id'} =
                    $snapshots->whereNotNull($stage . '_dim_stage_id')->last()?->{$stage . '_dim_stage_id'};
                $currentWorkflow->{$stage . '_dim_status_id'} =
                    $snapshots->whereNotNull($stage . '_dim_status_id')->last()?->{$stage . '_dim_status_id'};
                $currentWorkflow->{$stage . '_start_timestamp'} =
                    $snapshots->whereNotNull($stage . '_start_timestamp')->first()?->{$stage . '_start_timestamp'};
                $currentWorkflow->{$stage . '_end_timestamp'} =
                    $snapshots->whereNotNull($stage . '_end_timestamp')->last()?->{$stage . '_end_timestamp'};

                // Load the related status
                if ($currentWorkflow->{$stage . '_dim_status_id'}) {
                    $statusRecord = DimStatus::find($currentWorkflow->{$stage . '_dim_status_id'});
                    $currentWorkflow->{$stage . 'Status'} = $statusRecord;
                }

                // Load the related stage
                if ($currentWorkflow->{$stage . '_dim_stage_id'}) {
                    $stageRecord = DimStage::find($currentWorkflow->{$stage . '_dim_stage_id'});
                    $currentWorkflow->{$stage . 'Stage'} = $stageRecord;
                }
            }
        }

        // Get recent files
        $recentFiles = DimFile::orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
        ;

        // Get recent batches
        $recentBatches = DimBatch::with(['batchFiles.file'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
        ;

        return view('dashboard.index', compact('currentWorkflow', 'recentFiles', 'recentBatches'));
    }
}
