<x-app-layout title="Welcome">
    <x-custom.hero />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <div class="mb-16">
                    <h2 class="mt-16 mb-5 text-3xl text-yellow-800 font-bold">Featured Articles</h2>
                    <div class="grid grid-cols-3 gap-10 w-full">
                        @foreach ($featuredArticles as $article)
                        <x-custom.featured-article :article="$article" class="md:col-span-1 col-span-3" />
                        @endforeach
                    </div>
                    <a class="mt-10 block text-center text-lg text-yellow-800 font-semibold"
                    href="{{ route('articles.index') }}">More
                    Articles</a>
                </div>
                <hr>
                <h2 class="mt-16 mb-5 text-3xl text-yellow-800 font-bold">Latest Articles</h2>
                <div class="w-full mb-5">
                    @foreach ($latestArticles as $article)
                    <x-custom.latest-article :article="$article" />
                    @endforeach
                </div>
            </div>
            <a class="mt-10 block text-center text-lg text-yellow-800 font-semibold"
            href="{{ route('articles.index') }}">More
            Articles</a>
        </div>
    </div>
</div>
</x-app-layout>
