<!DOCTYPE html>
<html>
<head>
    <title>TESTapp</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.jpg') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    @yield('content')
</body>

{{-- <footer class="h-[10rem] w-full bottom-0"></footer> --}}

@if (session('alert'))
<div class="fixed inset-0 justify-center items-center flex bg-opacity-30 bg-gray-500 z-10">
    <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-3 rounded w-[27.5%] z-20 flex h-fit items-center" role="alert">
        <div class="overflow-x-auto flex-grow mr-3 max-h-60 overflow-y-auto">    
            <p class="break-words">{{ session('alert') }}</p>
        </div>
        <form action="{{ route('removeErr') }}">
            @csrf
            <button id="removeErr" type="submit">
                <i class="fa fa-times hover:text-gray-500 py-1"></i>
            </button>
        </form>
    </div>
</div>
@endif

</html>