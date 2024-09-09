@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
						<h2>Manage <b>Invoices</b></h2>
					</div>
					<div class="col-sm-6">
						@if(auth()->user()->hasRole('customer'))
						<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Invoice</span></a>
					@endif
					</div>
                </div>
            </div>
            <table class="table table-striped table-hover" id="AllInvoices">
                <thead>
                    <tr>
						<th>Invoice Number</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
               
                </tbody>
            </table>
			@forelse($all_Invoices as $order)

				<!-- View Modal HTML -->
	<div id="viewOrder{{$order->id}}" class="modal fade">
	  	<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">						
						<h4 class="modal-title">View Order</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
						<label>Address : {{$order->customer->address}}</label>
						</div>
						<div class="form-group">
						<label>Phone : {{$order->customer->phone}}</label>
						</div>	
						<div class="form-group">
							<label>Order Items</label>
							<table class="table table-bordered ">
                                        <thead class="table-light">
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                        </thead>
                                        <tbody>
											@forelse($order->invoice_items as $order_item)
										<tr>
                                      <td>{{$order_item->description}}</td>
                                      <td>{{$order_item->price}}</td>
                                      <td>{{$order_item->quantity}}</td>
                                   </tr>
								   @empty 
								   @endforelse
										</tbody>
                                    </table>
						</div>				
					</div>
					<div class="modal-footer">
						
					</div>
			</div>
		</div>
	</div>
	@empty 
	@endforelse
			
        </div>
    </div>
	<!-- Add Modal HTML -->
	<div id="addEmployeeModal" class="modal fade ">
		<div class="modal-dialog  modal-lg" style="  max-width: 850px; margin: 2rem auto;">
			<div class="modal-content">
			<form method="POST" action="{{URL('/invoice/create')}}" id="AddInvoice">
					@csrf
			        @method('POST')					<div class="modal-header">						
						<h4 class="modal-title">Add Invoice</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">					
						<div class="form-group">
							<label>Due Date</label>
							<input class="form-control" name="due_date" type="datetime-local" required>
						</div>
						<div class="form-group">
							<label>Invoice Items</label>
							<table class="table table-bordered orderitems">
                                        <thead class="table-light">
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                        </thead>
                                        <tbody>
										<tr>
                                <td><input type="text" class="items" name="invoice_items[1][description][]">
								<ul class="Dropdown">
                                </ul>
							</td>
                                <td><input type="number"  step="0.01"  name="invoice_items[1][price][]"></td>
                                <td><input type="number" name="invoice_items[1][quantity][]"></td>
                                   </tr>
										</tbody>
                                        <tfoot class="table-light">
                                            <th colspan="3" class="text-primary">
                                              <a href="javascript:void(0)" class="addnew"> Add new</a>
                                            </th>
                                        </tfoot>
                                    </table>
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
							<label>Due Date</label>
							<input class="form-control" name="due_date" id="due_date" type="datetime-local" required>
						</div>
						<div class="form-group">
							<label>Invoice Items</label>
							<table class="table table-bordered orderitems">
                                        <thead class="table-light">
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                        </thead>
                                        <tbody>
										
										</tbody>
                                    </table>
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


@include('invoice.datatable')
<script src="{{asset('order.js')}}"></script>


@endsection