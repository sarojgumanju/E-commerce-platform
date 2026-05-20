<?php

namespace App\Filament\Dokan\Resources\Orders\Pages;

use App\Filament\Dokan\Resources\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
