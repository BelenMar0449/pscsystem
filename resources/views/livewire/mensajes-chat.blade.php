<div class="flex flex-col h-full bg-white border border-blue-100 rounded-lg shadow">

    @if ($conversation)
        @php
            $otro = $conversation->users->where('id', '!=', auth()->id())->first();
            $foto = $otro?->documentacionAltas?->arch_foto;
            $foto_url = $foto ? asset($foto) : asset('images/default-user.jpg');
        @endphp

        <div class="flex items-center gap-3 px-4 py-3 border-b border-blue-100 bg-blue-50 rounded-t-lg">
            <img src="{{ $foto_url }}" class="w-10 h-10 rounded-full object-cover" alt="Foto">
            <div>
                <div class="text-base font-semibold text-slate-800">{{ $otro?->name }}</div>
                <div class="text-sm text-slate-500">Conversación</div>
            </div>
        </div>
    @endif

    <div class="flex-1 overflow-y-auto px-4 py-3 space-y-2 bg-white">
        @foreach ($messages as $msg)
            @php $esMio = $msg['user_id'] == auth()->id(); @endphp

            <div class="flex {{ $esMio ? 'justify-end' : 'justify-start' }}">
                <div class="{{ $esMio ? 'bg-blue-600 text-white' : 'bg-blue-100 text-slate-800' }}
                    max-w-xs md:max-w-md px-4 py-2 rounded-xl text-sm shadow">
                    {{ $msg['body'] }}
                </div>
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="enviarMensaje"
        class="flex items-center gap-2 px-4 py-3 border-t border-blue-100 bg-white rounded-b-lg">
        <textarea wire:model.defer="body"
            placeholder="Escribe tu mensaje..."
            class="flex-1 resize-none rounded-full px-4 py-2 text-sm border border-blue-200 focus:outline-none focus:ring focus:ring-blue-300 bg-blue-50 text-slate-800"
            rows="1"></textarea>

        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full transition"
            title="Enviar">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rotate-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>
    </form>
</div>
