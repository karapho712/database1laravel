@extends('layouts.admin.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        
       <!-- <p class="mb-4">Di sini tampilan databasenya brian.</p> -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
               <div class="d-sm-flex align-items-center justify-content-between"> 
                  <h1 class="h3 mb-2 text-gray-800">Tabel Periode</h1>
                  <button type="button" class="btn btn-success btn-icon-split m-1" name="create_record" id="create_record"> <span class="icon text-white-50"><i class="fas fa-plus"></i></span><span class="text">Tambah Periode</span></button>

                  <!-- modal start -->
                  <div class="modal fade" id="formModal" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title h3 mb-2 text-gray-800" id="exampleModalLongTitle">Tambah Data</h1>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <span id="form_result"></span>
                          <form method="POST" id="sample_form">
                            @csrf
                              <div class="form-group">
                                <label for="formNama">Periode</label>
                                <input type="text" class="form-control" name="periode" id="Periode" value="">
                              </div>
                              <div class="form-group">
                                <label for="formKeterangan">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" id="Keterangan" value="">
                              </div>
                               
                            </div>
                              <div class="modal-footer">
                                <input type="hidden" name="action" id="action" />
                                 <input type="hidden" name="hidden_id" id="hidden_id" />
                                <input type="submit" name="action_button" id="action_button" class="btn btn-success" value="Add" />
                              </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- comfirmation modal -->
                <div id="confirmModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="h3 mb-2 text-gray-800" id="exampleModalLongTitle">Hapus Data</h1>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                          <div class="modal-body">
                              <h4 style="margin:0; center">Are you sure you want to remove this data?</h4>
                          </div>
                          <div class="modal-footer">
                          <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Hapus</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          </div>
                      </div>
                  </div>
                </div> 
                <!-- end confirmation modal -->
            <!-- end modal -->
                
          </div>
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th width="30%">Nama Periode</th>
                    {{-- <th >Waktu Pembuatan</th> --}}
                    <th >Keterangan</th>
                    <th width="15%">Action</th>
                  </tr>
                </thead>
              </table>
            </div>
        </div>

      </div>
      <!-- /.container-fluid -->
@endsection


@push('prepend-style')
<link rel="stylesheet" href="{{url('frontend/libraries/bootstrap/css/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" href="{{url('frontend/libraries/gijgo/css/gijgo.min.css')}}">

{{-- <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> --}}
@endpush

@push('addon-script')
    
{{-- <script src="{{url('frontend/libraries/jquery/jquery-3.4.1.min.js')}}"></script> --}}
<script src="{{url('frontend/libraries/jquery/jquery.dataTables.min.js')}}"></script>

<script src="{{url('frontend/libraries/bootstrap/js/dataTables.bootstrap4.min.js')}}"></script>
{{-- <script src="{{url ('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script> --}}
<script src="{{url('frontend/libraries/gijgo/js/gijgo.min.js')}}"></script>

{{-- <script src="{{url('backend/js/sb-admin-2.min.js')}}"></script> --}}
{{-- <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script> --}}
    <script>
      function myFunction() {
          var checkbox = $("#myCheck");
          var text = $("#selectPeriode");
          var tngkt_period = $("#tingkat_kompotensi");

          if( checkbox.is(':checked') ){
            text1.style.display = "block";
            selectPeriode.setAttribute("disabled","disabled");
            // tngkt_period.removeAttribute("disabled")
          } else {
            text1.style.display = "none";
            selectPeriode.removeAttribute("disabled");
            // tngkt_period.setAttribute("disabled","disabled");
          }
       }

       $(document).ready(function(){
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                uiLibrary: 'bootstrap4',
                icons:{
                    rightIcon: '<img src="{{url('frontend/images/ic_doe.png')}}"/>'
                }
            });
            
            $('.datepicker2').datepicker({
                format: 'dd-mm-yyyy',
                uiLibrary: 'bootstrap4',
                icons:{
                    rightIcon: '<img src="{{url('frontend/images/ic_doe.png')}}"/>'
                }
            });
        
   
        $('#dataTable').DataTable({
          processing: true,
          serverSide: true,
          ajax:{
          url: "{{ route('periode.index') }}",
          },

          columns:[
          {
            data: 'periode',
            name: 'periode',
          },
          {
            data: 'keterangan',
            name: 'keterangan'
          },
          {
            data: 'action',
            name: 'action',
            orderable: false
          }
          ]
        });

        $('#create_record').click(function(){
          $('#sample_form')[0].reset();
          $('#alertSuccess').remove();
          $('.modal-title').text("Add New Record");
            $('#action_button').val("Add");
            $('#action').val("Add");
            $('#formModal').modal('show');
          });

          $('#sample_form').on('submit', function(event){
            event.preventDefault();
            if($('#action').val() == 'Add')
              {
              $.ajax({
                url:"{{ route('periode.store') }}",
                method:"POST",
                data: new FormData(this),
                contentType: false,
                cache:false,
                processData: false,
                dataType:"json",
                success:function(data)
                {
                var html = '';
                if(data.errors)
                {
                  html = '<div class="alert alert-danger">';
                  for(var count = 0; count < data.errors.length; count++)
                  {
                  html += '<p>' + data.errors[count] + '</p>';
                  }
                  html += '</div>';
                }
                if(data.success)
                {
                  html = '<div id="alertSuccess" class="alert alert-success" >' + data.success + '</div>';
                  $('#sample_form')[0].reset();
                  $('#dataTable').DataTable().ajax.reload();
                  setTimeout(function(){
                    $('#formModal').modal('hide');
                    $('#alertSuccess').remove();
                  }, 2000);
                }
                $('#form_result').html(html);
                }
              })
              }

            if($('#action').val() == "Edit")
              {
              $.ajax({
                url:"{{ route('periode.update') }}",
                method:"POST",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType:"json",
                success:function(data)
                {
                var html = '';
                if(data.errors)
                {
                  html = '<div class="alert alert-danger">';
                  for(var count = 0; count < data.errors.length; count++)
                  {
                  html += '<p>' + data.errors[count] + '</p>';
                  }
                  html += '</div>';
                }
                if(data.success)
                {
                  html = '<div id="alertSuccess" class="alert alert-success">' + data.success + '</div>';
                  $('#sample_form')[0].reset();
                  $('#dataTable').DataTable().ajax.reload();
                  setTimeout(function(){
                      $('#formModal').modal('hide');
                    }, 2000);
                }
                $('#form_result').html(html);
                $('#sample_form')[0].reset();
                }
              });
              }
        });

        $(document).on('click', '.edit', function(){
          var id = $(this).attr('id');
          $('#form_result').html('');
          $.ajax({
          url:"periode/"+id+"/edit",
          dataType:"json",
          success:function(html){
            $('#Periode').val(html.data.periode);
            $('#Keterangan').val(html.data.keterangan);
            $('#hidden_id').val(html.data.id);
            $('.modal-title').text("Edit New Record");
            $('#action_button').val("Edit");
            $('#action').val("Edit");
            $('#formModal').modal('show');
          }
          })
        });

        var user_id;

        $(document).on('click', '.delete', function(){
        user_id = $(this).attr('id');
        $('#confirmModal').modal('show');
        });

        $('#ok_button').click(function(){
        $.ajax({
          url:"periode/destroy/"+user_id,
          beforeSend:function(){
          $('#ok_button').text('Deleting...');
          },
          success:function(data)
          {
          $('#dataTable').DataTable().ajax.reload();
          setTimeout(function(){
            $('#confirmModal').modal('hide');
            $('#ok_button').text('Hapus');
          }, 1000);
          }
        })
      });
    });
    </script>


@endpush 

@push('crud-script')
    
@endpush