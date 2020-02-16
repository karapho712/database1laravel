<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class alumnidatabases extends Model
{
    use softDeletes;

    protected $fillable = [
        'nama','id_periode','tingkat_kompetensi','tanggal_terbit','tanggal_pengambilan','keterangan'
    ];

    protected $hidden = [

    ];

    public function periodes (){
        return $this->belongsTo(periodes::class, 'id_periode', 'id');
    }

    //
}
