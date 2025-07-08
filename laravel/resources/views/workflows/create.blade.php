@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Start New Workflow</h3>

                    <form action="{{ route('workflows.start') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="dim_version_id" class="block text-sm font-medium text-gray-700">Version</label>
                            <select id="dim_version_id" name="dim_version_id"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @foreach(\App\Models\DimVersion::where('active_flag', 1)->get() as $version)
                                    <option value="{{ $version->id }}">{{ $version->version_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit"
                                    class="ml-4 inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Start Workflow
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
