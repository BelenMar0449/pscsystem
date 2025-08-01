@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <x-navbar></x-navbar>
    <div class="py-4 px-2 sm:py-6 sm:px-4">
        <div class="mx-auto max-w-7xl">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                @if(session('success'))
                    <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md" role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    @else
                @endif
                <div class="space-y-4 rounded dark:bg-white">
                    <p class="text-gray-900 text-2xl dark:text-gray-900 text-2xl">
                        Información del Usuario
                    </p>

                    @if (!$solicitud)
                        <p class="text-red-600 text-sm">No hay información de solicitud disponible para este usuario.</p>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div><strong>Nombre:</strong> {{ $solicitud?->nombre }} {{ $solicitud?->apellido_paterno }} {{ $solicitud?->apellido_materno }}</div>
                            <div><strong>CURP:</strong> {{ $solicitud?->curp }}</div>
                            <div><strong>NSS:</strong> {{ $solicitud?->nss }}</div>
                            <div><strong>RFC:</strong> {{ $solicitud?->rfc }}</div>
                            <div><strong>Email:</strong> {{ $solicitud?->email }}</div>
                            <div><strong>Teléfono:</strong> {{ $solicitud?->telefono }}</div>
                            <div><strong>Domicilio (Comprobante):</strong>{{$solicitud?->domicilio_comprobante }}</div>
                            <div><strong>Dirección Fiscal:</strong>
                                {{ $solicitud?->domicilio_calle }}
                                #{{ $solicitud?->domicilio_numero }},
                                {{ $solicitud?->domicilio_colonia }},
                                {{ $solicitud?->domicilio_ciudad }},
                                {{ $solicitud?->domicilio_estado }}
                            </div>
                            <div><strong>Estado Civil:</strong> {{ $solicitud?->estado_civil }}</div>
                            <div><strong>Puesto:</strong> {{ $solicitud?->rol }}</div>
                            <div><strong>Sueldo:</strong> {{ $solicitud?->sueldo_mensual }}</div>
                            <div><strong>SD:</strong>{{ $solicitud?->sd }}</div>
                            <div><strong>SDI:</strong> {{ $solicitud?->sdi }}</div>
                            <div><strong>Empresa:</strong> {{ $solicitud?->empresa }}</div>
                            <div><strong>Punto:</strong> {{ $solicitud?->punto }}</div>
                            <div><strong>Fecha de Ingreso:</strong> {{ Carbon::parse($user?->fecha_ingreso)->format('d/m/Y') }}</div>
                            <div><strong>Fecha de Nacimiento:</strong> {{ Carbon::parse($solicitud?->fecha_nacimiento)->format('d/m/Y') }}</div>
                            <div><strong>Estatus:</strong>
                                @if($user->estatus == 'Reingreso')
                                    <span class="inline-flex items-center px-2 py-1 text-sm text-gray-800 bg-yellow-300 rounded-full">
                                        {{ $user->estatus }}
                                    </span>
                                @elseif($user->estatus == 'Activo')
                                    <span class="inline-flex items-center px-2 py-1 text-sm text-gray-800 bg-green-300 rounded-full">
                                        {{ $user->estatus }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 text-sm text-gray-800 bg-red-300 rounded-full">
                                        {{ $user->estatus }}
                                    </span>
                                @endif
                                @if($user->solicitudAlta->reingreso != null && $user->solicitudAlta->reingreso != 'NO')
                                    <div class="mt-2"><strong>Reingreso:</strong> {{$user->solicitudAlta->reingreso }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col items-center justify-start text-center space-y-2">
                            @if ($documentacion?->arch_foto)
                                <p class="font-semibold">Foto del solicitante:</p>
                                <img src="{{ asset($documentacion->arch_foto) }}" alt="Foto del usuario" class="w-40 h-40 object-cover rounded-full shadow">
                                <a href="{{ asset($documentacion->arch_foto) }}" target="_blank" class="text-blue-500 underline text-sm">Ver completa</a>
                            @else
                                <p class="text-sm text-gray-500">No hay foto cargada.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-6 mt-4">
                    <h3 class="text-lg font-semibold mb-4">Documentación</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                        @foreach([
                            'arch_solicitud_empleo' => 'Solicitud de Empleo',
                            'arch_acta_nacimiento' => 'Acta de Nacimiento',
                            'arch_curp' => 'CURP',
                            'arch_ine' => 'INE',
                            'arch_comprobante_domicilio' => 'Comprobante de Domicilio',
                            'arch_rfc' => 'RFC',
                            'arch_comprobante_estudios' => 'Comprobante de Estudios',
                            'arch_nss' => 'NSS',
                            'arch_contrato' => 'Contrato',
                            'arch_carta_rec_laboral' => 'Carta Recomendación Laboral',
                            'arch_carta_rec_personal' => 'Carta Recomendación Personal',
                            'arch_cartilla_militar' => 'Cartilla Militar',
                            'arch_infonavit' => 'Infonavit',
                            'arch_fonacot' => 'Fonacot',
                            'arch_licencia_conducir' => 'Licencia de Conducir',
                            'arch_carta_no_penales' => 'Carta No Penales',
                            'arch_acuse_imss' => 'Acuse de IMSS',
                            'arch_retencion_infonavit' => 'Retención de Infonavit',
                            'arch_foto' => 'Fotografía',
                            'visa' => 'Visa',
                            'pasaporte' => 'Pasaporte'
                        ] as $campo => $label)
                            @if($documentacion?->$campo)
                                <div class="flex items-center justify-between border rounded p-2 bg-gray-50">
                                    <span>{{ $label }}</span>
                                    <a href="{{ asset($documentacion->$campo) }}" target="_blank" class="text-blue-600 hover:underline text-sm">
                                        Ver Archivo
                                    </a>
                                </div>
                            @else
                                @if ($campo == 'arch_rfc')
                                    <div class="flex items-center justify-between border rounded p-2 bg-red-200 text-red-700">
                                        <span>{{ $label }}</span>
                                        <span class="text-xs">No disponible</span>
                                    </div>
                                @else
                                    <div class="flex items-center justify-between border rounded p-2 bg-red-50 text-red-700">
                                        <span>{{ $label }}</span>
                                        <span class="text-xs">No disponible</span>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="flex flex-wrap justify-center gap-4 mt-4">
                    @if($user->estatus != 'Inactivo')
                        @if(Auth::user()->rol == 'admin' || Auth::user()->solicitudAlta->departamento == 'Recursos Humanos' || Auth::user()->solicitudAlta->rol == 'AUXILIAR RECURSOS HUMANOS' || Auth::user()->solicitudAlta->rol == 'AUXILIAR RH' || Auth::user()->solicitudAlta->rol == 'AUX RH' || Auth::user()->solicitudAlta->rol == 'Auxiliar RH' || Auth::user()->solicitudAlta->rol == 'Auxiliar Recursos Humanos' || Auth::user()->solicitudAlta->rol == 'Aux RH' || Auth::user()->rol == 'AUXILIAR RECURSOS HUMANOS' || Auth::user()->rol == 'Auxiliar recursos humanos')
                            <a href="{{ route('admin.editarUsuarioForm', $user->id) }}"
                                class="inline-block bg-green-300 text-gray-800 py-2 px-4 rounded-md hover:bg-green-400 transition">
                                Editar
                            </a>

                            <a href="{{ route('sup.solicitarVacacionesElementoForm', $user->id) }}"
                                class="inline-block bg-yellow-300 text-gray-800 py-2 px-4 rounded-md hover:bg-yellow-400 transition">
                                Generar Sol. Vacaciones
                            </a>

                            <a href="{{ route('rh.descargarFicha', $user->id) }}"
                                class="inline-block bg-blue-300 text-gray-800 py-2 px-4 rounded-md hover:bg-blue-400 transition">
                                Descargar Ficha
                            </a>

                            @if ((Auth::user()->rol == 'admin' || Auth::user()->rol == 'admin' || Auth::user()->solicitudAlta->departamento == 'Recursos Humanos' || Auth::user()->solicitudAlta->rol == 'AUXILIAR RECURSOS HUMANOS' || Auth::user()->solicitudAlta->rol == 'AUXILIAR RH' || Auth::user()->solicitudAlta->rol == 'AUX RH' || Auth::user()->solicitudAlta->rol == 'Auxiliar RH' || Auth::user()->solicitudAlta->rol == 'Auxiliar Recursos Humanos' || Auth::user()->solicitudAlta->rol == 'Aux RH' || Auth::user()->rol == 'AUXILIAR RECURSOS HUMANOS' || Auth::user()->rol == 'Auxiliar recursos humanos') && $user->estatus == 'Activo')
                                <a href="#" class="inline-block bg-red-300 text-gray-800 py-2 px-4 rounded-md hover:bg-red-400 transition"
                                onclick="confirmarBaja({{ $user->id }})">
                                    Dar de Baja
                                </a>
                            @endif
                        @endif
                    @elseif($user->estatus == 'Inactivo')
                        @if(Auth::user()->rol == 'admin' || Auth::user()->solicitudAlta->departamento == 'Recursos Humanos' || Auth::user()->solicitudAlta->rol == 'AUXILIAR RECURSOS HUMANOS' || Auth::user()->solicitudAlta->rol == 'AUXILIAR RH' || Auth::user()->solicitudAlta->rol == 'AUX RH' || Auth::user()->solicitudAlta->rol == 'Auxiliar RH' || Auth::user()->solicitudAlta->rol == 'Auxiliar Recursos Humanos' || Auth::user()->solicitudAlta->rol == 'Aux RH' || Auth::user()->rol == 'AUXILIAR RECURSOS HUMANOS' || Auth::user()->rol == 'Auxiliar recursos humanos')
                            <a href="#" class="inline-block bg-green-300 text-gray-800 py-2 px-4 rounded-md hover:bg-green-400 transition"
                                onclick="confirmarReingreso({{ $user->id }})">
                                Reingreso
                            </a>
                        @endif
                    @endif
                    @if (Auth::user()->rol == 'admin')
                        <a href="{{ route('admin.verUsuarios') }}" class="inline-block bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400 transition">
                            Regresar
                        </a>
                    @elseif(Auth::user()->rol == 'AUXILIAR NOMINAS' || Auth::user()->rol == 'Auxiliar Nominas' || Auth::user()->solicitudAlta->rol == 'AUXILIAR NOMINAS' || Auth::user()->solicitudAlta->rol == 'Auxiliar Nominas' || Auth::user()->solicitudAlta->rol == 'Auxiliar nominas' )
                        @if($documentacion->arch_rfc == null && $user->estatus == 'Activo')
                            <a href="#" onclick="enviarNotificacion({{ $user->id }})" class="inline-block bg-red-300 text-gray-800 py-2 px-4 rounded-md hover:bg-red-400 transition">
                                Solicitar Const. de Situación Fiscal
                            </a>
                            <a href="{{ route('admin.verUsuarios') }}" class="inline-block bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400 transition">
                                Regresar
                            </a>
                        @else
                            <a href="{{ route('admin.verUsuarios') }}" class="inline-block bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400 transition">
                                Regresar
                            </a>
                        @endif
                    @else
                        <a href="{{ route('dashboard') }}" class="inline-block bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400 transition">
                            Regresar
                        </a>
                    @endif
                </div>
        </div>
    </div>
</x-app-layout>

<script>
    function confirmarBaja(userId) {
    Swal.fire({
        title: '¿Estás seguro?',
        html: `
            <p class="mb-2">Esto cambiará el estatus del usuario a 'Inactivo'.</p>
            <label for="fechaBaja" class="block mb-1 text-sm text-left">Fecha de baja:</label>
            <input type="date" id="fechaBaja" class="swal2-input" style="width: auto;">

            <label for="motivoBaja" class="block mt-3 mb-1 text-sm text-left">Motivo:</label>
            <select id="motivoBaja" class="swal2-input" style="width: auto;">
                <option value="">Seleccione un motivo</option>
                <option value="Renuncia">Renuncia</option>
                <option value="Ausentismo">Ausentismo</option>
                <option value="Separación voluntaria">Separación voluntaria</option>
            </select>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, dar de baja',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const fecha = document.getElementById('fechaBaja').value;
            const motivo = document.getElementById('motivoBaja').value;

            if (!fecha) {
                Swal.showValidationMessage('Debes ingresar una fecha de baja');
                return false;
            }
            if (!motivo) {
                Swal.showValidationMessage('Debes seleccionar un motivo');
                return false;
            }

            return { fecha, motivo };
        }
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            const { fecha, motivo } = result.value;
            window.location.href = `/admin/baja_usuario/${userId}?fecha=${fecha}&motivo=${encodeURIComponent(motivo)}`;
        }
    });
}


    function confirmarReingreso(userId) {
        Swal.fire({
            title: '¿Confirmas generar el reingreso?',
            html: `
                <p class="mb-2">Esto añadirá un nuevo reingreso para el usuario.</p>
                <label for="fechaReingreso" class="block mb-1 text-sm text-left">Fecha de reingreso:</label>
                <input type="date" id="fechaReingreso" class="swal2-input" style="width: auto;">
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, generar',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const fecha = document.getElementById('fechaReingreso').value;
                if (!fecha) {
                    Swal.showValidationMessage('Debes ingresar una fecha de reingreso');
                }
                return fecha;
            }
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                const fecha = result.value;
                window.location.href = `/reingreso/${userId}?fecha=${fecha}`;
            }
        });
    }

    function enviarNotificacion(userId) {
        fetch("{{ route('solicitar.constancia') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ user_id: userId })
        })
        .then(res => res.json())
        .then(data => {
            if(data.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Solicitud enviada',
                    text: 'Tu solicitud fue enviada a Recursos Humanos.'
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al enviar tu solicitud.'
            });
        });
    }

</script>

