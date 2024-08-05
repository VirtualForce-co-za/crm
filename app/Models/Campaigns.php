<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    use HasFactory;

    public function agent()
    {
        return $this->belongsTo(Agents::class, 'agentid', 'id');
    }
    public function instance()
    {
        return $this->belongsTo(Instances::class, 'instanceid', 'id');
    }
}
