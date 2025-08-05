<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppraisalResource\Pages;
use App\Filament\Resources\AppraisalResource\RelationManagers;
use App\Models\Appraisal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AppraisalResource extends Resource
{
    protected static ?string $model = Appraisal::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Avaliações';
    protected static ?string $modelLabel = 'Avaliação';
    protected static ?string $pluralModelLabel = 'Avaliações';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Estoque';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dados da Avaliação')
                    ->description('Informações gerais sobre a avaliação da motocicleta.')
                    ->schema([
                        Forms\Components\Select::make('motorcycle_id')
                            ->label('Moto Avaliada')
                            ->relationship('motorcycle', 'model')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('customer_id')
                            ->label('Cliente')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('fipe_code')
                            ->label('Código FIPE')
                            ->maxLength(50)
                            ->helperText('Código FIPE da moto para consulta de valor de referência.'),
                        Forms\Components\TextInput::make('fipe_value')
                            ->label('Valor FIPE (R$)')
                            ->numeric()
                            ->prefix('R$')
                            ->helperText('Valor de referência da tabela FIPE.'),
                        Forms\Components\TextInput::make('appraisal_value')
                            ->label('Valor de Avaliação (R$)')
                            ->numeric()
                            ->prefix('R$')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $appraisalValue = (float) $get('appraisal_value');
                                $refurbishmentCost = (float) $get('total_refurbishment_cost');
                                $set('final_calculated_price', $appraisalValue - $refurbishmentCost);
                            })
                            ->helperText('Valor proposto pela loja para compra da moto.'),
                        Forms\Components\DatePicker::make('appraisal_date')
                            ->label('Data da Avaliação')
                            ->required(),
                        Forms\Components\Textarea::make('notes')
                            ->label('Observações da Avaliação')
                            ->maxLength(65535)
                            ->rows(3),
                    ])->columns(2),

                Forms\Components\Section::make('Custos de Repasse e Preço Final')
                    ->description('Detalhes dos custos de reparo e o cálculo do preço final de repasse.')
                    ->schema([
                        Placeholder::make('total_refurbishment_cost')
                            ->label('Custo Total de Repasse (R$)')
                            ->content(function (?Appraisal $record, Set $set, Get $get): string {
                                if (!$record) {
                                    $set('total_refurbishment_cost', 0.00);
                                    return 'R$ 0,00';
                                }
                                $totalCost = $record->appraisalItems()->sum('cost');
                                $set('total_refurbishment_cost', $totalCost);
                                $appraisalValue = (float) $get('appraisal_value');
                                $set('final_calculated_price', $appraisalValue - $totalCost);
                                return new HtmlString('<span class="font-bold text-lg">R$ ' . number_format($totalCost, 2, ',', '.') . '</span>');
                            })
                            ->live()
                            ->dehydrated(false),

                        Placeholder::make('final_calculated_price')
                            ->label('Preço Final Calculado (R$)')
                            ->content(function (Get $get): string|HtmlString {
                                $appraisalValue = (float) $get('appraisal_value');
                                $refurbishmentCost = (float) $get('total_refurbishment_cost');
                                $finalPrice = $appraisalValue - $refurbishmentCost;
                                return new HtmlString('<span class="font-bold text-lg text-primary-600">R$ ' . number_format($finalPrice, 2, ',', '.') . '</span>');
                            })
                            ->live()
                            ->dehydrated(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('motorcycle.model')
                    ->label('Moto')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fipe_value')
                    ->label('Valor FIPE')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('appraisal_value')
                    ->label('Valor Avaliado')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_refurbishment_cost')
                    ->label('Custo Repasse')
                    ->money('BRL')
                    ->getStateUsing(fn (Appraisal $record): float => $record->appraisalItems()->sum('cost'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('final_calculated_price')
                    ->label('Preço Final')
                    ->money('BRL')
                    ->getStateUsing(fn (Appraisal $record): float => (float) $record->appraisal_value - $record->appraisalItems()->sum('cost'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('appraisal_date')
                    ->label('Data Avaliação')
                    ->date()
                    ->sortable(),
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
                Tables\Actions\ViewAction::make()
                    ->visible(fn (): bool => Auth::user()?->can('view_appraisals') ?? false),
                Tables\Actions\EditAction::make()
                    ->visible(fn (): bool => Auth::user()?->can('edit_appraisals') ?? false),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (): bool => Auth::user()?->can('delete_appraisals') ?? false),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn (): bool => Auth::user()?->can('delete_appraisals') ?? false),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AppraisalItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAppraisals::route('/'),
            'create' => Pages\CreateAppraisal::route('/create'),
            'edit' => Pages\EditAppraisal::route('/{record}/edit'),
            'view' => Pages\ViewAppraisal::route('/{record}'),
        ];
    }

    public static function canViewAny(): bool
    {
        return Auth::user()?->can('view_appraisals') ?? false;
    }

    public static function canCreate(): bool
    {
        return Auth::user()?->can('create_appraisals') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return Auth::user()?->can('edit_appraisals') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return Auth::user()?->can('delete_appraisals') ?? false;
    }
}


