<div>
    <div class="container px-6 py-4 mx-auto">
        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
        <x-titulo titulo="Reportes de ingreso x profesor"></x-titulo>
        </div>
        <form class="flex flex-wrap p-2" wire:submit.prevent="generarReporteClases" >
            <div class="md:w-64 xl:w-64  px-1 mb-2 md:mb-0 mt-3">
                <x-jet-label for="user_id" value="Profesor*" />
                <select         class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                wire:model="user_id" name="user_id" id="user_id"
                                placeholder="Seleccione tipo de documento...">
                                <option value="">Seleccione</option>
                                @foreach ($profesores as $profesor)
                                    <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
                                @endforeach
                            </select>
                <x-jet-input-error for="user_id" class="mt-2" />
            </div>

            <div class="md:w-64 xl:w-64  px-1 mb-2 md:mb-0 mt-3">
                <x-jet-label for="sede_id" value="Sede*" />
                <select         class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                wire:model="sede_id" name="sede_id" id="sede_id"
                                placeholder="Seleccione tipo de documento...">
                                <option value="">Seleccione</option>
                                @foreach($sedes as $sede)
                                <option value="{{ $sede->id }}">{{ $sede->nombre_sede }}</option>
                            @endforeach
                            </select>
                <x-jet-input-error for="sede_id" class="mt-2" />
            </div>
            <div class="md:w-64 xl:w-64  px-1 mb-2 md:mb-0 mt-3">
                <x-jet-label for="fecha_inicio" value="Fecha de inicio*" />
                <input wire:model="fecha_inicio" type="date" id="fecha_inicio"
                    placeholder="Fecha de inicio" name="fecha_inicio"
                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" max="{{$fecha_inicio}}" />
                <x-jet-input-error for="fecha_inicio" class="mt-2" />
            </div>
            <div class="md:w-64 xl:w-64  px-1 mb-2 md:mb-0 mt-3">
                <x-jet-label for="fecha_fin" value="Fecha de fin*" />
                <input wire:model="fecha_fin" type="date" id="fecha_fin" placeholder="Fecha fin"
                    name="fecha_fin"
                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"   max="{{$fecha_fin}}"/>
                <x-jet-input-error for="fecha_fin" class="mt-2" />
            </div>
            
            <div class="md:w-32 xl:w-32  px-1 mb-2 md:mb-0 mt-8">
              <x-jet-secondary-button wire:click="generarReporteClases" class="bg-indigo-500 hover:bg-indigo-500 text-white hover:text-white mr-2" style="background: #F97316">
                  Consultar
              </x-jet-secondary-button>
          </div>

          
    </form> 
    @if ($buscar == true)
    @if (!empty($clases))
    <div class="grid grid-cols-1 mt-2 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
        <table class="cell-border compact stripe tablas" id="reporte_planes">
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="">
                    <th class="p-2">#</th>
                    <th class="p-2">Cliente</th>
                    <th class="p-2">Sede</th>
                    <th class="p-2">Fecha Ingreso</th>
                   
                </tr>
            </thead>
            <tbody class="flex-1 sm:flex-none">
                @foreach ($clases as $clase)
                    <tr
                        class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 hover:bg-gray-100">
                        <td class="border-grey-light border p-3" data-label="#">
                            {{ $loop->iteration }}
                        </td>
                        <td class="border-grey-light border p-3" data-label="Cliente">
                            {{ $clase->cliente }}
                        </td>
                        <td class="border-grey-light border p-3"
                            data-label="Fecha de inicio">
                            {{ $clase->nombre_sede }}
                        </td>
                        <td class="border-grey-light border p-3"
                            data-label="Nombre del plan">
                            {{ $clase->fecha_ingreso}}
                        </td>                      
                        
                    </tr>
                @endforeach

            </tbody>
        </table>
        
        </div>

    </div>
    @else
    <div class="grid grid-cols-1 mt-2 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
        <p class="text-center mt-5">No se encontraron registros.</p>
    </div>


    @endif
    <div class="md:w-32 xl:w-32  px-1 mb-2 md:mb-0 mt-8">
        <x-jet-secondary-button wire:click="limpiar" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-3 mx-1 ml-3">
            Limpiar
        </x-jet-secondary-button>
    </div>

    @endif
    </div>
</div>