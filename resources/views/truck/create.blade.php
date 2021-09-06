@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create truck</div>
                <div class="card-body">
                    <form method="POST" action="{{route('truck.store')}}">

                        <div class="form-group">
                            <label>Maker:</label>
                            <input type="text" class="form-control" name="truck_maker" value="{{old('truck_maker')}}">
                            <small class="form-text text-muted">Add maker</small>
                        </div>
                        <div class="form-group">
                            <label>Plate:</label>
                            <input type="text" class="form-control" name="truck_plate" value="{{old('truck_plate')}}">
                            <small class="form-text text-muted">Add plate</small>
                        </div>
                        <div class="form-group">
                            <label>Make year:</label>
                            <input type="text" class="form-control" name="truck_make_year" value="{{old('truck_make_year')}}">
                            <small class="form-text text-muted">Add year</small>
                        </div>
                        <div class="form-group">
                            <label>Mechanic notices:</label>
                            <textarea id="summernote" name="truck_mechanic_notices" class="form-control">{{old('truck_mechanic_notices')}}</textarea>
                            <small class="form-text text-muted">Add notices</small>
                        </div>

                        <div class="form-group">
                            <label>Select mechanic:</label>
                            <select name="mechanic_id" class="form-control">
                                @foreach ($mechanics as $mechanic)
                                <option value="{{$mechanic->id}}" @if($mechanic->id == old('mechanic_id')) selected @endif>{{$mechanic->name}} {{$mechanic->surname}}</option>
                                @endforeach
                            </select>
                        </div>
                        @csrf
                        <button type="submit" class="btn btn-primary">ADD</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });

</script>

@endsection
