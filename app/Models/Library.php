<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    protected $table = 'libraries';
    protected $primaryKey = 'id_library';
    
    protected $fillable = [
        'name',
        'address',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'id_library', 'id_library');
    }

}
