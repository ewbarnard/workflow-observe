<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\FileRepository;
use Illuminate\Http\Request;

class FileController extends Controller
{
    protected $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['file_type', 'directory']);
        $files = $this->fileRepository->getFiles($filters);

        return view('files.index', compact('files', 'filters'));
    }

    public function show($id)
    {
        $file = $this->fileRepository->findFile($id);
        $processings = $this->fileRepository->getFileProcessingHistory($id);

        return view('files.show', compact('file', 'processings'));
    }
}
