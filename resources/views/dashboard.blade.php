<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			{{ __('Dashboard') }}
		</h2>
	</x-slot>

	<div class="py-10">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
				<section class="bg-white dark:bg-gray-900">
					<div class="container px-6 py-5 mx-auto">
						<div class="flex justify-center mb-5 sm:mx-4">
							<h2 class="xl:text-2xl md:text-2xl text-xl font-semibold text-gray-700 capitalize dark:text-white">
								#LaFelicidadSeEntrena
							</h2>
						</div>
						<div class="grid grid-cols-1 gap-8 mt-2 xl:mt-2 xl:gap-12 md:grid-cols-2 xl:grid-cols-4">
							@if( Auth::user()->rol=='cliente')
							<div
								class="p-8 space-y-3 border-2 border-orange-400 rounded-xl hover:shadow-orange-400/60 hover:shadow-2xl hover:bg-gray-50">
								<span class="inline-block text-gray-500 dark:text-gray-400">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
									</svg>
								</span>

								<h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">
									Ver historico de planes</h1>

								<p class="text-gray-500 dark:text-gray-300">
									Esta funcionalidad sirve para ver el historico de planes, asi com los planes activos.
								</p>

								<a href="{{ route('persona.historico') }}"
									class="inline-flex p-2 text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-full dark:bg-gray-500 dark:text-white hover:underline hover:text-gray-600 dark:hover:text-gray-500">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
								</a>
							</div>
							@else
							<div
								class="p-8 space-y-3 border-2 border-orange-400 rounded-xl hover:shadow-orange-400/60 hover:shadow-2xl hover:bg-gray-50">
								<span class="inline-block text-gray-500 dark:text-gray-400">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
									</svg>
								</span>

								<h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">
									Administración de clientes</h1>

								<p class="text-gray-500 dark:text-gray-300">
									Esta funcionalidad sirve para crear, editar, eliminar y listar los clientes
									vinculados a VitalFut.
									Tambien tiene la funcionalidad de asignar planes a cada cliente entre otras más.
								</p>

								<a href="{{ route('persona.index') }}"
									class="inline-flex p-2 text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-full dark:bg-gray-500 dark:text-white hover:underline hover:text-gray-600 dark:hover:text-gray-500">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
								</a>
							</div>
							@if(Auth::user()->rol=='admin')
							<div
								class="p-8 space-y-3 border-2 border-orange-400 rounded-xl hover:shadow-orange-400/60 hover:shadow-2xl hover:bg-gray-50">
								<span class="inline-block text-gray-500 dark:text-gray-400">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
									</svg>
								</span>

								<h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">
									Administración de sedes</h1>

								<p class="text-gray-500 dark:text-gray-300">
									Esta funciónalidad sirve para crear, editar, eliminar y listar las
									sedes deportivas de VitalFut.
								</p>

								<a href="{{ route('sedes.index') }}"
									class="inline-flex p-2 text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-full dark:bg-gray-500 dark:text-white hover:underline hover:text-gray-600 dark:hover:text-gray-500">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
								</a>
							</div>
							<div
								class="p-8 space-y-3 border-2 border-orange-400 rounded-xl hover:shadow-orange-400/60 hover:shadow-2xl hover:bg-gray-50">
								<span class="inline-block text-gray-500 dark:text-gray-400">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
									</svg>
								</span>

								<h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">
									Administración de planes</h1>

								<p class="text-gray-500 dark:text-gray-300">
									Esta funciónalidad sirve para crear, editar, eliminar y listar los planes que ofrece
									VitalFut.
								</p>

								<a href="{{ route('plan.index') }}"
									class="inline-flex p-2 text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-full dark:bg-gray-500 dark:text-white hover:underline hover:text-gray-600 dark:hover:text-gray-500">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
								</a>
							</div>
							@endif
							<div
								class="p-8 space-y-3 border-2 border-orange-400 rounded-xl hover:shadow-orange-400/60 hover:shadow-2xl hover:bg-gray-50">
								<span class="inline-block text-gray-500 dark:text-gray-400">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
										fill="currentColor">
										<path
											d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
									</svg>
								</span>

								<h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">
									Registro de ingreso</h1>

								<p class="text-gray-500 dark:text-gray-300">
									Esta funciónalidad sirve psara registar y controlar el ingreso de los usuarios a las clases
								</p>

								<a href="{{ route('ingreso.index') }}"
									class="inline-flex p-2 text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-full dark:bg-gray-500 dark:text-white hover:underline hover:text-gray-600 dark:hover:text-gray-500">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
								</a>
							</div>
							@endif
							<!--{{-- lo nuevo 2024-30-09 --}}-->
							@if(Auth::user()->rol=='admin')

							<div
								class="p-8 space-y-3 border-2 border-orange-400 rounded-xl hover:shadow-orange-400/60 hover:shadow-2xl hover:bg-gray-50">
								<span class="inline-block text-gray-500 dark:text-gray-400">
									<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
										<path fill="currentColor"
											d="M10 12q-1.65 0-2.825-1.175T6 8t1.175-2.825T10 4t2.825 1.175T14 8t-1.175 2.825T10 12m-8 8v-2.8q0-.825.425-1.55t1.175-1.1q1.275-.65 2.875-1.1T10 13h.35q.15 0 .3.05q-.2.45-.337.938T10.1 15H10q-1.775 0-3.187.45t-2.313.9q-.225.125-.363.35T4 17.2v.8h6.3q.15.525.4 1.038t.55.962zm14 1l-.3-1.5q-.3-.125-.562-.262T14.6 18.9l-1.45.45l-1-1.7l1.15-1q-.05-.35-.05-.65t.05-.65l-1.15-1l1-1.7l1.45.45q.275-.2.538-.337t.562-.263L16 11h2l.3 1.5q.3.125.563.275t.537.375l1.45-.5l1 1.75l-1.15 1q.05.3.05.625t-.05.625l1.15 1l-1 1.7l-1.45-.45q-.275.2-.537.338t-.563.262L18 21zm1-3q.825 0 1.413-.587T19 16t-.587-1.412T17 14t-1.412.588T15 16t.588 1.413T17 18m-7-8q.825 0 1.413-.587T12 8t-.587-1.412T10 6t-1.412.588T8 8t.588 1.413T10 10m.3 8" />
									</svg>
								</span>

								<h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">
									Administración de usuarios</h1>

								<p class="text-gray-500 dark:text-gray-300" style="text-align:justify;">
									Esta opción sirve para realizar toda la gestión de usuarios rol tipo profesor, crear, editar
									administrar sus sedes
								</p>

								<a href="{{ route('users.index') }}"
									class="inline-flex p-2 text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-full dark:bg-gray-500 dark:text-white hover:underline hover:text-gray-600 dark:hover:text-gray-500">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
								</a>
							</div>
							@endif
							<!--{{-- lo nuevo 2024-30-09 --}}-->

							<!--{{-- lo nuevo 2024-10-28 --}}-->
							@if(Auth::user()->rol=='admin'|| Auth::user()->rol=='profesor')

							<div
								class="p-8 space-y-3 border-2 border-orange-400 rounded-xl hover:shadow-orange-400/60 hover:shadow-2xl hover:bg-gray-50">
								<span class="inline-block text-gray-500 dark:text-gray-400">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 11 11">
										<path
											d="M9 1.25a1.25 1.25 0 1 1-2.5-.001A1.25 1.25 0 0 1 9 1.25zm0 7.23a1 1 0 1 0 0 2a1 1 0 0 0 0-2zm1.81-3.39L8.94 3.18A.48.48 0 0 0 8.56 3H1.51a.5.5 0 0 0 0 1H5L2.07 8.3a.488.488 0 0 0 0 .2a.511.511 0 0 0 1 .21H3L4.16 7H6l-1.93 3.24a.49.49 0 0 0-.07.26a.51.51 0 0 0 1 .2l3.67-6.38l1.48 1.48a.5.5 0 1 0 .7-.71h-.04z"
											fill="currentColor" />
									</svg>
								</span>

								<h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">
									Administración de Torneos</h1>

								<p class="text-gray-500 dark:text-gray-300" style="text-align:justify;">
									Esta opción para crear y gestionar los jugadores de los torneos internos vital fut
								</p>

								<a href="{{ route('torneo.index') }}"
									class="inline-flex p-2 text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-full dark:bg-gray-500 dark:text-white hover:underline hover:text-gray-600 dark:hover:text-gray-500">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
								</a>
							</div>

							@endif
							@if(Auth::user()->rol=='admin')
							{{-- fabian --}}
							<div
								class="p-8 space-y-3 border-2 border-orange-400 rounded-xl hover:shadow-orange-400/60 hover:shadow-2xl hover:bg-gray-50">
								<span class="inline-block text-gray-500 dark:text-gray-400">

									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
										<path fill="currentColor"
											d="M20 9.5q-.213 0-.357-.143T19.5 9t.143-.357T20 8.5t.357.143T20.5 9t-.143.357T20 9.5m-9.5 12v-4.311l-3.1 3.1l-.689-.689l3.789-3.788V13.5H8.189L4.4 17.288l-.688-.688l3.1-3.1H2.5v-1h4.312l-3.1-3.1l.688-.689L8.189 12.5H10.5v-2.311L6.712 6.4l.688-.688l3.1 3.1V4.5h1v4.312l3.1-3.1l.688.688l-3.788 3.789V12.5h8v1h-4.312l3.1 3.1l-.688.688l-3.788-3.788H11.5v2.312l3.788 3.788l-.688.688l-3.1-3.1V21.5zm9-14.77V2.5h1v4.23z" />
									</svg>
								</span>

								<h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">
									Congelación de planes</h1>

								<p class="text-gray-500 dark:text-gray-300" style="text-align:justify;">
									Esta opción para crear la congelación de planes, masiva e individualmente.
								</p>

								<a href="{{ route('congelacion.index') }}"
									class="inline-flex p-2 text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-full dark:bg-gray-500 dark:text-white hover:underline hover:text-gray-600 dark:hover:text-gray-500">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>

								</a>
							</div>
							@endif
                            @if(Auth::user()->rol=='admin'|| Auth::user()->rol=='profesor')

							<div
								class="p-8 space-y-3 border-2 border-orange-400 rounded-xl hover:shadow-orange-400/60 hover:shadow-2xl hover:bg-gray-50">
								<span class="inline-block text-gray-500 dark:text-gray-400">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20"><!-- Icon from All by undefined - undefined --><path fill="currentColor" d="M12.437 3.25A5 5 0 0 0 10.001 5a5 5 0 0 0-2.437-1.75A3 3 0 0 1 10.001 2c1.003 0 1.892.493 2.436 1.25m-8.81 7.97a6.504 6.504 0 0 1 5.85-5.2a4 4 0 1 0-5.85 5.199m12.747 0a4 4 0 1 0-5.85-5.199a6.504 6.504 0 0 1 5.85 5.199M15.5 12.5a5.5 5.5 0 1 1-11 0a5.5 5.5 0 0 1 11 0m-7.5-2a.5.5 0 0 0 .5.5h2.24q-.154.22-.32.485c-.483.772-1.028 1.846-1.166 2.953a.5.5 0 1 0 .992.124c.112-.893.567-1.819 1.022-2.547a11 11 0 0 1 .843-1.168l.012-.014l.004-.004A.5.5 0 0 0 11.75 10H8.5a.5.5 0 0 0-.5.5"/></svg>
								</span>

								<h1 class="text-2xl font-semibold text-gray-700 capitalize dark:text-white">
									Administración de sorteos</h1>

								<p class="text-gray-500 dark:text-gray-300" style="text-align:justify;">
									Esta opción para crear y gestionar los sorteos de los torneos internos Vitalfut
								</p>

								<a href="{{ route('sorteo.index') }}"
									class="inline-flex p-2 text-gray-700 capitalize transition-colors duration-200 transform bg-gray-200 rounded-full dark:bg-gray-500 dark:text-white hover:underline hover:text-gray-600 dark:hover:text-gray-500">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
								</a>
							</div>

							@endif
							<!--{{-- lo nuevo 2024-10-28 --}}-->


						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</x-app-layout>
