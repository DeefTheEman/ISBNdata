@extends('layout')
@section('content')
<script>
// SCROLLING
// this handles the previous edit data, depending on which index we are on
const bookdata = @json($bookdata);
const edits = @json($edits);
const fields = @json($fields);
let currentIndex = edits.length;

function displayOriginal() {
    fields.forEach(function (currentField, index) {
        if (index < 2) {
            return
        }
        else {
            original = document.getElementById(`original_${currentField}`);
            new_edit = document.getElementById(`${currentField}_id`);
            original.innerHTML = bookdata[currentField];
            new_edit.innerHTML = bookdata[currentField];
        }
    });
}

function displayEntry(index, firstTime = false) {
    document.getElementById('currentPage').innerHTML = index;

    edit = edits.find(entry => entry.version === index);
    // console.error(edit);
    fields.forEach(function (currentField, index) {
        //Skip book id and version
        if (index < 2) {
            return
        } else {
            fieldValue = edit[currentField];
            // console.error(`looked for: #editted_${currentField}`);
            editted = document.getElementById(`editted_${currentField}`);
            editted.innerHTML = fieldValue;
            if (firstTime && fieldValue) {
                new_edit = document.getElementById(`${currentField}_id`);
                new_edit.innerHTML = fieldValue;
            }
        }
    });
}

function prevBtn(source) {
    if (currentIndex == edits.length) {
        nextbtn = document.getElementById('next_btn');
        console.log(nextbtn);
        nextbtn.classList.add('hover:text-blue-500');
        nextbtn.classList.remove('text-gray-500', 'cursor-default')
    }
    if (currentIndex > 1) {
        currentIndex--;
        displayEntry(currentIndex);
    }
    if (currentIndex == 1) {
        source.classList.add('text-gray-500', 'cursor-default');
        source.classList.remove('hover:text-blue-500');
    }

}

function nextBtn(source) {
    if (currentIndex == 1) {
            prevbtn = document.getElementById('prev_btn');
            prevbtn.classList.add('hover:text-blue-500');
            prevbtn.classList.remove('text-gray-500', 'cursor-default')
        }
    if (currentIndex < edits.length) {
        currentIndex++;
        displayEntry(currentIndex);
        
    }
    if (currentIndex == edits.length) {
        source.classList.add('text-gray-500', 'cursor-default');
        source.classList.remove('hover:text-blue-500')
    }
}

document.addEventListener('DOMContentLoaded', function () {

    // Initial display
    displayOriginal();
    if (currentIndex > 1) {
        displayEntry(currentIndex, true);
        nextbtn = document.getElementById('next_btn');
        nextbtn.classList.add('text-gray-500', 'cursor-default')
        nextbtn.classList.remove('hover:text-blue-500');
        if (currentIndex == 1) {
            prevbtn = document.getElementById('prev_btn');
            prevbtn.classList.add('text-gray-500', 'cursor-default');
            prevbtn.classList.remove('hover:text-blue-500');
        }
    }
    else {
        prevbtn = document.getElementById('prev_btn');
        prevbtn.classList.add('hidden');
        nextbtn = document.getElementById('next_btn');
        nextbtn.classList.add('hidden');
        pageIndex = document.getElementById('currentPage');
        pageIndex.classList.add('hidden');
    }


    // SCROLLING BEHAVIOUR INPUT
    const textareas = document.querySelectorAll('.scalable-textarea');
    
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            if (this.scrollHeight > this.clientHeight) {
                this.style.height = Math.min(this.scrollHeight, 240) + 'px'; // 240px is 15rem
            }
        });
        
        // Trigger the input event to set the initial height
        textarea.dispatchEvent(new Event('input'));
    });
    
    // SUBMITTING
    // This is for ensuring at least one checkbox has been checked when the form is submitted
    const form = document.getElementById('input_form');
    const checkboxes = form.querySelectorAll('input[type="checkbox"]');

    form.addEventListener('submit', function(event) {
        const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

        if (!isChecked) {
            event.preventDefault();
        }
    });
});

function toggleSelectAll(source) {
    checkboxes = document.querySelectorAll('.property input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = source.checked;
    });
}

function insertText(source) {
    sourceId = source.id.replace('button_', ''); //Retrieve `original_field` from `button_original_field`
    textValue = document.querySelector(`#${sourceId}`).innerHTML;
    targetId = sourceId.split('_')[1]; //Retrieve `field` from `original_field`
    targetElement = document.querySelector(`#${targetId}_id`);
    targetElement.value = textValue;
}

</script>
<div class="flex flex-col items-center">

<form id="input_form" class="w-2/3" action="{{ route('editbook') }}">
    <div class="w-full mt-3 flex flex-row">
        <h1 class="w-full flex-grow text-2xl pl-1">Change book</h1>
        {{-- <button type="button" id="backToIndex" data-route="{{ route('back') }}" class="bg-blue-500 text-white px-4 py-2 mr-3 rounded">Back</button> --}}
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
    </div>
    <div class="w-full flex flex-col"> 
        <div class="flex mt-3 flex-row w-full">
            <p class="flex-grow mr-1 pl-1 w-1/3 text-xl">Original:</p>
            <div class="flex flex-row flex-grow mr-1 pl-1 w-1/3">
                <p class="flex-grow text-xl">Previous edit:</p>
                <button type="button" id="prev_btn" class="flex items-center text-xl p-0 m-0 hover:text-blue-500" onclick="prevBtn(this)">
                    <i class="fa fa-angle-left fa-lg mx-2"></i>
                </button>
                <p id="currentPage" class="text-xl">0</p>
                <button type="button" id="next_btn" class="flex items-center text-xl p-0 m-0 hover:text-blue-500" onclick="nextBtn(this)">
                    <i class="fa fa-angle-right fa-lg mx-2"></i>
                </button>
            </div>
            <div class="flex flex-grow pl-1 w-1/3">
                <p class="text-xl pl-1 flex-grow">New:</p>
                <label for="selectAll" class="mr-1 select-none">Select all</label>
                <input id="selectAll" type="checkbox" onclick="toggleSelectAll(this)">
            </div>
        </div>
        
        {{-- Individual properties --}}
        @foreach ($fields as $field)
        {{-- We dont want to change the book id so that iteration can be skipped --}}
        @if ($loop->iteration < 3) @continue @endif 
        {{-- @php
            // // Display values in json format with only commmas. Ints and floats are checked so they do not get interpretted as json
            // $fieldValue = $book->$field;
            // $json = json_decode($fieldValue);
            // if (!(is_numeric($fieldValue))) && $json && json_last_error() == JSON_ERROR_NONE) {
            //     $fieldValue = implode(', ', $json);
            // }
            
            // $filteredEdits = $edits->filter(function ($edit) {
            //     return !is_null($edit->$field);
            // });

            // $highestVersionUser = $users->sortByDesc('version')->first();


            $bookValue = $bookdata[$field];
            $editValue = $edit->$field;
            if ($editValue) {
                $newValue = $editValue;
            } else {
                $newValue = $bookValue;
            }

        @endphp --}}
        
        <div class="property w-full my-1">
            <div class="flex flex-row mb-1">
                <p class="flex-grow pl-1">{{ ucfirst($field) }}</p>
                <div class="flex flex-row lg:w-1/3">
                    <button type="button" id="button_original_{{ $field }}" onclick="insertText(this)" class="bg-blue-500 text-white px-1 ml-2 rounded">Original</button>
                    <button type="button" id="button_editted_{{ $field }}" onclick="insertText(this)" class="bg-blue-500 text-white px-1 ml-1 rounded">Editted</button>
                    <label for="{{ $field }}_check_id" class="pr-1 flex-grow text-right select-none">Change?</label>
                    <input id="{{ $field }}_check_id" name="{{ $field }}-check" type="checkbox">
                </div>
            </div>
            <div class="flex flex-row w-full">
                <label for="{{ $field }}_id" id="original_{{ $field }}" class="flex-grow max-h-[15rem] overflow-y-auto break-words w-1/3 mr-1 p-1 border border-gray-300 rounded-md"></label>
                <label for="{{ $field }}_id" id="editted_{{ $field }}" class="flex-grow max-h-[15rem] overflow-y-auto break-words w-1/3 mx-1 p-1 border border-gray-300 rounded-md"></label>
                <textarea type="text" rows="1" id="{{ $field }}_id" name="new-{{ $field }}" class="scalable-textarea resize-none break-words w-1/3 ml-1 p-1 border border-gray-300 rounded-md shadow-sm font-mono focus:outline-none focus:border-indigo-500"></textarea>
            </div>
        </div>
        @endforeach
    </div>
    {{-- Hidden inputs to retrieve data that should not be changed by admin --}}
    <input type="hidden" name="book_id" value="{{ $bookdata["id"] }}">
</form>

</div>
<div class="h-[10rem] w-full bottom-0"></div>
@endsection