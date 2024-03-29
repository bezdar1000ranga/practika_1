<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'student_id',   
        'discipline_id',   
        'avg',   
        'hours',   
    ];

    protected $primaryKey = 'performance_id';

    public function getId(): int
    {
        return $this->performance_id;
    }

}
