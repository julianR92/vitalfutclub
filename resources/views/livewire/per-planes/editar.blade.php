<div>
    <div class="{{ $mostrarModal }} fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle w-max p-6">

                
                <form wire:submit.prevent="actualizar" class="w-full max-w-full p-2">


                    <div class="text-center sm:text-left">
                        <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                            {{ $titulo }}
                        </h3>
                        <hr>
                    </div>

                    <div class="flex flex-wrap mt-3">                       

                        <div class="w-full md:w-3/3 px-1 mb-2 md:mb-0 mt-3">
                            <x-jet-label for="fecha_fin" value="Fecha fin*" />
                            <input wire:model="fecha_fin" type="date" id="fecha_fin" placeholder="Fecha Fin"
                                name="fecha_fin" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="fecha_fin" class="mt-2" />
                        </div>
                        <div class="w-full md:w-3/3 px-1 mb-2 md:mb-0 mt-3">
                            <x-jet-label for="" value="Numero de clases*" />
                            <input wire:model="numero_clase" type="number" id="numero_clase" placeholder="Numero de clases"
                                name="numero_clase" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
                            <x-jet-input-error for="numero_clase" class="mt-2" />
                        </div>
                        <div class="w-full md:w-3/3 px-1 mb-2 md:mb-0 mt-3">
                            <x-jet-label for="" value="Observaciones*" />
                            <textarea wire:model="observacion" id="observacion" placeholder="Observaciones"
                                name="observacion" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" required></textarea>
                            <x-jet-input-error for="observacion" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex justify-end mt-3">
                        {{-- loadin stattes --}}
                        <div wire:loading wire:target="actualizar">
                        <button disabled type="button" class="py-2.5 px-5 mr-2 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center">
                            <svg role="status" class="inline mr-2 w-4 h-4 text-gray-200 animate-spin dark:text-gray-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="#1C64F2"/>
                            </svg>
                            Actualizando Plan...
                        </button>
                    </div>
                        

                        <x-jet-button wire:loading.class="hidden" class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
                            Actualizar
                        </x-jet-button>
                        <x-jet-secondary-button wire:click="cerrarModal()" wire:loading.attr="disabled"
                            class="bg-gray-500 hover:bg-gray-700 text-white hover:text-white">
                            Cerrar
                        </x-jet-secondary-button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
