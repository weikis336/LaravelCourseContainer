<?php

namespace App\Models\SQL\Metrics\SF;

use Illuminate\Database\Eloquent\Model;

class SourceForgePlatforms extends Model
{
    protected $table = 'sourceforge_platforms';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];

    public function downloads()
    {
        return $this->hasMany(SourceForgeDownloads::class);
    }
    
}
