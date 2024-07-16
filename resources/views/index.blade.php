@extends('layout')

@section('content')
@foreach($books_model as $book)
    <p>{{ $book->ISBN }}</p>
    <p>{{ $book->title}}</p>
@endforeach
<h4 class="font-light">test</h4>
<form action="{{ route('updateroute') }}">
    @csrf
    <label for="ISBN" class="block text-sm font-medium text-gray-700">ISBN:</label>
    <input type="text" id="ISBN" name="ISBNnr" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">bleh</button>
</form>

@if (session('alert'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
    <span class="block sm:inline">{{ session('alert') }}</span>
</div>
@endif


@endsection