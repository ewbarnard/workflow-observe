<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\WorkflowRepository;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    protected $workflowRepository;

    public function __construct(WorkflowRepository $workflowRepository)
    {
        $this->workflowRepository = $workflowRepository;
    }

    public function index()
    {
        $workflows = FactWorkflowSnapshot::with(['version'])
            ->orderBy('snapshot_timestamp', 'desc')
            ->paginate(20)
        ;

        return view('workflows.index', compact('workflows'));
    }

    public function show($id)
    {
        $workflow = FactWorkflowSnapshot::with([
            'version',
            'configImportStage',
            'configImportStatus',
            // Add other stage and status relationships
        ])->findOrFail($id);

        return view('workflows.show', compact('workflow'));
    }

    public function start(Request $request)
    {
        $validated = $request->validate([
            'dim_version_id' => 'required|exists:dim_versions,id',
        ]);

        $workflow = $this->workflowRepository->createWorkflowSnapshot($validated);

        return redirect()->route('workflows.show', $workflow->id)
            ->with('success', 'Workflow started successfully')
        ;
    }
}
