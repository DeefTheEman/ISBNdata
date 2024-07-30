<?php

namespace App\Http\Controllers;

use App\Models\Edit;
use Illuminate\Http\Request;

class EditController extends Controller
{
    private function retrieveBook($book_id) {
        $jsondata = file_get_contents("https://isbndata.nl/api.php?key=ljksdu8fuwo4q33kljfopw9eufwp93uikq3jd&api=getdata&id=$book_id");
        if ($jsondata) {
            $bookdata = json_decode($jsondata, true);
            //Check for errors
            if (array_key_exists("Error", $bookdata)) {
                $error = $bookdata["Error"];
                if ($error == "Invalid id") {
                    return redirect()->back()->with('alert', "Book ID does not exist in database");
                } else {
                    return redirect()->back()->with('alert', "DB_ERROR: `$error`");
                }
            } 
            //if there are no errors check if book already has been editted, 
            //if not make a temporary edit model to retrieve fillable fields and null values
            else {
                $edits = Edit::where('book_id', $book_id)->get();
                
                // $edit = $edits->sortByDesc('version')->first();
                // if ($edits === null) {
                //     $edit = new Edit(); 
                // }
                $tempEdit = new Edit();
                $fields = $tempEdit->getFillable();
                return view('edit', compact('bookdata', 'edits', 'fields'));
            }
        } else {
            return redirect()->back()->with('alert', "ERROR: Database connection");
        }
    }

    public function getBook(Request $request) {
        $book_id = $request->input('book_id');
        if (!$book_id) {
            return redirect()->back()->with('alert', "No book ID recieved in request");
        }
        return $this->retrieveBook($book_id);
    }

    public function search(Request $request) {
        $query = $request->input("searchquery");
        $query = str_replace(' ', '%20', $query);

        //Immediately retrieve book when the entry is a book ID
        if (ctype_digit($query) && strlen($query) == 13) {
            return $this->retrieveBook($query);
        }

        $startTime = $request->input('startTime');
        $jsondata = file_get_contents("https://isbndata.nl/api.php?key=ljksdu8fuwo4q33kljfopw9eufwp93uikq3jd&api=search&q=$query");
        $endTime = round(microtime(true) * 1000);
        // Calculate time spent searching
        $timeTaken = round(($endTime - $startTime)/1000, 2);
        
        if ($jsondata) {
            $searchresults = json_decode($jsondata, true);
            if (array_key_exists("Error", $searchresults)) {
                $error = $searchresults["Error"];
                if ($error == "No results.") {
                    return redirect()->back()->with('alert', "No search results for given query");
                } 
                elseif ($error == "No search string provided") {
                    return redirect()->back()->with('alert', "No search query has been provided");
                } 
                else {
                    return redirect()->back()->with('alert', "DB_ERROR: `$error`");
                }
            } else {
                return redirect()->back()->with('search', [$searchresults, $timeTaken]);
            }
        } else {
            return redirect()->back()->with('alert', "ERROR: Database connection");
        }
    }

    public function editBook(Request $request) {
        $book_id = $request->input('book_id');
        if (!$book_id) {
            return redirect()->back()->with('alert', "Could not retrieve book ID");
        }
        // return redirect()->back()->with('alert', 'Testttt');

        $old_edits = Edit::where('book_id', $book_id)->get();
        $old_edit = $old_edits->sortByDesc('version')->first();
        if ($old_edit === null) {
            $edit = Edit::create([
                'book_id' => $book_id,
                'version' => 1,
                'maintitle' => null,
                'subtitle' => null,
                'collectiontitle' => null,
                'author' => null,
                'publisher' => null,
                'language' => null,
                'pagecount' => null,
                'keywords' => null,
                'nurcode' => null,
                'shortdescription' => null,
            ]);
            // $edit->save();
        }
        else {
            $newEdit = $old_edit->toArray();
            $newEdit["version"] += 1;
            $edit = Edit::create($newEdit);
            // $edit->save();
        }

        //Book ID needs to be fillable to be able to create it, but should not be changed, hence why it is skipped
        $fields = array_slice($edit->getFillable(), 2); 
        foreach ($fields as $field) {
            if ($request->input("$field-check")) {
                $newval = $request->input("new-$field");
                if ($edit->getFieldType($field) == 'json') {
                    $newval = json_decode($newval);
                }
                $edit->$field = $newval;
            }
        }
        $edit->save();
        return redirect()->route('index');
    }

    public function removeErr(Request $request) {
        session()->forget('alert');
        return redirect()->back();
    }
}
