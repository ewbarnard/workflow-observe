<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimDirectory extends Model
{
    use HasFactory;

    protected $table = 'dim_directories';

    protected $casts = [
        'creation_timestamp' => 'datetime',
    ];

    public function files()
    {
        return $this->hasMany(DimFile::class, 'dim_directory_id');
    }

    public function batches()
    {
        return $this->hasMany(DimBatch::class, 'dim_directory_id');
    }
}
