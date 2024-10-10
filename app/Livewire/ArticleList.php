<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleList extends Component
{
    use WithPagination;

    #[Url()]
    public $sort = 'desc';

    #[Url()]
    public $search = '';

    #[Url()]
    public $category = '';

    public function setSort($sort)
    {
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
    }

    #[On('search')]
    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    #[Computed()]
    public function articles()
    {
        return Article::published()
                    ->where('title', 'like', "%{$this->search}%")
                    ->when(Category::where('slug',$this->category)->first(), function ($query) {
                        $query->withCategory($this->category);
                    })
                    ->orderBy('published_at', $this->sort)
                    ->simplePaginate(9);
    }

    public function render()
    {
        return view('livewire.article-list');
    }
}
