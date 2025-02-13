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
        'customNozare',
        'virsraksts',
        'apraksts',
        'laiks',
        'epasts',
        'priority',
        'status',
    ];
  

    public $sortable = ['id', 'nozare', 'virsraksts', 'apraksts', 'laiks', 'epasts', 'priority', 'status'];
    
    protected $stopOnFirstFailure = true;

    public function editor()
    {
        return $this->belongsTo(User::class, 'editor');
    }

}
