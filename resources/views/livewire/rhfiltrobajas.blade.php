@php
    $currentPage = $solicitudes->currentPage();
    $lastPage = $solicitudes->lastPage();
@endphp
<div>
    <div class="mb-6">
        <input
            type="text"
            wire:model.live.debounce.300ms="search"
            placeholder="Buscar por nombre..."
            class="w-1/3 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
        >
        <input
            type="date"
            wire:model.live="fecha"
            class="w-1/4 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
        />
        <div wire:loading class="text-sm text-gray-500 mt-1">
            Buscando...
        </div>
    </div>
    @if($solicitudes->isEmpty())
                <p class="mt-4">No hay solicitudes aún.</p>

            @else
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No.</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Empresa</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Por</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Detalles</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha de Baja</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($solicitudes as $solicitud)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 whitespace-nowrap">{{ ($solicitudes->currentPage() - 1) * $solicitudes->perPage() + $loop->iteration }}</td>
                                    <td class="py-2 px-4 whitespace-nowrap">{{ $solicitud->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $solicitud->user->empresa }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $solicitud->por }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $solicitud->motivo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ \Carbon\Carbon::parse($solicitud->fecha_baja)->format('d/m/Y') }}</td>
                                    <td class="py-2 px-4">
                                        @if($solicitud->estatus == 'En Proceso')
                                            <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs leading-none text-gray-800 bg-yellow-300 rounded-full">
                                                {{ $solicitud->estatus }}
                                            </span>
                                        @elseif($solicitud->estatus == 'Aceptada')
                                            <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs leading-none text-green-100 bg-green-600 rounded-full">
                                                {{ $solicitud->estatus }}
                                            </span>
                                        @elseif($solicitud->estatus == 'Rechazada')
                                            <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs leading-none text-red-100 bg-red-600 rounded-full">
                                                {{ $solicitud->estatus }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4">
                                            <a href="{{route('rh.detalleSolicitudBaja', $solicitud->id)}}" class="inline-block text-blue-500 py-2 px-4 rounded-md mr-2 mb-2">
                                                Ver Más
                                            </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <ul class="flex justify-center space-x-2">
                        @if ($solicitudes->onFirstPage())
                            <li class="px-3 py-1 text-gray-500" aria-disabled="true">&laquo;</li>
                        @else
                            <li>
                                <button wire:click="previousPage" class="px-3 py-1 text-blue-600 hover:text-blue-800">&laquo;</button>
                            </li>
                        @endif

                        @if ($currentPage > 2)
                            <li>
                                <button wire:click="gotoPage(1)" class="px-3 py-1 text-blue-600 hover:text-blue-800">1</button>
                            </li>
                            @if ($currentPage > 3)
                                <li class="px-3 py-1 text-gray-500">...</li>
                            @endif
                        @endif

                        @for ($i = max(1, $currentPage - 1); $i <= min($lastPage, $currentPage + 1); $i++)
                            <li>
                                @if ($i == $currentPage)
                                    <span class="px-3 py-1 bg-blue-500 text-white rounded">{{ $i }}</span>
                                @else
                                    <button wire:click="gotoPage({{ $i }})" class="px-3 py-1 text-blue-600 hover:text-blue-800">{{ $i }}</button>
                                @endif
                            </li>
                        @endfor

                        @if ($currentPage < $lastPage - 1)
                            @if ($currentPage < $lastPage - 2)
                                <li class="px-3 py-1 text-gray-500">...</li>
                            @endif
                            <li>
                                <button wire:click="gotoPage({{ $lastPage }})" class="px-3 py-1 text-blue-600 hover:text-blue-800">{{ $lastPage }}</button>
                            </li>
                        @endif

                        @if ($solicitudes->hasMorePages())
                            <li>
                                <button wire:click="nextPage" class="px-3 py-1 text-blue-600 hover:text-blue-800">&raquo;</button>
                            </li>
                        @else
                            <li class="px-3 py-1 text-gray-500" aria-disabled="true">&raquo;</li>
                        @endif
                    </ul>
                </div>
                    @endif
                    <center><br><a href="{{ route('dashboard') }}" class="inline-block bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400 mr-2 mb-2">
                        Regresar
                    </a></center>
</div>
