<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Edittedbook;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookController extends Controller
{
    public function getBook(Request $request) 
    {
        $ISBN = $request->input('ISBNnr');
        try {
            if (!$ISBN) {
                return redirect()->back()->with('alert', "Please insert a book identifier");
            }
            $book = Book::where('ISBN', $ISBN)->firstOrFail();
            $fields = $book->getFillable();
            return view('edit', compact('book', 'fields'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('alert', "Book with code \"$ISBN\" does not exist in database.");
        }
    }

    public function editBook(Request $request) {
        $ISBN = $request->input('ISBN');
        error_log("$ISBN is retrieved ISBN");
        try {
            $edittedbook = Edittedbook::where('ISBN', $ISBN)->firstOrFail();
            error_log("found book");
        } catch (ModelNotFoundException $e) {
            // $book = new EdittedBook(['ISBN'=>$ISBN]);
            $edittedbook = Edittedbook::create([
                'ISBN' => $ISBN,
                'EAN' => null,
                'ISMN' => null,
                'title' => null,
                'subtitle' => null,
                'set_ISBN' => null,
                'publication_date' => null,
                'first_publication_date' => null,
                'author' => null,
                'product_form' => null,
                'ebook_format' => null,
                'drm_type' => null,
                'edition_type' => null,
                'edition' => null,
                'pages' => null,
                'file_size_or_duration' => null,
                'dimensions' => null,
                'weight' => null,
                'illustrations' => null,
                'language' => null,
                'original_language' => null,
                'original_title' => null,
                'nur_code' => null,
                'nur_language' => null,
                'avi_code' => null,
                'avi_language' => null,
                'geo_code' => null,
                'flap_text' => null,
                'short_description' => null,
                'series' => null,
                'primary_image' => null,
                'secondary_images' => null,
                'available_CB' => null,
                'available_CBC' => null,
                'release_date' => null,
                'translator' => null,
                'illustrator' => null,
                'theme' => null,
                'keywords' => null,
                'price' => null,
                'related_products' => null,
                ]);
            
            error_log("new editted book created");
        }
        $fields = $edittedbook->getFillable();
        foreach ($fields as $field) {
            if ($request->input("$field-check")) {
                $newval = $request->input("new-$field");
                error_log($edittedbook->getFieldType($field));
                if ($edittedbook->getFieldType($field) == 'json') {
                    $newval = json_decode($newval);
                }
                $edittedbook->$field = $newval;
            }
        }
        $edittedbook->save();
        return view('index');
    }

    public function removeErr(Request $request) 
    {
        session()->forget('alert');
        return redirect()->back();
    }

    // public function update(Request $request) {
    //     $book = new Book();
    //     $book->save();
    // }
}