<?php

namespace App\Filament\Resources\CategoryResource\Widgets;

use App\Models\Article;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class CategoryOverview extends BaseWidget
{
    /**
     * The widget stats.
     */
    protected function getStats(): array
    {
        $categories = Category::count();
        $active = Category::active()->count();
        $articleCount = Article::published()->count();

        return [
            Stat::make('Total Categories', Number::format($categories))
                ->description('The total number of categories')
                ->icon('heroicon-o-book-open'),

            Stat::make('Active Categories', Number::format($active))
                ->description('The total number of active categories')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Total Articles', Number::format($articleCount))
                ->description('The total number of published articles')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
