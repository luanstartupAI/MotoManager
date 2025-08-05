<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\Model;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $modelLabel = 'Cliente';
    protected static ?string $pluralModelLabel = 'Clientes';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Vendas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Dados Pessoais')
                    ->description('Informações básicas do cliente.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome Completo')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('document_number')
                            ->label('CPF/CNPJ')
                            ->maxLength(20)
                            ->unique(ignoreRecord: true),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone_number')
                            ->label('Telefone')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        DatePicker::make('birth_date')
                            ->label('Data de Nascimento'),
                    ])->columns(2),

                Section::make('Endereço e Origem')
                    ->description('Detalhes de contato e como o cliente chegou até nós.')
                    ->schema([
                        Textarea::make('address')
                            ->label('Endereço Completo')
                            ->maxLength(65535)
                            ->rows(3)
                            ->columnSpanFull(),
                        Select::make('lead_origin_id')
                            ->label('Origem do Lead')
                            ->relationship('leadOrigin', 'name')
                            ->searchable()
                            ->preload(),
                        Select::make('assigned_to_user_id')
                            ->label('Atribuído ao Vendedor')
                            ->relationship('assignedToUser', 'name')
                            ->searchable()
                            ->preload(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('document_number')
                    ->label('CPF/CNPJ')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone_number')
                    ->label('Telefone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('leadOrigin.name')
                    ->label('Origem Lead')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('assignedToUser.name')
                    ->label('Vendedor')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Criado Em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Última Atualização')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('lead_origin_id')
                    ->relationship('leadOrigin', 'name')
                    ->label('Filtrar por Origem do Lead'),
                SelectFilter::make('assigned_to_user_id')
                    ->relationship('assignedToUser', 'name')
                    ->label('Filtrar por Vendedor'),
            ])
            ->actions([
                ViewAction::make()
                    ->visible(fn (): bool => auth()->user()->can('view_customers')),
                EditAction::make()
                    ->visible(fn (): bool => auth()->user()->can('edit_customers')),
                DeleteAction::make()
                    ->visible(fn (): bool => auth()->user()->can('delete_customers')),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => auth()->user()->can('delete_customers')),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
            'view' => Pages\ViewCustomer::route('/{record}'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->can('view_customers');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create_customers');
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('edit_customers');
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->can('delete_customers');
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()->can('view_customers');
    }
}


