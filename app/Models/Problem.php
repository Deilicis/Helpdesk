<?php

namespace App\Models;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;


class Problem extends Model
{
    use Sortable;
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
  

    public $sortable = ['id', 'nozare', 'virsraksts', 'apraksts', 'laiks', 'epasts'];
    
    protected $stopOnFirstFailure = true;
}
