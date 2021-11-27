<!-- create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
    <div class="row" style="margin-top: 5rem;">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Client List</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('adminCreateCustomer') }}"> Create Client</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>S.No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created On</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($data as $key => $value)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->email }}</td>
            <td>{{ $value->created_at }}</td>
            <td>
                <form action="{{ route('adminDeleteCustomer', ['id' => $value->id]) }}" method="POST">   
                    <a class="btn btn-info" href="{{ route('adminDashboardViewCustomerContacts', ['id' => $value->id]) }}">Contact List</a>    
                    <a class="btn btn-primary" href="{{ route('adminEditCustomer', ['id' => $value->id]) }}">Edit</a>   
                    @csrf
                    @method('DELETE')      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>  
    {!! $data->links() !!} 
</div>
</div>   
</div>
</div>  
</div> 
@endsection