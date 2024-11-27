<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'photo'
    ];

    public function setNameAttribute($value) {
        $this->attributes['name'] = $value;
    
        // Generate the initial slug
        $slug = Str::slug($value);
    
        // Check if the slug already exists in the database
        $existingSlugCount = static::where('slug', $slug)->count();
    
        // Append a number to the slug if it already exists
        if ($existingSlugCount > 0) {
            $slug = "{$slug}-{$existingSlugCount}";
        }
    
        $this->attributes['slug'] = $slug;
    }
    

    public function officeSpaces(): HasMany
    {
        return $this->hasMany(OfficeSpace::class);
    }
}
