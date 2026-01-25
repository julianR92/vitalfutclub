<x-app-layout>
    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <section class="bg-white dark:bg-gray-900">
                    <div class="container px-6 py-7 mx-auto">
                        <div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg mb-4">
                            <x-titulo titulo="Nueva Sede"></x-titulo>
                        </div>

                        <form action="{{ route('sedes.store') }}" method="POST" class="w-full max-w-full p-2">
                            @csrf

                            <div class="flex flex-wrap mt-3">
                                <div class="w-full md:w-1/2 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="nombre_sede" value="Nombre de la Sede *" />
                                    <input type="text"
                                           name="nombre_sede"
                                           id="nombre_sede"
                                           value="{{ old('nombre_sede') }}"
                                           class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm @error('nombre_sede') border-red-500 @enderror"
                                           placeholder="Ingrese el nombre de la sede"
                                           required>
                                    @error('nombre_sede')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="w-full md:w-1/4 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="ciudad_id" value="Ciudad *" />
                                    <select name="ciudad_id"
                                            id="ciudad_id"
                                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm @error('ciudad_id') border-red-500 @enderror"
                                            required>
                                        <option value="">Seleccione</option>
                                        @foreach($ciudades as $ciudad)
                                            <option value="{{ $ciudad->id }}" {{ old('ciudad_id') == $ciudad->id ? 'selected' : '' }}>
                                                {{ $ciudad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ciudad_id')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="w-full md:w-1/4 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="user_id" value="Profesor Asignado" />
                                    <select name="user_id"
                                            id="user_id"
                                            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm @error('user_id') border-red-500 @enderror">
                                        <option value="">Sin asignar</option>
                                        @foreach($profesores as $profesor)
                                            <option value="{{ $profesor->id }}" {{ old('user_id') == $profesor->id ? 'selected' : '' }}>
                                                {{ $profesor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex flex-wrap mt-3">
                                <div class="w-full md:w-2/3 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="direccion" value="Dirección" />
                                    <input type="text"
                                           name="direccion"
                                           id="direccion"
                                           value="{{ old('direccion') }}"
                                           class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm @error('direccion') border-red-500 @enderror"
                                           placeholder="Dirección de la sede">
                                    @error('direccion')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
                                    <x-jet-label for="telefono" value="Teléfono" />
                                    <input type="text"
                                           name="telefono"
                                           id="telefono"
                                           value="{{ old('telefono') }}"
                                           class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm @error('telefono') border-red-500 @enderror"
                                           placeholder="Teléfono">
                                    @error('telefono')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex flex-wrap mt-3">
                                <div class="w-full md:w-full px-1 mb-2 md:mb-0">
                                    <x-jet-label for="persona_cargo" value="Persona a Cargo" />
                                    <input type="text"
                                           name="persona_cargo"
                                           id="persona_cargo"
                                           value="{{ old('persona_cargo') }}"
                                           class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm @error('persona_cargo') border-red-500 @enderror"
                                           placeholder="Nombre de la persona a cargo">
                                    @error('persona_cargo')
                                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex md:justify-end xl:justify-end justify-center mt-4">
                                <x-jet-button class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
                                    <i class="fas fa-save mr-2"></i>Guardar
                                </x-jet-button>
                                <a href="{{ route('sedes.index') }}"
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
