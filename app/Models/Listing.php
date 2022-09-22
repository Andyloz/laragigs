<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    public function scopeFilter(Builder $query, array $filters)
    {
        if ($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        if ($filters['search'] ?? false) {
            $params = [
                'operator' => 'like',
                'value' => '%' . request('search') . '%'
            ];
            $query->where('title', ...$params)
                ->orWhere('company', ...$params)
                ->orWhere('description', ...$params)
                ->orWhere('tags', ...$params)
                ->orWhere('location', ...$params);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
