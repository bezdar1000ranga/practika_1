<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'discipline_id',   
        'group_number',   
        'speciality',   
        'course',   
        'semester',   
    ];

    protected $primaryKey = 'group_id';

    public function getId(): int
    {
        return $this->group_id;
    }

}
