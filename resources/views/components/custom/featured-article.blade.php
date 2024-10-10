@props(['article'])

<div>
    <a href="{{ route('articles.show', $article->slug) }}">
        <div>
            <img class="w-full rounded-xl"
                src="{{ $article->getFeaturedImageUrl() }}">
        </div>
    </a>
    <div class="mt-3">
        <div class="flex items-center mb-2">
            <x-custom.category-badge :category="$article->category" />
            <p class="text-gray-500 text-sm">{{ $article->published_at->format('M d, Y') }}</p>
        </div>
        <a href="{{ route('articles.show', $article->slug) }}" class="text-xl font-bold text-gray-900">{{ $article->title }}</a>
    </div>

</div>
