@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Workflow Executions</h3>
                        <!-- Create Workflow button removed as requested -->
                    </div>

                    @if(isset($workflows) && $workflows->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Execution
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Version
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Start Time
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Files
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Batches
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">

                                @foreach($workflows as $workflow)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('workflows.show', $workflow->latest_id) }}"
                                               class="text-blue-500 hover:underline">
                                                #{{ $workflow->n8n_execution }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $workflow->version_name ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $workflow->start_time ? \Carbon\Carbon::parse($workflow->start_time)->format('Y-m-d H:i:s') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $workflow->total_files_processed ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $workflow->total_batches_created ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $lastStage = 'Not Started';
                                                $color = '#ccc';

                                                if($workflow->batch_creation_end_timestamp) {
                                                    $lastStage = 'Completed';
                                                    $color = '#22c55e'; // Green
                                                } elseif($workflow->batch_creation_dim_status_id) {
                                                    $lastStage = 'Batch Creation';
                                                    $color = '#3b82f6'; // Blue
                                                } elseif($workflow->batch_manifest_dim_status_id) {
                                                    $lastStage = 'Batch Manifest';
                                                    $color = '#3b82f6';
                                                } elseif($workflow->file_search_dim_status_id) {
                                                    $lastStage = 'File Search';
                                                    $color = '#3b82f6';
                                                } elseif($workflow->folder_search_dim_status_id) {
                                                    $lastStage = 'Folder Search';
                                                    $color = '#3b82f6';
                                                } elseif($workflow->config_import_dim_status_id) {
                                                    $lastStage = $workflow->config_import_end_timestamp ? 'Config Import Complete' : 'Config Import';
                                                    $color = $workflow->config_import_end_timestamp ? '#22c55e' : '#3b82f6';
                                                }
                                            @endphp

                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                  style="background-color: {{ $color }}; color: white;">{{ $lastStage }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $workflows->links() }}
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-gray-600">No workflows found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
