
<div class="py-10">
       <link rel="stylesheet" href="{{asset('css/cards.css')}}">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <section class="bg-white dark:bg-gray-900">
                  @if (Auth::user()->rol=='admin')
                <div class="wrapper">
                <div class="card">
                    <h3 class="card-title">Planes activos: {{$planes_activos}}</h3>
                        <!--<p class="card-content">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>-->
                        <!--<button class="card-btn">READ MORE</button>-->
                    </div>
                <div class="card">
                    <h3 class="card-title">Usuarios registrados: {{$usuarios}}</h3>
                        <!--<p class="card-content">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>-->
                        <!--<button class="card-btn">READ MORE</button>-->
                    </div>
                  </div>
                   @endif
                <div class="container px-6 py-7 mx-auto">
                    <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                        <x-titulo titulo="Listar Clientes"></x-titulo>
                    </div>
                    <!--<div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end">-->
                    <!--    <div class="rounded-md bg-lime-500"><p class=" text-white">Planes activos: <span class="text-2xl font-semibold text-black	">{{$planes_activos}}</span> </p></div>-->
                    <!--    <div class="rounded-md bg-blue-700 mt-2"><p class=" text-white">Usuarios registrados: <span class="text-2xl font-semibold text-black	">{{$usuarios}}</span> </p></div>-->
                    <!--</div>-->
                    <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end">
                        <x-jet-secondary-button wire:click="abrirModal"
                            class="bg-black hover:bg-gray-700 text-white hover:text-white text-center">
                            Nuevo cliente
                        </x-jet-secondary-button>
                    </div>
                    @livewire('persona.tabla')
                </div>
            </section>
        </div>
    </div>
</div>

@livewire('persona.modal')
