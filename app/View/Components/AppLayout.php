<?php

namespace App\View\Components;

use \App\Models\Category;
use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function __construct(public ?string $metaTitle = null, public ?string $metaDescription = null)
    {
    }

    public function render(): View
    {
        $categories = Category::query()
            ->join('category_posts', 'categories.id', '=', 'category_posts.category_id')
            ->select('categories.title', 'categories.slug', DB::raw('count(*) as total'))
            ->groupBy('categories.title', 'categories.slug')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        return view('layouts.app', compact('categories'));
    }
}
