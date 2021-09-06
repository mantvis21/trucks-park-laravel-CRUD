@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Mech Sarasas</div>
                <div class="card-body">


                    <ul class="list-group">
                        @foreach ($mechanics as $mechanic)
                        <li class="list-group-item">
                            <div class="list-item-container">
                                <div class="list-item-container__content">
                                    {{$mechanic->name}} {{$mechanic->surname}} <br>
                                    @if($mechanic->photo)
                                    <img class="portret" src="{{$mechanic->photo}}" alt="portret">
                                    @else
                                    <img class="portret" src="{{asset('img/no-image.png')}}" alt="portret">
                                    @endif
                                </div>
                                <div class="list-item-container__buttons">
                                    <a href="{{route('mechanic.edit',[$mechanic])}}" class="btn btn-primary">EDIT</a>
                                    <form method="POST" action="{{route('mechanic.destroy', $mechanic)}}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">DELETE</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
