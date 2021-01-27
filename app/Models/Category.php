<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;

    public static function getCachedCategories(): object
    {
        return Cache::tags('categories')
            ->rememberForever('categories.index', function () {
                return Category::select('id', 'name')->get();
            });
    }

    public static function flushCache(): void
    {
        Cache::tags('categories')->flush();
    }
}
