<?php

namespace App\Imports;

use App\alumnidatabases;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new alumnidatabases([
            'nama' => $row[1],
            'id_periode'=> $row[2],
            'tingkat_kompetensi'=> $row[3],
            'tanggal_terbit'=> $row[4],
            'tanggal_pengambilan'=> $row[5],
            'keterangan'=> $row[6],
        ]);
    }
}
