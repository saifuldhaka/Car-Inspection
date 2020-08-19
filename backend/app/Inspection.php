<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $table = 'inspections';
    protected $fillable = ['booking_date', 'first_name','email','phone','address','type','brand','model','year_made','mileage', 'status'];
    public $timestamps = false;
}
