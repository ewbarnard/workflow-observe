<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactFileProcessing extends Model
{
    use HasFactory;

    protected $table = 'fact_file_processings';

    protected $fillable = [
        'dim_version_id',
        'dim_file_id',
        'dim_stage_id',
        'dim_status_id',
        'process_timestamp',
        'dim_batch_id',
        'error_message',
        'processing_time_ms',
    ];

    protected $casts = [
        'process_timestamp' => 'datetime',
    ];

    public function version()
    {
        return $this->belongsTo(DimVersion::class, 'dim_version_id');
    }

    public function file()
    {
        return $this->belongsTo(DimFile::class, 'dim_file_id');
    }

    public function stage()
    {
        return $this->belongsTo(DimStage::class, 'dim_stage_id');
    }

    public function status()
    {
        return $this->belongsTo(DimStatus::class, 'dim_status_id');
    }

    public function batch()
    {
        return $this->belongsTo(DimBatch::class, 'dim_batch_id');
    }
}
