<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSearchResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'email_search_request_id', 'provider_index', 'result'
    ];
}
