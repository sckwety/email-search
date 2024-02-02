<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailSearchRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'company', 'linkedin_profile_url'
    ];

    public function emailSearchResults(): HasMany
    {
        return $this->hasMany(EmailSearchResult::class);
    }
}
