<div>
    <div class="{{ $mostrarModal }} fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle w-max p-6">
                <form wire:submit.prevent="guardar" class="w-full max-w-full p-2">

                    <div class="text-center sm:text-left">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                            {{ $titulo }}
                        </h3>
                        <hr>
                    </div>

                    <div class="flex flex-wrap mt-3">
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="nombre_plan" value="Nombre del plan" />
                            <input wire:model="nombre_plan" type="text" id="documento" placeholder="Nombre del plan"
                                name="nombre_plan"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="nombre_plan" class="mt-2" />
                        </div>

                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="numero_clases" value="Número de clases" />
                            <input wire:model="numero_clases" id="numero_clases" type="number"
                                placeholder="Número de clases" name="numero_clases"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="numero_clases" class="mt-2" />
                        </div>

                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="numero_dias" value="Número de días" />
                            <input wire:model="numero_dias" id="numero_dias" type="number" placeholder="Número de días"
                                name="numero_dias"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="numero_dias" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-wrap mt-3">
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="valor" value="Valor del plan" />
                            <input wire:model="valor" type="text" id="valor" placeholder="Valor del plan" name="valor"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="valor" class="mt-2" />
                        </div>
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="sede_id" value="Sede donde aplica el plan" />
                            <x-select wire:model="sede_id" name="sede_id" id="sede_id"
                                :placeholder="'Seleccione la sede'" :options="$sedes" />
                            <x-jet-input-error for="sede_id" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex justify-end mt-3">
                        <x-jet-button class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
                            Guardar
                        </x-jet-button>
                        <x-jet-secondary-button wire:click="cerrarModal()"
                            class="bg-gray-500 hover:bg-gray-700 text-white hover:text-white">
                            Cerrar
                        </x-jet-secondary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
