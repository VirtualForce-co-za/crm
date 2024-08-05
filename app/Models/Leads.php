<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;

    public function campaign()
    {
        return $this->belongsTo(Campaigns::class, 'campaignid', 'id');
    }

    public function agent()
    {
        return $this->belongsTo(Agents::class, 'agentid', 'id');
    }

    public function instance()
    {
        return $this->belongsTo(Instances::class, 'instanceid', 'id');
    }

    public function disposition()
    {
        return $this->belongsTo(Dispositions::class, 'dispositionid', 'id');
    }

    public function agentresponse()
    {
        return $this->belongsTo(Agentresponses::class, 'agentresponseid', 'id');
    }
}
