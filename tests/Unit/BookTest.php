<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected $library;

    protected function setUp(): void
    {
        parent::setUp();
        $this->library = \App\Models\Library::create([
            'name' => 'Biblioteca Central',
            'address' => 'Calle Principal 123',
        ]);
    }

    /**
     * Prueba para verificar que se pueden crear libros
     * 
     * Esta prueba envía una solicitud Post a la ruta /api/book con los datos de un libro y verifica que se haya creado correctamente, 
     * la función debe retornar un código de estado 201 y la estructura con los datos proporcionados, incluyendo titulo, autor, fecha de publicación, género, categoría y librería.
     * @return void
     */
    /** @test */
    public function it_can_create_a_book()
    {

        $response = $this->postJson('http://biblioteca-backend.test/api/book', [
            'title' => 'El nombre del viento',
            'author' => 'Patrick Rothfuss',
            'date_publication' => '26-12-2024',
            'gender' => 'Ficción',
            'category' => 'Novela',
            'id_library' => $this->library->id_library,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'nombre',
                'autor',
                'fecha de publicacion',
                'genero',
                'categoria',
                'libreria',
            ],
            'res',
        ]);
    }

    /**
     * Prueba para verificar que se pueden listar libros
     * 
     * Esta prueba cre4a dos libros manualmente con los datos proporcionados incluyendo titulo, autor, fecha de publicación, género, categoría y el id de la librería.
     * Luego, envía una solicitud get para listar los libros y verifica que la respuesta tenga un estado 200 y que la estructura de la respuesta JSON sea la respuesta esperada.
     * 
     * @return void
     */

    /** @test */
    public function it_can_list_a_book()
    {

        Book::create([
            'title' => 'El nombre del viento',
            'author' => 'Patrick Rothfuss',
            'date_publication' => '2024-12-26',
            'gender' => 'Ficción',
            'category' => 'Novela',
            'id_library' => $this->library->id_library,
        ]);
        Book::create([
            'title' => 'El temor de un hombre sabio',
            'author' => 'Patrick Rothfuss',
            'date_publication' => '2025-12-26',
            'gender' => 'Ficción',
            'category' => 'Novela',
            'id_library' => $this->library->id_library,
        ]);

        $response = $this->getJson('http://biblioteca-backend.test/api/book');
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'nombre',
                    'autor',
                    'fecha de publicacion',
                    'genero',
                    'categoria',
                    'libreria',
                ],
            ],
        ]);
    }

    /**
     * Prueba para verificar que se puede editar un libro.
     * 
     * Esta prueba crea un libro manualmente con los datos proporcionados incluyendo titulo, autor, fecha de publicación, género, categoría y el id de la librería.
     * Luego, se envía una una solicitud put a la ruta /api/book/{id} con los datos actualizados del libro y se verifica que la respuesta tenga un estado 200 y que 
     * la estructura de la respuesta JSON sea la respuesta esperada.
     * @return void
     */
    /** @test */
    public function it_can_edit_a_book()
    {
        $book = Book::create([
            'title' => 'El nombre del viento',
            'author' => 'Patrick Rothfuss',
            'date_publication' => '2024-12-26',
            'gender' => 'Ficción',
            'category' => 'Novela',
            'id_library' => $this->library->id_library,
        ]);

        $response = $this->putJson("http://biblioteca-backend.test/api/book/{$book->id_book}", [
            'title' => 'El nombre del viento (Actualizado)',
            'author' => 'Patrick Rothfuss',
            'date_publication' => '26-12-2024',
            'gender' => 'Ficción',
            'category' => 'Novela',
            'id_library' => $this->library->id_library,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'nombre' => 'El nombre del viento (Actualizado)',
                'autor' => 'Patrick Rothfuss',
                'fecha de publicacion' => '2024-12-26',
                'genero' => 'Ficción',
                'categoria' => 'Novela',
                'libreria' => $this->library->id_library,
            ],
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'El nombre del viento (Actualizado)',
            'author' => 'Patrick Rothfuss',
            'date_publication' => '2024-12-26',
            'gender' => 'Ficción',
            'category' => 'Novela',
            'id_library' => $this->library->id_library,
        ]);

    }

    /**
     * Prueba para verificar que se puede eliminar un libro.
     * 
     * Esta prueba crea un libro manualmente con los datos proporcionados incluyendo titulo, autor, fecha de publicación, género, categoría y el id de la librería.
     * Luego evía una solicitud delete a la ruta /api/book/{id} y verifica que la respuesta tenga un estado 200 y que el libro haya sido eliminado de la base de datos.
     */
    /** @test */
    public function it_can_delete_a_book()
    {
        $book = Book::create([
            'title' => 'El nombre del viento',
            'author' => 'Patrick Rothfuss',
            'date_publication' => '2024-12-26',
            'gender' => 'Ficción',
            'category' => 'Novela',
            'id_library' => $this->library->id_library,
        ]);

        $response = $this->deleteJson("http://biblioteca-backend.test/api/book/{$book->id_book}"); 
        $response->assertStatus(200); 
        $this->assertDatabaseMissing('books', [ 'id_book' => $book->id_book,]);
    }

}
