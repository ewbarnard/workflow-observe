<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimBatch extends Model
{
    use HasFactory;

    protected $table = 'dim_batches';

    public function directory()
    {
        return $this->belongsTo(DimDirectory::class, 'dim_directory_id');
    }

    public function batchFiles()
    {
        return $this->hasMany(DimBatchFile::class, 'dim_batch_id');
    }
}
