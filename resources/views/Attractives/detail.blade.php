@extends('principal')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="card mb-3">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <img class="card-img-top" src="{{ asset('images/attractives/'.$attractive->image) }}" alt="Card image cap">
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold">{{$attractive->name}}</h5>
                        <p class="card-text"><small class="text-primary">Category: {{ $attractive->category->name}}</small></p>
                        <p class="card-text">Description: <span>{{ $attractive->description}}</span></p>
                        <hr>
                        <p class="card-text">Address: <span>{{ $attractive->address}}</span></p>
                    </div>
                </div>
            </div>
          </div>

    </div>
</div>
@endsection