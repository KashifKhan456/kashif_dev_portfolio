<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\Testimonial;

class LandingService
{
    public function getLandingData(): array
    {
        return [
            'projects' => Project::orderBy('order', 'asc')->get(),
            'skills' => Skill::orderBy('order', 'asc')->get(),
            'experiences' => Experience::orderBy('order', 'asc')->get(),
            'settings' => Setting::pluck('value', 'key')->toArray(),
            'testimonials' => Testimonial::where('is_active', true)->orderBy('order', 'asc')->get(),
            'articles' => Article::where('is_published', true)->orderBy('order', 'asc')->orderBy('published_at', 'desc')->limit(4)->get(),
            'canLogin' => true,
        ];
    }
}
