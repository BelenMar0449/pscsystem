<x-app-layout>
    <x-navbar></x-navbar>
    <div class="py-4 px-2 sm:py-6 sm:px-4">
        <div class="container mx-auto max-w-7xl">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <h2 class="text-2xl mb-4">Formulario de Solicitud de Baja</h2>
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    @if($solicitudpendiente)
                        <p>
                            No puede realizar más acciones por el momento, ya que este usuario aún tiene una solicitud pendiente. Favor de esperar la respuesta a su solicitud
                        </p>
                        <center><br><a href="{{ route('dashboard') }}" class="inline-block bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400 mr-2 mb-2">
                            Regresar
                        </a></center>
                    @else
                    <form action="{{ route('rh.almacenarBajaNueva', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Datos Generales</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="fecha_hoy" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Baja</label>
                                    <input type="date" name="fecha_hoy" id="fecha_hoy" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="nss" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NSS</label>
                                    <p class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        {{$solicitud->nss}}
                                    </p>
                                </div>

                                <div>
                                    <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Ingreso</label>
                                    <p class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        {{ optional(\Carbon\Carbon::parse($user->fecha_ingreso))->format('d/m/Y') }}

                                    </p>
                                </div>

                                <div>
                                    <label for="incapacidad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">¿Incapacidad?</label>
                                    <input type="text" name="incapacidad" id="incapacidad" placeholder="Sí / No o Detalles" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Datos de Baja</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                    <p  value="{{$user->name}}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        {{$user->name}}
                                    </p>
                                </div>

                                <div>
                                    <label for="empresa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Empresa</label>
                                    <p class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        {{$user->empresa}}
                                    </p>
                                </div>

                                <div>
                                    <label for="punto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Punto</label>
                                    <p  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        {{$user->punto}}
                                    </p>
                                </div>

                                <div>
                                    <label for="por" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Por</label>
                                    <select name="por" id="por" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Seleccione</option>
                                        <option value="Ausentismo">Ausentismo</option>
                                        <option value="Separación Voluntaria">Separación Voluntaria</option>
                                        <option value="Renuncia">Renuncia</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="ultima_asistencia" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Última Asistencia</label>
                                    <input type="date" name="ultima_asistencia" id="ultima_asistencia" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="descuento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descuento por equipo/material no decuelto</label>
                                    <input type="text" name="descuento" id="descuento" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="adelanto_nomina" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descuento por Adelanto de Nómina</label>
                                    <input type="text" name="adelanto_nomina" id="adelanto_nomina" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div x-data="fileUpload()" class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Archivo de Baja</label>
                                    <div
                                        @dragover.prevent
                                        @drop.prevent="handleDrop($event)"
                                        class="flex items-center justify-center w-full p-4 border-2 border-dashed rounded-lg cursor-pointer transition bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 hover:border-blue-500"
                                        :class="{ 'border-blue-500': isDragging }"
                                        @dragenter="isDragging = true"
                                        @dragleave="isDragging = false"
                                    >
                                        <input type="file" name="archivo_baja" id="archivo_baja" class="hidden" @change="handleFile($event)" x-ref="inputFile">
                                        <div class="text-center">
                                            <p class="text-sm text-gray-600 dark:text-gray-300" x-text="fileName || 'Arrastra un archivo aquí o haz clic para seleccionarlo'"></p>
                                            <button type="button" class="mt-2 text-blue-600 hover:underline" @click="$refs.inputFile.click()">Seleccionar archivo</button>
                                        </div>
                                    </div>
                                </div>
                                <div x-data="fileUpload()" class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Archivo de Equipo Entregado</label>
                                    <div
                                        @dragover.prevent
                                        @drop.prevent="handleDrop($event)"
                                        class="flex items-center justify-center w-full p-4 border-2 border-dashed rounded-lg cursor-pointer transition bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 hover:border-blue-500"
                                        :class="{ 'border-blue-500': isDragging }"
                                        @dragenter="isDragging = true"
                                        @dragleave="isDragging = false"
                                    >
                                        <input type="file" name="archivo_equipo_entregado" id="arch_equipo_entregado" class="hidden" @change="handleFile($event)" x-ref="inputFile">
                                        <div class="text-center">
                                            <p class="text-sm text-gray-600 dark:text-gray-300" x-text="fileName || 'Arrastra un archivo aquí o haz clic para seleccionarlo'"></p>
                                            <button type="button" class="mt-2 text-blue-600 hover:underline" @click="$refs.inputFile.click()">Seleccionar archivo</button>
                                        </div>
                                    </div>
                                </div>
                                <div x-data="fileUpload()" class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Renuncia Firmada</label>
                                    <div
                                        @dragover.prevent
                                        @drop.prevent="handleDrop($event)"
                                        class="flex items-center justify-center w-full p-4 border-2 border-dashed rounded-lg cursor-pointer transition bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 hover:border-blue-500"
                                        :class="{ 'border-blue-500': isDragging }"
                                        @dragenter="isDragging = true"
                                        @dragleave="isDragging = false"
                                    >
                                        <input type="file" name="arch_renuncia" id="arch_renuncia" class="hidden" @change="handleFile($event)" x-ref="inputFile">
                                        <div class="text-center">
                                            <p class="text-sm text-gray-600 dark:text-gray-300" x-text="fileName || 'Arrastra un archivo aquí o haz clic para seleccionarlo'"></p>
                                            <button type="button" class="mt-2 text-blue-600 hover:underline" @click="$refs.inputFile.click()">Seleccionar archivo</button>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="motivo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Motivo (opcional)</label>
                                    <textarea name="motivo" id="motivo" rows="4"class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>
                            </div>
                        </div>

                        <center><div class="flex justify-center items-center text-right">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-green-300 border border-transparent rounded-md text-gray-800 hover:bg-green-500 transition-colors">
                                Enviar Solicitud
                            </button>
                            <a href="{{ route('dashboard') }}" class="inline-block bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400 mr-2 mb-2 ml-2 mt-1">
                                Regresar
                            </a>
                        </div></center>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    function fileUpload() {
        return {
            isDragging: false,
            fileName: '',
            handleFile(event) {
                const file = event.target.files[0];
                if (file) {
                    this.fileName = file.name;
                }
            },
            handleDrop(event) {
                const file = event.dataTransfer.files[0];
                if (file) {
                    this.$refs.inputFile.files = event.dataTransfer.files;
                    this.fileName = file.name;
                }
                this.isDragging = false;
            }
        }
    }
</script>

