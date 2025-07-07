<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\WorkflowRepository;
use App\Repositories\FileRepository;
use App\Repositories\BatchRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $workflowRepository;
    protected $fileRepository;
    protected $batchRepository;

    public function __construct(
        WorkflowRepository $workflowRepository,
        FileRepository $fileRepository,
        BatchRepository $batchRepository
    ) {
        $this->workflowRepository = $workflowRepository;
        $this->fileRepository = $fileRepository;
        $this->batchRepository = $batchRepository;
    }

    public function index()
    {
        $currentWorkflow = $this->workflowRepository->getCurrentWorkflow();
        $recentFiles = $this->fileRepository->getFiles()->take(5);
        $recentBatches = $this->batchRepository->getBatches()->take(5);

        return view('dashboard.index', compact('currentWorkflow', 'recentFiles', 'recentBatches'));
    }
}
