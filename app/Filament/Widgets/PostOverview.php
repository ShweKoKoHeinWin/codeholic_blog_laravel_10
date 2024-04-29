<?php

namespace App\Filament\Widgets;

use App\Models\PostView;
use App\Models\UpvoteDownvote;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Database\Eloquent\Model;

class PostOverview extends BaseWidget
{
    public ?Model $record = null;
    protected static string $view = 'post-resource.widgets.post-overview';

    protected int | string | array $columnSpan = 3;

    protected function getViewData(): array
    {
        return [
            'viewCounts' => PostView::where('post_id', '=', $this->record->id)->count(),
            'upvotes' => UpvoteDownvote::where('post_id', '=', $this->record->id)->where('is_upvote', '=', 1)->count(),
            'downvotes' => UpvoteDownvote::where('post_id', '=', $this->record->id)->where('is_upvote', '=', 0)->count()
        ];
    }
}
