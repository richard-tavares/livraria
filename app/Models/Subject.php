<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['description'];

    public $timestamps = true;

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
