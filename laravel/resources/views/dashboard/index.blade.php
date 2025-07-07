<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Current Workflow Status</h3>

                    @if ($currentWorkflow)
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
                            <div class="p-4 border rounded-lg">
                                <h4 class="font-medium text-gray-700">Config Import</h4>
                                <div class="mt-2 inline-block px-2 py-1 rounded-full text-xs"
                                     style="background-color: {{ $currentWorkflow->configImportStatus->status_color ?? '#ccc' }}">
                                    {{ $currentWorkflow->configImportStatus->status_name ?? 'Not Started' }}
                                </div>
                            </div>

                            <div class="p-4 border rounded-lg">
                                <h4 class="font-medium text-gray-700">Folder Search</h4>
                                <div class="mt-2 inline-block px-2 py-1 rounded-full text-xs"
                                     style="background-color: {{ $currentWorkflow->folderSearchStatus->status_color ?? '#ccc' }}">
                                    {{ $currentWorkflow->folderSearchStatus->status_name ?? 'Not Started' }}
                                </div>
                            </div>

                            <div class="p-4 border rounded-lg">
                                <h4 class="font-medium text-gray-700">File Search</h4>
                                <div class="mt-2 inline-block px-2 py-1 rounded-full text-xs"
                                     style="background-color: {{ $currentWorkflow->fileSearchStatus->status_color ?? '#ccc' }}">
                                    {{ $currentWorkflow->fileSearchStatus->status_name ?? 'Not Started' }}
                                </div>
                            </div>

                            <div class="p-4 border rounded-lg">
                                <h4 class="font-medium text-gray-700">Batch Manifest</h4>
                                <div class="mt-2 inline-block px-2 py-1 rounded-full text-xs"
                                     style="background-color: {{ $currentWorkflow->batchManifestStatus->status_color ?? '#ccc' }}">
                                    {{ $currentWorkflow->batchManifestStatus->status_name ?? 'Not Started' }}
                                </div>
                            </div>

                            <div class="p-4 border rounded-lg">
                                <h4 class="font-medium text-gray-700">Batch Creation</h4>
                                <div class="mt-2 inline-block px-2 py-1 rounded-full text-xs"
                                     style="background-color: {{ $currentWorkflow->batchCreationStatus->status_color ?? '#ccc' }}">
                                    {{ $currentWorkflow->batchCreationStatus->status_name ?? 'Not Started' }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 text-sm">Files Processed</span>
                                <p class="text-2xl font-bold">{{ $currentWorkflow->total_files_processed }}</p>
                            </div>

                            <div class="p-4 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 text-sm">Batches Created</span>
                                <p class="text-2xl font-bold">{{ $currentWorkflow->total_batches_created }}</p>
                            </div>

                            <div class="p-4 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 text-sm">Errors</span>
                                <p class="text-2xl font-bold">{{ $currentWorkflow->error_count }}</p>
                            </div>
                        </div>
                    @else
                        <div class="text-gray-500">No workflow in progress</div>
                        <a href="{{ route('workflows.create') }}"
                           class="mt-2 inline-block px-4 py-2 bg-blue-500 text-white rounded-md">
                            Start New Workflow
                        </a>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Recent Files</h3>

                        @if ($recentFiles->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            File Name
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
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
                                                    {{ $file->file_name }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ $file->file_type }}
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

                        @if ($recentBatches->count() > 0)
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
                                                {{ number_format($batch->batch_size_bytes / 1024, 2) }} KB
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
</x-app-layout>
