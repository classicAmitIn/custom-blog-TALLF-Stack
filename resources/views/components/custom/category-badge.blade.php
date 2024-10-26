@props(['category'])
<x-custom.badge wire:navigate href="{{ route('articles.index', ['category' => $category->slug]) }}" :textColor="$category->text_color"
    :bgColor="$category->bg_color">
    {{ $category->title }}
</x-custom.badge>
