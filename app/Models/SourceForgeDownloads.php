<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourceForgeDownloads extends Model
{   
    protected $fillable = [
        'id',
        'edition_id',
        'platform_id',
        'country_id',
        'downloads',
        'date',
    ];

    public function edition()
    {
        return $this->belongsTo(SourceForgeEditions::class);
    }
    public function platform()
    {
        return $this->belongsTo(SourceForgePlatforms::class);
    }
    public function country()
    {
        return $this->belongsTo(SourceForgeCountries::class);
    }
}
