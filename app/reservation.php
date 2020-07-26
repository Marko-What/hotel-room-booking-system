<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
       protected $table = "reservation";
       protected $fillable = ["datumPrihod","datumOdhod","sobeId", "ImePriimek", "email", "telNumber", "opomba"];
}
