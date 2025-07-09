<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimBatchFile extends Model
{
    use HasFactory;

    protected $table = 'dim_batch_files';

    public function batch()
    {
        return $this->belongsTo(DimBatch::class, 'dim_batch_id');
    }

    public function file()
    {
        return $this->belongsTo(DimFile::class, 'dim_file_id');
    }
}
