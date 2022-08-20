<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    use HasFactory, SoftDeletes;
}
