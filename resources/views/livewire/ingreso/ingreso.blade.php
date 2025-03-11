<div>
    
   <div class="{{$ocultar_busqueda}}"> 
 <div class="mx-auto overflow-hidden mt-10 mb-2 rounded-lg md:w-2/6 sm:w-4/6">
     
     <a href="{{route('ingreso.scanner')}}"><x-jet-secondary-button class="bg-black hover:bg-gray-700 text-white hover:text-white text-center">
                            Scanner Qr&nbsp;&nbsp; <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path fill="#fefbfb" d="M2 7V2h5v2H4v3H2Zm0 15v-5h2v3h3v2H2Zm15 0v-2h3v-3h2v5h-5Zm3-15V4h-3V2h5v5h-2Zm-2.5 10.5H19V19h-1.5v-1.5Zm0-3H19V16h-1.5v-1.5ZM16 16h1.5v1.5H16V16Zm-1.5 1.5H16V19h-1.5v-1.5ZM13 16h1.5v1.5H13V16Zm3-3h1.5v1.5H16V13Zm-1.5 1.5H16V16h-1.5v-1.5ZM13 13h1.5v1.5H13V13Zm6-8v6h-6V5h6Zm-8 8v6H5v-6h6Zm0-8v6H5V5h6ZM9.5 17.5v-3h-3v3h3Zm0-8v-3h-3v3h3Zm8 0v-3h-3v3h3Z"/></svg>
    </x-jet-secondary-button></a>
</div>

<div class="mx-auto overflow-hidden mt-10 shadow-lg mb-2 bg-neutral-900 shadow-lg border rounded-lg md:w-2/6 sm:w-4/6">
    <div>
      <form wire:submit.prevent="ingreso" >
      <div class="p-5 text-white text-center text-3xl bg-neutral-900"><span class="text-orange-500">Registro de Ingreso<br></span>{{$hoy}}</div>
      <div class="pt-10 p-5 pb-0 text-white text-right text-3xl bg-neutral-800 md:flex md:justify-center mb-6">
          <input type="number" id="numero_documento" name="numero_documento" wire:model="numero_documento" class="text-white text-center text-3xl bg-neutral-800 border-none " maxlength="12" autofocus readonly></div>
      <div class="p-5 text-white text-right text-3xl bg-neutral-900"></div>

      <div class="flex items-stretch bg-neutral-900 h-24">
        <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold  cursor-pointer">
          <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-orange-500 hover:border-2 hover:border-neutral-50 focus:outline-none"
          onClick="ponerInput(1)">1</div>
        </div>
      <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold  cursor-pointer"  >
          <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-orange-500 hover:border-2 hover:border-neutral-50 focus:outline-none"
          onClick="ponerInput(2)">2</div>
        </div>
       
        <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold  cursor-pointer" >
          <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-orange-500 hover:border-2 hover:border-neutral-50 focus:outline-none"
          onClick="ponerInput(3)">3</div>
        </div>
       
        {{-- <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold">
          <div class="rounded-full h-20 w-20 flex items-center bg-purple-800 justify-center shadow-lg border-2 border-purple-700 hover:border-2 hover:border-gray-500 focus:outline-none">+</div>
        </div> --}}
    </div>

    <div class="flex items-stretch bg-neutral-900 h-24">
      <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold cursor-pointer" >
        <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-orange-500 hover:border-2 hover:border-neutral-50 focus:outline-none"
        onClick="ponerInput(4)">4</div>
      </div>
    
      <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold cursor-pointer" >
        <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-orange-500 hover:border-2 hover:border-neutral-50 focus:outline-none"
        onClick="ponerInput(5)">5</div>
      </div>
     
      <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold cursor-pointer" >
        <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-orange-500 hover:border-2 hover:border-neutral-50 focus:outline-none"
        onClick="ponerInput(6)">6</div>
      </div>
     
      
  </div>
          


<div class="flex items-stretch bg-neutral-900 h-24">  
        
    <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold cursor-pointer" >
      <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-orange-500 hover:border-2 hover:border-neutral-50 focus:outline-none"
      onClick="ponerInput(7)">7</div>    
    </div>
   
  

  
    <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold cursor-pointer"  >
      <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-orange-500 hover:border-2 hover:border-neutral-50 focus:outline-none"
      onClick="ponerInput(8)">8</div>
    </div>
   
    <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold cursor-pointer"  >
      <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-orange-500 hover:border-2 hover:border-neutral-50 focus:outline-none"
      onClick="ponerInput(9)">9</div>
    </div>
   
    {{-- <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold">
      <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-orange-500 hover:border-2 hover:border-neutral-50 focus:outline-none"></div>
    </div> --}}
</div>
      

      


<div class="flex items-stretch bg-neutral-900 h-24 mb-4">
    <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold cursor-pointer" onClick="borrar();">
      <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-orange-500 hover:border-2 hover:border-neutral-50 focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M6.707 4.879A3 3 0 018.828 4H15a3 3 0 013 3v6a3 3 0 01-3 3H8.828a3 3 0 01-2.12-.879l-4.415-4.414a1 1 0 010-1.414l4.414-4.414zm4 2.414a1 1 0 00-1.414 1.414L10.586 10l-1.293 1.293a1 1 0 101.414 1.414L12 11.414l1.293 1.293a1 1 0 001.414-1.414L13.414 10l1.293-1.293a1 1 0 00-1.414-1.414L12 8.586l-1.293-1.293z" clip-rule="evenodd" />
      </svg></div>
    </div>
  
    <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold cursor-pointer" >
      <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-orange-500 hover:border-2 hover:border-neutral-50 focus:outline-none"
      onClick="ponerInput(0)">0</div>
    </div>
   
    <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold cursor-pointer">
      <button type="submit">
      <div class="rounded-full h-20 w-20 flex items-center bg-green-500 justify-center shadow-lg border-2 border-green-500 hover:border-2 hover:border-neutral-50 focus:outline-none">IR</div></button>
    </div>
   {{-- <div class="flex-1 px-2 py-2 justify-center flex items-center text-white text-2xl font-semibold">
      <div class="rounded-full h-20 w-20 flex items-center bg-orange-500 justify-center shadow-lg border-2 border-purple-700 hover:border-2 hover:border-gray-500 focus:outline-none">=</div>
    </div> --}}
</div>  
  </form>  
  </div>
</div>
</div>

    
    @include('livewire.ingreso.card') 
    @push('js')
        <script>
        
            function ponerInput(valor){
                document.getElementById('numero_documento').value+=valor;
                @this.set('numero_documento', document.getElementById('numero_documento').value, true)
            }
            
            function borrar(){
                let str = document.getElementById('numero_documento').value;
                document.getElementById('numero_documento').value=str.slice(0, -1);
                @this.set('numero_documento', document.getElementById('numero_documento').value, true)
            }
            
            function startTime() {
                 today = new Date();
                 h = today.getHours();
                 m = today.getMinutes();
                 s = today.getSeconds();
                 m = checkTime(m);
                 s = checkTime(s);
                 document.getElementById('reloj').innerHTML = h + ": " + m + ": " + s;
                 t = setTimeout('startTime()', 500);
            }
        
              function checkTime(i) {
                 if (i < 10) {
                    i = "0" + i;
                 }
                 return i;
              }
              window.onload = function() {
                 startTime();
              }
        </script>
        

    @endpush
   
</div>


