<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\BatchRepository;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    protected $batchRepository;

    public function __construct(BatchRepository $batchRepository)
    {
        $this->batchRepository = $batchRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name']);
        $batches = $this->batchRepository->getBatches($filters);

        return view('batches.index', compact('batches', 'filters'));
    }

    public function show($id)
    {
        $batch = $this->batchRepository->findBatch($id);
        $files = $this->batchRepository->getBatchFiles($id);

        return view('batches.show', compact('batch', 'files'));
    }
}
