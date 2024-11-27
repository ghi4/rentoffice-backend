<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class OfficeSpace extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail',
        'is_open',
        'is_full_booked',
        'price',
        'duration',
        'address',
        'about',
        'slug',
        'city_id'
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
    

    public function photos(): HasMany {
        return $this->hasMany(OfficeSpacePhoto::class);
    }

    public function benefits(): HasMany {
        return $this->hasMany(OfficeSpaceBenefit::class);
    }

    public function city(): BelongsTo {
        return $this->belongsTo(City::class);
    }
}
