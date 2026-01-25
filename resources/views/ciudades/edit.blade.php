<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="bg-white dark:bg-gray-900">
                    <div class="container px-6 py-7 mx-auto">
                        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg mb-4">
                            <x-titulo titulo="Editar Ciudad"></x-titulo>
                        </div>
                        <form action="{{ route('ciudades.update', $ciudad) }}" method="POST" class="w-full max-w-full p-2">
                            @csrf
                            @method('PUT')

                            <div class="flex flex-wrap mt-3">
                                <div class="w-full md:w-1/2 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="nombre" value="Nombre *" />
                                    <input type="text"
                                           name="nombre"
                                           id="nombre"
                                           value="{{ old('nombre', $ciudad->nombre) }}"
                                           class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm @error('nombre') border-red-500 @enderror"
                                           placeholder="Ingrese el nombre de la ciudad"
                                           required>
                                    @error('nombre')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="w-full md:w-1/4 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="codigo" value="Código *" />
                                    <input type="text"
                                           name="codigo"
                                           id="codigo"
                                           value="{{ old('codigo', $ciudad->codigo) }}"
                                           class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm @error('codigo') border-red-500 @enderror"
                                           placeholder="Código"
                                           required>
                                    @error('codigo')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="w-full md:w-1/4 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="estado" value="Estado *" />
                                    <select name="estado"
                                            id="estado"
                                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm @error('estado') border-red-500 @enderror"
                                            required>
                                        <option value="">Seleccione</option>
                                        <option value="1" {{ old('estado', $ciudad->estado) == '1' ? 'selected' : '' }}>Activa</option>
                                        <option value="0" {{ old('estado', $ciudad->estado) == '0' ? 'selected' : '' }}>Inactiva</option>
                                    </select>
                                    @error('estado')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex md:justify-end xl:justify-end justify-center mt-4">
                                <x-jet-button class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
                                    <i class="fas fa-save mr-2"></i>Actualizar
                                </x-jet-button>
                                <a href="{{ route('ciudades.index') }}"
                                   class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-md">
                                    <i class="fas fa-arrow-left mr-2"></i>Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
