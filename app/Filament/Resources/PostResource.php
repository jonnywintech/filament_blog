<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([

                    TextInput::make('title')->rules('min:3|max:125')
                        ->minLength(3)
                        ->maxLength(125)
                        ->unique(ignoreRecord: true)
                        ->required(),

                    ColorPicker::make('color')->required(),

                    TextInput::make('slug'),

                    Select::make('category_id')
                        ->label('Select category')
                        ->relationship('category', 'title')
                        ->searchable()
                        ->preload()
                        ->required(),

                    MarkdownEditor::make('content')
                        ->columnSpanFull()
                        ->required(),

                ])->columns(2)->columnSpan(2),

                Group::make()->schema([

                    Section::make()->schema([

                        FileUpload::make('thumbnail')->required(),

                    ])->columnSpan(1),

                    Section::make()->schema([

                        TagsInput::make('tags')->separator(',')
                            ->splitKeys(['Tab', ' '])
                            ->required(),

                        Checkbox::make('published'),

                    ])->columnSpan(1),

                ])->columnSpan(1),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')->searchable()
                    ->sortable(),
                TextColumn::make('category.title'),
                TextColumn::make('slug'),
                ColorColumn::make('color'),
                ImageColumn::make('thumbnail')->disk('public')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')->label('Created Date')
                    ->sortable(),
                TextColumn::make('updated_at')->label('Updated Date')
                    ->date()
                    ->sortable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
