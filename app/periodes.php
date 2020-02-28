<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class periodes extends Model
{
    use softDeletes;

    protected $fillable = [
        'periode', 'keterangan'
    ];

    public function alumni(){
        return $this->hasMany(alumnidatabases::class, 'id_periode', 'id');
    }
    //
}
