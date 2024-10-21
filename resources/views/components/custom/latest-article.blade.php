@props(['article'])

<article {{ $attributes->merge(['class' => '[&:not(:last-child)]:border-b border-gray-100 pb-10']) }}>
    <div class="article-body grid grid-cols-12 gap-3 mt-5 items-start">
        <div class="article-thumbnail col-span-4 flex items-center">
            <a href="{{ route('articles.show', $article->slug) }}" >
                <img class="mw-100 mx-auto rounded-xl"
                src="{{ $article->getFeaturedImageUrl() }}"
                alt="{{ $article->featured_image_caption }}">
            </a>
        </div>
        <div class="col-span-8">
            <div class="article-meta flex py-1 text-sm items-center">
                <x-custom.author :author="$article->user" size="sm" />
                <span class="text-gray-500 text-xs">. {{ $article->published_at->diffForHumans() }}</span>
            </div>
            <h2 class="text-xl font-bold text-gray-900">
                <a href="{{ route('articles.show', $article->slug) }}" >
                    {{ $article->title }}
                </a>
            </h2>

            <p class="mt-2 text-base text-gray-700 font-medium">
                {{ $article->getSummary() }}
            </p>
            <div class="flex items-center justify-between mt-6 article-actions-bar">
                <div class="flex gap-x-2">
                        <x-custom.category-badge :category="$article->category" />
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">{{ $article->getReadingTime() }} min read</span>
                    </div>
                </div>
                <div>
                    <livewire:like-button :key="'like-' . $article->id" :$article />
                </div>
        </div>
    </div>
</article>
