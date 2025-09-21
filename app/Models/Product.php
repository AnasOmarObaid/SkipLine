<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'unit',
        'sku',
        'barcode',
        'price',
        'description',
        'sale_price',
        'stock',
        'rate',
        'nutrition',
        'is_active'
    ];

    /**
     * The translatable array
     *
     * @var list<string>
     */
    public $translatable = [
        'name',
        'description',
        'unit',
        'nutrition'
    ];

    /**
     * The attributes that are append to collection
     *
     * @var list<string>
     */
    protected $appends = [
        'image_url',
        'formatted_created_at',
    ];

    /**
     * getCoverAttribute
     *
     * @return void
     */
    public function getImageUrlAttribute()
    {
        return asset($this->getImagePath());
    }


    /**
     * getFormattedCreatedAtAttribute
     *
     * @return string
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('jS M - D - g:i A');
    }


    /**
     * Get the image associated with the user.
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Users who favorited this product.
     *
     * @return BelongsToMany
     */
    public function favoredBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /**
     * hasImage
     *
     * @return bool
     */
    public function hasImage(): bool
    {

        return $this->image?->path ? true : false;
    }


        /**
     * getImagePath
     *
     * @return string
     */
    public function getImagePath(): string
    {
        // get the first Letters from full name -- Anas Omar ==> AO
        return $this->hasImage() ? 'storage/' . $this->image?->path : 'https://placehold.co/600x400/123459/';
    }
}
