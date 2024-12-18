<x-app-layout :title="$article->title">
    <div class="max-w-5xl py-5 mx-auto mt-10 px-3">
        <img class="my-2 rounded-lg" src="{{ $article->getFeaturedImageUrl() }}" alt="thumbnail">
        <h1 class="text-4xl font-bold text-left text-gray-800">
            {{ $article->title }}
        </h1>
        <div class="flex items-center justify-between mt-2">
            <div class="flex items-center py-5">
                <x-custom.author :author="$article->user" size="md" />
                    <span class="text-sm text-gray-500">| {{ $article->getReadingTime() }} min read</span>
                </div>
                <div class="flex items-center">
                    <span class="mr-2 text-gray-500">{{ $article->published_at->diffForHumans() }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.3"
                    stroke="currentColor" class="w-5 h-5 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <div
        class="flex items-center justify-between px-2 py-4 my-6 text-sm border-t border-b border-gray-100 article-actions-bar">
        <div class="flex items-center">
            <x-custom.category-badge :category="$article->category" />
            </div>
            <div>
                <div class="flex items-center">

                    <livewire:like-button :key="'like-' . $article->id" :$article />
                </div>
            </div>
        </div>
        <div class="grid grid-cols-4">
            <div class="col-span-4">
                <article class="py-3 text-lg prose text-justify text-gray-800 lg:prose-xl max-w-none">{!! str($article->body)->markdown()->sanitizeHtml() !!}</article>
            </div>
        </div>
        {{-- <article class="py-3 text-lg prose text-justify text-gray-800 lg:prose-xl">{!! str($article->body)->markdown()->sanitizeHtml() !!}</article> --}}


        <div class="flex items-center mt-10 space-x-4">
            @foreach ($article->tags as $tag)
            <x-custom.tag-badge :tag="$tag" />
            @endforeach
        </div>

        <livewire:article-comments :key="'comments' . $article->id" :$article />
    </div>
</x-app-layout>
