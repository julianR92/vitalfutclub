<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 div-principal">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <section class="bg-white dark:bg-gray-900">
                <div class="container px-6 py-7 mx-auto">
                    <div class="flex justify-between bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                        <x-titulo titulo="Detalle del cliente"></x-titulo>
                        <a href="{{ route('persona.index') }}"
                            class="pt-1 text-blue-600 bg-blue-100 hover:bg-blue-200 text-white font-bold py-2 px-4 rounded-full"
                            title="Volver">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                            </svg>
                        </a>
                    </div>
                    {{-- @dd($planes) --}}

                    <div class="md:flex xl:flex mt-1 p-1 py-3 border-b border-gray-200">
                        <div class="w-full md:w-1/6 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">Tipo de documento</p>
                            <p class="text-sm">{{ $persona->tipo_doc }}</p>
                        </div>
                        <div class="w-full md:w-1/6 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">No de documento</p>
                            <p class="text-sm">{{ $persona->documento }}</p>
                        </div>
                        <div class="w-full md:w-2/6 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">Nombre</p>
                            <p class="text-sm">{{ $persona->nombres }} {{ $persona->apellidos }}</p>
                        </div>
                        <div class="w-full md:w-1/6 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">Teléfono</p>
                            <p class="text-sm">{{ $persona->telefono }}</p>
                        </div>
                    </div>
                    <div class="md:flex xl:flex p-1 py-3 border-b border-gray-200">
                        <div class="w-full md:w-2/6 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">Dirección</p>
                            <p class="text-sm">{{ $persona->direccion }}</p>
                        </div>
                        <div class="w-full md:w-2/6 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">Correo electrónico</p>
                            <p class="text-sm">{{ $persona->correo }}</p>
                        </div>

                        <div class="w-full md:w-1/6 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">Estado del usuario</p>
                            <p class="text-sm font-bold @if ($persona->users->estado == 1) {{ 'text-green-600' }} @else {{ 'text-red-600' }}@endif">
                                {{ $persona->users->estado == 1 ? 'Activo' : 'Inactivo' }}</p>
                        </div>
                        {{-- @dd($planes)) --}}
                        <div class="w-full md:w-1/6 px-1 mb-2 md:mb-0">

                          @if(count($planes))
                            @if(!$planes[0]->estado)
                            <x-jet-secondary-button wire:click="$emitTo('per-planes.modal','abrirModal',{{$persona->id}})"
                                class="bg-blue-500 hover:bg-blue-700 text-white hover:text-white">
                                Asignar
                            </x-jet-secondary-button>
                            @else
                            <p class="text-sm font-bold text-green-600">
                                 Actualmente se encuentra con un plan activo</p>

                            @endif
                            @else
                            <x-jet-secondary-button wire:click="$emitTo('per-planes.modal','abrirModal',{{$persona->id}})"
                                class="bg-blue-500 hover:bg-blue-700 text-white hover:text-white">
                                Asignar
                            </x-jet-secondary-button>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
            <section class="bg-white dark:bg-gray-900">
                <div class="container px-6 mx-auto">
                    <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                        <x-titulo titulo="Historico de planes"></x-titulo>
                    </div>
                    <div class="p-4">
                        <table class="cell-border compact stripe compact tablas">
                            <thead class="">
                                <tr class="">
                                    <th class="p-2" >#</th>
                                    <th class="p-2">Nombre del plan</th>
                                    <th class="p-2">Fecha Fin</th>
                                    <th class="p-2">Número de clases</th>
                                    <th class="p-2">Clases registradas</th>
                                    <th class="p-2">Número de días</th>
                                    <th class="p-2">Valor</th>
                                    <th class="p-2">Sede</th>
                                    <th class="p-3 text-center" width="110px">Acciones</th>
                                </tr>
                            </thead>

                                <tbody class="flex-1 sm:flex-none">
                                    @if ($planes)
                                        @foreach ($planes as $plan)
                                            <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 hover:bg-gray-100">
                                                <td class="border-grey-light border  p-3" data-label="ID">
                                                    {{ $plan->id_perplanes }}
                                                </td>
                                                <td class="border-grey-light border  p-3" data-label="Plan">
                                                    {{ $plan->nombre_plan }}
                                                </td>
                                                <td class="border-grey-light border  p-3" data-label="Fecha Fin">
                                                    {{ $plan->fecha_fin }}
                                                </td>
                                                <td class="border-grey-light border p-3" data-label="# Clases">
                                                    {{ $plan->cantidad_plan*$plan->numero_clase }}
                                                </td>
                                                <td class="border-grey-light border p-3" data-label="Clases Registradas">
                                                    {{ $plan->count_ingreso }}
                                                </td>
                                                <td class="border-grey-light border p-3" data-label="# Dias">
                                                    {{$plan->cantidad_plan*$plan->numero_dias}}
                                                </td>
                                                <td class="border-grey-light border p-3" data-label="Valor">
                                                    ${{$plan->cantidad_plan*$plan->valor }}
                                                </td>
                                                <td class="border-grey-light border p-3" data-label="Sede">
                                                    {{ $plan->nombre_sede }}
                                                </td>


                                                <td class="border-grey-light border p-3" data-label="Actions">
                                                    <div class="flex item-center justify-center">
                                                        <a href="/storage/public/facturas/{{$persona->documento}}/Factura-de-venta-{{$plan->id_perplanes}}.pdf" target="_blank"
                                                            class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125" title="Descarga Factura">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                                              </svg></a>

                                                    @if(Auth::user()->rol=='admin')
                                                         @if($plan->estado)
                                                         <button class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125 btnQR" title="descargar QR" data-id="{{$plan->id_perplanes}}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" class="btnQR"  data-id="{{$plan->id_perplanes}}">
                                                                <path class="btnQR"  data-id="{{$plan->id_perplanes}}" fill="#121212" d="M4 4h6v6H4V4m16 0v6h-6V4h6m-6 11h2v-2h-2v-2h2v2h2v-2h2v2h-2v2h2v3h-2v2h-2v-2h-3v2h-2v-4h3v-1m2 0v3h2v-3h-2M4 20v-6h6v6H4M6 6v2h2V6H6m10 0v2h2V6h-2M6 16v2h2v-2H6m-2-5h2v2H4v-2m5 0h4v4h-2v-2H9v-2m2-5h2v4h-2V6M2 2v4H0V2a2 2 0 0 1 2-2h4v2H2m20-2a2 2 0 0 1 2 2v4h-2V2h-4V0h4M2 18v4h4v2H2a2 2 0 0 1-2-2v-4h2m20 4v-4h2v4a2 2 0 0 1-2 2h-4v-2h4Z"/></svg>
                                                        </button>
                                                        <button wire:click="$emitTo('per-planes.editar','abrirModal',{{$plan->id_perplanes}})"
                                                            class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                            </svg>
                                                        </button>


                                                        <button wire:click="$emit('eliminarJs',{{ $plan->id_perplanes}})"
                                                            class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                        
                                                        @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @push('js')
        <script>
            Livewire.on('eliminarJs', ($perplanes) => {
                Swal.fire({
                    title: 'Esta seguro de eliminar este registro?',
                    text: "Se borrara la asginacion de este plan completamente y no quedaran registros en la base de datos",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, confirmar!',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emitTo('per-planes.editar', 'eliminar', $perplanes);
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
            // let btnQr = document.getElementById('btnQR');
             document.addEventListener('click', (e)=>{
              if(e.target.matches('.btnQR')){
                Livewire.emit('downloadQr', e.target.dataset.id);
                setTimeout(()=>{
                   location.reload(); 
                },3000)
              }
             })
             
          
        </script>
    @endpush
</div>
@livewire('per-planes.modal')
@livewire('per-planes.editar')
