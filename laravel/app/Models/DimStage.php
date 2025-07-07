<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimStage extends Model
{
    use HasFactory;

    protected $table = 'dim_stages';

    protected $fillable = [
        'stage_name',
        'stage_order',
        'stage_description',
        'active_flag',
    ];

    public function fileProcessings()
    {
        return $this->hasMany(FactFileProcessing::class, 'dim_stage_id');
    }
}
