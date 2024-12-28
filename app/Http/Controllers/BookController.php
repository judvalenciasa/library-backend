<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Carbon\Carbon;

class BookController extends Controller
{
    /**
     * Muestra una lista de los libros.
     * 
     * Este método obtiene todos los registro de los libros de la base de datos y retorna un JSON con la información de los libros.
     * Si ocurre algún problema al consultar la base de datos se retorna un mensaje de error.
     * 
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Throwable
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
     * Almacena un libro recién creado en la base de datos.
     * 
     * Este método recibe una solicittud de creación de un libro, formatea la fecha de publicación proporcionada
     * en el formato 'd-m-Y' a 'Y-m-d' y crea un nuevo registro en la base de datos con los datos proporcionados, incluyendo 
     * titulo, autor, fecha de publicación, género, categoría y librería.
     * 
     * @param \App\Http\Requests\BookRequest $request
     * @return \App\Http\Resources\BookResource
     */
    public function store(BookRequest $request)
    {
        try{
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
        }catch(\Throwable $th){
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create the book.',
                'error' => $th->getMessage(), // Opcional: detalles técnicos del error
            ], 500); // 500: Internal server error;
        }
        
    }

    /**
     * Actualizado el libro especificado en la base de datos.
     * 
     * Este método recibe una solicitud de actualización de un libro, formatea la fecha de publicación proporcionada
     * en el formato 'd-m-Y' a 'Y-m-d' y actualiza el registro en la base de datos con los datos proporcionados, incluyendo
     * autor, fecha de publicación, género y categoría.
     * Finalmente retorna un JSON con la información del libro actualizado.
     * 
     * @param  \App\Http\Requests\BookRequest  $request
     * @param  \App\Models\Book  $book
     * @abstract \App\Http\Resources\BookResource
     */
    public function update(BookRequest $request, Book $book)
    {
        try {
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
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Falló al actualizar',
                'error' => $th->getMessage(), // Opcional: detalles técnicos del error
            ], 500); // 500: Internal server error
        }
    }

    /**
     * Elimina el libro especificado de la base de datos.
     * 
     * Este método recibe una solicitud de eliminación de un libro y elimina el registro de la base de datos.
     * Luego, devuelve una respuesta JSON con un mensaje de éxito.
     * 
     * @param \App\Models\Book  $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Book $book)
    {
        try {
            $book->delete();
            return response()->json(['message' => 'Libro eliminado con éxito']);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Fallo al borrar el libro.',
                'error' => $th->getMessage(), // Opcional: detalles técnicos del error
            ], 500); // 500: Internal server error
        }
    }
}
