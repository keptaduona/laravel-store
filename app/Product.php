<?php

namespace App;

use App\Model;

class Product extends Model
{
    public function sizes() {
        return $this->hasMany(Size::class);
    }
}
