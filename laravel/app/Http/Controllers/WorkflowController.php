<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\DimStage;
use App\Models\DimStatus;
use App\Models\FactWorkflowSnapshot;
use App\Repositories\WorkflowRepository;
use Illuminate\Support\Facades\DB;

class WorkflowController extends Controller
{
    protected $workflowRepository;

    public function __construct(WorkflowRepository $workflowRepository)
    {
        $this->workflowRepository = $workflowRepository;
    }

    public function index()
    {
        // Get a virtual "accumulated" view of each workflow execution
        $workflows = DB::table('fact_workflow_snapshots as fws')
            ->select([
                'fws.n8n_execution',
                'v.version_name',
                DB::raw('MIN(fws.created_at) as start_time'),
                DB::raw('MAX(fws.created_at) as last_updated'),
                DB::raw('MAX(fws.total_files_processed) as total_files_processed'),
                DB::raw('MAX(fws.total_batches_created) as total_batches_created'),
                DB::raw('MAX(fws.total_bytes_processed) as total_bytes_processed'),
                DB::raw('MAX(fws.error_count) as error_count'),
                DB::raw('MAX(fws.config_import_dim_status_id) as config_import_dim_status_id'),
                DB::raw('MAX(fws.folder_search_dim_status_id) as folder_search_dim_status_id'),
                DB::raw('MAX(fws.file_search_dim_status_id) as file_search_dim_status_id'),
                DB::raw('MAX(fws.batch_manifest_dim_status_id) as batch_manifest_dim_status_id'),
                DB::raw('MAX(fws.batch_creation_dim_status_id) as batch_creation_dim_status_id'),
                DB::raw('MAX(fws.config_import_end_timestamp) as config_import_end_timestamp'),
                DB::raw('MAX(fws.folder_search_end_timestamp) as folder_search_end_timestamp'),
                DB::raw('MAX(fws.file_search_end_timestamp) as file_search_end_timestamp'),
                DB::raw('MAX(fws.batch_manifest_end_timestamp) as batch_manifest_end_timestamp'),
                DB::raw('MAX(fws.batch_creation_end_timestamp) as batch_creation_end_timestamp'),
                // Get the ID of the latest record for linking purposes
                DB::raw('MAX(fws.id) as latest_id'),
            ])
            ->leftJoin('dim_versions as v', 'fws.dim_version_id', '=', 'v.id')
            ->groupBy('fws.n8n_execution', 'v.version_name')
            ->orderBy('start_time', 'desc')
            ->paginate(20)
        ;

        return view('workflows.index', compact('workflows'));
    }

    public function show($id)
    {
        // Get the original record to find the n8n_execution value
        $originalRecord = FactWorkflowSnapshot::findOrFail($id);

        // Get all snapshots for this execution
        $snapshots = FactWorkflowSnapshot::where('n8n_execution', $originalRecord->n8n_execution)
            ->orderBy('created_at', 'asc')
            ->get()
        ;

        // Create an accumulated view by merging all snapshots
        $workflow = (object)[
            'id' => $originalRecord->id,
            'n8n_execution' => $originalRecord->n8n_execution,
            'version' => $originalRecord->version,
            'created_at' => $snapshots->first()->created_at,
            'updated_at' => $snapshots->last()->updated_at,
            'total_files_processed' => $snapshots->max('total_files_processed'),
            'total_batches_created' => $snapshots->max('total_batches_created'),
            'total_bytes_processed' => $snapshots->max('total_bytes_processed'),
            'error_count' => $snapshots->max('error_count'),
            'statuses' => [], // Add an array to store status objects explicitly
            'stages' => [],    // Add an array to store stage objects explicitly
        ];

        // Debug array to help troubleshoot issues
        $debug = [];

        // Accumulate all stage information
        foreach (['config_import', 'folder_search', 'file_search', 'batch_manifest', 'batch_creation'] as $stage) {
            // Get the latest non-null values for each stage field
            $workflow->{$stage . '_dim_stage_id'} =
                $snapshots->whereNotNull($stage . '_dim_stage_id')->last()?->{$stage . '_dim_stage_id'};
            $workflow->{$stage . '_dim_status_id'} =
                $snapshots->whereNotNull($stage . '_dim_status_id')->last()?->{$stage . '_dim_status_id'};
            $workflow->{$stage . '_start_timestamp'} =
                $snapshots->whereNotNull($stage . '_start_timestamp')->first()?->{$stage . '_start_timestamp'};
            $workflow->{$stage . '_end_timestamp'} =
                $snapshots->whereNotNull($stage . '_end_timestamp')->last()?->{$stage . '_end_timestamp'};

            // Add debug data
            $debug[$stage] = [
                'dim_status_id' => $workflow->{$stage . '_dim_status_id'},
                'dim_stage_id' => $workflow->{$stage . '_dim_stage_id'},
                'start_timestamp' => $workflow->{$stage . '_start_timestamp'},
                'end_timestamp' => $workflow->{$stage . '_end_timestamp'},
            ];

            // Load the related status and store it in the statuses array
            if ($workflow->{$stage . '_dim_status_id'}) {
                $statusRecord = DimStatus::find($workflow->{$stage . '_dim_status_id'});

                // Store both ways - as a property and in the array
                $workflow->statuses[$stage] = $statusRecord;
                $workflow->{$stage . '_status'} = $statusRecord; // Changed property name format

                $debug[$stage]['status_record'] = $statusRecord ? [
                    'id' => $statusRecord->id,
                    'name' => $statusRecord->status_name,
                    'color' => $statusRecord->status_color,
                ] : 'Not found';
            }

            // Load the related stage and store it in the stages array
            if ($workflow->{$stage . '_dim_stage_id'}) {
                $stageRecord = DimStage::find($workflow->{$stage . '_dim_stage_id'});

                // Store both ways - as a property and in the array
                $workflow->stages[$stage] = $stageRecord;
                $workflow->{$stage . '_stage'} = $stageRecord; // Changed property name format

                $debug[$stage]['stage_record'] = $stageRecord ? [
                    'id' => $stageRecord->id,
                    'name' => $stageRecord->stage_name,
                ] : 'Not found';
            }
        }

        // Add debug data to workflow
        $workflow->debug = $debug;

        return view('workflows.show', compact('workflow', 'snapshots'));
    }
}
