<div class="py-10">
<link rel="stylesheet" href="{{asset('css/cards.css')}}">
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <section class="bg-white dark:bg-gray-900">
               <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg" style="margin:10px 20px 0px 20px;">
                        <x-titulo titulo="Planes Activos por Sede"></x-titulo>
                    </div>
                <div class="wrapper">

                @foreach ($planes_sedes as $planes) 
                <div class="card">
                    <h3 class="card-title">{{$planes->nombre_sede}}: {{$planes->numero_planes}}</h3>
                        <!--<p class="card-content">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>-->
                        <!--<button class="card-btn">READ MORE</button>-->
                    </div>
                    @endforeach
                
                  </div>
                <div class="container px-6 py-4 mx-auto">
                    <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                        <x-titulo titulo="Reportes"></x-titulo>
                    </div>
                    <form class="flex flex-wrap p-2">
                            <div class="md:w-64 xl:w-64  px-1 mb-2 md:mb-0 mt-3">
                                <x-jet-label for="fecha_inicio" value="Fecha de inicio*" />
                                <input wire:model="fecha_inicio" type="date" id="fecha_inicio"
                                    placeholder="Fecha de inicio" name="fecha_inicio"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                                <x-jet-input-error for="fecha_inicio" class="mt-2" />
                            </div>
                            <div class="md:w-64 xl:w-64  px-1 mb-2 md:mb-0 mt-3">
                                <x-jet-label for="fecha_fin" value="Fecha de fin*" />
                                <input wire:model="fecha_fin" type="date" id="fecha_fin" placeholder="Fecha fin"
                                    name="fecha_fin"
                                    class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                                <x-jet-input-error for="fecha_fin" class="mt-2" />
                            </div>
                            <!--
                            <div class="md:w-32 xl:w-32  px-1 mb-2 md:mb-0 mt-8">
                                <x-jet-secondary-button  wire:click="generarReportePlanes" class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
                                    Reporte de planes
                                </x-jet-secondary-button>
                            </div>
                            -->
                            <div class="md:w-32 xl:w-32  px-1 mb-2 md:mb-0 mt-8">
                              <x-jet-secondary-button wire:click="generarReporteClases" class="bg-indigo-500 hover:bg-indigo-500 text-white hover:text-white mr-2">
                                  Reporte de clases
                              </x-jet-secondary-button>
                          </div>
                          <div class="md:w-32 xl:w-32  px-1 mb-2 md:mb-0 mt-8">
                              <x-jet-secondary-button wire:click="generarReportePlanes2" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                  Reporte de planes
                              </x-jet-secondary-button>
                          </div>
                    </form>
                    <div>
                        @if ($buscar == true)
                            @if ($reporte_planes)
                                <div class="grid grid-cols-1 mt-2 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
                                    <table class="cell-border compact stripe tablas" id="reporte_planes">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr class="">
                                                <th class="p-2">Cliente</th>
                                                <th class="p-2">Fecha de inicio</th>
                                                <th class="p-2">Nombre del plan</th>
                                                <th class="p-2">Valor pagado</th>
                                                <th class="p-2">Fecha creacion</th>
                                            </tr>
                                        </thead>
                                        <tbody class="flex-1 sm:flex-none">
                                            @foreach ($reporte_planes as $persona)
                                                <tr
                                                    class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 hover:bg-gray-100">
                                                    <td class="border-grey-light border p-3" data-label="Cliente">
                                                        {{ $persona->cliente }}
                                                    </td>
                                                    <td class="border-grey-light border p-3"
                                                        data-label="Fecha de inicio">
                                                        {{ $persona->fecha_inicio }}
                                                    </td>
                                                    <td class="border-grey-light border p-3"
                                                        data-label="Nombre del plan">
                                                        {{ $persona->nombre_plan }}
                                                    </td>
                                                    <td class="border-grey-light border p-3" data-label="Valor pagado">
                                                        {{ $persona->total_plan }}
                                                    </td>
                                                    <td class="border-grey-light border p-3"
                                                        data-label="Fecha creación">
                                                        {{ $persona->created_at }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @elseif ($reporte_clases)
                                <div class="grid grid-cols-1 mt-2 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
                                    <table class="cell-border compact stripe tablas" id="reporte_clases">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr class="">
                                                <th class="p-2">Documento</th>
                                                <th class="p-2">Cliente</th>
                                                <th class="p-2">Fecha de ingreso</th>
                                            </tr>
                                        </thead>
                                        <tbody class="flex-1 sm:flex-none">
                                            @foreach ($reporte_clases as $persona)
                                                <tr
                                                    class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 hover:bg-gray-100">
                                                    <td class="border-grey-light border p-3" data-label="Documento">
                                                        {{ $persona->documento }}
                                                    </td>
                                                    <td class="border-grey-light border p-3" data-label="Cliente">
                                                        {{ $persona->cliente }}
                                                    </td>
                                                    <td class="border-grey-light border p-3"
                                                        data-label="Fecha de ingreso">
                                                        {{ $persona->fecha_ingreso }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @elseif($reporte_planes2)
                            <div class="grid grid-cols-1 mt-2 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
                                    <table class="cell-border compact stripe tablas" id="reporte_planes2">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr class="">
                                                <th class="p-2">Documento</th>
                                                <th class="p-2">Nombres</th>
                                                <th class="p-2">Apellidos</th>
                                                <th class="p-2">Valor pagado</th>
                                                <th class="p-2">Sede</th>
                                                <th class="p-2">Fecha creacion</th>
                                            </tr>
                                        </thead>
                                        <tbody class="flex-1 sm:flex-none">
                                            @foreach ($reporte_planes2 as $persona)
                                                <tr
                                                    class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 hover:bg-gray-100">
                                                    <td class="border-grey-light border p-3" data-label="Documento">
                                                        {{ $persona->documento }}
                                                    </td>
                                                    <td class="border-grey-light border p-3" data-label="Nombres">
                                                        {{ $persona->nombres }}
                                                    </td>
                                                    <td class="border-grey-light border p-3" data-label="Apellidos">
                                                        {{ $persona->apellidos }}
                                                    </td>
                                                    <td class="border-grey-light border p-3" data-label="Valor pagado">
                                                        {{ $persona->total_plan }}
                                                    </td>
                                                     <td class="border-grey-light border p-3" data-label="Sede">
                                                        {{ $persona->nombre_sede }}
                                                    </td>
                                                    <td class="border-grey-light border p-3"
                                                        data-label="Fecha creación">
                                                        {{ $persona->created_at }}
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center mt-5">No se encontraron registros.</p>
                            @endif
                        @endif
                    </div>
                    <div class="col-md-12 text-right mt-3 {{$hidden}}">
                        <button onClick="exportar('xlsx','{{$reporte}}')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Exportar</button>
                        
                    </div>
                </div>
                 @livewire('reportes.reportes-sedes')
            </section>
        </div>
    </div>
</div>
<script>
    
    function exportar(type,reporte,fn, dl) {
        
       var elt = document.getElementById(reporte);
       console.log(elt);
       var wb = XLSX.utils.table_to_book(elt, { sheet: "reporte" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('Reporte.' + (type || 'xlsx')));
    }
    
</script>
