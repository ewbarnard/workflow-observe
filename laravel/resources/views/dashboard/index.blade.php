@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Current Workflow Status</h3>

                    @if(isset($currentWorkflow))
                        <!-- Update this part to properly display the workflow status -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Current Workflow:
                                #{{ $currentWorkflow->n8n_execution }}</h3>


                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Files Processed -->
                                <div class="bg-white p-4 rounded shadow">
                                    <h4 class="text-sm font-medium text-gray-500">Files Processed</h4>
                                    <p class="text-2xl font-bold">{{ $currentWorkflow->total_files_processed }}</p>
                                </div>

                                <!-- Batches Created -->
                                <div class="bg-white p-4 rounded shadow">
                                    <h4 class="text-sm font-medium text-gray-500">Batches Created</h4>
                                    <p class="text-2xl font-bold">{{ $currentWorkflow->total_batches_created }}</p>
                                </div>

                                <!-- Current Status -->
                                <div class="bg-white p-4 rounded shadow">
                                    <h4 class="text-sm font-medium text-gray-500">Current Status</h4>
                                    @php
                                        $lastStage = 'Not Started';
                                        $statusName = '';
                                        $color = '#ccc';

                                        if($currentWorkflow->batch_creation_dim_status_id) {
                                            $lastStage = 'Batch Creation';
                                            $status = $currentWorkflow->batch_creationStatus ?? null;
                                        } elseif($currentWorkflow->batch_manifest_dim_status_id) {
                                            $lastStage = 'Batch Manifest';
                                            $status = $currentWorkflow->batch_manifestStatus ?? null;
                                        } elseif($currentWorkflow->file_search_dim_status_id) {
                                            $lastStage = 'File Search';
                                            $status = $currentWorkflow->file_searchStatus ?? null;
                                        } elseif($currentWorkflow->folder_search_dim_status_id) {
                                            $lastStage = 'Folder Search';
                                            $status = $currentWorkflow->folder_searchStatus ?? null;
                                        } elseif($currentWorkflow->config_import_dim_status_id) {
                                            $lastStage = 'Config Import';
                                            $status = $currentWorkflow->config_importStatus ?? null;
                                        }

                                        // If completed all stages
                                        if($currentWorkflow->batch_creation_end_timestamp) {
                                            $lastStage = 'Workflow';
                                            $statusName = 'Completed';
                                            $color = '#22c55e'; // Green
                                        }
                                        // If we have a status object
                                        elseif(isset($status)) {
                                            $statusName = $status->status_name;
                                            $color = $status->status_color;
                                        }
                                    @endphp
                                    <p class="inline-flex items-center mt-1">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full"
                                              style="background-color: {{ $color }}; color: white;">
                                            {{ $lastStage }} {{ $statusName ? "- $statusName" : "" }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-6">
                            <div class="bg-gray-50 p-4 rounded-md">
                                <p class="text-gray-600">No workflows found.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Recent Files</h3>

                        @if (isset($recentFiles) && $recentFiles->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            File Path
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Directory
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Size
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($recentFiles as $file)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('files.show', $file->id) }}"
                                                   class="text-blue-500 hover:underline">
                                                    {{ basename($file->file_path) }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ basename(dirname($file->file_path)) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ number_format($file->file_size_bytes / 1024, 2) }} KB
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('files.index') }}" class="text-blue-500 hover:underline">View all
                                    files</a>
                            </div>
                        @else
                            <div class="text-gray-500">No files processed yet</div>
                        @endif
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Recent Batches</h3>

                        @if (isset($recentBatches) && $recentBatches->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Batch Name
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Files
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Size
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($recentBatches as $batch)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('batches.show', $batch->id) }}"
                                                   class="text-blue-500 hover:underline">
                                                    {{ $batch->batch_name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $batch->file_count }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ number_format($batch->total_bytes / 1024, 2) }} KB
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('batches.index') }}" class="text-blue-500 hover:underline">View all
                                    batches</a>
                            </div>
                        @else
                            <div class="text-gray-500">No batches created yet</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
