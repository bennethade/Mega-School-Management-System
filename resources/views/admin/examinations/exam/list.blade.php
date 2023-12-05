@extends('layouts.app')

@section('content')



<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Exam List : ({{ $getRecord->total() }}) Total Exams</h1>
        </div>
        <div class="col-sm-6" style="text-align: right;">
          <a href="{{ route('examinations.add') }}" class="btn btn-primary">Add New Exam</a>
          
        </div>
        
      </div>
    </div><!-- /.container-fluid -->
  </section>



  <section class="content">
    <div class="container-fluid">
      
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Search Exam</h3>
            </div>
            
            <form method="get" action=" ">
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-3">
                    <label>Exam Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Exam Name" value="{{ Request::get('name') }}">
                  </div>

                  <div class="form-group col-md-3">
                    <label>Date</label>
                    <input type="date" class="form-control" name="date" placeholder="Enter date" value="{{ Request::get('date') }}">
                  </div>

                  <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary" style="margin-top: 32px;">Search</button>
                    <a href="{{ route('examinations.list') }}" class="btn btn-success" style="margin-top: 32px;">Reset</a>
                  </div>
                  
                </div>
              </div>
              <!-- /.card-body -->
            </form>
          </div>
          
    </div>
  </section>



  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
         
        <!-- /.col -->
        <div class="col-md-12">

          @include('_message')

          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Exam List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  @php
                    $id = 1
                  @endphp
                  <tr>
                    <th>#</th>
                    <th>Exam Name</th>
                    <th>Note</th>
                    <th>Created By</th>
                    <th>Created Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($getRecord as $value)
                    <tr>
                      <td>{{ $id++ }}</td>
                      <td>{{ $value->name }}</td>
                      <td>{{ $value->note }}</td>
                      <td>{{ $value->created_by }}</td>
                      <td>{{ date('d-m-Y H:i:A', strtotime($value->created_at)) }}</td>
                      <td>
                        <a href="{{ route('examinations.edit', [$value->id]) }}" class="btn btn-primary">Edit</a>
                        {{-- <a href="{{ url('admin/admin/edit/'.$value->id) }}" class="btn btn-primary">Edit</a> --}}
                        <a href="{{ route('examinations.delete', [$value->id]) }}" class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>

              <div style="padding: 10px; float: right;">
                {{ $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() }}

                {{-- {{ $getRecord->links() }} --}}


                {{--
                  GO TO APPSERVICEPROVIDER AND ADD THE CODE BELOW FOR THIS PAGINATION TO WORK PROPERLY


                    public function boot(): void
                    {
                        paginator::useBootstrap();
                    }
                --}}
              </div>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>



@endsection