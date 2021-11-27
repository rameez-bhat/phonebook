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
                <h2>Contact List</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('customerCreateCustomerContact',['Clientid'=>$Clientid]) }}"> Create Contact</a>
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
            <th>Phone</th>
            <th>Created On</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($data as $key => $value)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $value->name }}</td>
            <td>{{ $value->phone }}</td>
            <td>{{ $value->created_at }}</td>
            <td>
                <form action="{{ route('customerDeleteCustomerContact', ['id' => $value->id,'Clientid'=>$Clientid]) }}" method="POST">     
                    <a class="btn btn-primary" href="{{ route('customerEditCustomerContact', ['id' => $value->id,'Clientid'=>$Clientid]) }}">Edit</a>   
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