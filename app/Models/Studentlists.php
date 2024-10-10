<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model ;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Studentlists extends Model
{
    use HasFactory, Notifiable , HasApiTokens;


    protected $table = 'student_list';
    protected $fillable= ['name','course'];
}



