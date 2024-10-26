<div class=" px-3 lg:px-7 py-6">
    <div class="flex justify-between items-center border-b border-gray-100">
        <div class="text-gray-600">
            @if ($this->activeCategory || $search)
                <x-button class="mr-3 text-xs gray-500" wire:click="clearFilters()">Reset</x-button>
            @endif
            @if ($this->activeCategory)
                <x-custom.badge wire:navigate href="{{ route('articles.index', ['category' => $this->activeCategory->slug]) }}"
                    :textColor="$this->activeCategory->text_color" :bgColor="$this->activeCategory->bg_color">
                    {{ $this->activeCategory->title }}
                </x-custom.badge>
            @endif
            @if ($search)
                <span class="ml-2">
                    Searching : <strong>{{ $search }}</strong>
                </span>
            @endif
        </div>
        <div class="flex items-center space-x-4 font-medium">
            <x-checkbox wire:model.live="popular" />
            <x-label>Popular</x-label>
            <span>|</span>
            <button class="{{ $sort === 'desc' ? 'text-gray-900 border-b border-gray-700' : 'text-gray-500'}} py-4" wire:click="setSort('desc')">Latest</button>
            <button class="{{ $sort === 'asc' ? 'text-gray-900 border-b border-gray-700' : 'text-gray-500'}} py-4" wire:click="setSort('asc')">Oldest</button>
        </div>
    </div>
    <div class="py-4">
        @foreach ($this->articles as $article)
            <x-custom.latest-article wire:key="{{ $article->id }}" :article="$article" />
        @endforeach
    </div>

    <div class="my-3">
        {{ $this->articles->links() }}
    </div>
</div>
