<div class="h-full overflow-y-auto bg-blue-50 p-3 rounded-lg border border-blue-100">
    <div class="flex items-center justify-between mb-4 px-2">
        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard') }}"
                class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-100 hover:bg-blue-200 text-blue-600 transition"
                title="Volver al Dashboard">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </div>
        <h2 class="text-lg font-semibold text-slate-800">Chats</h2>
        <button wire:click="toggleBuscador"
            class="w-9 h-9 rounded-full flex items-center justify-center bg-blue-600 text-white hover:bg-blue-700 transition"
            title="Nuevo chat">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
        </button>
    </div>

    @if ($mostrarBuscador)
        <div class="px-2 mb-3">
            <input
                wire:model.live="buscarUsuario"
                x-ref="searchInput"
                type="text"
                placeholder="Buscar usuario..."
                class="w-full px-4 py-2 rounded-full border border-blue-200 bg-white text-sm text-slate-800 focus:outline-none focus:ring focus:ring-blue-300"
            >
        </div>

        <div wire:transition>
            @if (count($usuariosFiltrados) > 0)
                <div class="bg-white rounded-lg shadow p-2 mb-4 mx-2 border border-blue-100">
                    @foreach ($usuariosFiltrados as $usuario)
                        @php
                            $foto = $usuario->documentacionAltas?->arch_foto;
                            $foto_url = $foto ? asset($foto) : asset('images/default-user.jpg');
                        @endphp
                        <div wire:click="iniciarConversacion({{ $usuario->id }})"
                            class="flex items-center gap-3 cursor-pointer px-3 py-2 hover:bg-blue-100 rounded text-slate-800">
                            <img src="{{ $foto_url }}" alt="Foto" class="w-8 h-8 rounded-full object-cover">
                            <span>{{ $usuario->name }}</span>
                        </div>
                    @endforeach
                </div>
            @elseif(strlen($buscarUsuario) >= 2)
                <div class="px-4 py-2 text-slate-500">No se encontraron resultados</div>
            @endif
        </div>
    @endif

    <div class="space-y-1">
        @foreach ($conversaciones as $conv)
            @php
                $otro = $conv->users->where('id', '!=', auth()->id())->first();
                $foto = $otro?->documentacionAltas?->arch_foto;
                $foto_url = $foto ? asset($foto) : asset('images/default-user.jpg');
            @endphp

            <div wire:click="seleccionarConversacion({{ $conv->id }})"
                class="flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-blue-100 transition">
                <img src="{{ $foto_url }}" alt="Foto" class="w-10 h-10 rounded-full object-cover">
                <div class="flex-1">
                    <strong class="block text-slate-800">
                        {{ $conv->is_group ? $conv->title ?? 'Grupo sin nombre' : $otro?->name }}
                    </strong>
                    <span class="text-sm text-slate-500">
                        {{ $conv->latestMessage?->body ?? 'Sin mensajes' }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>

@script
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('resultadosActualizados', () => {
            Livewire.dispatch('render');
        });

        Livewire.on('focusSearchInput', () => {
            setTimeout(() => {
                document.querySelector('[x-ref="searchInput"]')?.focus();
            }, 100);
        });
    });
</script>
@endscript
