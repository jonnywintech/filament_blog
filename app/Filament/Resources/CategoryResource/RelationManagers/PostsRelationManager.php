<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
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

                TextInput::make('slug')->required(),

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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('id')->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')->searchable()
                    ->sortable(),
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
