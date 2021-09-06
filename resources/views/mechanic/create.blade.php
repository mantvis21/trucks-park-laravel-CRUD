@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Mechanic</div>
                <div class="card-body">
                    <form method="POST" action="{{route('mechanic.store')}}" enctype='multipart/form-data'>

                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" class="form-control" name="mechanic_name" value="{{old('mechanic_name')}}">
                            <small class="form-text text-muted">Add name</small>
                        </div>
                        <div class="form-group">
                            <label>Surname:</label>
                            <input type="text" class="form-control" name="mechanic_surname" value="{{old('mechanic_surname')}}">
                            <small class="form-text text-muted">Add surname</small>
                        </div>
                        <div class="form-group">
                            <label>Add image:</label> <br>
                            <input type="file" name="mechanic_photo">
                        </div>
                        @csrf
                        <button type="submit" class="btn btn-primary">ADD</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
