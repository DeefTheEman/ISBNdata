@extends('layout')
@section('content')
<script>
    function setStartTime() {
        startTime = new Date().getTime();
        document.getElementById('startTime').value = new Date().getTime();
        console.error(startTime);
    }
</script>

{{-- <div class="flex flex-col"> --}}
<div class="flex justify-center w-full">
    <form class="my-5 w-1/2 lg:w-1/3" action="{{ route('search') }}">
        @csrf
        <label for="search" class="block text-sm px-1 font-medium flex-grow">Search (ID, title, author, description, etc.):</label>
        <div class="flex mt-1">
            <input type="text" id="search" name="searchquery" class="flex-grow block w-full p-2 mr-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 sm:text-sm">
            <input type="hidden" id="startTime" name="startTime">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" onclick="setStartTime()">Search</button>
        </div>
    </form>
</div>

@if (session('search'))
@php
    $searchresult = session('search')[0]; //this is an associative array
    extract($searchresult); //retrieves `rowsfound` and `results`
    $showed_rows = count($results);
    
    $timeTaken = session('search')[1];
@endphp

<div class="flex flex-col mx-10 mb-10">
    <p class="text-gray-500 px-2">Showing {{ $showed_rows}} of {{ $rowsfound }} total rows (Search time: {{ $timeTaken }} s)</p>
    <div class="px-1">
        <div class="flex flex-row py-1 border-b border-black font-bold">
            <div class="w-[8rem] mx-1">
                <p class="">Book ID</p>
            </div>
            <div class="flex flex-row w-full">
                <p class="w-1/3 mx-1">Title</p>
                <p class="w-1/3 mx-1">Author</p>
                <p class="w-1/3 mx-1">Publisher</p>
            </div>
        </div>
    </div>
    @foreach ($results as $result)
    <form action="{{ route('getbook') }}" class="flex rounded hover:bg-gray-300 px-1">
        <input type="hidden" name="book_id" value={{ $result["isbn"] }}>
        <button type="submit" class="flex flex-row flex-grow py-1 border-b border-gray-300">
            <div class="w-[8rem] mx-1 text-left">
                <p class="">{{ $result["isbn"]}}</p>
            </div>
            <div class="flex flex-row w-full">
                <p class="w-1/3 mx-1 text-left">{{ $result["title"]}}</p>
                <p class="w-1/3 mx-1 text-left">{{ $result["author"]}}</p>
                <p class="w-1/3 mx-1 text-left">{{ $result["publisher"]}}</p>
            </div>
        </button>
    </form>
    @endforeach
</div>
@endif

{{-- </div> --}}
@endsection