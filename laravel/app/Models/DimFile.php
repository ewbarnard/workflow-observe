<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimFile extends Model
{
    use HasFactory;

    protected $table = 'dim_files';

    protected $fillable = [
        'file_path',
        'file_name',
        'file_type',
        'directory_path',
        'directory_created_timestamp',
        'file_created_timestamp',
        'file_size_bytes',
        'original_source_reference',
    ];

    protected $casts = [
        'directory_created_timestamp' => 'datetime',
        'file_created_timestamp' => 'datetime',
    ];

    public function processings()
    {
        return $this->hasMany(FactFileProcessing::class, 'dim_file_id');
    }

    public function batches()
    {
        return $this->belongsToMany(DimBatch::class, 'fact_batch_file_maps', 'dim_file_id', 'dim_batch_id')
            ->withPivot(['file_sequence_in_batch', 'file_start_position', 'file_end_position'])
        ;
    }
}
