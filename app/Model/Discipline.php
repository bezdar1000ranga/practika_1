<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'discipline_name'   
    ];

    protected $primaryKey = 'discipline_id';

    public function getId(): int
    {
        return $this->discipline_id;
    }

}
