<?php 

require_once 'Tickets/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
defined('BASEPATH') OR exit('No direct script access allowed');

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
 
class Generar_ticket {

    public function __construct() {

    }

    public function imprimirTicket($ticket) {
        $nombre_impresora = "EPSON TM-T20II"; 
         
        // $connector = new WindowsPrintConnector($nombre_impresora);
        $connector = new FilePrintConnector("php://stdout/".$nombre_impresora);
        $printer = new Printer($connector);    

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2 ,3);
        $printer->text("BOUTIQUE GLAMOUR\n");
        $printer->setTextSize(1 ,1);
        $printer->text("De: Mary Luz Mendoza Maldonado\n");
        $printer->text("------------------------------------------------\n");
        $printer->text("Jr Este Mz M9 Lote 3 Mariscal Caceres costado del centro comercial el 'EL COLOSO'\n");
        $printer->setTextSize(2, 2);
        $printer->text("RUC: 104114478187\n");
        $printer->setTextSize(2, 1);
        $printer->text("Cel: 931708179\n");
        $printer->setTextSize(1, 1);
        $printer->text("Alquiler de vestidos de noche, ternos,accesorios\n");
        $printer->text("como: carteras, zapatos, boleros para toda\n");
        $printer->text("ocación o evento social\n");
        $printer->text("------------------------------------------------\n");
        $printer->setTextSize(2, 2);
        $printer->text("CONTRATO DE ALQUILER \n");
        $printer->text("N° ".str_pad($ticket->ventaId, 6, "0", STR_PAD_LEFT)."\n");
        $printer->setTextSize(1, 1);
        $printer->text("------------------------------------------------\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Fecha    : ".date("d/m/Y H:i:s")."\n");
        // $printer->text("Fecha: ".formatoFechaHora($ticket->fecha)->format("d/m/Y H:i:s")."\n");
        $printer->text("DNI      : ".$ticket->customer->nro_documento."\n");
        $printer->text("Nombres  : ".$ticket->customer->nombres." ".$ticket->customer->apellido_paterno." ".$ticket->customer->apellido_materno."\n");
        $printer->text("Teléfono : ".$ticket->customer->telefono."\n");
        $printer->text("Dirección: ".$ticket->customer->direccion."\n");
        $printer->text("------------------------------------------------\n");
        $printer->setTextSize(1, 2);
        $printer->text("CODIGO   DESCRIPCION                     IMPORTE\n");
        $printer->setTextSize(1, 1);
        $printer->text("------------------------------------------------\n");
        foreach ($ticket->details as $key => $item) {
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text(str_pad($this->limpiarCerosMedio($item->codigo), 9). $item->nombre."\n");
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("S/".number_format($item->precio, 2, '.', ',')."\n");
        }
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("------------------------------------------------\n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->setTextSize(2, 1);
        $printer->text("TOTAL A PAGAR: S/".number_format($ticket->precioTotal, 2, '.', ',')."\n");
        $printer->text("     A CUENTA: S/".number_format($ticket->totalPagado, 2, '.', ',')."\n");
        $printer->text("        SALDO: S/".number_format($ticket->totalSaldo, 2, '.', ',')."\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);
        $printer->text("------------------------------------------------\n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("Fecha recojo prenda     : ".$this->formatoFechaHora($ticket->fechaSalida, "d/m/Y")."\n");
        $printer->text("Fecha devolución prenda : ".$this->formatoFechaHora($ticket->fechaDevolucion, "d/m/Y")."\n");
        $printer->text("------------------------------------------------\n");
        $printer->setUnderline(Printer::UNDERLINE_SINGLE);
        $printer->setTextSize(1, 2);
        $printer->text("CLAUSULAS DEL CONTRATO\n");
        $printer->setUnderline(Printer::UNDERLINE_NONE);
        $printer->setTextSize(1, 1);
        $printer->text("1. Dejar DNI actual y recibo de agua o luz del último mes\n");
        $printer->text("2. El alquiler de prenda es de sólo 24 horas según lo acordado, pasada la fecha indicada se le cobrara el monto del 50%, sin lugar a reclamo alguno\n");
        $printer->text("3. NO SE ACEPTAN CAMBIOS ni devoluciones del efectivo por ninguna razón\n");

        $printer->feed(2);
        $printer->cut();
        $printer->pulse();
        $printer->close();
    }

    public function formatoFechaHora($fecha, $format) {
        $fecha = new DateTime($fecha, new DateTimeZone('America/Lima'));
        $fecha->modify("-5 hours");
        return $fecha->format($format);
    }
    public function limpiarCerosMedio($texto) {
        $i = 0;
        $newTexto = "";
        $tipo = 1;  // 1: prefijo, 2: ceros, 3: numero
        while($i<strlen($texto)){
            if($texto[$i]=="0"){    
                if($tipo == 1){
                    $tipo = 2;
                }    
                if($tipo == 3){
                    $newTexto .= $texto[$i];
                }
            }
            else {
                if(!is_numeric($texto[$i])){
                    $newTexto .= $texto[$i];  
                    $tipo = 1;
                }
                else {
                    $newTexto .= $texto[$i]; 
                    $tipo = 3;
                }    
            }        
            $i++;
        }
        return $newTexto;
    }
}


?>