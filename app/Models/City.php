<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    public $table = 'cities';
    public $primaryKey = 'city_code';
    protected $keyType = 'string';

    protected $fillable = [
        '*'
    ];

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'city_code', 'city_code');
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class, 'city_code', 'city_code');
    }
}
