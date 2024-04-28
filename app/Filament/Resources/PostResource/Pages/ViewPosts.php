<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Widgets\PostOverview;

class ViewPost extends ViewRecord
{
  protected static string $resource = PostResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\EditAction::make(),
    ];
  }


  protected function getHeaderWidgets(): array
  {
    return [
      PostOverview::class,
    ];
  }
}
