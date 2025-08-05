<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            🚨 Central de Alertas e Notificações
        </x-slot>

        <div class="space-y-4">
            @foreach($alerts as $alert)
                <div class="flex items-start space-x-4 p-4 rounded-lg border-l-4 
                    @if($alert['type'] === 'danger') bg-red-50 border-red-500 dark:bg-red-900/20
                    @elseif($alert['type'] === 'warning') bg-yellow-50 border-yellow-500 dark:bg-yellow-900/20
                    @elseif($alert['type'] === 'info') bg-blue-50 border-blue-500 dark:bg-blue-900/20
                    @elseif($alert['type'] === 'success') bg-green-50 border-green-500 dark:bg-green-900/20
                    @endif
                ">
                    <div class="flex-shrink-0">
                        <span class="text-2xl">{{ $alert['icon'] }}</span>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold 
                            @if($alert['type'] === 'danger') text-red-800 dark:text-red-200
                            @elseif($alert['type'] === 'warning') text-yellow-800 dark:text-yellow-200
                            @elseif($alert['type'] === 'info') text-blue-800 dark:text-blue-200
                            @elseif($alert['type'] === 'success') text-green-800 dark:text-green-200
                            @endif
                        ">
                            {{ $alert['title'] }}
                        </h4>
                        <p class="mt-1 text-sm 
                            @if($alert['type'] === 'danger') text-red-700 dark:text-red-300
                            @elseif($alert['type'] === 'warning') text-yellow-700 dark:text-yellow-300
                            @elseif($alert['type'] === 'info') text-blue-700 dark:text-blue-300
                            @elseif($alert['type'] === 'success') text-green-700 dark:text-green-300
                            @endif
                        ">
                            {{ $alert['message'] }}
                        </p>
                    </div>
                    
                    @if($alert['action'] && $alert['url'])
                        <div class="flex-shrink-0">
                            <a href="{{ $alert['url'] }}" 
                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150
                                @if($alert['type'] === 'danger') bg-red-600 hover:bg-red-700 focus:ring-red-500
                                @elseif($alert['type'] === 'warning') bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500
                                @elseif($alert['type'] === 'info') bg-blue-600 hover:bg-blue-700 focus:ring-blue-500
                                @elseif($alert['type'] === 'success') bg-green-600 hover:bg-green-700 focus:ring-green-500
                                @endif
                               ">
                                {{ $alert['action'] }}
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

