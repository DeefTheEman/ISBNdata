<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Database\Eloquent\Model;

class BookController extends Controller
{
    public function controllerFunc()
    {
        $books = Book::all();

        return view('index', [
            'books_model' => $books
        ]);
    }

    public function update(Request $request) {
        $model = Model::find($request->input('ISBNnr'));
        $model->title = 'Sample book 5';
        $model->save();
        return redirect()->back();
    }
}