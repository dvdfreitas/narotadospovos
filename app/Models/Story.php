<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Story extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'subtitle', 'summary', 'slug', 'image', 'date', 'is_featured'];

    // A date fica sem cast de propósito: o formulário de edição escreve-a
    // tal como está num <input type="date">, que só aceita Y-m-d.
    protected $casts = [
        'visible'     => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * As que se mostram ao público, da mais recente para a mais antiga.
     * O id desempata as do mesmo dia, para a ordem não mudar entre páginas.
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('visible', true)->orderByDesc('date')->orderByDesc('id');
    }

    /**
     * Para onde a história leva. O url guarda o caminho da notícia em
     * resources/views/stories (2025/01/revista_mut), ou um caminho absoluto
     * do site quando a notícia é outra página (/campanha).
     */
    public function link(): string
    {
        return Str::startsWith($this->url, '/') ? $this->url : '/noticias/' . $this->url;
    }

    /** As imagens vivem em public/stories, com o mesmo ano/mês da notícia. */
    public function imageUrl(): string
    {
        return $this->image ? '/stories/' . $this->image : '/images/default.jpg';
    }

    /** "25 abr. 2026" */
    public function displayDate(): string
    {
        return Carbon::parse($this->date)->locale('pt')->translatedFormat('j M Y');
    }
}
