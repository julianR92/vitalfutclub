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
                            <x-jet-label for="tipo_doc" value="Tipo de documento" />
                            <select
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                wire:model="tipo_doc" name="tipo_doc" id="tipo_doc" placeholder="Seleccione tipo de documento...">
                                <option value="">Seleccione</option>
                                <option value="{{'Tarjeta de identidad'}}" wire:key="{{'Tarjeta de identidad'}}">Tarjeta de identidad</option>
                                <option value="Cedula de ciudadanía" wire:key="tipo_doc">Cedula de ciudadanía</option>
                                <option value="Pasaporte" wire:key="tipo_doc">Pasaporte</option>
                                <option value="Cedula extranjería" wire:key="tipo_doc">Cedula extranjería</option>
                            </select>
                            <x-jet-input-error for="tipo_doc" class="mt-2" />
                        </div>

                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="documento" value="Documento" />
                            <input wire:model="documento" type="text" id="documento" placeholder="Número de documento"
                                name="documento"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="documento" class="mt-2" />
                        </div>

                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="nombres" value="Nombres" />
                            <input wire:model="nombres" id="nombres" type="text" placeholder="Nombres" name="nombres"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="nombres" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-wrap mt-3">
                        <div class="w-full md:w-2/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="apellidos" value="Apellidos" />
                            <input wire:model="apellidos" type="text" id="apellidos" placeholder="Apelidos"
                                name="apellidos"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="apellidos" class="mt-2" />

                        </div>
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="fecha_nacimiento" value="Fecha de nacimiento*" />
                            <input wire:model="fecha_nacimiento" type="date" id="fecha_nacimiento" placeholder="Dirección"
                                name="fecha_nacimiento"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                                <x-jet-input-error for="fecha_nacimiento" class="mt-2" />
                        </div>
                        
                    </div>

                    <div class="flex flex-wrap mt-3">
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="telefono" value="Teléfono" />
                            <input wire:model="telefono" type="text" id="apellidos" placeholder="Teléfono"
                                name="telefono"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="telefono" class="mt-2" />

                        </div>
                        <div class="w-full md:w-2/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="correo" value="Correo electrónico" />
                            <input wire:model="correo" type="text" id="correo" placeholder="Correo electrónico"
                                name="correo"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="correo" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex flex-wrap mt-3">
                        <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">

                            <x-jet-label for="estado" value="Estado" />
                            <select
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                wire:model="estado" id="estado" name="estado" placeholder="Seleccione el estado del usuario...">
                                <option value="">Seleccione</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                            <x-jet-input-error for="estado" class="mt-2" />
                        </div>
                        <div class="w-full md:w-2/3 px-1 mb-2 md:mb-0">
                            <x-jet-label for="direccion" value="Dirección" />
                            <input wire:model="direccion" type="text" id="direccion" placeholder="Dirección"
                                name="direccion"
                                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                                <x-jet-input-error for="direccion" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex md:justify-end xl:justify-end justify-center mt-3">
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
