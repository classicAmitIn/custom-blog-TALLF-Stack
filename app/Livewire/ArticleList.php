<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleList extends Component
{
    use WithPagination;

    #[Url()]
    public $sort = 'desc';

    public function setSort($sort)
    {
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
    }

    #[Computed()]
    public function articles()
    {
        return Article::published()->orderBy('published_at', $this->sort)->simplePaginate(9);
    }

    public function render()
    {
        return view('livewire.article-list');
    }
}
