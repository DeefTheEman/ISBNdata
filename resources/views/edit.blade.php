@extends('layout')
@section('content')

<body class="h-screen flex flex-col items-center">

<form class="w-2/3" action="{{ route('editbook') }}">
    <div class="w-full mt-3 flex flex-row">
        <h1 class="w-full flex-grow text-2xl">Change book</h1>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
    </div>
    <div class="w-full flex flex-col">
    
        {{-- Page titles --}}
        <script>
            function toggleSelectAll(source) {
                checkboxes = document.querySelectorAll('.property input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = source.checked;
                });
            }
        </script>
        <div class="flex mt-3 flex-row w-full">
            <p class="flex-grow mr-1 w-1/3 text-xl">Original:</p>
            <p class="flex-grow mr-1 w-1/3 text-xl">Previous edit:</p>
            <div class="flex flex-grow ml-1 w-1/3">
                <p class="text-xl flex-grow">New:</p>
                <label for="selectAll" class="mr-1 select-none">Select all</label>
                <input id="selectAll" type="checkbox" onclick="toggleSelectAll(this)">
            </div>
        </div>
        {{-- Individual properties --}}
        @foreach ($fields as $field)
            @php
                // Display values in json format with only commmas. Ints and floats are checked so they do not get interpretted as json
                $fieldValue = $book->$field;
                $json = json_decode($fieldValue);
                if (!(is_int($fieldValue) or is_float($fieldValue)) && $json && json_last_error() == JSON_ERROR_NONE) {
                    $fieldValue = implode(', ', $json);
                }
            @endphp
            <div class="property">
                <div class="flex flex-row w-full">
                    <p class="flex-grow w-1/3 pl-1">{{ ucfirst($field) }}</p>
                    <label for="{{ $field }}_check_id" class="mr-1 select-none">Change?</label>
                    <input id="{{ $field }}_check_id" name="{{ $field }}-check" type="checkbox">  
                </div>
                <div class="flex flex-row w-full">
                    <label for="{{ $field }}_id" class="flex-grow w-1/3 mr-1 mb-2 p-1 border border-gray-300 rounded-md">{{ $fieldValue }}</label>
                    <label for="{{ $field }}_id" class="flex-grow w-1/3 mx-1 mb-2 p-1 border border-gray-300 rounded-md">{{ $fieldValue }}</label>
                    <textarea type="text" id="{{ $field }}_id" name="new-{{ $field }}" class="flex-grow w-1/3 ml-1 mb-2 p-1 border border-gray-300 rounded-md shadow-sm font-mono focus:outline-none focus:border-indigo-500">{{ $fieldValue }}</textarea>
                </div>
            </div>
        @endforeach

        {{-- Hidden inputs to retrieve data that should not be changed by admin --}}
        <input type="hidden" name="ISBN" value="{{ $book->ISBN }}">
        <input type="hidden" name="EAN" value="{{ $book->EAN }}">
        <input type="hidden" name="ISMN" value="{{ $book->ISMN }}">
    
    </div>
</form>

</body>
@endsection