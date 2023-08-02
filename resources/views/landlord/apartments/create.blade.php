@extends('layouts.template')
@section('styles')
<style type="text/css">
.map-container {
display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
  grid-auto-rows: minmax(100px, auto);
}
</style>
<script type="module" src="{{ asset('js/map.js') }}"></script>
@endsection
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('content')
<div class="container">
    <div class="map-container">
        <div>
            <div id="map" style="width: 100%; height: 100vh"></div>
        </div>
        <div>
            <form action="{{ route('apartments.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Apartment Name:</label>
                    <input type="text"
                        class="form-control @error('name') is-invalid @enderror" 
                        name="name" placeholder="WanG Plaza" id="name"
                        value="@if(old('name')){{old('name')}}@endif">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Contact Email:</label>
                    <input type="email" name="email" id="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        placeholder="wangplaza@gmail.com"
                        value="@if(old('email')){{old('email')}}@endif">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Contact Phone:</label>
                    <input type="tel" name="phone" id="phone" 
                        class="form-control @error('phone') is-invalid @enderror"
                        placeholder="0712345678"
                        value="@if(old('phone')){{old('phone')}}@endif">
                    @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" name="location" id="location" 
                        class="form-control @error('location') is-invalid @enderror" 
                        placeholder="Thika" >
                    @error('location')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="latitude">Latitude:</label>
                    <input type="text" name="latitude" id="latitude" 
                        class="form-control @error('latitude') is-invalid @enderror" 
                        placeholder="" value="" readonly>
                    @error('latitude')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="longitude">Longitude:</label>
                    <input type="text" name="longitude" id="longitude" 
                        class="form-control @error('longitude') is-invalid @enderror" 
                        placeholder="" value="" readonly>
                    @error('longitude')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" 
                        cols="30" rows="10" 
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="More details"></textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group mt-2">
                    <button class="btn btn-lg btn-block btn-primary">Add Apartment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap&v=weekly"
    defer
></script>
@endsection