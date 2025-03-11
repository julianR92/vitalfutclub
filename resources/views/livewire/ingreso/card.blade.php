<div class="{{$ocultar_div}}">
  
    <div class="mx-auto overflow-hidden mt-10 mb-2 bg-neutral-50 rounded-lg md:w-3/12 sm:w-4/6">
    <div class="max-w-sm rounded overflow-hidden shadow-lg"> 
      <form wire:submit.prevent="ingresoClase">  
        <div class="px-6 py-4">
         <p class="font-bold">Fecha de ingreso:</p> 
          <span>{{ date("d-m-Y")}} </span><span class="" id="reloj"></span>
         </div>
        
                   


          <div class="px-6 font-bold text-3xl mb-2">{{$this->nombre}}</div>
           <div class="px-6 font-bold text-1xl">Plan: {{$this->plan}}</div>
          <div class="px-6 font-bold text-1xl mb-2">Sede: {{$this->sede}}</div>
          <p class="px-6 text-gray-700 text-base">
           <span class="text-xl">Hasta: </span> <span class="text-3xl font-bold">{{$this->fecha_final}}</span> <br> 
           <span class="text-xl">Dias Restantes:</span>  <span class="text-3xl	font-bold @if($this->dias < 5) {{'text-red-500'}} @endif">{{$this->dias}}</span> <br>
           <span class="text-xl">Clases Restantes: </span> <span class="text-3xl	font-bold @if($this->clases < 5) {{'text-red-500'}} @endif" >
              @if($this->clases > 100) 
              Ilimitadas
              @else
              {{$this->clases}}
              @endif
            
          </p>
        </div>
        <div class="px-6 pt-4 mb-4 flex justify-end mt-3">
          <x-jet-button  class="bg-green-600 hover:bg-green-700 text-white hover:text-white mr-2">
            Registrar Ingreso
        </x-jet-button>
        <x-jet-secondary-button wire:click="cancelar()" class="bg-gray-500 hover:bg-gray-700 text-white hover:text-white">
            Cancelar
        </x-jet-secondary-button>
      </div>
      </form>
      </div>
      </div>
      @push('js')
        <script>
        
        
          
          
          
          
          
        </script>
        

    @endpush
</div>