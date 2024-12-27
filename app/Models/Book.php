<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $primaryKey = 'id_book';

    protected $fillable = [
        'title',
        'author',
        'date_publication',
        'gender',
        'category',
        'id_library',
    ];

    public function library()
    {
        return $this->belongsTo(Library::class, 'id_library', 'id_library');
    }
}
