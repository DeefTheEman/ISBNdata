@extends('layout')
@section('content')

<div class="flex flex-col h-screen justify-center items-center bg-gray-500">
    <div class="flex flex-col items-center lg:w-1/3 w-2/3 h-1/2 min-h-96 top-1/2 rounded-2xl shadow-2xl bg-white">
        <img src="{{ asset('favicon.jpg') }}" alt="bookicon" class="h-1/3 mt-10 object-contain">
        <p class="text-2xl mb-3">ISBNDATA - Beheer</p>
        <form class="flex flex-col w-3/4" action="{{ route('verifyKey') }}">
            @csrf
            <label for="login" class="text-sm px-1 font-medium ">Login key:</label>
            <div class="flex mt-1">
                <input type="password" id="login" name="loginkey" class="flex-grow block w-full p-2 mr-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 sm:text-sm">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded"">Login</button>
            </div>
        </form>
    </div>

</div>

@endsection