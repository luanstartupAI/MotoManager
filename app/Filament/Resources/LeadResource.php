<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\LeadOrigin;
use App\Models\Motorcycle;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel = 'Oportunidades';
    protected static ?string $modelLabel = 'Oportunidade';
    protected static ?string $pluralModelLabel = 'Oportunidades';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Vendas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informações do Lead')
                    ->description('Detalhes sobre o lead e o interesse do cliente.')
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->label('Cliente')
                            ->options(Customer::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->placeholder('Selecione o cliente'),
                        Forms\Components\Select::make('motorcycle_of_interest_id')
                            ->label('Moto de Interesse')
                            ->options(Motorcycle::all()->pluck('model', 'id'))
                            ->searchable()
                            ->nullable()
                            ->placeholder('Selecione a moto de interesse'),
                        Forms\Components\Select::make('lead_origin_id')
                            ->label('Origem do Lead')
                            ->options(LeadOrigin::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->placeholder('Selecione a origem'),
                    ])->columns(2),

                Forms\Components\Section::make('Status e Atribuição')
                    ->description('Gerenciamento do funil de vendas e responsável pelo lead.')
                    ->schema([
                        Forms\Components\Select::make('assigned_to_user_id')
                            ->label('Vendedor Responsável')
                            ->options(User::all()->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->placeholder('Selecione o vendedor'),
                        Forms\Components\Select::make('status')
                            ->label('Status do Lead')
                            ->options([
                                'NOVO' => 'Novo',
                                'CONTATADO' => 'Contatado',
                                'PROPOSTA_ENVIADA' => 'Proposta Enviada',
                                'NEGOCIACAO' => 'Negociação',
                                'GANHO' => 'Ganho',
                                'PERDIDO' => 'Perdido',
                            ])
                            ->required()
                            ->reactive(),
                        Forms\Components\Textarea::make('lost_reason')
                            ->label('Motivo da Perda')
                            ->visible(fn (Forms\Get $get): bool => $get('status') === 'PERDIDO')
                            ->maxLength(65535)
                            ->rows(3),
                    ])->columns(2),
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
                Tables\Columns\TextColumn::make('motorcycleOfInterest.model')
                    ->label('Moto de Interesse')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('assignedToUser.name')
                    ->label('Vendedor')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('leadOrigin.name')
                    ->label('Origem')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'NOVO' => 'gray',
                        'CONTATADO' => 'info',
                        'PROPOSTA_ENVIADA' => 'warning',
                        'NEGOCIACAO' => 'primary',
                        'GANHO' => 'success',
                        'PERDIDO' => 'danger',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lost_reason')
                    ->label('Motivo da Perda')
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
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filtrar por Status')
                    ->options([
                        'NOVO' => 'Novo',
                        'CONTATADO' => 'Contatado',
                        'PROPOSTA_ENVIADA' => 'Proposta Enviada',
                        'NEGOCIACAO' => 'Negociação',
                        'GANHO' => 'Ganho',
                        'PERDIDO' => 'Perdido',
                    ]),
                Tables\Filters\SelectFilter::make('assigned_to_user_id')
                    ->label('Filtrar por Vendedor')
                    ->options(User::all()->pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('lead_origin_id')
                    ->label('Filtrar por Origem')
                    ->options(LeadOrigin::all()->pluck('name', 'id')),
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
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
            'view' => Pages\ViewLead::route('/{record}'),
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


