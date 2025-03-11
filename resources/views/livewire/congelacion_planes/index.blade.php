<x-app-layout>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<div class="py-10">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
				<section class="bg-white dark:bg-gray-900">
					<div class="container px-6 py-7 mx-auto">
						<div class="bg-slate-100/50 py-1 px-3 border-solid border-b rounded-lg">
							<x-titulo titulo="Congelación de planes"></x-titulo>
						</div>
						<div class="grid grid-cols-1 mt-4 xl:mt-4 md:grid-cols-1 xl:grid-cols-1 justify-items-end"
							style="margin-bottom: 15px;">
							<x-jet-secondary-button class="bg-black hover:bg-gray-700 text-white hover:text-white"
								id="btnCongelar">
								Congelar plan
							</x-jet-secondary-button>
						</div>

						<div class="grid grid-cols-1 mt-4 xl:mt-2 md:grid-cols-2 xl:grid-cols-1">
							<table class="cell-border compact stripe tabla" id="tabla" width="100%">
								<thead>
									<tr>
										<th>Documento</th>
										<th>Nombre</th>
										<th>Apellido</th>
										<th>Fecha de inicio</th>
										<th>Fecha fin</th>
										<th>Observación</th>
										<!-- <th>Acciones</th> -->
									</tr>
								</thead>
								<tbody>
									@foreach ($datos as $item)
									<tr>
										<td>{{$item->persona->documento}}</td>
										<td>{{$item->persona->nombres}}</td>
										<td>{{$item->persona->apellidos}}</td>
										<td>{{$item->fecha_inicio}}</td>
										<td>{{$item->fecha_fin}}</td>
										<td>{{$item->observacion}}</td>
										<!-- <td>
											<x-jet-secondary-button
												class="bg-blue-500 hover:bg-blue-700 text-white hover:text-white"
												onclick="editar({{$item->id}})">
												Editar
											</x-jet-secondary-button>
											<x-jet-secondary-button class="bg-red-500 hover:bg-red-700 text-white hover:text-white"
												onclick="eliminar({{$item->id}})">
												Eliminar
											</x-jet-secondary-button>
										</td> -->
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
				</section>
			</div>
		</div>
	</div>

	<div class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true"
		id="modal">
		<div class="flex items-end justify-center min-h-screen pt-4 px-3 pb-20 text-center sm:block sm:p-0">
			<div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
			<div
				class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle w-full max-w-xl p-6">
				<form class="p-2" id="frm">

					<div class="text-center sm:text-left">
						<h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
							Congelación de plan
						</h3>
						<hr>
					</div>

					<div class="flex flex-wrap mt-3">
						<div class="w-full md:w-1/3 px-1 mb-2 md:mb-0">
							<x-jet-label for="tipo" value="Tipo" />
							<select
								class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
								name="tipo" id="tipo" placeholder="Seleccione..." required>
								<option value="">Seleccione</option>
								<option value="I">Individual</option>
								<option value="M">Masivo</option>
							</select>
							<x-jet-input-error for="tipo" class="mt-2" />
						</div>

						<div class="w-full md:w-2/3 px-1 mb-2 md:mb-0">
							<x-jet-label for="persona_id" value="Seleccione la persona" />
							<select
								class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
								name="persona_id" id="persona_id" disabled="true">
								<option value="">Seleccione</option>
								@foreach ($personas as $item)
								<option value="{{$item->id}}">{{$item->documento}} | {{$item->nombres}} {{$item->apellidos}}
								</option>
								@endforeach
							</select>
							<x-jet-input-error for="persona_id" class="mt-2" />
						</div>

					</div>

					<div class="flex flex-wrap mt-3">
						<div class="w-full md:w-1/2 px-1 md:mb-0">
							<x-jet-label for="fecha_inicio" value="Fecha inicio congelación*" />
							<input wire:model="fecha_inicio" type="date" id="fecha_inicio" placeholder="seleccione"
								name="fecha_inicio" required
								class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
							<x-jet-input-error for="fecha_inicio" class="mt-2" />
						</div>
						<div class="w-full md:w-1/2 px-1 mt-2 md:mb-0">
							<x-jet-label for="fecha_fin" value="Fecha fin congelación*" />
							<input wire:model="fecha_fin" type="date" id="fecha_fin" placeholder="seleccione" name="fecha_fin"
								required
								class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" />
							<x-jet-input-error for="fecha_fin" class="mt-2" />
						</div>
					</div>

					<div class="flex flex-wrap mt-3">
						<div class="w-full md:w-3/3 px-1 mb-2 md:mb-0">
							<x-jet-label for="observacion" value="Observación" />
							<x-jet-input id="observacion" type="text" name="observacion" class="mt-1 block w-full" />
						</div>
					</div>

					<div class="flex md:justify-end xl:justify-end justify-center mt-3">
						<x-jet-button id="btnGuardar"
							class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
							Guardar
						</x-jet-button>
						<x-jet-secondary-button id="btnCerrar"
							class="bg-gray-500 hover:bg-gray-700 text-white hover:text-white" onclick="cerrar()">
							Cerrar
						</x-jet-secondary-button>
					</div>
				</form>
			</div>
		</div>
	</div>

	@push('js')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script>
		let doc = document;

		$(document).ready(function() {
			new DataTable('#tabla', {
				pageLength: 30
			});
		});
		function cerrar() {
			doc.getElementById('modal').classList.add('hidden');
			doc.getElementById('tipo').value = '';
			doc.getElementById('persona_id').value = '';
			doc.getElementById('fecha_inicio').value = '';
			doc.getElementById('fecha_fin').value = '';
		}

		doc.getElementById('btnCongelar').addEventListener('click', () => {
			doc.getElementById('modal').classList.remove('hidden');
			doc.getElementById('modal').classList.add('show');
		});

		doc.getElementById('tipo').addEventListener('change', () => {
			let tipo = doc.getElementById('tipo').value;
			if (tipo == 'I') {
				doc.getElementById('persona_id').disabled = false;
				$('#persona_id').select2({
				placeholder: "Selecciona una persona",
				allowClear: true,
				width: 'resolve'
				})
			} else {
				$('#persona_id').select2('destroy');
				doc.getElementById('persona_id').value = '';
				doc.getElementById('persona_id').disabled = true;
			}
		});

		doc.getElementById('btnGuardar').addEventListener('click', (e) => {
			e.preventDefault();
			if (doc.getElementById('tipo').value == '' || doc.getElementById('fecha_inicio').value == ''||doc.getElementById('fecha_fin').value == '') {
				toastr.warning('Campos vacios', 'Atención');
				return;
			}
			
			let formData = new FormData();
			formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

			let tipo = doc.getElementById('tipo').value;
			if(tipo=='I'){
				let personaId = $('#persona_id').val(); // Usamos jQuery para obtener el valor de Select2
				if (personaId == '' || personaId === null) {
					toastr.error('Debe seleccionar una persona', 'Atención');
					return;
				}
				formData.append('plan_id', $('#persona_id').val());
			}else{
				formData.append('plan_id', doc.getElementById('persona_id').value);
			}

			formData.append('tipo', tipo);
			formData.append('fecha_inicio', doc.getElementById('fecha_inicio').value);
			formData.append('fecha_fin', doc.getElementById('fecha_fin').value);
			let fecha_inicio = doc.getElementById('fecha_inicio').value;
			let fecha_fin = doc.getElementById('fecha_fin').value;
			let diferencia = (new Date(fecha_fin) - new Date(fecha_inicio)) / (1000 * 60 * 60 * 24);
			
			if (diferencia < 0) {
				toastr.error('La fecha fin no puede ser menor a la fecha inicio', 'Atención');
				return;
			}
			formData.append('diferencia', diferencia);
			formData.append('observacion', doc.getElementById('observacion').value);

			$.ajax({
				url: '/congelacion-plan',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function (response) {
					
					if (response.success) {
						Swal.fire({
							title: 'Congelación de planes',
							text: response.message,
							icon: "success"
						});

						setTimeout(() => {
							location.reload();
						}, 2500)

					} else {
						Swal.fire({
						title: 'Congelación de planes',
						text: response.message,
						icon: "error"
						});
					}
				},
				error: function (xhr, status, error) {
					toastr.error('¡Se produjo el error!' + error, 'Intenta mas tarde');
				}
			});
		});
	</script>
	@endpush

</x-app-layout>