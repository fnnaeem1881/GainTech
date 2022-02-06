<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title>User List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
    {{-- toastr --}}
    <link rel="stylesheet" type="text/css"
     href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <style>
        .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>




</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
<div class="row flex-lg-nowrap">
  <div class="col-12 col-lg-auto mb-3" style="width: 200px;">
    <div class="card p-3">
      <div class="e-navlist e-navlist--active-bg">
        <ul class="nav">
          <li class="nav-item"><a class="nav-link px-2 active" href="{{route('profile')}}"><i class="fa fa-fw fa-bar-chart mr-1"></i><span>Profile</span></a></li>
          <li class="nav-item"><a class="nav-link px-2" href="{{route('user_list')}}"><i class="fa fa-fw fa-th mr-1"></i><span>User CRUD</span></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col">
    <div class="e-tabs mb-3 px-3">
      <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active" href="#">Users</a></li>
      </ul>
    </div>
    <div class="text-center">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
    <div class="row flex-lg-nowrap">
      <div class="col mb-3">
        <div class="e-panel card">
          <div class="card-body">
              <form action="{{route('deleteAll')}}" method="POST">
                @csrf

            <div class="card-title " style="overflow: hidden;">
              <span class="mr-2  float-left" style="font-size:20px;"><span>Users</span><small class="px-1">Be a wise leader</small></span>
              <span class="mr-2 float-right"><button type="submit" class="btn btn-danger btn-sm"><small class="px-1">Delete All</small></button></span>
            </div>
            <div class="e-table">
              <div class="table-responsive table-lg mt-3">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th class="align-top">
                        Select
                      </th>
                      <th>Photo</th>
                      <th class="max-width">Name</th>
                      <th class="sortable">Date</th>
                      <th> </th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($data as $row)
                    <tr>



                      <td class="align-middle">
                        <div class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                          <input type="checkbox" name="ids[]" value="{{$row->id}}" class="custom-control-input" id="item-{{$row->id}}">
                          <label class="custom-control-label" for="item-{{$row->id}}"></label>
                        </div>
                      </td>
                      <td class="align-middle text-center">
                        <div class="bg-light d-inline-flex justify-content-center align-items-center align-top" style="width: 35px; height: 35px; border-radius: 3px;">
                            <img width="100%" src="{{asset('image')}}/{{$row->photo}}">
                        </div>
                      </td>
                      <td class="text-nowrap align-middle">{{$row->name}}</td>
                      <td class="text-nowrap align-middle"><span>{{$row->created_at}}</span></td>
                      <td class="text-center align-middle">
                        @if($row->status == 1)
                        <i class="fa fa-fw text-secondary cursor-pointer fa-toggle-on"></i>
                        @else
                        <i class="fa fa-fw text-secondary cursor-pointer fa-toggle-off"></i>
                        @endif
                        </td>
                      <td class="text-center align-middle">
                        <div class="btn-group align-top">
                            <a href="{{route('profile_view',$row->id)}}" class="btn btn-sm btn-outline-secondary badge" type="button" >View</a>
                            <button class="btn btn-sm btn-outline-secondary badge" type="button" data-toggle="modal" data-target="#user-edit-form-modal{{$row->id}}">Edit</button>
                            <a href="{{route('destroy',$row->id)}}" class="btn btn-sm btn-outline-secondary badge" type="button"><i class="fa fa-trash"></i></a>

                        </div>
                        </div>
                      </td>

                    </tr>
                    @endforeach

                  </tbody>
                </table>
              </div>
              <div class="d-flex justify-content-center">
                <ul class="pagination mt-3 mb-0">
                    {{ $data->links() }}
                </ul>
              </div>
            </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-3 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="text-center px-xl-3">
              <button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#user-form-modal">New User</button>
            </div>
            <hr class="my-3">
            <div class="e-navlist e-navlist--active-bold">
              <ul class="nav">
                <li class="nav-item active"><a href="" class="nav-link"><span>All</span>&nbsp;<small>/&nbsp;32</small></a></li>
                <li class="nav-item"><a href="" class="nav-link"><span>Active</span>&nbsp;<small>/&nbsp;16</small></a></li>
                <li class="nav-item"><a href="" class="nav-link"><span>Selected</span>&nbsp;<small>/&nbsp;0</small></a></li>
              </ul>
            </div>
            <hr class="my-3">
            <div>
              <div class="form-group">
                <label>Date from - to:</label>
                <div>
                  <input id="dates-range" class="form-control flatpickr-input" placeholder="01 Dec 17 - 27 Jan 18" type="text" readonly="readonly">
                </div>
              </div>
              <div class="form-group">
                <label>Search by Name:</label>
                <div><input class="form-control w-100" type="text" placeholder="Name" value=""></div>
              </div>
            </div>
            <hr class="my-3">
            <div class="">
              <label>Status:</label>
              <div class="px-2">
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" name="user-status" id="users-status-disabled">
                  <label class="custom-control-label" for="users-status-disabled">Disabled</label>
                </div>
              </div>
              <div class="px-2">
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" name="user-status" id="users-status-active">
                  <label class="custom-control-label" for="users-status-active">Active</label>
                </div>
              </div>
              <div class="px-2">
                <div class="custom-control custom-radio">
                  <input type="radio" class="custom-control-input" name="user-status" id="users-status-any" checked="">
                  <label class="custom-control-label" for="users-status-any">Any</label>
                </div>
              </div>
            </div>
            <hr class="my-3">
            <div class="text-center px-xl-3">
              <button class="btn btn-primary btn-block" type="button" >Search</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- User  Create Form Modal -->
    <div class="modal fade" role="dialog" tabindex="-1" id="user-form-modal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Create User</h5>
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="py-1">
                <form action="{{route('user_store')}}" class="form" method="POST" enctype="multipart/form-data" novalidate="">
                    @csrf
                    <div class="row">
                  <div class="col">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Full Name</label>
                          <input  id="name" class="block mt-1 w-full form-control" type="text" name="name" placeholder="Enter Name"  required autofocus>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Username</label>
                          <input class="form-control" type="text" name="username" placeholder="Enter Username"  required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Email</label>
                          <input class="form-control block mt-1 w-full" type="email" name="email" placeholder="user@example.com" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col mb-3">
                        <div class="form-group">
                          <label>About</label>
                          <textarea class="form-control" name="about" rows="5" placeholder="My Bio" required></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-6 mb-3">
                    <div class="mb-2"><b>Password</b></div>

                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>New Password</label>
                          <input class="form-control" name="password" type="password" placeholder="••••••" required>
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Confirm <span class="d-none d-xl-inline">Password</span></label>
                          <input class="form-control" name="password_confirmation" type="password" placeholder="••••••" required></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">Save Here</button>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>

      <!-- Edit Form Model -->
      @foreach ($edit as $row)


      <div class="modal fade" role="dialog" tabindex="-1" id="user-edit-form-modal{{$row->id}}">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Create User</h5>
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">×</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="py-1">
                <form action="{{route('user_update',$row->id)}}" class="form" method="POST" enctype="multipart/form-data" novalidate="">
                    @csrf
                <div class="row">
                    <div class="col">
                    <div class="row">
                        <div class="col">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input class="form-control" type="text" name="name" placeholder="Enter Name" value="{{$row->name}}">
                        </div>
                        </div>
                        <div class="col">
                        <div class="form-group">
                            <label>Username</label>
                            <input class="form-control" type="text" name="username" placeholder="Enter Username" value="{{$row->username}}">
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="email" name="email" value="{{$row->email}}">
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                        <div class="form-group">
                            <label>Photos</label>
                            <input class="form-control" type="file" name="photo" >
                            <input class="form-control" type="hidden" name="old_photo" placeholder="Enter Name" value="{{$row->photo}}">

                        </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col">
                            <label>Status</label>

                        <div class="form-group">
                            <label for="active">Active</label>
                            <input class="s-control" type="radio" id="active" name="status" placeholder="Enter status" value="1">

                            <label for="inactive">Inactive </label>
                             <input class="s-control" id="inactive" type="radio" name="status" placeholder="Enter status" value="0">
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                        <div class="form-group">
                            <label>About</label>
                            <textarea class="form-control" rows="5" name="about" placeholder="My Bio">{{$row->about}}</textarea>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 mb-3">
                    <div class="mb-2"><b>Change Password</b></div>
                    <div class="row">
                        <div class="col">
                        <div class="form-group">
                            <label>Current Password</label>
                            <input class="form-control" name="current_pass" type="password" placeholder="••••••">
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                        <div class="form-group">
                            <label>New Password</label>
                            <input class="form-control"  name="new_pass" type="password" placeholder="••••••">
                        </div>
                        </div>
                        <div class="col">
                        <div class="form-group">
                            <label>Confirm <span class="d-none d-xl-inline">Password</span></label>
                            <input class="form-control"  name="conf_pass" type="password" placeholder="••••••"></div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                    </div>
                </div>
                </form>

            </div>
            </div>
        </div>
        </div>
    </div>
    @endforeach
</div>
</div>

<style type="text/css">
body{
    margin-top:20px;
    background:#f8f8f8
}
</style>

<script type="text/javascript">
@if(Session::has('message'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.success("{{ session('message') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.error("{{ session('error') }}");
  @endif

  @if(Session::has('info'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.info("{{ session('info') }}");
  @endif

  @if(Session::has('warning'))
  toastr.options =
  {
  	"closeButton" : true,
  	"progressBar" : true
  }
  		toastr.warning("{{ session('warning') }}");
  @endif
</script>

</body>
</html>
