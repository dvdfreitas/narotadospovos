<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Story extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'subtitle', 'summary', 'slug', 'image', 'date'];

    protected static function boot()
    {
        parent::boot();

        // Gerar slug automáticamnete a partir do título - Evento de criação
        static::creating(function ($story) {
            $story->slug = Str::slug($story->title);
        });

        // Atualizar automáticamnete slug - Evento de atualização
        static::updating(function ($story) {
            $story->slug = Str::slug($story->title);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
