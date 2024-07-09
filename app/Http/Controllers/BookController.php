<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function controllerFunc()
    {
        $books = Book::all();

        return view('index', [
            'books_model' => $books
        ]);
    }
}