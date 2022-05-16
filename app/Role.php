<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends ProtectedModel
{
    protected $fillable = array(
        'title',
        'name',
    );
}
