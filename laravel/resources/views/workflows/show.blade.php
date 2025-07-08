@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Workflow #{{ $workflow->id }}</h3>
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
                                {{ $workflow->snapshot_timestamp ? $workflow->snapshot_timestamp->format('Y-m-d H:i:s') : 'N/A' }}
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
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                  style="background-color: {{ $workflow->configImportStatus->status_color ?? '#ccc' }}; color: white;">
                                                {{ $workflow->configImportStatus->status_name ?? 'Unknown' }}
                                            </span>
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
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                  style="background-color: {{ $workflow->folderSearchStatus->status_color ?? '#ccc' }}; color: white;">
                                                {{ $workflow->folderSearchStatus->status_name ?? 'Unknown' }}
                                            </span>
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
                                            {{ $workflow->folder_search_end_timestamp->diffInSeconds($workflow->folder_search_start_timestamp) }}
                                            s
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>

                                <!-- Additional stages would follow the same pattern -->

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
