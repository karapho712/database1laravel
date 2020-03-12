<?php

namespace App\Exports;

// use App\User;
use App\alumnidatabases;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
// use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return alumnidatabases::select('id','nama', 'id_periode', 'tingkat_kompetensi', 'tanggal_terbit', 'tanggal_pengambilan', 'keterangan');
        ;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Id_periode',
            'tingkat_kompetensi',
            'tanggal_terbit',
            'tanggal_pengambilan', 
            'keterangan',
        ];
    }
}
