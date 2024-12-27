<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $books = Book::all();
            return BookResource::collection($books);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request)
    {
        $formattedDate = Carbon::createFromFormat('d-m-Y', $request->date_publication)->format('Y-m-d');
        
        $book = Book::create(
            [
                'title' => $request->title,
                'author' => $request->author,
                'date_publication' => $formattedDate,
                'gender' => $request->gender,
                'category' => $request->category,
                'id_library' => 1,
            ]
        );

        return new BookResource($book);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookRequest $request, Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, Book $book)
    {
        $formattedDate = Carbon::createFromFormat('d-m-Y', $request->date_publication)->format('Y-m-d');
        $book->update(
            [
                'title' => $request->title,
                'author' => $request->author,
                'date_publication' => $formattedDate,
                'gender' => $request->gender,
                'category' => $request->category
            ]
        );
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete(); 
        return response()->json(['message' => 'Libro eliminado con éxito']);
    }
}
