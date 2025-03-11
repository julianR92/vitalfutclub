<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;
use App\Models\PerPLanes;


class Notificaciones extends Mailable
{
    use Queueable, SerializesModels;
    public $detalleCorreo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($detalleCorreo)
    {
        $this->detalleCorreo = $detalleCorreo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        if($this->detalleCorreo['adjunto'] == 'SI'){
            
        $path = storage_path().'/app/public/facturas/'.$this->detalleCorreo['documento'].'/Factura-de-venta-'.$this->detalleCorreo['numero_factura'].'.pdf';
        return  $this->subject($this->detalleCorreo['Subject'])->view('factura.plantilla')->attach($path)
        ->attachData($this->generatePDF($this->detalleCorreo['documento'],$this->detalleCorreo['numero_factura'],$this->detalleCorreo['nombres']), $this->detalleCorreo['documento'].'-'.$this->detalleCorreo['numero_factura'].'.pdf', ['mime' => 'application/pdf']);

        }else{
        return  $this->subject($this->detalleCorreo['Subject'])->view('factura.plantilla');
        }
    }
    
     public function generatePDF($documento,$factura,$nombres)
    {    
        $plan = PerPLanes::findOrFail($factura);
        
        $data = [
                'documento' => $documento,
                'numero_factura' => $factura
            ];
       
       $encodedData = json_encode($data);
        $qrCodeImage = QrCode::format('png')->size(300)->generate($encodedData);
        $qrCodeDataUri = 'data:image/png;base64,' . base64_encode($qrCodeImage);
        $pdfHtml = view('factura.qr-code', ['qrCodeDataUri' => $qrCodeDataUri, 'nombres'=>$nombres, 'documento'=>$documento, 'plan'=>$plan])->render();
        $pdf = \PDF::loadHTML($pdfHtml)->setPaper('a4');
        return $pdf->output();
    }
    
}
