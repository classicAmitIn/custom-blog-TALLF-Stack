<?php

namespace App\Filament\Resources\ArticleResource\Widgets;

use App\Models\Article;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class ArticleOverview extends BaseWidget
{
    /**
     * The widget stats.
     */
    protected function getStats(): array
    {
        $articles = Article::count();
        $published = Article::published()->count();
        $category = Category::active()->count();

        return [
            Stat::make('Total Articles', Number::format($articles))
                ->description('The total number of articles')
                ->icon('heroicon-o-book-open'),

            Stat::make('Published Articles', Number::format($published))
                ->description('The total number of published articles')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Total Categories', Number::format($category))
                ->description('The total number of active categories')
                ->icon('heroicon-o-x-circle'),
        ];
    }
}
