<?php

namespace App\Filament\Widgets;

use App\Models\Motorcycle;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class InventoryTurnoverWidget extends ChartWidget
{
    protected static ?string $heading = '🏍️ Distribuição do Estoque por Marca';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        // Buscar motos disponíveis por marca
        $motorcyclesByBrand = Motorcycle::where('status', 'DISPONIVEL')
            ->selectRaw('brand, COUNT(*) as total')
            ->groupBy('brand')
            ->get();

        $labels = [];
        $data = [];
        $colors = [
            'rgba(239, 68, 68, 0.8)',   // Vermelho vibrante
            'rgba(59, 130, 246, 0.8)',  // Azul vibrante
            'rgba(16, 185, 129, 0.8)',  // Verde vibrante
            'rgba(245, 158, 11, 0.8)',  // Amarelo vibrante
            'rgba(139, 92, 246, 0.8)',  // Roxo vibrante
            'rgba(236, 72, 153, 0.8)',  // Rosa vibrante
        ];

        foreach ($motorcyclesByBrand as $index => $motorcycle) {
            $labels[] = $motorcycle->brand . ' (' . $motorcycle->total . ')';
            $data[] = $motorcycle->total;
        }

        // Se não há motos, mostrar dados de exemplo
        if (empty($labels)) {
            $labels = ['Honda (1)', 'Yamaha (1)'];
            $data = [1, 1];
            $colors = ['rgba(239, 68, 68, 0.8)', 'rgba(59, 130, 246, 0.8)'];
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                    'borderColor' => array_map(function($color) {
                        return str_replace('0.8', '1', $color);
                    }, array_slice($colors, 0, count($data))),
                    'borderWidth' => 3,
                    'hoverBorderWidth' => 5,
                    'hoverOffset' => 10,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                    'labels' => [
                        'usePointStyle' => true,
                        'padding' => 20,
                        'font' => [
                            'size' => 12,
                            'weight' => 'bold',
                        ],
                        'generateLabels' => null, // Usar labels padrão
                    ],
                ],
                'tooltip' => [
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                    'titleColor' => '#fff',
                    'bodyColor' => '#fff',
                    'borderColor' => 'rgba(255, 255, 255, 0.1)',
                    'borderWidth' => 1,
                    'cornerRadius' => 8,
                    'displayColors' => true,
                    'callbacks' => [
                        'label' => 'function(context) {
                            const label = context.label || "";
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ": " + value + " (" + percentage + "%)";
                        }'
                    ],
                ],
            ],
            'cutout' => '60%',
            'radius' => '90%',
            'animation' => [
                'animateRotate' => true,
                'animateScale' => true,
                'duration' => 1000,
            ],
            'elements' => [
                'arc' => [
                    'borderWidth' => 3,
                ],
            ],
        ];
    }
}

