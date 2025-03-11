<div>

	<div class="grid grid-cols-1 mt-2 xl:mt-2 md:grid-cols-2 xl:grid-cols-1 div-principal">
		<table class="cell-border compact stripe tabla" id="tabla"  wire:ignore>
			<thead class="">
				<tr class="">
					<th class="p-2" data-label="Tipo Doc">Tipo documento</th>
					<th class="p-2" data-label="CC">Documento</th>
					<th class="p-2" data-label="Nombres">Nombre</th>
					<th class="p-2" data-label="Apellidos">Apellidos</th>
					<th class="p-2" data-label="Telefono">Teléfono</th>
					<th class="p-2" data-label="Email">Correo electrónico</th>
					<th class="p-2" data-label="Direccion">Dirección</th>
					<th class="p-2" data-label="Fecha Registro">Fecha registro</th>
					<th class="p-3 text-center" width="110px" data-label="Actions">Acciones</th>
				</tr>
			</thead>
			<tbody class="flex-1 sm:flex-none text-sm">
				{{-- @if ($personas)
				@foreach ($personas as $persona)
				<tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 hover:bg-gray-100">
					<td class="border-grey-light border p-3" data-label="Tipo Doc">
						{{ $persona->tipo_doc }}
					</td>
					<td class="border-grey-light border p-3" data-label="CC">
						{{ $persona->documento }}
					</td>
					<td class="border-grey-light border p-3" data-label="Nombres">
						{{ $persona->nombres . ' ' . $persona->apellidos }}
					</td>
					<td class="border-grey-light border p-3" data-label="Telefono">
						{{ $persona->telefono }}
					</td>
					<td class="border-grey-light border p-3 email-td" data-label="Email">
						{{ $persona->correo }}
					</td>
					<td class="border-grey-light border p-3" data-label="Direccion">
						{{ $persona->direccion }}
					</td>
					<td class="border-grey-light border p-3" data-label="Estado">
						<span
							class="px-2 py-1 font-semibold  @if ($persona->users->estado == 1) {{ 'bg-green-100' }}@else {{ 'bg-red-100' }}@endif rounded-sm">
							{{ $persona->users->estado == 1 ? 'Activo' : 'Inactivo' }}
						</span>
					</td>
					<td class="border-grey-light border p-3" data-label="Fecha Registro">
						{{ $persona->created_at }}
					</td>
					<td class="border-grey-light border p-3" data-label="Actions">
						<div class="flex item-center justify-center">
							<a href="{{ route('persona.detalle',$persona) }}"
								class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
								</svg>
							</a>
							@if(Auth::user()->rol=='admin')
							<button data-id="{{$persona->id}}"
								class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125 btnEditar">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
									data-id="{{$persona->id}}" class="btnEditar">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
										data-id="{{$persona->id}}" class="btnEditar" />
								</svg>

							</button>



							<button data-id="{{$persona->id}}"
								class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125 btnEliminar">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
									data-id="{{$persona->id}}" class="btnEliminar">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
										class="btnEliminar" data-id="{{$persona->id}}" />
								</svg>
							</button>
							@endif
						</div>
					</td>
				</tr>
				@endforeach
				@endif --}}
			</tbody>
		</table>
	</div>
	@push('js')
	<script>
		$(document).ready(function () {
			var rol = "{{ Auth::user()->rol }}";
			$('#tabla').DataTable({
				destroy: true,
				processing: true,
				responsive:true,
				ajax: {
					url: '/persona/getData',
					type: 'GET'
				},
				columns: [
					{ data: 'tipo_doc', title: 'Tipo Documento', className: 'p-2', orderable: true },
					{ data: 'documento', title: 'Documento', className: 'p-2', orderable: true },
					{ data: 'nombres', title: 'Nombres', className: 'p-2', orderable: true },
					{ data: 'apellidos', title: 'Apellidos', className: 'p-2', orderable: true },
					{ data: 'telefono', title: 'Teléfono', className: 'p-2', orderable: true },
					{ data: 'correo', title: 'Correo Electrónico', className: 'p-2', orderable: true },
					{ data: 'direccion', title: 'Dirección', className: 'p-2', orderable: true },
					{
						data: 'created_at',
						title: 'Fecha registro',
						orderable: true,
						render: function (data, type, row) {
							return data.substring(0, 10);
						}
					},
					{
						data: null,
						title: 'Acciones',
						className: 'p-3 text-center',
						orderable: false,
						render: function (data, type, row) {
							return `
							<div class="flex item-center justify-center">
								<a href="/persona/${row.id}/detalle" class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" data-id="${row.id}">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
									</svg>
								</a>
								${rol === 'admin' ? `
								<button data-id="${row.id}" class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125 btnEditar">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="btnEditar" data-id="${row.id}">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
									</svg>
								</button>
								<button data-id="${row.id}" class="w-4 mx-2 transform hover:text-blue-800 hover:scale-125 btnEliminar">
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="btnEliminar" data-id="${row.id}" >
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
											d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
									</svg>
								</button>
								` : ''}
							</div>
							`;
						}
					},
				],
				scrollX: true,
				"order": [[0, "desc"]],
				language: {
					sProcessing: "Procesando...",
					sLengthMenu: "Mostrar _MENU_ registros",
					sZeroRecords: "No se encontraron resultados",
					sEmptyTable: "Ningún dato disponible en esta tabla",
					sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
					sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
					sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
					sInfoPostFix: "",
					sSearch: "Buscar:",
					sUrl: "",
					sInfoThousands: ",",
					sLoadingRecords: "Cargando...",
					oPaginate: {
						sFirst: "Primero",
						sLast: "Último",
						sNext: "Siguiente",
						sPrevious: "Anterior",
					},

					oAria: {
						sSortAscending:
							": Activar para ordenar la columna de manera ascendente",
						sSortDescending:
							": Activar para ordenar la columna de manera descendente",
					},
				},
				pageLength: 25,

			});

		});
		// Livewire.on('eliminarJs', ($persona) => {
		//     Swal.fire({
		//         title: 'Esta seguro de eliminar este registro?',
		//         text: "Si la persona no tiene planes asignados se borrarán los datos tano del usuario como del cliente",
		//         icon: 'warning',
		//         showCancelButton: true,
		//         confirmButtonColor: '#3085d6',
		//         cancelButtonColor: '#d33',
		//         confirmButtonText: 'Si, confirmar!',
		//         cancelButtonText: 'Cancelar',
		//     }).then((result) => {
		//         if (result.isConfirmed) {
		//             Livewire.emitTo('persona.modal', 'eliminar', $persona);
		//             Swal.fire(
		//                 'Registro eliminado!',
		//                 'Registro eliminado correctamente.',
		//                 'success',
		//             )
		//         }
		//     })
		// });
		$('.div-principal').ready(function () {
			if ($(window).width() < 640) {
				$('.tablas').removeClass('dataTable');
			} else {
				$('.tablas').addClass('dataTable');
			}

		});

		document.addEventListener('click', (e) => {
			if (e.target.matches('.btnEditar')) {
				Livewire.emitTo('persona.modal', 'abrirModal', e.target.dataset.id);
			}

			if (e.target.matches('.btnEliminar')) {
				Swal.fire({
					title: 'Esta seguro de eliminar este registro?',
					text: "Si la persona no tiene planes asignados se borrar��n los datos tano del usuario como del cliente",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Si, confirmar!',
					cancelButtonText: 'Cancelar',
				}).then((result) => {
					if (result.isConfirmed) {
						Livewire.emitTo('persona.modal', 'eliminar', e.target.dataset.id);
						Swal.fire(
							'Registro eliminado!',
							'Registro eliminado correctamente.',
							'success',
						)
					}
				})

			}

		});
	</script>
	@endpush
</div>