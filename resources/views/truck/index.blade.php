@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Trucks list
                    <div class="sorter">
                        <form action="{{route('truck.index')}}" method="get">
                            <div class="sorter__group">
                                <span>By maker</span> <input type="radio" name="sort_by" value="maker" checked>
                                <span>By plate</span> <input type="radio" name="sort_by" value="plate" @if ($sort_by=='plate' ) checked @endif>
                            </div>

                            <div class="sorter__group">
                                <span>ASC</span> <input type="radio" name="sort_dir" value="asc" checked>
                                <span>DESC</span> <input type="radio" name="sort_dir" value="desc" @if ($sort_dir=='desc' ) checked @endif>
                            </div>

                            <div class="sorter__group">
                                <span>Select Mechanic:</span>
                                <select name="mechanic_id" class="form-control">
                                    <option value='all'>All mechanics</option>
                                    @foreach ($mechanics as $mechanic)
                                    <option value="{{$mechanic->id}}" @if($mechanic->id == $mechanic_id) selected @endif>{{$mechanic->name}} {{$mechanic->surname}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sorter__group">
                                <button class="btn btn-primary" type="submit">Show</button>
                                <a class="btn btn-primary" href="{{route('truck.index')}}">Reset</a>
                            </div>
                        </form>
                        <form action="{{route('truck.index')}}" method="get">
                            <div class="sorter__group">
                                <input type="text" name="s" value="{{$s}}">
                                <button class="btn btn-primary" type="submit">Find</button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse ($trucks as $truck)
                        <li class="list-group-item">
                            <div class="list-item-container">
                                <div class="list-item-container__content">
                                    <span>{{$truck->maker}} {{$truck->plate}}</span> <br>
                                    <small>{{$truck->truckWithMechanic->name}} {{$truck->truckWithMechanic->surname}} </small>
                                    <div>
                                        {!!$truck->mechanic_notices!!}
                                    </div>
                                </div>
                                <div class="list-item-container__buttons">
                                    <a href="{{route('truck.edit',[$truck])}}" class="btn btn-primary m-1">EDIT</a>
                                    {{-- <a href="{{route('truck.pdf',[$truck])}}" class="btn btn-primary m-1">PDF</a> --}}
                                    <form method="POST" action="{{route('truck.destroy', [$truck])}}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">DELETE</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @empty
                            <h3>No results found</h3>
                        @endforelse
                    </ul>
                </div>
                <div class="pag">
                    {{$trucks->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
