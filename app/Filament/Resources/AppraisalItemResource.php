<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppraisalItemResource\Pages;
use App\Filament\Resources\AppraisalItemResource\RelationManagers;
use App\Models\AppraisalItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class AppraisalItemResource extends Resource
{
    protected static ?string $model = AppraisalItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationLabel = 'Itens de Avaliação';
    protected static ?string $modelLabel = 'Item de Avaliação';
    protected static ?string $pluralModelLabel = 'Itens de Avaliação';
    protected static bool $shouldRegisterNavigation = false; // Ocultar do menu

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('appraisal_id')
                    ->label('Avaliação Relacionada')
                    ->relationship('appraisal', 'id')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('item_name')
                    ->label('Item/Serviço')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cost')
                    ->label('Custo (R$)')
                    ->numeric()
                    ->prefix('R$')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->label('Observações')
                    ->maxLength(65535)
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('appraisal.id')
                    ->label('ID Avaliação')
                    ->sortable(),
                Tables\Columns\TextColumn::make('item_name')
                    ->label('Item/Serviço')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost')
                    ->label('Custo')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Observações')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado Em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Última Atualização')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn (): bool => Auth::user()?->can('edit_appraisal_items') ?? false),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (): bool => Auth::user()?->can('delete_appraisal_items') ?? false),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn (): bool => Auth::user()?->can('delete_appraisal_items') ?? false),
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
            'index' => Pages\ListAppraisalItems::route('/'),
            'create' => Pages\CreateAppraisalItem::route('/create'),
            'edit' => Pages\EditAppraisalItem::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('view_appraisal_items') ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('create_appraisal_items') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()?->can('edit_appraisal_items') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()?->can('delete_appraisal_items') ?? false;
    }
}


