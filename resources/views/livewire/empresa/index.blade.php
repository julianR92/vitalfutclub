<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <section class="bg-white dark:bg-gray-900">
                <div class="container px-6 py-7 mx-auto">
                    <div class="flex justify-between bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                        <x-titulo titulo="Datos de la empresa"></x-titulo>
                        <a href="{{ route('inicio') }}"
                            class="pt-1 text-orange-600 bg-orange-100 hover:bg-orange-200 text-white font-bold py-2 px-4 rounded-full"
                            title="Volver">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                            </svg>
                        </a>
                    </div>

                    <div class="flex mt-1 p-1 py-3 border-b border-gray-200">
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">Nit</p>
                            <p class="text-sm">{{ $empresa->nit }}</p>
                        </div>
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">Razón social</p>
                            <p class="text-sm">{{ $empresa->razon_social }}</p>
                        </div>
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">Dirección</p>
                            <p class="text-sm">{{ $empresa->direccion }}</p>
                        </div>
                    </div>

                    <div class="flex p-1 py-3 border-b border-gray-200">
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">Representante legal</p>
                            <p class="text-sm">{{ $empresa->representante }}</p>
                        </div>
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">Teléfono</p>
                            <p class="text-sm">{{ $empresa->telefono }}</p>
                        </div>
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <p class="font-medium text-sm text-gray-400">Correo electrónico</p>
                            <p class="text-sm">{{ $empresa->correo }}</p>
                        </div>

                    </div>
                    <div class="flex p-1 py-3 border-b border-gray-200 justify-end">
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-secondary-button
                                wire:click="$emitTo('empresa.modal','abrirModal',{{ $empresa->id }})"
                                class="bg-black hover:bg-gray-700 text-white hover:text-white">
                                Actualizar datos
                            </x-jet-secondary-button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@livewire('empresa.modal')
