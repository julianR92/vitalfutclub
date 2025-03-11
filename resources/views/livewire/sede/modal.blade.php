<div>
  
    <div class="{{ $mostrarModal }} fixed z-10 inset-0 overflow-y-auto w-full" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center md:block md:p-0 w-full">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all md:my-8 md:align-middle w-9/12 sm:w-12/12 p-6 scale-95">
                <form wire:submit.prevent="guardar" class="w-full max-w-full p-2">

                    <div class="text-center sm:text-left">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                            {{ $titulo }}
                        </h3>
                        <hr>
                    </div>

                    <div class="flex flex-wrap mt-3">
                        <div class="w-full md:w-3/3 px-1 mb-2 md:mb-0">
                            <label for="current_password" class="font-medium"> Nombre sede*
                                <x-jet-input id="nombre_sede" type="text" class="mt-1 block w-full" wire:model="nombre_sede" minlength="5" required/>
                              @error('nombre_sede') <div><p class="text-red-400">{{$message}}</p></div> @enderror
                            </label>
                        </div>                        

                    </div>

                    <div class="flex flex-wrap mt-3">
                        <div class="w-full md:w-3/3 px-1 mb-2 md:mb-0">
                            <label for="current_password" class="font-medium"> Dirección*
                                <x-jet-input id="direccion" type="text" class="mt-1 block w-full" wire:model="direccion" onkeypress="return Direccion(event)"/>
                              @error('direccion') <div><p class="text-red-400">{{$message}}</p></div> @enderror
                            </label>

                        </div>                       
                    </div>

                    <div class="flex flex-wrap mt-3">
                        <div class="w-full md:w-3/3 px-1 mb-2 md:mb-0">
                            <label for="telefono" class="font-medium"> Telefono*
                                <x-jet-input id="telefono" type="text" class="mt-1 block w-full" wire:model="telefono" onkeypress="return Numeros(event)" minlength="7" maxlength="10"/>
                              @error('telefono') <div><p class="text-red-400">{{$message}}</p></div> @enderror
                                </label>
                        </div>                       
                    </div>

                    <div class="flex flex-wrap mt-3">
                        <div class="w-full md:w-3/3 px-1 mb-2 md:mb-0">
                            <label for="persona_cargo" class="font-medium"> Personal a Cargo*
                                <x-jet-input id="persona_cargo" type="text" class="mt-1 block w-full" wire:model="persona_cargo" onkeypress="return Letras(event)" onkeyup="aMayusculas(this.value,this.id)"/>
                              @error('persona_cargo') <div><p class="text-red-400">{{$message}}</p></div> @enderror
                                </label>
                           
                        </div>
                    </div>

                    <div class="flex justify-end mt-3">
                        <x-jet-button class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
                            Guardar
                        </x-jet-button>
                        <x-jet-secondary-button wire:click="cerrarModalSede()"
                            class="bg-gray-500 hover:bg-gray-700 text-white hover:text-white">
                            Cerrar
                        </x-jet-secondary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
