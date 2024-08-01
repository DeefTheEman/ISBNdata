@extends('layout')
@section('content')
<style>
    
</style>
<script>
const bookdata = @json($bookdata);
const edits = @json($edits);
const fields = @json($fields);
const lastIndex = edits.reduce((max, item) => {
    return item.version > max ? item.version : max;
}, 0);
let currentIndex = lastIndex;
console.log(currentIndex);
// const newestClasses = ['bg-yellow-200', 'bg-opacity-75']; //The css properties that the newest entries must have

document.addEventListener('DOMContentLoaded', function () {
    first_version = document.getElementById('first_version');
    prev_version = document.getElementById('prev_version');
    next_version = document.getElementById('next_version');
    last_version = document.getElementById('last_version');

    function pageSelector(index) {
        document.getElementById('pageIndex').innerHTML = index;

        document.querySelectorAll('.indexbutton').forEach(element => {
            element.classList.add('hover:text-blue-500');
            element.classList.remove('text-gray-500', 'cursor-default');
        });
        if (currentIndex == 0) {
            first_version.classList.add('text-gray-500', 'cursor-default');
            first_version.classList.remove('hover:text-blue-500');
            prev_version.classList.add('text-gray-500', 'cursor-default');
            prev_version.classList.remove('hover:text-blue-500');
        }
        else if (currentIndex == lastIndex) {
            next_version.classList.add('text-gray-500', 'cursor-default');
            next_version.classList.remove('hover:text-blue-500');
            last_version.classList.add('text-gray-500', 'cursor-default');
            last_version.classList.remove('hover:text-blue-500');
        }
    }

    function displayData(version = 0) {
        pageSelector(version);
        for (const field in fields) {
            // console.log(field);
            fieldElement = document.getElementById(`${field}_input`);
            fieldElement.classList.remove('bg-yellow-200', 'bg-red-200', 'bg-opacity-75');
            //First check a bunch of conditions, if one of them doesn't hold default to the 
            if (version > 0) {
                filteredEdits = edits.filter(item => item.field == field);
                if (filteredEdits.length) {
                    sortedEdits = filteredEdits.sort((a, b) => b.version - a.version);
                    console.log(sortedEdits);
                    // const highestFieldVersion = filteredEdits.reduce((max, item) => {
                    //     return item.version > max ? item.version : max;
                    // }, 0);
                    // const highestFieldVersion = sortedEdits[0].version;
                    for (const entry in sortedEdits) {
                        edit = sortedEdits[entry];
                        console.log(edit);
                        if (version > edit.version) {
                            displayVersion = edit.version;
                            console.log(`want to display ${displayVersion} of ${field}`);
                            fieldElement.value = filteredEdits.filter(item => item.version == displayVersion)[0].value;
                            fieldElement.classList.add('bg-yellow-200', 'bg-opacity-75');
                            break
                        } else if (edit.version == version) {
                            fieldElement.value = filteredEdits.filter(item => item.version == version)[0].value;
                            fieldElement.classList.add('bg-red-200', 'bg-opacity-75');
                            break
                        } else {
                            continue
                        }
                    }
                    continue 
                    // if (version > highestFieldVersion) {
                    //     displayVersion = highestFieldVersion;
                    //     fieldElement.value = filteredEdits.filter(item => item.version == displayVersion)[0].value;
                    //     fieldElement.classList.add('bg-yellow-200', 'bg-opacity-75');
                    //     continue
                    // } else if (version == highestFieldVersion) {
                    //     fieldElement.value = filteredEdits.filter(item => item.version == version)[0].value;
                    //     fieldElement.classList.add('bg-orange-200', 'bg-opacity-75');
                    //     continue
                    // } else {
                    //     sortedEdits.slice(1).forEach(edit => {
                    //         if (edit.version > version) {
                    //             displayVersion = highestFieldVersion;
                    //             fieldElement.value = filteredEdits.filter(item => item.version == displayVersion)[0].value;
                    //             fieldElement.classList.add('bg-yellow-200', 'bg-opacity-75');
                    //         }
                    //     })
                    // }
                }
            }


            // if (version > 0) {
            //     filteredEdits = edits.filter(item => item.field == field);
            //     //Only insert the correct version of the field if the field exists in edit database, otherwise it will default to the bookdata
            //     if (filteredEdits.length) {
            //         // console.log(field);
            //         const highestFieldVersion = filteredEdits.reduce((max, item) => {
            //             return item.version > max ? item.version : max;
            //         }, 0);
            //         // console.log(highestFieldVersion);
            //         //If the desired version is higher than the highest version in de database, pick the highest version in the databse
            //         if (version > highestFieldVersion) {
            //             displayVersion = highestFieldVersion;
            //         }
            //         else {
            //             displayVersion = version
            //         }
            //         //Check whether the displayed version is the newest version and add styling accordingly
            //         if (version == highestFieldVersion) {
            //             fieldElement.classList.add('bg-orange-200', 'bg-opacity-75');
            //         }
            //         else {
            //             fieldElement.classList.add('bg-yellow-200', 'bg-opacity-75');
            //         }
            //         //Set the html element to the fieldvalue of the desired version
            //         // console.log(displayVersion);
            //         // console.log(filteredEdits.filter(item => item.version == displayVersion)[0]);
            //         fieldElement.value = filteredEdits.filter(item => item.version == displayVersion)[0].value;
            //         continue
            //     }
            // }
            //Default value
            originalValue = bookdata[field];
            if (originalValue) {
                fieldElement.value = originalValue;
            }
        }
    }

    first_version.addEventListener('click', function () {
        if (!(currentIndex == 0)) {
            currentIndex = 0;
            displayData(currentIndex);
        }
    });

    prev_version.addEventListener('click', function () {
        if (!(currentIndex == 0)) {
            currentIndex--;
            displayData(currentIndex)
        }
    });

    next_version.addEventListener('click', function () {
        if (!(currentIndex == lastIndex)) {
            currentIndex++;
            displayData(currentIndex);
        }
    });

    last_version.addEventListener('click', function () {
        if (!(currentIndex == lastIndex)) {
            currentIndex = lastIndex;
            displayData(currentIndex);
        }
    });

    displayData(lastIndex);
    // console.log('displayed data');
});

</script>

<form id="editBookForm" action="{{ route('editbook') }}" class="flex flex-col items-center">
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
    <div class="flex flex-wrap w-5/6">    
        @foreach ($fields as $field => $isArray)
        <div class="w-1/4 p-1">
            <label for="{{ $field }}_input" class="pl-1">{{ $field }}</label>
            <input id="{{ $field }}_editted" type="hidden">
            <textarea rows="3" id="{{ $field }}_input" name="{{ $field }}_value" type="text" class="resize-none break-words w-full p-1 border bg-yellow-200 bg-opacity-75 border-gray-300 rounded-md shadow-sm font-mono focus:outline-none focus:border-indigo-500"></textarea>
            {{-- <textarea rows="3" id="{{ $field }}_input" name="{{ $field }}_value" type="text" class="resize-none break-words w-full p-1 bg-yellow-200 bg-opacity-75 border border-gray-300 rounded-md shadow-sm font-mono focus:outline-none focus:border-indigo-500"></textarea> --}}
            {{-- <textarea rows="3" id="{{ $field }}_input" name="{{ $field }}_value" type="text" class="resize-none break-words w-full p-1 border-red-500 border-2 rounded-md shadow-sm font-mono"></textarea> --}}
        </div>
        @endforeach
    </div>
</form>
@endsection