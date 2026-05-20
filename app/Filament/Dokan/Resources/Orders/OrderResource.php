<?php

namespace App\Filament\Dokan\Resources\Orders;

use App\Filament\Dokan\Resources\Orders\Pages\CreateOrder;
use App\Filament\Dokan\Resources\Orders\Pages\EditOrder;
use App\Filament\Dokan\Resources\Orders\Pages\ListOrders;
use App\Filament\Dokan\Resources\Orders\Schemas\OrderForm;
use App\Filament\Dokan\Resources\Orders\Tables\OrdersTable;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\Auth;
use Override;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BellAlert;

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    #[Override]
    public static function getEloquentQuery(): EloquentBuilder
    {
        return Order::where('dokan_id', Auth::guard('dokan')->user()->id);
    }

    public static function table(Table $table): Table
    {
        return OrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
