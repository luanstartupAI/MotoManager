<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Models\Motorcycle;
use App\Models\Sale;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $totalMotorcycles = Motorcycle::where("status", "DISPONIVEL")->count();
        $totalLeads = Lead::whereIn("status", ["NOVO", "CONTATADO", "PROPOSTA_ENVIADA", "NEGOCIACAO"])->count();
        $totalSales = Sale::count();
        $totalRevenue = Sale::sum("final_sale_price");
        
        // Calcular vendas do mês atual vs mês anterior
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $salesThisMonth = Sale::whereMonth('created_at', $currentMonth)
                             ->whereYear('created_at', $currentYear)
                             ->count();
        
        $lastMonth = Carbon::now()->subMonth();
        $salesLastMonth = Sale::whereMonth('created_at', $lastMonth->month)
                             ->whereYear('created_at', $lastMonth->year)
                             ->count();
        
        $salesTrend = $salesLastMonth > 0 ? 
            round((($salesThisMonth - $salesLastMonth) / $salesLastMonth) * 100, 1) : 
            ($salesThisMonth > 0 ? 100 : 0);

        // Calcular leads convertidos
        $convertedLeads = Lead::where("status", "VENDIDO")->count();
        $conversionRate = $totalLeads > 0 ? round(($convertedLeads / ($totalLeads + $convertedLeads)) * 100, 1) : 0;

        // Calcular ticket médio
        $averageTicket = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        return [
            Stat::make("💰 Faturamento Total", "R$ " . number_format($totalRevenue, 2, ",", "."))
                ->description("Receita total das vendas")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make("🏍️ Motos Disponíveis", $totalMotorcycles)
                ->description($totalMotorcycles > 5 ? "Estoque saudável" : "⚠️ Estoque baixo")
                ->descriptionIcon($totalMotorcycles > 5 ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-triangle')
                ->color($totalMotorcycles > 5 ? 'success' : 'warning'),

            Stat::make("🎯 Leads Ativos", $totalLeads)
                ->description("Taxa de conversão: {$conversionRate}%")
                ->descriptionIcon($conversionRate > 20 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($conversionRate > 20 ? 'success' : 'danger'),

            Stat::make("📈 Vendas do Mês", $salesThisMonth)
                ->description($salesTrend >= 0 ? "+{$salesTrend}% vs mês anterior" : "{$salesTrend}% vs mês anterior")
                ->descriptionIcon($salesTrend >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart([3, 5, 2, 8, 4, 9, $salesThisMonth])
                ->color($salesTrend >= 0 ? 'success' : 'danger'),

            Stat::make("💵 Ticket Médio", "R$ " . number_format($averageTicket, 2, ",", "."))
                ->description("Valor médio por venda")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('info'),

            Stat::make("⭐ Performance Geral", $this->getPerformanceScore() . "%")
                ->description($this->getPerformanceDescription())
                ->descriptionIcon($this->getPerformanceIcon())
                ->color($this->getPerformanceColor()),
        ];
    }

    private function getPerformanceScore(): int
    {
        $score = 0;
        
        // Pontuação baseada em estoque
        $motorcycles = Motorcycle::where("status", "DISPONIVEL")->count();
        if ($motorcycles > 10) $score += 25;
        elseif ($motorcycles > 5) $score += 15;
        elseif ($motorcycles > 0) $score += 10;
        
        // Pontuação baseada em leads
        $leads = Lead::whereIn("status", ["NOVO", "CONTATADO", "PROPOSTA_ENVIADA", "NEGOCIACAO"])->count();
        if ($leads > 10) $score += 25;
        elseif ($leads > 5) $score += 15;
        elseif ($leads > 0) $score += 10;
        
        // Pontuação baseada em vendas
        $sales = Sale::whereMonth('created_at', Carbon::now()->month)->count();
        if ($sales > 5) $score += 25;
        elseif ($sales > 2) $score += 15;
        elseif ($sales > 0) $score += 10;
        
        // Pontuação baseada em faturamento
        $revenue = Sale::sum("final_sale_price");
        if ($revenue > 100000) $score += 25;
        elseif ($revenue > 50000) $score += 15;
        elseif ($revenue > 0) $score += 10;
        
        return min($score, 100);
    }

    private function getPerformanceDescription(): string
    {
        $score = $this->getPerformanceScore();
        
        if ($score >= 80) return "Excelente performance!";
        if ($score >= 60) return "Boa performance";
        if ($score >= 40) return "Performance regular";
        return "Precisa melhorar";
    }

    private function getPerformanceIcon(): string
    {
        $score = $this->getPerformanceScore();
        
        if ($score >= 80) return 'heroicon-m-trophy';
        if ($score >= 60) return 'heroicon-m-face-smile';
        if ($score >= 40) return 'heroicon-m-face-frown';
        return 'heroicon-m-exclamation-triangle';
    }

    private function getPerformanceColor(): string
    {
        $score = $this->getPerformanceScore();
        
        if ($score >= 80) return 'success';
        if ($score >= 60) return 'info';
        if ($score >= 40) return 'warning';
        return 'danger';
    }
}


