@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Workflow #{{ $workflow->n8n_execution }}</h3>
                        <a href="{{ route('workflows.index') }}" class="text-blue-500 hover:underline">
                            Back to Workflows
                        </a>
                    </div>

                    <div class="mb-6">
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-t-md">
                            <dt class="text-sm font-medium text-gray-500">Version</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $workflow->version->version_name ?? 'Unknown' }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Start Time</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $workflow->created_at ? $workflow->created_at->format('Y-m-d H:i:s') : 'N/A' }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Files Processed</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $workflow->total_files_processed ?? 0 }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Batches Created</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $workflow->total_batches_created ?? 0 }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Total Size</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ number_format(($workflow->total_bytes_processed ?? 0) / 1024, 2) }} KB
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 rounded-b-md">
                            <dt class="text-sm font-medium text-gray-500">Errors</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $workflow->error_count ?? 0 }}
                            </dd>
                        </div>
                    </div>

                    <h4 class="font-medium text-lg mb-4">Workflow Stages</h4>

                    <div class="mb-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        Stage
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Status
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Start Time
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        End Time
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Duration
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">

                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        Config Import
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @if($workflow->config_import_dim_status_id)
                                            @php
                                                // Get the status from the statuses array as a fallback
                                                $status = $workflow->config_import_status ?? ($workflow->statuses['config_import'] ?? null);
                                            @endphp
                                            @if($status)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                    style="background-color: {{ $status->status_color }}; color: white;">
                                                    {{ $status->status_name }}
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                    style="background-color: #ccc; color: white;">
                                                    Status ID: {{ $workflow->config_import_dim_status_id }} (Not Found)
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-500">Not Started</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $workflow->config_import_start_timestamp ? $workflow->config_import_start_timestamp->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $workflow->config_import_end_timestamp ? $workflow->config_import_end_timestamp->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @if($workflow->config_import_start_timestamp && $workflow->config_import_end_timestamp)
                                            {{ $workflow->config_import_end_timestamp->diffInSeconds($workflow->config_import_start_timestamp) }}
                                            s
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        Folder Search
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @if($workflow->folder_search_dim_status_id)
                                            @php
                                                // Get the status from the statuses array as a fallback
                                                $status = $workflow->folder_search_status ?? ($workflow->statuses['folder_search'] ?? null);
                                            @endphp
                                            @if($status)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                    style="background-color: {{ $status->status_color }}; color: white;">
                                                    {{ $status->status_name }}
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                    style="background-color: #ccc; color: white;">
                                                    Status ID: {{ $workflow->folder_search_dim_status_id }} (Not Found)
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-500">Not Started</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $workflow->folder_search_start_timestamp ? $workflow->folder_search_start_timestamp->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $workflow->folder_search_end_timestamp ? $workflow->folder_search_end_timestamp->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @if($workflow->folder_search_start_timestamp && $workflow->folder_search_end_timestamp)
                                            {{ abs($workflow->folder_search_end_timestamp->diffInSeconds($workflow->folder_search_start_timestamp)) }}
                                            s
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>

                                <!-- File Search Row -->
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        File Search
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @if($workflow->file_search_dim_status_id)
                                            @php
                                                // Get the status from the statuses array as a fallback
                                                $status = $workflow->file_search_status ?? ($workflow->statuses['file_search'] ?? null);
                                            @endphp
                                            @if($status)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                    style="background-color: {{ $status->status_color }}; color: white;">
                                                    {{ $status->status_name }}
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                    style="background-color: #ccc; color: white;">
                                                    Status ID: {{ $workflow->file_search_dim_status_id }} (Not Found)
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-500">Not Started</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $workflow->file_search_start_timestamp ? $workflow->file_search_start_timestamp->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $workflow->file_search_end_timestamp ? $workflow->file_search_end_timestamp->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @if($workflow->file_search_start_timestamp && $workflow->file_search_end_timestamp)
                                            {{ $workflow->file_search_end_timestamp->diffInSeconds($workflow->file_search_start_timestamp) }}
                                            s
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>

                                <!-- Batch Manifest Row -->
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        Batch Manifest
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @if($workflow->batch_manifest_dim_status_id)
                                            @php
                                                // Get the status from the statuses array as a fallback
                                                $status = $workflow->batch_manifest_status ?? ($workflow->statuses['batch_manifest'] ?? null);
                                            @endphp
                                            @if($status)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                    style="background-color: {{ $status->status_color }}; color: white;">
                                                    {{ $status->status_name }}
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                    style="background-color: #ccc; color: white;">
                                                    Status ID: {{ $workflow->batch_manifest_dim_status_id }} (Not Found)
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-500">Not Started</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $workflow->batch_manifest_start_timestamp ? $workflow->batch_manifest_start_timestamp->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $workflow->batch_manifest_end_timestamp ? $workflow->batch_manifest_end_timestamp->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @if($workflow->batch_manifest_start_timestamp && $workflow->batch_manifest_end_timestamp)
                                            {{ $workflow->batch_manifest_end_timestamp->diffInSeconds($workflow->batch_manifest_start_timestamp) }}
                                            s
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>

                                <!-- Batch Creation Row -->
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        Batch Creation
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        @if($workflow->batch_creation_dim_status_id)
                                            @php
                                                // Get the status from the statuses array as a fallback
                                                $status = $workflow->batch_creation_status ?? ($workflow->statuses['batch_creation'] ?? null);
                                            @endphp
                                            @if($status)
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                    style="background-color: {{ $status->status_color }}; color: white;">
                                                    {{ $status->status_name }}
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                    style="background-color: #ccc; color: white;">
                                                    Status ID: {{ $workflow->batch_creation_dim_status_id }} (Not Found)
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-500">Not Started</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $workflow->batch_creation_start_timestamp ? $workflow->batch_creation_start_timestamp->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ $workflow->batch_creation_end_timestamp ? $workflow->batch_creation_end_timestamp->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @if($workflow->batch_creation_start_timestamp && $workflow->batch_creation_end_timestamp)
                                            {{ $workflow->batch_creation_end_timestamp->diffInSeconds($workflow->batch_creation_start_timestamp) }}
                                            s
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Add after the workflow stages section -->

                    @if(isset($snapshots) && $snapshots->count() > 1)
                        <h4 class="font-medium text-lg mb-4 mt-8">Workflow History</h4>
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Snapshot
                                        Time
                                    </th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Files
                                        Processed
                                    </th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Batches
                                        Created
                                    </th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Current
                                        Stage
                                    </th>
                                    <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($snapshots as $snapshot)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                            {{ $snapshot->updated_at->format('Y-m-d H:i:s') }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $snapshot->total_files_processed }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $snapshot->total_batches_created }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            @php
                                                $currentStage = 'Not Started';
                                                $stageStatusId = null;

                                                if ($snapshot->batch_creation_dim_status_id) {
                                                    $currentStage = 'Batch Creation';
                                                    $stageStatusId = $snapshot->batch_creation_dim_status_id;
                                                }
                                                elseif ($snapshot->batch_manifest_dim_status_id) {
                                                    $currentStage = 'Batch Manifest';
                                                    $stageStatusId = $snapshot->batch_manifest_dim_status_id;
                                                }
                                                elseif ($snapshot->file_search_dim_status_id) {
                                                    $currentStage = 'File Search';
                                                    $stageStatusId = $snapshot->file_search_dim_status_id;
                                                }
                                                elseif ($snapshot->folder_search_dim_status_id) {
                                                    $currentStage = 'Folder Search';
                                                    $stageStatusId = $snapshot->folder_search_dim_status_id;
                                                }
                                                elseif ($snapshot->config_import_dim_status_id) {
                                                    $currentStage = 'Config Import';
                                                    $stageStatusId = $snapshot->config_import_dim_status_id;
                                                }
                                            @endphp
                                            {{ $currentStage }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            @if($stageStatusId)
                                                @php
                                                    $status = App\Models\DimStatus::find($stageStatusId);
                                                @endphp
                                                @if($status)
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                        style="background-color: {{ $status->status_color }}; color: white;">
                                                        {{ $status->status_name }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-500">Unknown</span>
                                                @endif
                                            @else
                                                <span class="text-gray-500">Not Started</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
