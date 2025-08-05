<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Vendas';
    protected static ?string $modelLabel = 'Venda';
    protected static ?string $pluralModelLabel = 'Vendas';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Vendas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->label('Cliente')
                    ->relationship('customer', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('motorcycle_id')
                    ->label('Motocicleta')
                    ->relationship('motorcycle', 'model')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('user_id')
                    ->label('Vendedor')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\TextInput::make('original_price')
                    ->label('Preço Original')
                    ->numeric()
                    ->prefix('R$')
                    ->required(),

                Forms\Components\TextInput::make('discount_amount')
                    ->label('Desconto')
                    ->numeric()
                    ->prefix('R$')
                    ->default(0),

                Forms\Components\TextInput::make('final_sale_price')
                    ->label('Preço Final')
                    ->numeric()
                    ->prefix('R$')
                    ->required(),

                Forms\Components\Select::make('payment_method')
                    ->label('Forma de Pagamento')
                    ->options([
                        'DINHEIRO' => 'Dinheiro',
                        'CARTAO_CREDITO' => 'Cartão de Crédito',
                        'CARTAO_DEBITO' => 'Cartão de Débito',
                        'FINANCIAMENTO' => 'Financiamento',
                        'PIX' => 'PIX',
                        'TRANSFERENCIA' => 'Transferência',
                    ])
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'PENDENTE' => 'Pendente',
                        'CONFIRMADA' => 'Confirmada',
                        'ENTREGUE' => 'Entregue',
                        'CANCELADA' => 'Cancelada',
                    ])
                    ->required()
                    ->default('PENDENTE'),

                Forms\Components\DatePicker::make('sale_date')
                    ->label('Data da Venda')
                    ->required()
                    ->default(now()),

                Forms\Components\Textarea::make('notes')
                    ->label('Observações')
                    ->rows(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('motorcycle.brand')
                    ->label('Marca')
                    ->searchable(),

                Tables\Columns\TextColumn::make('motorcycle.model')
                    ->label('Modelo')
                    ->searchable(),

                Tables\Columns\TextColumn::make('final_sale_price')
                    ->label('Valor Final')
                    ->money('BRL')
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Pagamento')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'DINHEIRO' => 'success',
                        'PIX' => 'info',
                        'CARTAO_CREDITO', 'CARTAO_DEBITO' => 'warning',
                        'FINANCIAMENTO' => 'primary',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'CONFIRMADA' => 'success',
                        'ENTREGUE' => 'primary',
                        'PENDENTE' => 'warning',
                        'CANCELADA' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Vendedor')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sale_date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'PENDENTE' => 'Pendente',
                        'CONFIRMADA' => 'Confirmada',
                        'ENTREGUE' => 'Entregue',
                        'CANCELADA' => 'Cancelada',
                    ]),

                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Forma de Pagamento')
                    ->options([
                        'DINHEIRO' => 'Dinheiro',
                        'CARTAO_CREDITO' => 'Cartão de Crédito',
                        'CARTAO_DEBITO' => 'Cartão de Débito',
                        'FINANCIAMENTO' => 'Financiamento',
                        'PIX' => 'PIX',
                        'TRANSFERENCIA' => 'Transferência',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Excluir'),
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}

