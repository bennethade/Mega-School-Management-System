@extends('layouts.app')
@section('content')
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1>Assign Subject List </h1>
            </div>
            <div class="col-sm-6" style="text-align: right;">
               <a href="{{ route('assign_subject.add') }}" class="btn btn-primary">Assign New Subjects</a>
            </div>
         </div>
      </div>
      <!-- /.container-fluid -->
   </section>
   <section class="content">
      <div class="container-fluid">
         <div class="card">
            <div class="card-header">
               <h3 class="card-title">Search Assign Subject</h3>
            </div>
            <form method="get" action=" ">
               <div class="card-body">
                  <div class="row">
                     <div class="form-group col-md-3">
                        <label>Class Name</label>
                        <input type="text" class="form-control" name="class_name" placeholder="Search Class Name" value="{{ Request::get('class_name') }}">
                     </div>
                     <div class="form-group col-md-3">
                        <label>Subject Name</label>
                        <input type="text" class="form-control" name="subject_name" placeholder="Search Subject Name" value="{{ Request::get('subject_name') }}">
                     </div>
                     <div class="form-group col-md-3">
                        <label>Date</label>
                        <input type="date" class="form-control" name="date" placeholder="Search by Date" value="{{ Request::get('date') }}">
                     </div>
                     <div class="form-group col-md-3">
                        <button type="submit" class="btn btn-primary" style="margin-top: 32px;">Search</button>
                        <a href="{{ route('assign_subject.list') }}" class="btn btn-success" style="margin-top: 32px;">Reset</a>
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
                     <h3 class="card-title">Assign Subject List</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                     <table class="table table-striped">
                        <thead>
                           @php
                           $id = 1
                           @endphp
                           <tr>
                              <th>S/N</th>
                              <th>Class Name</th>
                              <th>Subject Name</th>
                              <th>Status</th>
                              <th>Created By</th>
                              <th>Created Date</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($getRecord as $value)
                           <tr>
                              <td>{{ $id++ }}</td>
                              <td>{{ $value->class_name }}</td>
                              <td>{{ $value->subject_name }}</td>
                              <td>
                                 @if ($value->status == 0)
                                 Active
                                 @else
                                 Inactive
                                 @endif
                              </td>
                              <td>{{ $value->created_by_name }}</td>
                              <td>{{ date('d-m-Y H:i:A', strtotime($value->created_at)) }}</td>
                              <td>
                                 <a href="{{ url('admin/assign_subject/edit_single'.$value->id) }}" class="btn btn-warning">Single Edit</a>
                                 <a href="{{ route('assign_subject.mass_edit', [$value->id]) }}" class="btn btn-primary">Mass Edit</a>
                                 <a href="{{ url('admin/assign_subject/delete/'.$value->id) }}" class="btn btn-danger">Delete</a>
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                     <div style="padding: 10px; float: right;">
                        {{ $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() }}
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
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>
@endsection