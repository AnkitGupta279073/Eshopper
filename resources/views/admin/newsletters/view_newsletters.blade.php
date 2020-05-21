@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Users</a> <a href="#" class="current">View Newsletters Subscriber</a> </div>
    <h1>Newsletters Subscriber</h1>
    @if(Session::has('flash_message_error'))
      <div class="alert alert-error alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{!! session('flash_message_error') !!}</strong>
      </div>
    @endif   
    @if(Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{!! session('flash_message_success') !!}</strong>
        </div>
    @endif
  </div>
  <div style="margin-left: 1209px;">
  <a href="{{  url('/admin/export-newsletters-emails') }}" class="btn btn-primary">Export</a>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Newsletters Subscriber</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>User ID</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($viewNewslettersSubscriber as $viewNewsletters)
                <tr class="gradeX">
                  <td class="center">{{ $viewNewsletters->id }}</td>
                  <td class="center">{{ $viewNewsletters->email }}</td>
                  <td class="center">
                    @if($viewNewsletters->status==1)
                      <a href="{{ url('/admin/update-newsletters-status/'.$viewNewsletters->id.'/0') }}"><span style="color:green">Active</span></a>
                    @else
                       <a href="{{ url('/admin/update-newsletters-status/'.$viewNewsletters->id.'/1') }}"> <span style="color:red">Inactive</span></a>
                    @endif
                  </td>
                    <td class="center">{{ $viewNewsletters->created_at }}</td>
                    <td><a href="{{ url('/admin/delete-newsletters/'.$viewNewsletters->id) }}" class="btn btn-primary btn-mini">Delete</a></td>
                  
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection