<?php

namespace App\Exports;

// use App\User;
use App\alumnidatabases;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return alumnidatabases::select('id','nama', 'id_periode', 'tingkat_kompetensi', 'tanggal_terbit', 'tanggal_pengambilan', 'keterangan')->get();
        ;
    }
}
