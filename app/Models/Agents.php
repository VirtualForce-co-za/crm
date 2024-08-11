<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Instances;

class Agents extends Model
{
    use HasFactory;

    public function instance()
    {
        return $this->belongsTo(Instances::class, 'instanceid', 'id');
    }
}