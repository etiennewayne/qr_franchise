<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    use HasFactory;

    protected $table = 'franchises';
    protected $primaryKey = 'franchise_id';

    protected $fillable = ['franchise_reference', 'description', 'sysuser'];


}

