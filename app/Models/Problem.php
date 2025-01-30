<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [
        'nozare',
        'virsraksts',
        'apraksts',
        'laiks',
        'epasts',
    ];
    
    protected $stopOnFirstFailure = true;
}
