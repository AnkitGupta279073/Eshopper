@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Admin/Sub Admin</a> <a href="#" class="current">View </a> </div>
    <h1>Admin/Sub Admin</h1>
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
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Admin/Sub Admin</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>UserName</th>
                  <th>Type</th>
                  <th>Roles(Accessability)</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($admins as $admin)
                <tr  class="gradeX">
                  <td style="text-align: center;" class="center">{{ $admin->id }}</td>
                  <td style="text-align: center;" class="center">{{ $admin->username }}</td>
                  <td style="text-align: center;" class="center">{{ $admin->type }}</td>

                  @if($admin->type == "Admin")
                    @php $roles = "All"; @endphp

                    @else
                      @php $roles = ""; @endphp
                      @if($admin->categories_access == 1)
                        @php $roles.="Category, "; @endphp
                      @endif
                      @if($admin->products_access == 1)
                        @php $roles.="Products, "; @endphp
                      @endif
                      @if($admin->orders_access == 1)
                        @php $roles.="Orders, "; @endphp
                      @endif
                      @if($admin->users_access == 1)
                        @php $roles.="Users, "; @endphp
                      @endif

                      @endif

                       <td style="text-align: center;" class="center"><?php  echo $roles = rtrim($roles,',');?></td>
                  <td style="text-align: center;" class="center">
                    @if($admin->status==1)
                      <span style="color:green">Active</span>
                    @else
                      <span style="color:red">Inactive</span>
                    @endif
                  </td>
                  <td style="text-align: center;" class="center">{{ $admin->created_at }}</td>
                  <td style="text-align: center;" class="center">{{ $admin->updated_at }}</td>
                  <td style="text-align: center;" class="center"><a href="{{ url('/admins/edit-admin/'.$admin->id) }}" class="btn btn-primary btn-mini">Edit</a></td>
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