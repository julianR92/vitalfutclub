<div>

    <div class="grid grid-cols-1 mt-2 xl:mt-2 md:grid-cols-2 xl:grid-cols-1">
        <div class="flex">
            <select wire:model="itemPagina"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm h-8 mr-1 text-xs">
                <option value="10">10</option>
                <option value="30">30</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <x-jet-input wire:model="buscador" class="w-full mb-2 h-8" id="buscar" type="text"
                placeholder="Ingrese el termino de busqueda..."></x-jet-input>
            <button wire:click="limpiarFiltros"
                class="ml-2 transform hover:text-blue-800 hover:scale-125 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>
        </div>
        <table class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg ">
            <thead class="text-white text-left">
                <tr
                    class="bg-gray-200 text-gray-600 text-sm leading-normal flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                    <th class="p-2">Tipo documento
                        <button wire:click="ordenar('tipo_doc')">
                            <span class="@if ($campo == 'tipo_doc') {{ 'text-blue-400' }}@else {{ '' }}@endif">
                                <svg xmlns="http://www.w3.org/2000/svg" class="@if ($campo == 'tipo_doc') {{ 'h-4 w-4' }}@else {{ 'h-3 w-3' }}@endif" fill="
                                    none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </span>
                        </button>
                    </th>
                    <th class="p-2">Documento
                        <button wire:click="ordenar('documento')">
                            <span class="@if ($campo == 'documento') {{ 'text-blue-400' }}@else {{ '' }}@endif">
                                <svg xmlns="http://www.w3.org/2000/svg" class="@if ($campo == 'documento') {{ 'h-4 w-4' }}@else {{ 'h-3 w-3' }}@endif" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </span>
                        </button>
                    </th>
                    <th class="p-2">Nombre
                        <button wire:click="ordenar('nombres')">
                            <span class="@if ($campo == 'nombres') {{ 'text-blue-400' }}@else {{ '' }}@endif">
                                <svg xmlns="http://www.w3.org/2000/svg" class="@if ($campo == 'nombres') {{ 'h-4 w-4' }}@else {{ 'h-3 w-3' }}@endif" fill="
                                    none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </span>
                        </button>
                    </th>
                    <th class="p-2">Teléfono</th>
                    <th class="p-2">Correo electrónico
                        <button wire:click="ordenar('correo')">
                            <span class="@if ($campo == 'correo') {{ 'text-blue-400' }}@else {{ '' }}@endif">
                                <svg xmlns="http://www.w3.org/2000/svg" class="@if ($campo == 'correo') {{ 'h-4 w-4' }}@else {{ 'h-3 w-3' }}@endif" fill="
                                    none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </span>
                        </button>
                    </th>
                    <th class="p-2">Dirección</th>
                    <th class="p-2">Estado
                        <button wire:click="ordenar('estado')">
                            <span class="@if ($campo == 'estado') {{ 'text-blue-400' }}@else {{ '' }}@endif">
                                <svg xmlns="http://www.w3.org/2000/svg" class="@if ($campo == 'estado') {{ 'h-4 w-4' }}@else {{ 'h-3 w-3' }}@endif" fill="
                                    none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </span>
                        </button>
                    </th>
                    <th class="p-2">Fecha registro
                        <button wire:click="ordenar('created_at')">
                            <span class="@if ($campo == 'created_at') {{ 'text-blue-400' }}@else {{ '' }}@endif">
                                <svg xmlns="http://www.w3.org/2000/svg" class="@if ($campo == 'created_at') {{ 'h-4 w-4' }}@else {{ 'h-3 w-3' }}@endif" fill="
                                    none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                            </span>
                        </button>
                    </th>
                    <th class="p-3 text-center" width="110px">Acciones</th>
                </tr>
            </thead>
            <tbody class="flex-1 sm:flex-none">
                @if ($personas)
                    @foreach ($personas as $persona)
                        <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 hover:bg-gray-100">
                            <td class="border-grey-light border  p-3">
                                {{ $persona->tipo_doc }}
                            </td>
                            <td class="border-grey-light border p-3">
                                {{ $persona->documento }}
                            </td>
                            <td class="border-grey-light border p-3">
                                {{ $persona->nombre . ' ' . $persona->apellidos }}
                            </td>
                            <td class="border-grey-light border p-3">
                                {{ $persona->telefono }}
                            </td>
                            <td class="border-grey-light border p-3">
                                {{ $persona->correo }}
                            </td>
                            <td class="border-grey-light border p-3">
                                {{ $persona->direccion }}
                            </td>
                            <td class="border-grey-light border p-3">
                                <span class="px-2 py-1 font-semibold  @if ($persona->users->estado == 1) {{ 'bg-green-100' }}@else {{ 'bg-red-100' }}@endif  rounded-sm">
                                    {{ $persona->users->estado == 1 ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="border-grey-light border p-3">
                                {{ $persona->created_at }}
                            </td>
                            <td class="border-grey-light border p-3">
                                <div class="flex item-center justify-center">
                                    <a href="{{ route('persona.index') }}"
                                        class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <button wire:click="$emitTo('persona.modal','abrirModal',{{ $persona->id }})"
                                        class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button wire:click="$emit('eliminarJs',{{ $persona->id }})"
                                        class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="bg-red px-4 py-3 items-center justify-between border-t border-gray-200 sm:px-6">
            {{ $personas->links() }}
        </div>
    </div>
    @push('js')
        <script>
            Livewire.on('eliminarJs',($persona) => {
                Swal.fire({
                    title: 'Esta seguro de eliminar este registro?',
                    text: "Si la persona no tiene planes asignados se borrarán los datos tano del usuario como del cliente",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, confirmar!',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('persona.modal', 'eliminar', $persona);
                        Swal.fire(
                            'Registro eliminado!',
                            'Registro eliminado correctamente.',
                            'success',
                        )
                    }
                })
            });
        </script>
    @endpush
</div>
