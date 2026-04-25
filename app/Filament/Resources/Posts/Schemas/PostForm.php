<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Group;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
        ->components([
                // Section 1 - Post Details
                Section::make('Post Details')
                ->description('Fill in the details of the post.')
                ->icon('heroicon-o-document-text')
                ->schema([
            Group::make([
                    TextInput::make('title')->rules('required|min:5|max:255')
                    ->validationMessages([
                        'required' => 'Judul postingan tidak boleh kosong.',
                        'min' => 'Judul terlalu pendek, minimal harus 5 karakter.',
                        'max' => 'Judul terlalu panjang, maksimal 255 karakter.',
                    ]),
                    TextInput::make('slug')
                    ->unique(ignoreRecord: true)
                    ->rules('required|min:3')
                    ->validationMessages([
                        'unique' => 'Slug harus unik dan tidak boleh sama',
                    ]),
                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->required()
                        ->preload()
                        ->searchable(),
                    ColorPicker::make('color'),
                ])->columns(2),
                    MarkdownEditor::make('body')->columnSpanFull(),
                ])->columnSpan(2),

                Group::make([
                // Section 2 - Image
                Section::make("Image Upload")
                ->icon('heroicon-o-photo')
                ->schema([
                    FileUpload::make('image')->image()
                        ->required()
                        ->validationMessages([
                            'required' => 'Gambar harus diunggah.',
                            'image' => 'File yang diunggah harus berupa gambar.',
                        ])
                        ->directory('posts')
                        ->disk('public'),
                ]),
                // Section 3 - Meta
                Section::make('Meta Information')
                ->icon('heroicon-o-cog-6-tooth')
                ->schema([
                    TagsInput::make('tags'),
                    Checkbox::make('published'),
                    DateTimePicker::make('published_at'),
                ]),
            ])->columnSpan(1),
        ])->columns(3);
    }
}