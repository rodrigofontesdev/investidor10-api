<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category, $this>
     */
    public function categoryItem(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Str::slug($value)
        );
    }
}
