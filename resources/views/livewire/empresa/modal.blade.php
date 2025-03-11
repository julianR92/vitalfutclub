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
                            <x-jet-label for="nit" value="Nit de la empresa" />
                            <input wire:model="nit" type="text" id="nit" placeholder="Nit de la empresa" name="nit"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="nit" class="mt-2" />
                        </div>

                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="razon_social" value="Razón social" />
                            <input wire:model="razon_social" type="text" id="razon_social" placeholder="Razón social"
                                name="razon_social"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="razon_social" class="mt-2" />
                        </div>

                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="direccion" value="Dirección" />
                            <input wire:model="direccion" type="text" id="direccion" placeholder="Dirección"
                                name="direccion"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="direccion" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-wrap mt-3">
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="representante" value="Representante legal" />
                            <input wire:model="representante" type="text" id="representante" placeholder="Representante legal"
                                name="representante"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="representante" class="mt-2" />
                        </div>

                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="telefono" value="Teléfono" />
                            <input wire:model="telefono" type="text" id="telefono" placeholder="Teléfono"
                                name="telefono"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="telefono" class="mt-2" />
                        </div>

                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="correo" value="Correo eletrónico" />
                            <input wire:model="correo" type="text" id="correo" placeholder="Correo eletrónico"
                                name="correo"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="correo" class="mt-2" />
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
