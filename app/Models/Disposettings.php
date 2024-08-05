<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposettings extends Model
{
    use HasFactory;

    public function disposition()
    {
        return $this->belongsTo(Dispositions::class);
    }

    public function agentresponse()
    {
        return $this->belongsTo(Agentresponses::class);
    }
}
