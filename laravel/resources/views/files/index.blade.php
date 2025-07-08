@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Files</h3>

                        <!-- Search and filters -->
                        <form method="GET" action="{{ route('files.index') }}" class="flex space-x-2">
                            <div>
                                <input type="text" name="directory" value="{{ $filters['directory'] ?? '' }}"
                                       placeholder="Filter by directory"
                                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div>
                                <select name="file_type"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">All file types</option>
                                    <option
                                        value="csv" {{ isset($filters['file_type']) && $filters['file_type'] == 'csv' ? 'selected' : '' }}>
                                        CSV
                                    </option>
                                    <option
                                        value="txt" {{ isset($filters['file_type']) && $filters['file_type'] == 'txt' ? 'selected' : '' }}>
                                        TXT
                                    </option>
                                    <option
                                        value="json" {{ isset($filters['file_type']) && $filters['file_type'] == 'json' ? 'selected' : '' }}>
                                        JSON
                                    </option>
                                    <!-- Add more file types as needed -->
                                </select>
                            </div>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Filter
                            </button>
                        </form>
                    </div>

                    @if(isset($files) && $files->count() > 0)
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
                                        Directory
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Size
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Created
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($files as $file)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('files.show', $file->id) }}"
                                               class="text-blue-500 hover:underline">
                                                {{ $file->file_name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ strtoupper($file->file_type) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $file->directory_path }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ number_format($file->file_size_bytes / 1024, 2) }} KB
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $file->file_created_timestamp ? $file->file_created_timestamp->format('Y-m-d H:i:s') : 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $files->links() }}
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-gray-600">No files found matching your criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
