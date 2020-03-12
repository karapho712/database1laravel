<?php

namespace App\Imports;

use App\alumnidatabases;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      
        return new alumnidatabases([
            'id'  => $row['id'],
            'nama' => $row['nama'],
            'id_periode'    => $row['id_periode'],
            'tingkat_kompetensi' => $row['tingkat_kompetensi'],
            'tanggal_terbit'=> $row['tanggal_terbit'] ,
            'tanggal_pengambilan' => $row['tanggal_pengambilan'], 
            'keterangan'=> $row['keterangan'],
        ]);
    

        // return new alumnidatabases([
        //     'nama' => $row[1],
        //     'id_periode'=> $row[2],
        //     'tingkat_kompetensi'=> $row[3],
        //     'tanggal_terbit'=> $row[4],
        //     'tanggal_pengambilan'=> $row[5],
        //     'keterangan'=> $row[6],
        // ]);
    }
}
