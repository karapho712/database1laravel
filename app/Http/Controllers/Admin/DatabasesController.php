<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\User;
use App\alumnidatabases;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\periodes;
use Validator;
use App\Http\Requests\Admin\alumnidatabasesRequest;
use App\Http\Requests\Admin\periodesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use PDF;

class DatabasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodes_item = periodes::all();
        // $items = alumnidatabases::with(['periodes'])->get();

        if(request()->ajax())
        {
            return dataTables()->of(alumnidatabases::with('periodes')->latest()->get())
                    ->addColumn('id_periode', function($nilai){
                        if ($nilai->periodes == NULL){
                            return "Periode Tidak Ditemukan";
                         }
                        else {
                            return $nilai->periodes->periode;
                        }

                        // return $nilai->periodes->periode;
                    })
                    ->rawColumns(['id_periode'])

                    ->addColumn('tanggal_terbit', function($dateText){

                        if($dateText->tanggal_terbit != NULL){
                        $a = date('d-m-Y',strtotime($dateText->tanggal_terbit));
                        
                        return $a ;
                        // return $dateText->tanggal_terbit ;
                        }
                        else {
                            return "Belum Di Input";
                        }
                        
                    })
                    ->rawColumns(['tanggal_terbit'])

                    ->addColumn('tanggal_pengambilan', function($dateText){

                        if($dateText->tanggal_pengambilan != NULL){
                        $a = date('d-m-Y',strtotime($dateText->tanggal_pengambilan));
                        
                        return $a ;
                        // return $dateText->tanggal_pengambilan ;
                        }
                        else {
                            return "Belum Di Input";
                        }
                        
                    })
                    ->rawColumns(['tanggal_pengambilan'])

                    // ->addColumn('tanggal_terbit', function($date){
                    //     // $dataText = new DateTime($data);
                        
                    //     //     return "Belum di Isi";
                    //     //  }
                    //     // else {
                    //      return $date->format('Y-m-d');
                    //     // }

                    //     // return $nilai->periodes->periode;
                    // })
                    // ->rawColumns(['tanggal_terbit'])
                    
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm my-1 d-inline"><i class="fa fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm my-1 d-inline"><i class="fa fa-trash"></i></button>';

                        // '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm">Delete</button>'

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                                
        }

        return view('pages.admin.database.index', [
            "periodes_item" => $periodes_item
        ]);

        // $periodes_item = Periodes::all();
        // $items = alumnidatabases::with(['periodes'])->get();

        // return view('pages.admin.database.index', [
        //     "items" => $items, 
        //     "periodes_item" => $periodes_item
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->filled('tanggal_terbit')){
            $a = date('Y-m-d',strtotime($request->input('tanggal_terbit')));
        } else {
            $a=NULL;
        }

        if ($request->filled('tanggal_pengambilan')){
            $b = date('Y-m-d',strtotime($request->input('tanggal_pengambilan')));
        } else {
            $b=NULL;
        }

        $rules = array(
            'nama'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        

        if($request->filled('tambah_periode')){
            
            $inputperiode = $request -> only('tambah_periode');
            // Echo "<pre>";
            // print_r($inputperiode);
            $idperiode = periodes::create([
                'periode' => $request->input('tambah_periode')
            ]);

            alumnidatabases::create([
                'nama' =>$request->input('nama'),
                'id_periode' =>$idperiode->id,
                'tingkat_kompetensi' =>$request->input('tingkat_kompetensi'),
                'tanggal_terbit' =>$a,
                'tanggal_pengambilan' =>$b,
                'keterangan' =>$request->input('keterangan')
            ]);
            
            // $data = $request ->all();
            // $data[id_periode] = $periodebaru;
                //date('Y-m-d',strtotime('11-01-2019'));
           

            // alumnidatabase::create($data);


            // Echo "<pre>";
            // print_r("bagian tercheck");

            // // Echo "<pre>";
            // // print_r("tambah periode check");
        } else {
            // $data = $request->all();

            // Echo "<pre>";
            // print_r($data);
            // exit();

            alumnidatabases::create([
                'nama' =>$request->input('nama'),
                'id_periode' =>$request->input('id_periode'),
                'tingkat_kompetensi' =>$request->input('tingkat_kompetensi'),
                'tanggal_terbit' =>$a,
                'tanggal_pengambilan' =>$b,
                'keterangan' =>$request->input('keterangan')
            ]);

            // Echo "<pre>";
            // print_r($data);
        }

     
        // periodes::create($input);
        // alumnidatabases::create($data);
                
        // return redirect()->route('database.index');

        // Echo "<pre>";
        // print_r($input);
        // print_r($data);

        return response()->json(['success' => 'Data Added successfully.']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = alumnidatabases::findOrFail($id);
            return response()->json(['data' => $data]);
        }

        // $item = alumnidatabases::findOrFail($id);
        // return $item;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->filled('tanggal_terbit')){
            $a = date('Y-m-d',strtotime($request->input('tanggal_terbit')));
        } else {
            $a=NULL;
        }

        if ($request->filled('tanggal_pengambilan')){
            $b = date('Y-m-d',strtotime($request->input('tanggal_pengambilan')));
        } else {
            $b=NULL;
        }

        $rules = array(
            'nama'    =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if($request->filled('tambah_periode')){
            
            $inputperiode = $request -> only('tambah_periode');
            // Echo "<pre>";
            // print_r($inputperiode);
            $idperiode = periodes::create([
                'periode' => $request->input('tambah_periode')
            ]);

            $form_data = array(
                'nama' =>$request->input('nama'),
                'id_periode' =>$idperiode->id,
                'tingkat_kompetensi' =>$request->input('tingkat_kompetensi'),
                'tanggal_terbit' =>$a,
                'tanggal_pengambilan' =>$b,
                'keterangan' =>$request->input('keterangan')
            );

            alumnidatabases::whereId($request->hidden_id)->update($form_data);

            // $data = $request ->all();
            // $data[id_periode] = $periodebaru;

           

            // alumnidatabase::create($data);


            // Echo "<pre>";
            // print_r("bagian tercheck");

            // // Echo "<pre>";
            // // print_r("tambah periode check");
        } else {
            $form_data = array(
                'nama' =>$request->input('nama'),
                'id_periode' =>$request->id_periode,
                'tingkat_kompetensi' =>$request->input('tingkat_kompetensi'),
                'tanggal_terbit' =>$a,
                'tanggal_pengambilan' =>$b,
                'keterangan' =>$request->input('keterangan')
            );

            alumnidatabases::whereId($request->hidden_id)->update($form_data);
            // Echo "<pre>";
            // print_r($data);
        }

        return response()->json(['success' => 'Data is successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = alumnidatabases::findOrFail($id);
        $data->delete();
    }

    public function cetak_pdf() {
        // alumnidatabases
        $datacetak = alumnidatabases::with([
            'periodes'
        ])->get();
        // dd($datacetak);
        // return $datacetak;
        
        // $pdf = PDF::loadview('cetak_pdf');
    	$pdf = PDF::loadview('pages.admin.database.cetak_pdf',['datapdf'=>$datacetak]);
    	return $pdf->download('data.pdf');
    }

    public function databasesExport() {
        // $databases = alumnidatabases::select('nama', 'id_periode', 'tingkat_kompetensi', 'tanggal_terbit', 'tanggal_pengambilan', 'keterangan')->get();

        return Excel::download(new UsersExport, 'databaseswebsite.xlsx');

        // return Excel::create('database', function($excel) use($databases){
        //     $excel->sheet('myDatabase', function($sheet) use($databases){
        //         $sheet->fromArray($databases);
        //     });
        // })->download('xls');
    }

    public function databasesImport(Request $request) {
        // $databases = alumnidatabases::select('nama', 'id_periode', 'tingkat_kompetensi', 'tanggal_terbit', 'tanggal_pengambilan', 'keterangan')->get();

        // if ($request->file('fileImport')) {
        //     // alumnidatabases::truncate();

        //     Excel::import(new UsersImport(), request()->file('fileImport'));
        //     return back();
        // }

        $users = Excel::toArray(new UsersImport(), $request->file('fileImport'));
        // dd($users);

        foreach ($users['0'] as $user){
            alumnidatabases::where('id', $user["id"])->updateOrInsert([
                'nama' => $user["nama"],
                'id_periode'=> $user["id_periode"],
                'tingkat_kompetensi'=> $user["tingkat_kompetensi"],
                'tanggal_terbit'=> $user["tanggal_terbit"],
                'tanggal_pengambilan'=> $user["tanggal_pengambilan"],
                'keterangan'=> $user["keterangan"],
            ]);
        }

        // return array(head($users))
        // ->each(function ($row, $key) {
        //     alumnidatabases::where('id', $row['id'])
        //         ->update([
        //             'nama' => $row['nama'],
        //             'id_periode'=> $row['id_periode'],
        //             'tingkat_kompetensi'=> $row['tingkat_kompetensi'],
        //             'tanggal_terbit'=> $row['tanggal_terbit'],
        //             'tanggal_pengambilan'=> $row['tanggal_pengambilan'],
        //             'keterangan'=>$row['keterangan'],
        //         ]);
        // });

        
        // return head($users) -> each(function ($row, $key) {
        //     alumnidatabases::where('id', $row['id'])
        //         ->update([
        //             'nama' => $row['nama'],
        //             'id_periode'=> $row['id_periode'],
        //             'tingkat_kompetensi'=> $row['tingkat_kompetensi'],
        //             'tanggal_terbit'=> $row['tanggal_terbit'],
        //             'tanggal_pengambilan'=> $row['tanggal_pengambilan'],
        //             'keterangan'=>$row['keterangan'],
        //         ]);
        // });
        
        // Excel::import(new UsersImport, 'users.xlsx');

        // $headings = (new HeadingRowImport)->toArray('fileImport');

        // dd($users); 

        // foreach ($users[0] as $user){
        //     alumnidatabases::where('id', $user[0])->update(Arr::except($row, ['id']));
        // }
    

        // update(Arr::except($row, ['id']))

        // return collect(head($users))
        // ->each(function ($row, $key) {
        //     alumnidatabases::where('id', $row['id'])
        //         ->update([
        //             'nama' => $row['nama'],
        //             'id_periode'=> $row['id_periode'],
        //             'tingkat_kompetensi'=> $row['tingkat_kompetensi'],
        //             'tanggal_terbit'=> $row['tanggal_terbit'],
        //             'tanggal_pengambilan'=> $row['tanggal_pengambilan'],
        //             'keterangan'=>$row['keterangan'],
        //         ]);
        // });


        // $xusers =head($users);
        // $xusers -> each(function ($row, $key) {
        //     alumnidatabases::where('id', $row['id'])
        //         ->update(Arr::except($row, ['id']));
        // });
        
        // foreach ($users[0] as $user){
        //     alumnidatabases::updateOrInsert('id', $user[0])->update([
        //         'nama' => $user[1],
        //         'id_periode'=> $user[2],
        //         'tingkat_kompetensi'=> $user[3],
        //         'tanggal_terbit'=> $user[4],
        //         'tanggal_pengambilan'=> $user[5],
        //         'keterangan'=> $user[6],
        //     ]);
        // }

        return redirect('admin/database');
        
        // return ($users);

        // return Excel::create('database', function($excel) use($databases){
        //     $excel->sheet('myDatabase', function($sheet) use($databases){
        //         $sheet->fromArray($databases);
        //     });
        // })->download('xls');
    }
}
