<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'last_name',   
        'first_name',   
        'middle_name',   
        'gender',   
        'birth_date',   
        'address',   
        'group_id',   
    ];

    protected $primaryKey = 'student_id';

    public function getId(): int
    {
        return $this->student_id;
    }

}
