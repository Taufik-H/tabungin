<?php

namespace App\View\Components;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Category;
use App\Models\Discussion as DiscussionModel;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class Discussion extends Component
{
    public $discussions;
    public $categories;
    public $selectedCategory;

    public function __construct($categorySlug = null)
    {
        $query = DiscussionModel::with(['user', 'category'])
                                ->withCount(['comments', 'likes']);
    
        if ($categorySlug) {
            $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
        }
    
        // Ganti dari get() ke paginate()
        $this->discussions = $query->latest()->paginate(6); // <= ini kunci pagination
        $this->categories = Category::all();
        $this->selectedCategory = $categorySlug;
    }


    public function render(): View
    {
        return view('components.discussion');
    }
}
