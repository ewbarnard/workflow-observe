<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimBatch extends Model
{
    use HasFactory;

    protected $table = 'dim_batches';

    protected $fillable = [
        'batch_name',
        'batch_description',
        'batch_created_timestamp',
        'batch_size_bytes',
        'file_count',
    ];

    protected $casts = [
        'batch_created_timestamp' => 'datetime',
    ];

    public function files()
    {
        return $this->belongsToMany(DimFile::class, 'fact_batch_file_maps', 'dim_batch_id', 'dim_file_id')
            ->withPivot(['file_sequence_in_batch', 'file_start_position', 'file_end_position'])
        ;
    }

    public function fileProcessings()
    {
        return $this->hasMany(FactFileProcessing::class, 'dim_batch_id');
    }
}
