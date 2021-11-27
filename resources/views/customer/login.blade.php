<!-- create.blade.php -->

@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Admin Login 
  </div>
  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('games.store') }}">
          <div class="form-group">
              @csrf
              <label for="user_name">UserName/Email:</label>
              <input type="text" class="form-control" name="username"/>
          </div>
          <div class="form-group">
              <label for="cases">Password :</label>
              <input type="text" class="form-control" name="password"/>
          </div>
          <button type="submit" class="btn btn-primary">login</button>
      </form>
  </div>
</div>
@endsection