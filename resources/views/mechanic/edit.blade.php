@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Mechanic</div>
                <div class="card-body">
                    <form method="POST" action="{{route('mechanic.update',$mechanic)}}" enctype='multipart/form-data'>

                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" class="form-control" name="mechanic_name" value="{{old('mechanic_name' ,$mechanic->name)}}">
                            <small class="form-text text-muted">Edit name</small>
                        </div>
                        <div class="form-group">
                            <label>Surname:</label>
                            <input type="text" class="form-control" name="mechanic_surname" value="{{old('mechanic_surname' ,$mechanic->surname)}}">
                            <small class="form-text text-muted">Edit surname</small>
                        </div>
                        @if($mechanic->photo)
                        <img class="portret" src="{{$mechanic->photo}}" alt="portret">
                        <div class="form-group">
                            <label>Delete image</label>
                            <input type="checkbox" name="mechanic_photo_delete">
                        </div>
                        @else
                        <img class="portret" src="{{asset('img/no-image.png')}}" alt="portret">
                        @endif
                        <div class="form-group">
                            <label>Add image:</label> <br>
                            <input type="file" name="mechanic_photo">
                        </div>
                        @csrf
                        <button type="submit" class="btn btn-primary">EDIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
