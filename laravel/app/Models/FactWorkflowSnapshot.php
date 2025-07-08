<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FactWorkflowSnapshot extends Model
{
    use HasFactory;

    protected $table = 'fact_workflow_snapshots';

    protected $fillable = [
        'dim_version_id',
        'n8n_execution',
        'config_import_dim_stage_id',
        'config_import_dim_status_id',
        'config_import_start_timestamp',
        'config_import_end_timestamp',
        'folder_search_dim_stage_id',
        'folder_search_dim_status_id',
        'folder_search_start_timestamp',
        'folder_search_end_timestamp',
        'file_search_dim_stage_id',
        'file_search_dim_status_id',
        'file_search_start_timestamp',
        'file_search_end_timestamp',
        'batch_manifest_dim_stage_id',
        'batch_manifest_dim_status_id',
        'batch_manifest_start_timestamp',
        'batch_manifest_end_timestamp',
        'batch_creation_dim_stage_id',
        'batch_creation_dim_status_id',
        'batch_creation_start_timestamp',
        'batch_creation_end_timestamp',
        'total_files_processed',
        'total_batches_created',
        'total_bytes_processed',
        'error_count',
    ];

    protected $casts = [
        'config_import_start_timestamp' => 'datetime',
        'config_import_end_timestamp' => 'datetime',
        'folder_search_start_timestamp' => 'datetime',
        'folder_search_end_timestamp' => 'datetime',
        'file_search_start_timestamp' => 'datetime',
        'file_search_end_timestamp' => 'datetime',
        'batch_manifest_start_timestamp' => 'datetime',
        'batch_manifest_end_timestamp' => 'datetime',
        'batch_creation_start_timestamp' => 'datetime',
        'batch_creation_end_timestamp' => 'datetime',
    ];

    public function version()
    {
        return $this->belongsTo(DimVersion::class, 'dim_version_id');
    }

    public function configImportStage()
    {
        return $this->belongsTo(DimStage::class, 'config_import_dim_stage_id');
    }

    public function configImportStatus()
    {
        return $this->belongsTo(DimStatus::class, 'config_import_dim_status_id');
    }

    public function folderSearchStage()
    {
        return $this->belongsTo(DimStage::class, 'folder_search_dim_stage_id');
    }

    public function folderSearchStatus()
    {
        return $this->belongsTo(DimStatus::class, 'folder_search_dim_status_id');
    }

    public function fileSearchStage()
    {
        return $this->belongsTo(DimStage::class, 'file_search_dim_stage_id');
    }

    public function fileSearchStatus()
    {
        return $this->belongsTo(DimStatus::class, 'file_search_dim_status_id');
    }

    public function batchManifestStage()
    {
        return $this->belongsTo(DimStage::class, 'batch_manifest_dim_stage_id');
    }

    public function batchManifestStatus()
    {
        return $this->belongsTo(DimStatus::class, 'batch_manifest_dim_status_id');
    }

    public function batchCreationStage()
    {
        return $this->belongsTo(DimStage::class, 'batch_creation_dim_stage_id');
    }

    public function batchCreationStatus()
    {
        return $this->belongsTo(DimStatus::class, 'batch_creation_dim_status_id');
    }

    // Additional stage and status relationships would be defined similarly
}
