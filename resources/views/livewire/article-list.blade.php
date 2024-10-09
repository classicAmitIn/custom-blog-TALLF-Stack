<div class=" px-3 lg:px-7 py-6">
    <div class="flex justify-between items-center border-b border-gray-100">
        <div class="flex items-center space-x-4 font-light ">
            <button class="text-gray-500 py-4" wire:click="setSort('desc')">Latest</button>
            <button class="text-gray-900 py-4 border-b border-gray-700" wire:click="setSort('asc')">Oldest</button>
        </div>
    </div>
    <div class="py-4">
        @foreach ($this->articles as $article)
            <x-custom.latest-article :article="$article" />
        @endforeach
    </div>

    <div class="my-3">
        {{ $this->articles->links() }}
    </div>
</div>
