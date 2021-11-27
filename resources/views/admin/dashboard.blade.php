<!-- create.blade.php -->

@extends('layouts.app')

@section('content')
<style>
  a[disabled] {
    pointer-events: none;
}
  </style>
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                <a class="btn btn-info {{ ( $viewType == 'Monthly' ) ? 'disabled' : '' }}"  href="{{ route('adminDashboard',['View'=>'Monthly']) }}">Monthly</a>    
                    <a class="btn btn-primary {{ ( $viewType == 'Weekly' ) ? 'disabled' : '' }}"  href="{{ route('adminDashboard',['View'=>'Weekly']) }}">Weekly</a> 
                    <a class="btn btn-success {{ ( $viewType == 'Daily' ) ? 'disabled' : '' }}"  href="{{ route('adminDashboard',['View'=>'Daily']) }}">Daily</a> 
                <div id="google-line-chart" style="width: 900px; height: 500px"></div>
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
                    <a class="btn btn-info"  href="{{ route('adminDashboardViewCustomerContacts', ['id' => $value->id]) }}">Contact List</a>    
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
 
        function drawChart() {
 
        var data = google.visualization.arrayToDataTable([
            ['Month Name', '{{$viewType}} Contact Count'],
 
                @php
                foreach($GraphData as $d) {
                    echo "['".$d->month_name."', ".$d->count."],";
                }
                @endphp
        ]);
 
        var options = {
          title: 'Contact Counts',
          curveType: 'function',
          legend: { position: 'bottom' }
        };
 
          var chart = new google.visualization.LineChart(document.getElementById('google-line-chart'));
 
          chart.draw(data, options);
        }
    </script>
@endsection