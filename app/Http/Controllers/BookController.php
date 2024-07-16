<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookController extends Controller
{
    public function controllerFunc()
    {
        $books = Book::all();

        return view('index', [
            'books_model' => $books
        ]);
    }

    public function update(Request $request) 
    {
        $ISBN = $request->input('ISBNnr');
        error_log($ISBN);
        try {
            $model = Book::where('ISBN', $ISBN)->firstOrFail();
            $model->title = 'Sample book 5';
            $model->save();
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('alert', "$ISBN does not exist in database");
        }
        
    }

    // public function update(Request $request) {
    //     $book = new Book();
    //     $book->save();
    // }
}