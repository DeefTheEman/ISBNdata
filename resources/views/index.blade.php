@extends('layout')
@section('content')
<body class="h-screen flex items-center justify-center">

<div class="flex justify-center h-full w-full">
    <form class="mt-10 w-1/2 lg:w-1/3" action="{{ route('getbook') }}">
        @csrf
        <label for="ISBN" class="block text-sm px-1 font-medium text-gray-700 flex-grow">Book ID (ISBN, ISMN, EAN or ...?):</label>
        <div class="flex mt-1">
            <input type="text" id="ISBN" name="ISBNnr" class="flex-grow block w-full p-2 mr-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 sm:text-sm">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
        </div>
    </form>
</div>

@if (session('alert'))
<div class="fixed inset-0 justify-center items-center flex bg-opacity-30 bg-gray-500 z-10">
    <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 rounded w-1/3 z-20 flex h-fit items-center" role="alert">
        <div class="overflow-x-auto flex-grow mr-3 max-h-60 overflow-y-auto">    
            <p class="break-words">{{ session('alert') }}</p>
        </div>
        <form action="{{ route('removeErr') }}">
            @csrf
            <button type="submit">
                <i class="fa fa-times hover:text-gray-500 py-1"></i>
            </button>
        </form>
    </div>
</div>
@endif

{{-- @if (session('alert')) --}}
{{-- <div class="w-full h-full justify-content align-content"> --}}
    {{-- <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert"> --}}
        {{-- <span class="block sm:inline">{{ session('alert') }}</span> --}}
        {{-- {{ session('alert') }} --}}
    {{-- </div> --}}
{{-- </div> --}}
{{-- @endif --}}

</body>
@endsection