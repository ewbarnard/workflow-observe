<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimStatus extends Model
{
    use HasFactory;

    protected $table = 'dim_statuses';

    protected $fillable = [
        'status_name',
        'status_color',
        'status_description',
    ];

    public function fileProcessings()
    {
        return $this->hasMany(FactFileProcessing::class, 'dim_status_id');
    }
}
