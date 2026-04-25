<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Action;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make
                ([
                    Step::make('Product Information')
                        ->icon('heroicon-o-information-circle')
                        ->description('Isi Informasi Produk')
                        ->schema
                        ([
                            Group::make
                            ([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('sku')
                                ->required(),
                            ])->columns(2),
                            MarkdownEditor::make('description')
                        ]),
                    Step::make('Pricing & Stock')
                        ->icon('heroicon-o-currency-dollar')
                        ->description('Isi Harga dan Jumlah Stok')
                        ->schema
                        ([
                            TextInput::make('price')
                                ->numeric()
                                ->minValue(1)
                                ->required(),
                            TextInput::make('stock')
                                ->numeric()
                                ->required(),
                        ]),
                    Step::make('Media & Status')
                        ->icon('heroicon-o-photo')
                        ->description('Upload gambar dan atur status')
                        ->schema([
                            FileUpload::make('image')
                                ->disk('public')
                                ->directory('products'),
                            Checkbox::make('is_active'),
                            Checkbox::make('is_featured'),
                        ]),
                ])
                ->columnSpanFull()
                ->submitAction(
                    Action::make('save')
                        ->label('Save Product')
                        ->color('primary')
                        ->submit('save')
                )
            ]);
    }
}
