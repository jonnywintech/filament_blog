<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Tabs\Tab;
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
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Filament\Resources\PostResource\RelationManagers\AuthorsRelationManager;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Create new post')->tabs([
                    Tab::make('Basic information')
                        ->icon('heroicon-s-document-text')
                        ->schema([
                            TextInput::make('title')->rules('min:3|max:125')
                                ->minLength(3)
                                ->maxLength(125)
                                ->unique(ignoreRecord: true)
                                ->required(),

                            ColorPicker::make('color')->required(),

                            TextInput::make('slug')->required(),

                            Select::make('category_id')
                                ->label('Select category')
                                ->relationship('category', 'title')
                                ->searchable()
                                ->preload()
                                ->required(),


                        ]),

                    Tab::make('Content')
                        ->icon('heroicon-s-pencil-square')
                        ->schema([
                            MarkdownEditor::make('content')
                                ->columnSpanFull()
                                ->required(),
                        ]),

                    Tab::make('Meta')
                        ->icon('heroicon-s-document-chart-bar')
                        ->schema([
                            TagsInput::make('tags')->separator(',')
                                ->splitKeys(['Tab', ' '])
                                ->required(),

                            FileUpload::make('thumbnail')->required(),

                            Checkbox::make('published'),

                        ]),

                ])->columnSpanFull()->activeTab(3)->persistTabInQueryString(),
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
                // Filter::make('Published Posts')->query(
                //     function($query): Builder {
                //         return $query->where('published', true);
                //     }
                // ),
                SelectFilter::make('category_id')
                ->label('Category')
                ->relationship('category', 'title')
                ->searchable()
                ->preload(),
                TernaryFilter::make('published')
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
            AuthorsRelationManager::class,
            CommentsRelationManager::class,
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
