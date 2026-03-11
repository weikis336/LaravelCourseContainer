<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourceForgeEditions extends Model
{   
    protected $table = 'sourceforge_editions';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'codename',
        'version',
        'release_date',
        'project',
    ];

    public function downloads()
    {
        return $this->hasMany(SourceForgeDownloads::class);
    }
}
