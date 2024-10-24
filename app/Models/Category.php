<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<News, $this>
     */
    public function newsItem(): HasMany
    {
        return $this->hasMany(News::class, 'category', 'id');
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => Str::slug($value)
        );
    }
}
