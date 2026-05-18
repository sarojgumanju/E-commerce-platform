<?php

namespace App\Filament\Dokan\Resources\Products\Pages;

use App\Filament\Dokan\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Override;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    #[Override]
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        
    $data['dokan_id'] = Auth::guard('dokan')->user()->id;
    $data['slug'] = Str::slug($data['name']);
    return parent::mutateFormDataBeforeCreate($data);
    }
}
