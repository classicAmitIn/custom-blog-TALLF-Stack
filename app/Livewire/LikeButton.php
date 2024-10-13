<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class LikeButton extends Component
{

    public Article $article;

    public function toggleLike()
    {
        if (auth()->guest()) {
            return $this->redirect(route('login'), true);
        }

        $user = auth()->user();

        if ($user->hasLiked($this->article)) {
            $user->likes()->detach($this->article);
            return;
        }

        $user->likes()->attach($this->article);
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
