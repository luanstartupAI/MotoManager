<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Models\Motorcycle;
use App\Models\Sale;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class AlertsWidget extends Widget
{
    protected static string $view = 'filament.widgets.alerts-widget';
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'alerts' => $this->getAlerts(),
        ];
    }

    private function getAlerts(): array
    {
        $alerts = [];

        // Verificar estoque baixo
        $lowStockCount = Motorcycle::where('status', 'DISPONIVEL')->count();
        if ($lowStockCount <= 3) {
            $alerts[] = [
                'type' => 'danger',
                'icon' => '⚠️',
                'title' => 'Estoque Crítico',
                'message' => "Apenas {$lowStockCount} motos disponíveis. Considere reabastecer o estoque.",
                'action' => 'Ver Estoque',
                'url' => '/admin/motorcycles',
            ];
        }

        // Verificar leads antigos sem follow-up
        $oldLeads = Lead::whereIn('status', ['NOVO', 'CONTATADO'])
            ->where('created_at', '<', Carbon::now()->subDays(7))
            ->count();
        
        if ($oldLeads > 0) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => '📞',
                'title' => 'Leads Pendentes',
                'message' => "{$oldLeads} leads sem contato há mais de 7 dias. Faça o follow-up!",
                'action' => 'Ver Leads',
                'url' => '/admin/leads',
            ];
        }

        // Verificar meta de vendas do mês
        $salesThisMonth = Sale::whereMonth('created_at', Carbon::now()->month)->count();
        $targetSales = 10; // Meta mensal
        
        if ($salesThisMonth < $targetSales * 0.5 && Carbon::now()->day > 15) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => '📈',
                'title' => 'Meta em Risco',
                'message' => "Apenas {$salesThisMonth} vendas este mês. Meta: {$targetSales}. Acelere as vendas!",
                'action' => 'Ver Vendas',
                'url' => '/admin/sales',
            ];
        }

        // Verificar motos paradas há muito tempo
        $staleMotorcycles = Motorcycle::where('status', 'DISPONIVEL')
            ->where('created_at', '<', Carbon::now()->subDays(60))
            ->count();
            
        if ($staleMotorcycles > 0) {
            $alerts[] = [
                'type' => 'info',
                'icon' => '🏍️',
                'title' => 'Motos Paradas',
                'message' => "{$staleMotorcycles} motos no estoque há mais de 60 dias. Considere promoções.",
                'action' => 'Ver Detalhes',
                'url' => '/admin/motorcycles',
            ];
        }

        // Verificar oportunidades quentes
        $hotLeads = Lead::where('status', 'PROPOSTA_ENVIADA')
            ->where('updated_at', '>', Carbon::now()->subDays(3))
            ->count();
            
        if ($hotLeads > 0) {
            $alerts[] = [
                'type' => 'success',
                'icon' => '🔥',
                'title' => 'Oportunidades Quentes',
                'message' => "{$hotLeads} propostas enviadas recentemente. Faça o acompanhamento!",
                'action' => 'Ver Propostas',
                'url' => '/admin/leads',
            ];
        }

        // Se não há alertas, mostrar mensagem positiva
        if (empty($alerts)) {
            $alerts[] = [
                'type' => 'success',
                'icon' => '✅',
                'title' => 'Tudo em Ordem',
                'message' => 'Parabéns! Não há alertas críticos no momento. Continue o excelente trabalho!',
                'action' => null,
                'url' => null,
            ];
        }

        return $alerts;
    }
}

