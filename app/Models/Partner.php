<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo', 
        'slug', 
        'visible', 
        'website', 
        'facebook', 
        'instagram', 
        'linkedIn'
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    /** Ver o disco 'partners' em config/filesystems.php. */
    public function logoUrl(): ?string
    {
        return $this->logo ? '/images/partners/' . $this->logo : null;
    }

    /** Os que aparecem no site. Escondem-se em /admin/parceiros. */
    public function scopeVisible(Builder $query): void
    {
        $query->where('visible', true);
    }
}
