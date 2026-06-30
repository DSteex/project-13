<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Filament\Resources\LinkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Override;
use Illuminate\Support\Str;

class CreateLink extends CreateRecord
{
    protected static string $resource = LinkResource::class;

    #[Override]
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['code'] = Str::random(6);

        return $data;
    }
}
