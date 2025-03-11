<div>
    <div class="grid grid-cols-1 mt-2 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
        <table class="cell-border compact stripe compact tablas">
            <thead class="">
                <tr
                    class="">
                    <th class="p-2">Nombre del plan</th>
                    <th class="p-2">Número de clases</th>
                    <th class="p-2">Número de días</th>
                    <th class="p-2">Valor del plan</th>
                    <th class="p-2">Sede</th>
                    <th class="p-2">Fecha registro</th>
                    <th class="p-3 text-center" width="110px">Acciones</th>
                </tr>
            </thead>
            <tbody class="flex-1 sm:flex-none">
                @if ($planes)
                    @foreach ($planes as $plan)
                        <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 hover:bg-gray-100">
                            <td class="border-grey-light border  p-3" data-label="Plan">
                                {{ $plan->nombre_plan }}
                            </td>
                            <td class="border-grey-light border p-3" data-label="# Clases">
                                {{ $plan->numero_clases }}
                            </td>
                            <td class="border-grey-light border p-3" data-label="# Dias">
                                {{ $plan->numero_dias }}
                            </td>
                            <td class="border-grey-light border p-3" data-label="Valor">
                                {{ $plan->valor }}
                            </td>
                            <td class="border-grey-light border p-3" data-label="Sede">
                                {{ $plan->nombre_sede }}
                            </td>
                            <td class="border-grey-light border p-3" data-label="Fecha de registro">
                                {{ $plan->created_at }}
                            </td>
                            <td class="border-grey-light border p-3" data-label="Actions">
                                <div class="flex item-center justify-center">
                                    <button wire:click="$emitTo('plan.modal','abrirModal',{{ $plan->id }})"
                                        class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button wire:click="$emit('eliminarJs',{{ $plan->id }})"
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
    </div>
    @push('js')
        <script>
            Livewire.on('eliminarJs', ($plan) => {
                Swal.fire({
                    title: 'Esta seguro de eliminar este registro?',
                    text: "Si ya existen planes asignados, este plan no podra ser eliminado.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, confirmar!',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('plan.modal', 'eliminar', $plan);
                        Swal.fire(
                            'Registro eliminado!',
                            'Registro eliminado correctamente.',
                            'success',
                        )
                    }
                })
            });
            $('.div-principal').ready(function () {
                if ($(window).width() < 640) {
                $('.tablas').removeClass('dataTable');
             }else{
                $('.tablas').addClass('dataTable');
             }
            
            });
        </script>
    @endpush
</div>
