<x-app-layout title="Articles">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full grid grid-cols-4 gap-10">
                <div class="md:col-span-3 col-span-4">
                    <livewire:article-list />
                </div>

                <div id="side-bar"
                class="border-t border-t-gray-100 md:border-t-none col-span-4 md:col-span-1 px-3 md:px-6  space-y-10 py-6 pt-10 md:border-l border-gray-100 h-screen sticky top-0">
                @include('articles.partials.search-box')
                @include('articles.partials.category-box')
            </div>
        </div>
    </div>
</div>
</x-app-layout>
