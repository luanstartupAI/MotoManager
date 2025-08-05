<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MotorcycleResource\Pages;
use App\Filament\Resources\MotorcycleResource\RelationManagers;
use App\Models\Motorcycle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class MotorcycleResource extends Resource
{
    protected static ?string $model = Motorcycle::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Estoque';
    protected static ?string $modelLabel = 'Motocicleta';
    protected static ?string $pluralModelLabel = 'Motocicletas';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Estoque';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dados Básicos da Moto')
                    ->description('Informações essenciais de identificação e tipo da motocicleta.')
                    ->schema([
                        Forms\Components\TextInput::make('brand')
                            ->label('Marca')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('model')
                            ->label('Modelo')
                            ->required()
                            ->maxLength(100),
                        Forms\Components\TextInput::make('version')
                            ->label('Versão')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('model_year')
                            ->label('Ano Modelo')
                            ->numeric()
                            ->required()
                            ->minValue(1900)
                            ->maxValue(date('Y') + 2),
                        Forms\Components\TextInput::make('manufacture_year')
                            ->label('Ano Fabricação')
                            ->numeric()
                            ->required()
                            ->minValue(1900)
                            ->maxValue(date('Y') + 1),
                        Forms\Components\Select::make('type')
                            ->label('Tipo')
                            ->options([
                                'NOVA' => 'Nova',
                                'USADA' => 'Usada',
                            ])
                            ->required()
                            ->reactive(), // Para reagir à seleção e mostrar/esconder campos
                        Forms\Components\TextInput::make('color')
                            ->label('Cor')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('mileage')
                            ->label('Quilometragem (KM)')
                            ->numeric()
                            ->default(0)
                            ->visible(fn (Forms\Get $get): bool => $get('type') === 'USADA'), // Visível apenas para motos usadas
                        Forms\Components\TextInput::make('engine_details')
                            ->label('Detalhes do Motor')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Documentação e Identificação')
                    ->description('Números de chassi, placa e RENAVAM para registro.')
                    ->schema([
                        Forms\Components\TextInput::make('license_plate')
                            ->label('Placa')
                            ->maxLength(10)
                            ->unique(ignoreRecord: true)
                            ->visible(fn (Forms\Get $get): bool => $get('type') === 'USADA'), // Visível apenas para motos usadas
                        Forms\Components\TextInput::make('chassis_number')
                            ->label('Número do Chassi')
                            ->maxLength(100)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('renavam')
                            ->label('RENAVAM')
                            ->maxLength(100)
                            ->unique(ignoreRecord: true)
                            ->visible(fn (Forms\Get $get): bool => $get('type') === 'USADA'), // Visível apenas para motos usadas
                        Forms\Components\TextInput::make('fipe_code')
                            ->label('Código FIPE')
                            ->maxLength(50)
                            ->helperText('Utilizado para consulta automática de preço de referência.'),
                    ])->columns(2),

                Forms\Components\Section::make('Valores e Status')
                    ->description('Preços de compra, venda e o status atual da moto no estoque.')
                    ->schema([
                        Forms\Components\TextInput::make('purchase_price')
                            ->label('Preço de Compra (Custo)')
                            ->numeric()
                            ->required()
                            ->prefix('R$'),
                        Forms\Components\TextInput::make('refurbishment_cost')
                            ->label('Custo de Recondicionamento')
                            ->numeric()
                            ->default(0.00)
                            ->prefix('R$')
                            ->helperText('Custos de reparo e preparação para venda.'),
                        Forms\Components\TextInput::make('sale_price')
                            ->label('Preço de Venda Anunciado')
                            ->numeric()
                            ->required()
                            ->prefix('R$'),
                        Forms\Components\Select::make('status')
                            ->label('Status no Estoque')
                            ->options([
                                'DISPONIVEL' => 'Disponível',
                                'RESERVADA' => 'Reservada',
                                'VENDIDA' => 'Vendida',
                                'EM_MANUTENCAO' => 'Em Manutenção',
                                'AVALIACAO' => 'Em Avaliação',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('purchase_date')
                            ->label('Data de Entrada no Estoque'),
                    ])->columns(2),

                Forms\Components\Section::make('Imagens da Moto')
                    ->description('Faça upload das fotos da motocicleta.')
                    ->schema([
                        Forms\Components\FileUpload::make('images')
                            ->label('Fotos da Moto')
                            ->multiple()
                            ->image()
                            ->reorderable()
                            ->appendFiles()
                            ->storeFileNamesIn('original_filename')
                            ->collection('motorcycle_images'), // Nome da coleção de mídia
                    ]),

                Forms\Components\Section::make('Observações Adicionais')
                    ->description('Qualquer informação extra relevante sobre a motocicleta.')
                    ->schema([
                        Forms\Components\Textarea::make('details')
                            ->label('Detalhes/Observações')
                            ->maxLength(65535)
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('brand')
                    ->label('Marca')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('model')
                    ->label('Modelo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('version')
                    ->label('Versão')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('license_plate')
                    ->label('Placa')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('mileage')
                    ->label('KM')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('sale_price')
                    ->label('Preço Venda')
                    ->money('BRL')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'DISPONIVEL' => 'success',
                        'RESERVADA' => 'warning',
                        'VENDIDA' => 'danger',
                        'EM_MANUTENCAO' => 'info',
                        'AVALIACAO' => 'gray',
                    })
                    ->searchable()
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
                Tables\Filters\SelectFilter::make('type')
                    ->label('Filtrar por Tipo')
                    ->options([
                        'NOVA' => 'Nova',
                        'USADA' => 'Usada',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filtrar por Status')
                    ->options([
                        'DISPONIVEL' => 'Disponível',
                        'RESERVADA' => 'Reservada',
                        'VENDIDA' => 'Vendida',
                        'EM_MANUTENCAO' => 'Em Manutenção',
                        'AVALIACAO' => 'Em Avaliação',
                    ]),
                Tables\Filters\SelectFilter::make('brand')
                    ->label('Filtrar por Marca')
                    ->options(Motorcycle::distinct()->pluck('brand', 'brand')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMotorcycles::route('/'),
            'create' => Pages\CreateMotorcycle::route('/create'),
            'edit' => Pages\EditMotorcycle::route('/{record}/edit'),
            'view' => Pages\ViewMotorcycle::route('/{record}'),
        ];
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canEdit(Model $record): bool
    {
        return true;
    }

    public static function canDelete(Model $record): bool
    {
        return true;
    }

    public static function canView(Model $record): bool
    {
        return true;
    }
}


