<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <section class="bg-white dark:bg-gray-900">
                <div class="container px-6 py-7 mx-auto">
                    <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
                        <x-titulo titulo="Listar Sedes"></x-titulo>
                    </div>
                    <div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end">
                        <x-jet-secondary-button wire:click="abrirModal"
                            class="bg-black hover:bg-gray-700 text-white hover:text-white">
                            Nueva Sede
                        </x-jet-secondary-button>
                    </div>
                    @livewire('sede.tabla')
                </div>
            </section>
        </div>
    </div>
</div>
@livewire('sede.modal')
