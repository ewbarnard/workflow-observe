<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimVersion extends Model
{
    use HasFactory;

    protected $table = 'dim_versions';

    protected $fillable = [
        'version_name',
        'version_description',
        'active_flag',
    ];

    public function workflowSnapshots()
    {
        return $this->hasMany(FactWorkflowSnapshot::class, 'dim_version_id');
    }

    public function fileProcessings()
    {
        return $this->hasMany(FactFileProcessing::class, 'dim_version_id');
    }
}
