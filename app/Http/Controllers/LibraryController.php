<?php

namespace App\Http\Controllers;

use App\Http\Requests\LibraryRequest;
use App\Http\Resources\LibraryResource;
use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Muestra una lista de los librerias.
     * 
     * Este método obtiene todos los registro de los libros de la base de datos y retorna un JSON con la información de las librerias.
     * Si ocurre algún problema al consultar la base de datos se retorna un mensaje de error.
     * 
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Throwable
     */
    public function index()
    {
        try {
            $books = Library::all();
            return LibraryResource::collection($books);
        } catch (\Throwable $th) {
            return $th;
        }
    }


    /**
     * Almacena una libreria recién en la base de datos.
     * 
     * Este método recibe una solicittud de creación de una libreria, formatea la fecha de publicación proporcionada
     * recibe name y address.
     * 
     * @param \App\Http\Requests\LibraryRequest $request
     * @return \App\Http\Resources\LibraryResource
     */
    public function store(LibraryRequest $request)
    {
        try{
            $book = Library::create(
                [
                    'name' => $request->name,
                    'address' => $request->address,
                ]
            );
    
            return new LibraryResource($book);
        }catch(\Throwable $th){
            return response()->json([
                'status' => 'error',
                'message' => 'Fallo al crear una librería',
                'error' => $th->getMessage(), // Opcional: detalles técnicos del error
            ], 500); // 500: Internal server error;
        }
        
    }

}
