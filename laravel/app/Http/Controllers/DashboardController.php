<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\FactWorkflowSnapshot;
use App\Models\DimFile;
use App\Models\DimBatch;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $currentWorkflow = FactWorkflowSnapshot::with([
            'version',
            'configImportStage',
            'configImportStatus',
            // Add other relationships as needed
        ])
            ->orderBy('snapshot_timestamp', 'desc')
            ->first()
        ;

        $recentFiles = DimFile::latest()->take(5)->get();
        $recentBatches = DimBatch::latest()->take(5)->get();

        return view('dashboard.index', compact('currentWorkflow', 'recentFiles', 'recentBatches'));
    }
}
