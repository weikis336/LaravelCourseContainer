<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourceForgeCountries extends Model
{
    protected $table = 'sourceforge_countries';
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
