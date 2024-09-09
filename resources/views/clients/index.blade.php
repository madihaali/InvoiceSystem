@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
						<h2>Manage <b>Clients</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Client</span></a>
					</div>
                </div>
            </div>
			<table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
						<th>Address</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($all_clients as $order)
                    <tr>
                        <td>{{$order->user->name}}</td>
                        <td>{{$order->address}}</td>
						<td>{{$order->phone}}</td>
                        <td width="20%">
						  @can('edit clients')
                            <a href="javascript:void(0)" class="edit" id="{{$order->id}}edit" orderid="{{$order->id}}" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							@endcan
							@role('Super-Admin')
                            <a href="javascript:void(0)" class="delete" id="{{$order->id}}delete" orderid="{{$order->id}}" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
							@endrole
                            <a href="/invoices/{{$order->id}}" class="view" id="{{$order->id}}view"  ><i class="material-icons" data-toggle="tooltip" title="View">&#xf1c5;</i></a>
                          </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
			
			
	<div class="clearfix">
                <ul class="pagination">
                {{ $all_clients->appends(request()->query())->render() }}

                </ul>
            </div>
        </div>
    </div>
	<!-- Add Modal HTML -->
	<div id="addEmployeeModal" class="modal fade ">
		<div class="modal-dialog  modal-lg" style="  max-width: 850px; margin: 2rem auto;">
			<div class="modal-content">
			<form method="POST" action="{{URL('/clients/create')}}" id="AddInvoice">
					@csrf
			        @method('POST')				
                    	<div class="modal-header">						
						<h4 class="modal-title">Add Invoice</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Name</label>
							<input class="form-control" name="name" type="text" required>
						</div>
                        <div class="form-group">
							<label>Phone</label>
							<input class="form-control" name="phone" type="text"  required>
						</div>
                        <div class="form-group">
							<label>Adress</label>
							<input class="form-control" name="address" type="text"  required>
						</div>
                        <div class="form-group">
							<label>Password</label>
							<input class="form-control" name="password" id="client_password" type="text" required>
						</div>
                        <div id="password-strength-status"></div>

                        <div class="form-group">
							<label>Email</label>
							<input class="form-control" name="email" type="email" required>
						</div>	
                        <div class="form-group">
							<label>Role</label>
							<select class="form-control" name="role"  required>
                                @forelse($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @empty
                                @endforelse
                            </select>
						</div>		
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-success" value="Add">
					</div>
				</form>
			</div>
		</div>
	</div>
	
	<!-- Delete Modal HTML -->
	<div id="deleteEmployeeModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
			<form method="POST" action="" id="deleteform">
					@csrf
			        @method('POST')
					<div class="modal-header">						
						<h4 class="modal-title">Delete Invoice</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<p>Are you sure you want to delete these Records?</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
						<input type="hidden" class="form-control" required id="order_id" name="order_id">
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-danger" value="Delete">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Edit Modal HTML -->
	<div id="editEmployeeModal" class="modal fade">
		<div class="modal-dialog modal-lg" style="  max-width: 850px; margin: 2rem auto;">
			<div class="modal-content">
				<form method="POST" action="" id="editform">
					@csrf
			        @method('POST')
					<div class="modal-header">						
						<h4 class="modal-title">Edit Order</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Name</label>
							<input class="form-control" id="client_name" name="name" type="text" required>
							<input class="form-control" id="client_id" name="id" type="hidden" required>
						</div>
                        <div class="form-group">
							<label>Phone</label>
							<input class="form-control" id="phone" name="phone" type="text"  required>
						</div>
                        <div class="form-group">
							<label>Adress</label>
							<input class="form-control" id="address" name="address" type="text"  required>
						</div>
                        <div class="form-group">
							<label>Password</label>
							<input class="form-control" name="password" id="client_password" type="text" required>
						</div>
                        <div id="password-strength-status"></div>

                        <div class="form-group">
							<label>Email</label>
							<input class="form-control"  id="email" name="email" type="email" required>
						</div>	
                        <div class="form-group">
							<label>Role</label>
							<select class="form-control" name="role"  required>
                                @forelse($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @empty
                                @endforelse
                            </select>
						</div>		
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
						<input type="submit" class="btn btn-info" value="Save">
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="{{asset('clients.js')}}"></script>
@endsection