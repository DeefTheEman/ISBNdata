@extends('layout')
@section('content')
<script>
    // function search(source) {
    //     //Measure time
    //     startTime = new Date().getTime();
    //     document.getElementById('startTime').value = new Date().getTime();
    //     console.error(startTime);
        
    //     //Ensure pagescrolling
    // }

document.addEventListener('DOMContentLoaded', function () {
    //Measure time
    function measureTime() {
        startTime = new Date().getTime();
        document.getElementById('startTime').value = new Date().getTime();
    }

    function submitForm(index) {
        document.getElementById('indexInput').value = index;
        // document.getElementById('searchform').sumbit();
        // console.log(document.getElementById('searchform'));
        measureTime();
        document.getElementById('searchform').submit();
    }

    //Pass start time data to form
    document.getElementById('searchButton').addEventListener('click', function () {
        measureTime();
        document.getElementById('searchform').submit();
    });
    // document.getElementById('searchform').addEventListener('submit', measureTime());

    //Only add listeners when a search has been done
    const searchresult = @json(session('searchresults'));
    if (searchresult) {
        const {rowsfound, fromrow, rowcount, results} = searchresult;
        const currentIndex = fromrow / rowcount + 1;
        const lastIndex = Math.ceil(rowsfound / rowcount);

        first_search = document.getElementById('first_search');
        prev_search = document.getElementById('prev_search');
        next_search = document.getElementById('next_search');
        last_search = document.getElementById('last_search');

        first_search.addEventListener('click', function () {
            if (!(currentIndex == 1)) {
                submitForm(1);
            }
        });
    
        prev_search.addEventListener('click', function () {
            if (!(currentIndex == 1)) {
                submitForm(currentIndex - 1);
            }
        });
    
        next_search.addEventListener('click', function () {
            if (!(currentIndex == lastIndex)) {
                submitForm(currentIndex + 1);
            }
        });
    
        last_search.addEventListener('click', function () {
            if (!(currentIndex == lastIndex)) {
                submitForm(lastIndex);
            }
        });

        if (currentIndex == 1) {
            first_search.classList.add('text-gray-500', 'cursor-default');
            first_search.classList.remove('hover:text-blue-500')
            prev_search.classList.add('text-gray-500', 'cursor-default');
            prev_search.classList.remove('hover:text-blue-500')
        }
        if (currentIndex == lastIndex) {
            next_search.classList.add('text-gray-500', 'cursor-default');
            next_search.classList.remove('hover:text-blue-500')
            last_search.classList.add('text-gray-500', 'cursor-default');
            last_search.classList.remove('hover:text-blue-500')
        }
    }


});
</script>

{{-- <div class="flex flex-col"> --}}
<div class="flex justify-center w-full">
    <form id="searchform" class="my-5 w-1/2 lg:w-1/3" action="{{ route('getSearch') }}">
        @csrf
        <label for="search" class="block text-sm px-1 font-medium flex-grow">Search (ID, title, author, description, etc.):</label>
        <div class="flex mt-1">
            <input type="text" id="search" name="searchquery" value="{{ old('searchquery') }}" class="flex-grow block w-full p-2 mr-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-indigo-500 sm:text-sm">
            <input type="hidden" id="startTime" name="startTime">
            <input type="hidden" id="indexInput" name="pageIndex" value="1">
            <button type="button" id="searchButton" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
        </div>
    </form>
</div>

@if (session('searchresults'))
@php
    $searchresult = session('searchresults');
    extract($searchresult); //retrieves `rowsfound`, `fromrow`, `rowcount` and `results`
    $frombook = $fromrow + 1;
    if ($fromrow + $rowcount > $rowsfound) {
        $tobook = $rowsfound;
    } else {
        $tobook = $fromrow + $rowcount;
    }
    
    
    $timeTaken = session('timeTaken');
@endphp

<div class="flex flex-col mx-10 mb-10">
    <div class="flex">
        @if ($timeTaken)
            <p class="flex-grow text-gray-500 px-2">Showing book {{ $frombook }} - {{ $tobook }} of {{ $rowsfound }} total books (Search time: {{ $timeTaken }} s)</p>    
        @else
            <p class="flex-grow text-gray-500 px-2">Showing book {{ $frombook }} - {{ $tobook }} of {{ $rowsfound }} total books</p>
        @endif
        <div class="flex">
            <button type="button" id="first_search" class="flex items-center text-xl p-0 m-0 hover:text-blue-500">
                <i class="fa fa-angle-double-left fa-lg mx-2"></i>
            </button>
            <button type="button" id="prev_search" class="flex items-center text-xl p-0 m-0 hover:text-blue-500">
                <i class="fa fa-angle-left fa-lg mx-2"></i>
            </button>
            <p id="pageIndex" class="text-xl">{{ $fromrow / 50 + 1 }}</p>
            <button type="button" id="next_search" class="flex items-center text-xl p-0 m-0 hover:text-blue-500">
                <i class="fa fa-angle-right fa-lg mx-2"></i>
            </button>
            <button type="button" id="last_search" class="flex items-center text-xl p-0 m-0 hover:text-blue-500">
                <i class="fa fa-angle-double-right fa-lg mx-2"></i>
            </button>
        </div>
    </div>
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