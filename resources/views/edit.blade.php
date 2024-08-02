@extends('layout')
@section('content')
<style>
    
</style>
<script>
const bookdata = @json($bookdata);
const edits = @json($edits);
const fields = @json($fields);
const lastIndex = edits.length ? edits.sort((a, b) => b.version - a.version)[0].version : 0;
console.log(lastIndex);
let currentIndex = lastIndex; //Initalize index number
let allowSubmit = false;

// console.log(lastIndex);

document.addEventListener('DOMContentLoaded', function () {
    first_version = document.getElementById('first_version');
    prev_version = document.getElementById('prev_version');
    next_version = document.getElementById('next_version');
    last_version = document.getElementById('last_version');
    
    function resetArrows() {
        document.querySelectorAll('.indexbutton').forEach(element => {
            element.classList.add('hover:text-blue-500');
            element.classList.remove('text-gray-500', 'cursor-default');
        });
    }

    function disableRight() {
        next_version.classList.add('text-gray-500', 'cursor-default');
        next_version.classList.remove('hover:text-blue-500');
        last_version.classList.add('text-gray-500', 'cursor-default');
        last_version.classList.remove('hover:text-blue-500');
    }
            
    function disableLeft() {
        first_version.classList.add('text-gray-500', 'cursor-default');
        first_version.classList.remove('hover:text-blue-500');
        prev_version.classList.add('text-gray-500', 'cursor-default');
        prev_version.classList.remove('hover:text-blue-500');
    }

    function displayData(version = 0) {
        document.getElementById('pageIndex').innerHTML = version; //Handle page number
        //selector arrow styling:
        resetArrows();
        if (currentIndex == 0) {
            disableLeft();
            console.log('disabled left');
        }
        if (currentIndex == lastIndex) {
            disableRight();
            console.log('disabled right');
        }
        //Insert data into textareas
        for (const field in fields) {
            fieldElement = document.getElementById(`${field}_input`);
            fieldElement.value = null;
            fieldElement.classList.remove('bg-yellow-100', 'bg-red-300', 'bg-opacity-75', 'bg-opacity-50');
            //First check a bunch of conditions, if one of them doesn't hold default to the original bookdata
            if (version > 0) {
                filteredEdits = edits.filter(item => item.field == field);
                //Check if there are edits
                if (filteredEdits.length) {
                    sortedEdits = filteredEdits.sort((a, b) => b.version - a.version);
                    //Check from highest to lowest version number whether that versions field value should be displayed 
                    //(only if the current page number is higher or equal to the version number)
                    for (const entry in sortedEdits) {
                        edit = sortedEdits[entry];
                        // console.log(edit);
                        // console.log(version);
                        // console.log(edit.version);
                        if (version > edit.version) {
                            displayVersion = edit.version;
                            fieldElement.value = filteredEdits.filter(item => item.version == displayVersion)[0].value;
                            fieldElement.classList.add('bg-yellow-100', 'bg-opacity-75');
                            // console.log(`added yellow to ${field}`);
                            break
                        } else if (version == edit.version) {
                            fieldElement.value = filteredEdits.filter(item => item.version == version)[0].value;
                            fieldElement.classList.add('bg-red-300', 'bg-opacity-75');
                            // console.log(`added red to ${field}`);
                            break
                        } else {
                            continue
                        }
                    }
                    continue
                }
            }
            //Default value
            originalValue = bookdata[field];
            if (originalValue) {
                fieldElement.value = originalValue;
            }
        }
    }

    first_version.addEventListener('click', function () {
        if (!(currentIndex == 0) && !allowSubmit) {
            currentIndex = 0;
            displayData(currentIndex);
        }
    });

    prev_version.addEventListener('click', function () {
        if (!(currentIndex == 0) && !allowSubmit) {
            currentIndex--;
            displayData(currentIndex)
        }
    });

    next_version.addEventListener('click', function () {
        if (!(currentIndex == lastIndex) && !allowSubmit) {
            currentIndex++;
            displayData(currentIndex);
        }
    });

    last_version.addEventListener('click', function () {
        if (!(currentIndex == lastIndex) && !allowSubmit) {
            currentIndex = lastIndex;
            displayData(currentIndex);
        }
    });

    //Display data in textareas
    displayData(lastIndex);

    //Reset styling of a button
    function allowButton(buttonID, allowed) {
        button = document.getElementById(buttonID);
        if (allowed) {
            allowSubmit = true;
            button.classList.add('bg-blue-500');
            button.classList.remove('bg-gray-500', 'cursor-default');
        } else {
            allowSubmit = false;
            for (const field in fields) {
                document.getElementById(`${field}_editted`).value = false;
            }
            button.classList.remove('bg-blue-500');
            button.classList.add('bg-gray-500', 'cursor-default');
        }
    }

    //Set listeners for editting of textareas
    for (const field in fields) {
        fieldElement = document.getElementById(`${field}_input`);
        fieldElement.addEventListener('input', function () {
            document.getElementById(`${field}_editted`).value = true;
            disableLeft();
            disableRight();
            this.classList.remove('border', 'focus:border-indigo-500');
            this.classList.add('ring-2', 'ring-red-500');
            allowButton('resetallbutton', true);
            allowButton('submitbutton', true);
        });
    }

    document.getElementById('resetallbutton').addEventListener('click', function () {
        if (allowSubmit) {
            displayData(currentIndex);
            allowButton('resetallbutton', false);
            allowButton('submitbutton', false);
            for (const field in fields) {
                fieldElement = document.getElementById(`${field}_input`);
                fieldElement.classList.add('border', 'focus:border-indigo-500');
                fieldElement.classList.remove('ring-2', 'ring-red-500');
            }
        }
    });

    document.getElementById('submitbutton').addEventListener('click', function () {
        document.getElementById('editBookForm').submit();
    });
    
});

</script>

<div class="flex flex-col items-center bg-gray-200">
<div class="flex flex-col w-5/6">
    <div class="flex w-full justify-between items-center">
        <p class="text-2xl pl-2">Editting book: <span class="font-mono">{{ $bookdata['maintitle'] }} (ID: {{ $bookdata['id'] }})</span></p>
        <div class="flex items-center pr-2">
            <img src="{{ asset('favicon.png') }}" alt="bookicon" class="h-10">
            <p class="font-semibold text-xl">ISBNData</p>
        </div>
    </div>
    <div class="flex items-center justify-between m-2">
        <div>
            <button type="button" onclick="{{ route('back')}}" class="bg-blue-500 text-white px-4 py-2 rounded">Back</button>
            <button type="button" id="resetallbutton" class="bg-gray-500 cursor-default text-white px-4 py-2 rounded">Reset all</button>
        </div>
        <div class="flex">
            <button type="button" id="first_version" class="indexbutton flex items-center text-xl p-0 m-0 hover:text-blue-500">
                <i class="fa fa-angle-double-left fa-lg mx-2"></i>
            </button>
            <button type="button" id="prev_version" class="indexbutton flex items-center text-xl p-0 m-0 hover:text-blue-500">
                <i class="fa fa-angle-left fa-lg mx-2"></i>
            </button>
            <p id="pageIndex" class="text-xl">0</p>
            <button type="button" id="next_version" class="indexbutton flex items-center text-xl p-0 m-0 hover:text-blue-500">
                <i class="fa fa-angle-right fa-lg mx-2"></i>
            </button>
            <button type="button" id="last_version" class="indexbutton flex items-center text-xl p-0 m-0 hover:text-blue-500">
                <i class="fa fa-angle-double-right fa-lg mx-2"></i>
            </button>
        </div>
        <button type="button" id="submitbutton" class="bg-gray-500 cursor-default text-white px-4 py-2 rounded">Submit</button>
    </div>
    <form id="editBookForm" action="{{ route('editbook') }}" class="flex flex-wrap w-full">
        <input type="hidden" name="book_id" value={{ $bookdata['id'] }}>   
        @foreach ($fields as $field => $isArray)
        <div class="flex flex-col w-1/4 p-1 text-">
            <label for="{{ $field }}_input" class="pl-1">{{ $field }}</label>
            <input id="{{ $field }}_editted" name="{{ $field }}_editted" type="hidden">
            <textarea rows="3" id="{{ $field }}_input" name="{{ $field }}_value" type="text" class="break-words flex-grow w-full p-1 border border-gray-300 rounded-md shadow-sm font-mono focus:outline-none focus:border-indigo-500"></textarea>
        </div>
        @endforeach
    </form>
</div>
<footer class="h-24 w-full"></footer>
</div>
@endsection