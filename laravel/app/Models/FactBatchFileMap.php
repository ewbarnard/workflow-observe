<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactBatchFileMap extends Model
{
    use HasFactory;

    protected $table = 'fact_batch_file_maps';

    protected $fillable = [
        'dim_batch_id',
        'dim_file_id',
        'file_sequence_in_batch',
        'file_start_position',
        'file_end_position',
    ];

    public function batch()
    {
        return $this->belongsTo(DimBatch::class, 'dim_batch_id');
    }

    public function file()
    {
        return $this->belongsTo(DimFile::class, 'dim_file_id');
    }
}
