<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8 md:py-12 bg-gradient-to-br from-gray-50 via-orange-50/30 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-10">
                <h2 class="xl:text-2xl md:text-2xl text-xl font-semibold text-gray-900 capitalize dark:text-white">
                    #LaFelicidadSeEntrena
                </h2>

                <div class="w-24 h-1 bg-gradient-to-r from-orange-400 to-orange-600 mx-auto rounded-full shadow-lg">
                </div>
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                @if (Auth::user()->rol == 'cliente')
                    <!-- Cliente: Ver Histórico de Planes -->
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-300 hover:-translate-y-2 cursor-pointer">
                        <!-- Efecto de brillo en hover -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-orange-400/10 via-orange-300/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <!-- Círculo decorativo -->
                        <div
                            class="absolute -top-10 -right-10 w-32 h-32 bg-orange-100 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition-all duration-500">
                        </div>

                        <div class="relative p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-orange-400/50 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                    <i class="fa-solid fa-users text-white text-2xl"></i>
                                </div>
                                <span
                                    class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full group-hover:bg-orange-200 transition-colors duration-300">Plan</span>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 min-h-[56px]">
                                Ver Histórico de Planes
                            </h3>

                            <p class="text-gray-600 text-sm leading-relaxed min-h-[60px]">
                                Consulta tu historial completo de planes y revisa todos tus planes activos.
                            </p>

                            <a href="{{ route('persona.historico') }}"
                                class="inline-flex items-center space-x-2 text-orange-600 font-semibold text-sm group-hover:text-orange-700 transition-colors duration-300">
                                <span>Acceder</span>
                                <i
                                    class="fa-solid fa-arrow-right text-sm group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Administración de Clientes -->
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-300 hover:-translate-y-2 cursor-pointer">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-orange-400/10 via-orange-300/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute -top-10 -right-10 w-32 h-32 bg-orange-100 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition-all duration-500">
                        </div>

                        <div class="relative p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-orange-400/50 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                    <i class="fa-solid fa-users text-white text-2xl"></i>
                                </div>
                                <span
                                    class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full group-hover:bg-orange-200 transition-colors duration-300">Gestión</span>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 min-h-[56px]">
                                Administración de Clientes
                            </h3>

                            <p class="text-gray-600 text-sm leading-relaxed min-h-[60px]">
                                Gestiona clientes, asigna planes y administra toda la información de usuarios VitalFut.
                            </p>

                            <a href="{{ route('persona.index') }}"
                                class="inline-flex items-center space-x-2 text-orange-600 font-semibold text-sm group-hover:text-orange-700 transition-colors duration-300">
                                <span>Acceder</span>
                                <i
                                    class="fa-solid fa-arrow-right text-sm group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>

                    @if (Auth::user()->rol == 'admin')
                        <!-- Congelación de Planes -->
                        <div
                            class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-300 hover:-translate-y-2 cursor-pointer">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-orange-400/10 via-orange-300/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div
                                class="absolute -top-10 -right-10 w-32 h-32 bg-orange-100 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition-all duration-500">
                            </div>

                            <div class="relative p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-orange-400/50 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                        <i class="fa-solid fa fa-building text-white text-2xl"></i>
                                    </div>
                                    <span
                                        class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full group-hover:bg-orange-200 transition-colors duration-300">Ciudades</span>
                                </div>

                                <h3
                                    class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 min-h-[56px]">
                                    Ciudades
                                </h3>

                                <p class="text-gray-600 text-sm leading-relaxed min-h-[60px]">
                                    Gestiona las ciudades donde VitalFut tiene presencia.
                                </p>

                                <a href="/ciudades"
                                    class="inline-flex items-center space-x-2 text-orange-600 font-semibold text-sm group-hover:text-orange-700 transition-colors duration-300">
                                    <span>Acceder</span>
                                    <i
                                        class="fa-solid fa-arrow-right text-sm group-hover:translate-x-2 transition-transform duration-300"></i>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (Auth::user()->rol == 'admin')
                        <!-- Administración de Sedes -->
                        <div
                            class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-300 hover:-translate-y-2 cursor-pointer">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-orange-400/10 via-orange-300/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div
                                class="absolute -top-10 -right-10 w-32 h-32 bg-orange-100 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition-all duration-500">
                            </div>

                            <div class="relative p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-orange-400/50 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                        <i class="fa-solid fa-building text-white text-2xl"></i>
                                    </div>
                                    <span
                                        class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full group-hover:bg-orange-200 transition-colors duration-300">Sedes</span>
                                </div>

                                <h3
                                    class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 min-h-[56px]">
                                    Administración de Sedes
                                </h3>

                                <p class="text-gray-600 text-sm leading-relaxed min-h-[60px]">
                                    Crea, edita y gestiona las sedes deportivas de VitalFut en todo el país.
                                </p>

                                <a href="{{ route('sedes.index') }}"
                                    class="inline-flex items-center space-x-2 text-orange-600 font-semibold text-sm group-hover:text-orange-700 transition-colors duration-300">
                                    <span>Acceder</span>
                                    <i
                                        class="fa-solid fa-arrow-right text-sm group-hover:translate-x-2 transition-transform duration-300"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Administración de Planes -->
                        <div
                            class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-300 hover:-translate-y-2 cursor-pointer">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-orange-400/10 via-orange-300/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div
                                class="absolute -top-10 -right-10 w-32 h-32 bg-orange-100 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition-all duration-500">
                            </div>

                            <div class="relative p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-orange-400/50 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                        <i class="fa-solid fa-file-lines text-white text-2xl"></i>
                                    </div>
                                    <span
                                        class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full group-hover:bg-orange-200 transition-colors duration-300">Planes</span>
                                </div>

                                <h3
                                    class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 min-h-[56px]">
                                    Administración de Planes
                                </h3>

                                <p class="text-gray-600 text-sm leading-relaxed min-h-[60px]">
                                    Gestiona todos los planes y servicios que VitalFut ofrece a sus clientes.
                                </p>

                                <a href="/planes"
                                    class="inline-flex items-center space-x-2 text-orange-600 font-semibold text-sm group-hover:text-orange-700 transition-colors duration-300">
                                    <span>Acceder</span>
                                    <i
                                        class="fa-solid fa-arrow-right text-sm group-hover:translate-x-2 transition-transform duration-300"></i>
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Registro de Ingreso -->
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-300 hover:-translate-y-2 cursor-pointer">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-orange-400/10 via-orange-300/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute -top-10 -right-10 w-32 h-32 bg-orange-100 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition-all duration-500">
                        </div>

                        <div class="relative p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-orange-400/50 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                    <i class="fa-solid fa-user-group text-white text-2xl"></i>
                                </div>
                                <span
                                    class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full group-hover:bg-orange-200 transition-colors duration-300">Control</span>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 min-h-[56px]">
                                Registro de Ingreso
                            </h3>

                            <p class="text-gray-600 text-sm leading-relaxed min-h-[60px]">
                                Registra y controla el ingreso de usuarios a las clases deportivas.
                            </p>

                            <a href="{{ route('ingreso.index') }}"
                                class="inline-flex items-center space-x-2 text-orange-600 font-semibold text-sm group-hover:text-orange-700 transition-colors duration-300">
                                <span>Acceder</span>
                                <i
                                    class="fa-solid fa-arrow-right text-sm group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                @endif

                @if (Auth::user()->rol == 'admin')
                    <!-- Administración de Usuarios -->
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-300 hover:-translate-y-2 cursor-pointer">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-orange-400/10 via-orange-300/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute -top-10 -right-10 w-32 h-32 bg-orange-100 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition-all duration-500">
                        </div>

                        <div class="relative p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-orange-400/50 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                    <i class="fa-solid fa-user-gear text-white text-2xl"></i>
                                </div>
                                <span
                                    class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full group-hover:bg-orange-200 transition-colors duration-300">Usuarios</span>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 min-h-[56px]">
                                Administración de Usuarios
                            </h3>

                            <p class="text-gray-600 text-sm leading-relaxed min-h-[60px]">
                                Gestiona profesores, sus permisos y las sedes asignadas a cada uno.
                            </p>

                            <a href="{{ route('users.index') }}"
                                class="inline-flex items-center space-x-2 text-orange-600 font-semibold text-sm group-hover:text-orange-700 transition-colors duration-300">
                                <span>Acceder</span>
                                <i
                                    class="fa-solid fa-arrow-right text-sm group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                @endif



                @if (Auth::user()->rol == 'admin')
                    <!-- Congelación de Planes -->
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-300 hover:-translate-y-2 cursor-pointer">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-orange-400/10 via-orange-300/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute -top-10 -right-10 w-32 h-32 bg-orange-100 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition-all duration-500">
                        </div>

                        <div class="relative p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-orange-400/50 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                    <i class="fa-solid fa-pause-circle text-white text-2xl"></i>
                                </div>
                                <span
                                    class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full group-hover:bg-orange-200 transition-colors duration-300">Especial</span>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 min-h-[56px]">
                                Congelación de Planes
                            </h3>

                            <p class="text-gray-600 text-sm leading-relaxed min-h-[60px]">
                                Gestiona la congelación de planes de forma masiva o individual.
                            </p>

                            <a href="{{ route('congelacion.index') }}"
                                class="inline-flex items-center space-x-2 text-orange-600 font-semibold text-sm group-hover:text-orange-700 transition-colors duration-300">
                                <span>Acceder</span>
                                <i
                                    class="fa-solid fa-arrow-right text-sm group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                @endif

                @if (Auth::user()->rol == 'admin' || Auth::user()->rol == 'profesor')
                    <!-- Administración de Sorteos -->
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-300 hover:-translate-y-2 cursor-pointer">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-orange-400/10 via-orange-300/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute -top-10 -right-10 w-32 h-32 bg-orange-100 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition-all duration-500">
                        </div>

                        <div class="relative p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-orange-400/50 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                    <i class="fa-solid fa-gift text-white text-2xl"></i>
                                </div>
                                <span
                                    class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full group-hover:bg-orange-200 transition-colors duration-300">Sorteos</span>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 min-h-[56px]">
                                Administración de Sorteos
                            </h3>

                            <p class="text-gray-600 text-sm leading-relaxed min-h-[60px]">
                                Crea y gestiona los sorteos de los torneos internos VitalFut.
                            </p>

                            <a href="{{ route('sorteo.index') }}"
                                class="inline-flex items-center space-x-2 text-orange-600 font-semibold text-sm group-hover:text-orange-700 transition-colors duration-300">
                                <span>Acceder</span>
                                <i
                                    class="fa-solid fa-arrow-right text-sm group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                @endif

                 @if (Auth::user()->rol == 'admin' || Auth::user()->rol == 'profesor')
                    <!-- Administración de Torneos -->
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-300 hover:-translate-y-2 cursor-pointer">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-orange-400/10 via-orange-300/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute -top-10 -right-10 w-32 h-32 bg-orange-100 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition-all duration-500">
                        </div>

                        <div class="relative p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-orange-400/50 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                    <i class="fa-solid fa-trophy text-white text-2xl"></i>
                                </div>
                                <span
                                    class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full group-hover:bg-orange-200 transition-colors duration-300">Torneos</span>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 min-h-[56px]">
                                Administración de Torneos
                            </h3>

                            <p class="text-gray-600 text-sm leading-relaxed min-h-[60px]">
                                Crea y gestiona jugadores para los torneos internos VitalFut.
                            </p>

                            <a href="{{ route('torneo.index') }}"
                                class="inline-flex items-center space-x-2 text-orange-600 font-semibold text-sm group-hover:text-orange-700 transition-colors duration-300">
                                <span>Acceder</span>
                                <i
                                    class="fa-solid fa-arrow-right text-sm group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                @endif
                 @if (Auth::user()->rol == 'admin' || Auth::user()->rol == 'profesor')
                    <!-- Administración de Medidas -->
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 hover:border-orange-300 hover:-translate-y-2 cursor-pointer">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-orange-400/10 via-orange-300/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                        <div
                            class="absolute -top-10 -right-10 w-32 h-32 bg-orange-100 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition-all duration-500">
                        </div>

                        <div class="relative p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-orange-400 via-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-xl group-hover:shadow-orange-400/50 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                    <i class="fa-solid fa-ruler text-white text-2xl"></i>
                                </div>
                                <span
                                    class="px-3 py-1 bg-orange-100 text-orange-600 text-xs font-bold rounded-full group-hover:bg-orange-200 transition-colors duration-300">Medidas</span>
                            </div>

                            <h3
                                class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors duration-300 min-h-[56px]">
                                Administración de Medidas
                            </h3>

                            <p class="text-gray-600 text-sm leading-relaxed min-h-[60px]">
                                Crea y gestiona las medidas de los jugadores de Vitalfut.
                            </p>

                            <a href="{{ route('medidas.historial') }}"
                                class="inline-flex items-center space-x-2 text-orange-600 font-semibold text-sm group-hover:text-orange-700 transition-colors duration-300">
                                <span>Acceder</span>
                                <i
                                    class="fa-solid fa-arrow-right text-sm group-hover:translate-x-2 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                @endif



            </div>
        </div>
    </div>
</x-app-layout>
