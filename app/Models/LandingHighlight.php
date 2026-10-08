<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingHighlight extends Model
{
    const SECTION_HOME_HERO = 'home_hero';

    const SECTION_PLANS_FOOTER = 'plans_footer';

    protected $fillable = [
        'section', 'icon', 'color', 'title', 'description', 'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function scopeSection($query, string $section)
    {
        return $query->where('section', $section)->orderBy('sort_order');
    }
}
