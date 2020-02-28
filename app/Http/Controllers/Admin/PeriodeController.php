<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\alumnidatabases;
use App\periodes;
use Validator;
use App\Http\Requests\Admin\alumnidatabasesRequest;
use App\Http\Requests\Admin\periodesRequest;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $periodes = periodes::all();
        // $items = alumnidatabases::with(['periodes'])->get();

        if(request()->ajax())
        {

            return datatables()->of(periodes::latest()->get())
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-info btn-sm my-1 d-inline"><i class="fa fa-pencil-alt"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm my-1 d-inline"><i class="fa fa-trash"></i></button>';

                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                                
        }

        return view('pages.admin.periodetabel.index');

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
        $rules = array(
            'periode'    =>  'required',
            'keterangan' =>'string|nullable'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $data = $request->all();

        periodes::create($data);

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
            $data = periodes::findOrFail($id);
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
        $rules = array(
            'periode'    =>  'required',
            'keterangan' => 'string|nullable'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'periode' =>$request->input('periode'),
            'keterangan' =>$request->input('keterangan'),
        );

        // $data = $request->all();

        periodes::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Data Added successfully.']);

      

            // $data = $request ->all();
            // $data[id_periode] = $periodebaru;

           

            // alumnidatabase::create($data);


            // Echo "<pre>";
            // print_r("bagian tercheck");

            // // Echo "<pre>";
            // // print_r("tambah periode check");
            // Echo "<pre>";
            // print_r($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = periodes::findOrFail($id);
        $data->delete();
    }
}
