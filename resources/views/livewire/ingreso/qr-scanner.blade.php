<div>
     <div class="{{$ocultar_busqueda}}"> 
        <div style="display: flex; justify-content: flex-start;">
         <a href="{{route('ingreso.index')}}" style="text-decoration: none; color: #007bff; font-weight: bold; padding: 10px 20px; background-color: #f0f0f0; border-radius: 5px;">Atrás</a>
         </div>
  
       <div class="mx-auto overflow-hidden mt-10 mb-2 rounded-lg md:w-2/6 sm:w-4/6">
            <div id="qr-reader"></div>
             <div id="qr-reader-results"></div>
        </div>
    </div>
@include('livewire.ingreso.card-qr') 
@push('js')
 <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script type="text/javascript">

window.addEventListener('reset-qr', event => {
    setTimeout(function(){
         location.reload();
    }, 3000);
})
    
var resultContainer = document.getElementById('qr-reader-results');
var lastResult, countResults = 0;
let documento;

function onScanSuccess(decodedText, decodedResult) {
    if (decodedText !== lastResult) {
        ++countResults;
        lastResult = decodedText;
        documento = JSON.parse(decodedResult.decodedText);
        if(documento.documento){
        Livewire.emit('validateQr', documento.documento);
        }

        // Handle on success condition with the decoded message.
        //console.log(`Scan result ${decodedText}`, decodedResult,countResults);
    }
    
}

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
//  reloj
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
              
            //   window.addEventListener('reset-qr', event => {
            //   alert('Name updated to: );
            // })


            // Livewire.on('reset-qr', () => {
            //      setTimeout(()=>{
            //          location.reload();
            //      },2000)
                
            // })
   
</script>
@endpush
</div>