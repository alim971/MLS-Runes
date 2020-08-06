<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Champion extends Model
{
    //
    protected $fillable = [
        'name', 'burst', 'poke', 'basic', 'tank', 'sustain', 'utility', 'mobility', 'difficulty'
        ];
}
