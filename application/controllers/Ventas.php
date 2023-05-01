<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->library('form_validation');
        $this->load->model('admin_model');
        $this->load->model('inventario_model');
        $this->load->model('venta_model');
        $this->load->model('compra_model');
        $this->load->model('user_model');
        $this->load->model('tienda_model');
        $this->load->helper('date');
        $this->load->library('generar_ticket');
        $file = $_SERVER['DOCUMENT_ROOT']."/assets/files/Lista de códigos de barra - Inventario.xlsx";  
        // $this->load->library('Leerexcelclass', [$file]);
    }

    public function _remap($method)
    {
        if ($this->admin_model->logged_id()) {            
            $this->$method();
        }
        else {
            redirect('/');
        }
    }

    public function index()
    {
        redirect('/ventas/listar');
    }

    public function listar(){
        // $usuarios = $this->user_model->getList();
        // $roles = $this->list_roles();
        $fechaDesde = new DateTime(); //getdate();
        // $interval = new DateInterval('P2D');
        $interval = new DateInterval('P0D');
        $interval->invert = 1;
        $fechaDesde = $fechaDesde->add($interval);   
        $fechaHasta = new DateTime();    
        $fechaHasta = $fechaHasta->add(new DateInterval('P0D'));  

        /* 		
        if(defined($_GET['fechaDesde']))
			$fechaDesde = $this->input->get('fechaDesde');
		else 				
			$fechaDesde = new DateTime();	
		if(defined($this->input->get('fechaHasta')))
			$fechaHasta = $this->input->get('fechaHasta');
		else 				
            $fechaHasta = new DateTime();  
        */	
        $usuario = $this->session->userdata('user');
        $tiendaId = $usuario['tienda_sel'];
        $user = $usuario;
        $ventas = $this->venta_model->listarVentas($fechaDesde->format('Ymd'), $fechaHasta->format('Ymd'));
        $tiendas = $this->tienda_model->getList();
        $vendedores = $this->user_model->getList();
        $js = ['sales/sale-list-v2.js?=v1.1'];    
        $css = [];  // 'jquery-ui.min'  'multiselect/bootstrap-multiselect.min'     
        $datos = [
            'page' => 'sales/list-sales',
            'js' => $js,
            'css' => $css,
            'usuario' => $usuario,
            'ventas' => $ventas,
            'tiendas' => $tiendas,
            'vendedores' => $vendedores,
            'fechaDesde' => $fechaDesde->format("d/m/Y"),
            'fechaHasta' => $fechaHasta->format("d/m/Y"),
            'tiendaId' => $tiendaId
        ];
        $this->load->view('init', $datos);
    }

    public function listarVentas($fechaDesde, $fechaHasta, $tiendaId)
    {
        $ventas = $this->venta_model->listarVentas($fechaDesde, $fechaHasta, $tiendaId);
        echo json_encode($ventas);
    }

	public function listarJson(){	
        // $fechaDesde = new DateTime();
        // $interval = new DateInterval('P7D');
        // $interval->invert = 1;
        // $fechaDesde = $fechaDesde->add($interval);   
		// $fechaHasta = new DateTime();	
        //$tiendaId = 2;		

        $fechaDesde = $this->input->post('fechaDesde');
        $dia = substr($fechaDesde, 0, 2); $mes = substr($fechaDesde, 3, 2); $ano = substr($fechaDesde, 6, 4);
        $fechaDesde = new DateTime("$ano-$mes-$dia");
        $fechaHasta = $this->input->post('fechaHasta');
        $dia = substr($fechaHasta, 0, 2); $mes = substr($fechaHasta, 3, 2); $ano = substr($fechaHasta, 6, 4);
        $fechaHasta = new DateTime("$ano-$mes-$dia");
        $tiendaId = $this->input->post('tienda');
        $estadoId = $this->input->post('estado');
        $vendedorId = $this->input->post('vendedor');
        $ventas = $this->venta_model->listarVentas($fechaDesde->format('Ymd'), $fechaHasta->format('Ymd'), $tiendaId, $estadoId, $vendedorId);
        $data = [];
        //$data['data'] = [];
        $data['data'] = $ventas;        
        echo json_encode($data);
    }

    public function obtenerNroVenta() {
        $nro = $this->venta_model->obtenerNroVenta();
        $nro = str_pad($nro[0]->ventaId + 1, 6, "0", STR_PAD_LEFT);
        echo json_encode($nro);
    }

    public function obtenerNroTicket(){
        $tiendaId = $this->input->post('tiendaId');
        $result = $this->venta_model->obtenerNroTicket($tiendaId);
        echo json_encode($result[0]);
    }

    public function registrar(){    
        $vendedores = $this->user_model->listar();
        $tiendas = $this->tienda_model->getList();
        $usuario = $this->session->userdata('user');
        $js = ['sale-model.js?v=1.0', 'sales/sale-add-v2.js?v=1.1'];
        $css = [];
        $datos = [
            'page' => 'sales/add-sales',    
            'js' => $js,
            'css' => $css,
            'vendedores' => $vendedores,
            'tiendas' => $tiendas,
            'usuario' => $usuario
        ];
        $this->load->view('init', $datos);
    }

    public function obtenerCorrelativo() {
        $res = $this->venta_model->obtenerCorrelativo('NV','TK01');
        echo json_encode($res[0]->numeroDoc);
    }
    
    public function registrar_venta() {
        try {
            $fecha = mdate('%Y-%m-%d %H:%i:%s');
            $usuario = (int)$this->session->userdata('user')['usuario_id'];

            // Obtener los datos del cliente
            $clienteId=$this->input->post('clienteId');
            $cliente = [
                'clienteId' => $clienteId,
                'tipo_persona' => 1,
                'tipo_documento' => $this->input->post('tipoDocumento'),
                'nro_documento' => $this->input->post('nroDocumento'),
                'nombres' => $this->input->post('nombres'),
                'apellido_paterno' => $this->input->post('apellidos'),
                'apellido_materno' => '',
                'direccion' => $this->input->post('direccion'),
                'email' => $this->input->post('email'),
                'telefono' => $this->input->post('telefono'),
                'celular' => '',
                'observaciones' => $this->input->post('observaciones'),                
                'usuarioId_created' => $usuario,  
                'usuarioId_updated' => $usuario,  
                'created_at' => $fecha,
                'updated_at' => $fecha
            ];  

            // Verificar si existe 
            $existe_cliente=$this->venta_model->obtenerClienteByNumero($cliente['nro_documento']);            
            if(empty($existe_cliente)){
                // echo "No existe cliente";
                $clienteId=$this->venta_model->registrarCliente($cliente);
            }            
            else{
                // echo "Ya existe cliente";
                $this->venta_model->modificarCliente($cliente);
            }
            
            /*
            $venta = [
                'ventaId' => 0,
                'clienteId' => $clienteId,
                'estado' => $this->input->post('estado'),
                'fechaSalida' => $this->input->post('fechaSalida'),
                'fechaDevolucion' => $this->input->post('fechaDevolucion')
            ];
            */

            $clienteTemp=json_decode($this->input->post('cliente'));
            $ventaTemp=json_decode($this->input->post('venta'));
            $ventaDetailsTemp=json_decode($this->input->post('venta-details'));
            $ventaPaymentsTemp=json_decode($this->input->post('venta-payments'));

            // Obtener la fecha de registro 
            $fechaRegistro = new DateTime($ventaTemp->fechaRegistro);
            $fechaRegistro->modify("-5 hours");
            $fechaSalida = new DateTime($ventaTemp->fechaSalida);
            $fechaSalida->modify("-5 hours");
            $fechaDevolucion = new DateTime($ventaTemp->fechaDevolucion);
            $fechaDevolucion->modify("-5 hours");

            $tipoDoc = $ventaTemp->tipoDoc;
            $serieDoc = substr($ventaTemp->nroOperacion,0,4);
            $numeroDoc = substr($ventaTemp->nroOperacion,5,6);
            $nroOperacion = $ventaTemp->nroOperacion;

            // Verificar si ya esta registrado
            $existe_correlativo = $this->venta_model->verificaExisteCorrelativo($tipoDoc, $serieDoc, $numeroDoc);
            // Obtener el siguiente correlativo
            if($existe_correlativo) {
                $res = $this->venta_model->obtenerCorrelativo($tipoDoc,$serieDoc);
                $numeroDoc = $res[0]->numeroDoc;
                $nroOperacion = $serieDoc."-".$numeroDoc;
                $this->venta_model->actualizarCorrelativo($tipoDoc, $serieDoc, $numeroDoc);
            }

            // Agregar las variables de auditoria 
            $venta = [
                // 'ventaId'=>$ventaTemp->ventaId,
                'tipoDoc'=>$tipoDoc,
                'serieDoc'=>$serieDoc,
                'numeroDoc'=>$numeroDoc,
                'numeroComprobante'=>$nroOperacion,
                'clienteId'=>$clienteId,
                'vendedorId'=>(int)$ventaTemp->vendedorId, // $this->session->userdata('user')['usuario_id'],
                'tiendaId' =>(int)$ventaTemp->tiendaId,
                'tipoOperacionId'=>$ventaTemp->tipoId,
                'estadoId'=> (int)$ventaTemp->estadoId,
                'etapaId'=>0,
                'clienteNro'=>$ventaTemp->clienteNro,
                'clienteNombres'=>$ventaTemp->clienteNombres,
                'observaciones'=>$ventaTemp->observaciones,
                'dejoDocumento'=>$ventaTemp->dejoDocumento,
                'dejoRecibo'=>$ventaTemp->dejoRecibo,
                'precioTotal'=>$ventaTemp->precioTotal,
                'totalEfectivo'=>$ventaTemp->totalEfectivo,
                'totalTarjeta'=>$ventaTemp->totalTarjeta,
                'totalVuelto'=>$ventaTemp->totalVuelto,
                'totalPagado'=>$ventaTemp->totalPagado,
                'totalSaldo'=>$ventaTemp->totalSaldo,
                'totalGarantia'=>$ventaTemp->totalGarantia,
                'fechaRegistro' => $fechaRegistro->format("Y-m-d H:i:s"),
                'anulado' => 0,
                'usuarioId_created' => $usuario,  
                'usuarioId_updated' => $usuario,  
                'created_at' => $fecha,
                'updated_at' => $fecha
            ];   
            
            if ($ventaTemp->estadoId == 1) {    // Reservado
                $venta['fechaSalidaProgramada']=$fechaSalida->format("Y-m-d H:i:s");  
                $venta['fechaDevolucionProgramada']=$fechaDevolucion->format("Y-m-d H:i:s"); 
            } else if ($ventaTemp->estadoId == 2) { // Alquilado
                $venta['fechaSalidaProgramada']=$fechaSalida->format("Y-m-d H:i:s");  
                $venta['fechaDevolucionProgramada']=$fechaDevolucion->format("Y-m-d H:i:s");
                $venta['fechaSalida']=$fechaSalida->format("Y-m-d H:i:s");  
                $venta['fechaDevolucion']=$fechaDevolucion->format("Y-m-d H:i:s");  
            }
            // Registrar la venta 
            $result = $this->venta_model->registrarVenta($venta, $ventaTemp->details, $ventaPaymentsTemp);
            if ($result>0){
                $ventaTemp->ventaId = $result;

                // Incrementar el correlativo
                $this->venta_model->incrementarCorrelativo($tipoDoc, $serieDoc);
            }
            $ventaTemp->fecha = $fecha;
            $ventaTemp->customer = $clienteTemp;

            // Imprimir el Ticket                
            // $this->imprimirTicket($ventaTemp);
            // echo $result;
            echo $nroOperacion;

            // echo "<pre>";        
            // echo print_r($ventaTemp);
            // echo "</pre>";
            // die($result);
            // echo var_dump($venta);
        }
        catch(\Exception $e) {
            echo 0;
        }
    }

    public function editar() {
        $ventaId = $this->uri->segment(3);
        $vendedores = $this->user_model->getList();
        $tiendas = $this->tienda_model->getList();
        $venta = $this->venta_model->obtenerVenta($ventaId);
        $usuario = $this->session->userdata('user');
        if(empty($venta)){
            $venta = [];
        }else{
            $cliente = $this->venta_model->obtenerClienteById($venta->clienteId);
            $venta->customer = $cliente[0];
        } 
        
        $js = [
        'droparea.min', 
        'fileinput/fileinput.min', 
        'fileinput/locales/es', 
        'fileinput/themes/fas/theme.min', 
        'sale-model.js?v=1.0', 
        'sales/sale-edit-v2.js?v=1.0'
        ];
        $css = [];
        $datos = [
            'page' => 'sales/edit-sales',    
            'js' => $js,
            'css' => $css,
            'vendedores' => $vendedores,
            'tiendas' => $tiendas,
            'venta' => $venta,
            'usuario' => $usuario
        ];
        $this->load->view('init', $datos);
    }

    public function editar_venta() {
        try {
            $fecha = mdate('%Y-%m-%d %H:%i:%s');
            $usuario = (int)$this->session->userdata('user')['usuario_id'];

            // Obtener los datos del cliente
            $cliente = [
                'clienteId' => $this->input->post('customerId'),
                'tipo_persona' => 1,
                'tipo_documento' => $this->input->post('tipoDocumento'),
                'nro_documento' => $this->input->post('nroDocumento'),
                'nombres' => $this->input->post('nombres'),
                'apellido_paterno' => $this->input->post('apellidos'),
                'apellido_materno' => '',
                'direccion' => $this->input->post('direccion'),
                'email' => $this->input->post('email'),
                'telefono' => $this->input->post('telefono'),
                'celular' => '',
                'observaciones' => $this->input->post('observaciones'),
                'usuarioId_updated' => $usuario,  
                'updated_at' => $fecha
            ];  

            // Verificar si existe 
            $this->venta_model->modificarCliente($cliente);
            
            $clienteTemp=json_decode($this->input->post('cliente'));
            $ventaTemp=json_decode($this->input->post('venta'));
            $ventaDetailsTemp=json_decode($this->input->post('venta-detalle'));
            $ventaPaymentsTemp=json_decode($this->input->post('venta-pago'));

            // Obtener la fecha de salida y devolución
            $fechaSalida = new DateTime($ventaTemp->fechaSalida);
            $fechaSalida->modify("-5 hours");
            $fechaDevolucion = new DateTime($ventaTemp->fechaDevolucion);
            $fechaDevolucion->modify("-5 hours");

            $ventaId = $ventaTemp->ventaId;
            $estadoId_Anterior = $ventaTemp->estadoId_Anterior;
            $venta = [                
                'clienteId'=>$ventaTemp->clienteId,
                'vendedorId'=>(int)$ventaTemp->vendedorId,
                'tiendaId' =>(int)$ventaTemp->tiendaId,
                'tipoOperacionId' => $ventaTemp->tipoId,
                'etapaId' => 0,
                'observaciones'=>$ventaTemp->observaciones,
                'dejoDocumento'=>$ventaTemp->dejoDocumento,
                'dejoRecibo'=>$ventaTemp->dejoRecibo,
                'estadoId'=> (int)$ventaTemp->estadoId,
                // 'estadoId_Anterior'=> (int)$ventaTemp->estadoId_Anterior,
                'precioTotal'=>$ventaTemp->precioTotal,
                'totalEfectivo'=>$ventaTemp->totalEfectivo,
                'totalTarjeta'=>$ventaTemp->totalTarjeta,
                'totalVuelto'=>$ventaTemp->totalVuelto,
                'totalPagado'=>$ventaTemp->totalPagado,
                'totalSaldo'=>$ventaTemp->totalSaldo,
                'totalGarantia'=>$ventaTemp->totalGarantia,
                'usuarioId_updated' => $usuario,  
                'updated_at' => $fecha
            ];            
            
            $venta['fechaSalidaProgramada']=$fechaSalida->format("Y-m-d H:i:s"); //$ventaTemp->fechaSalida;  
            $venta['fechaDevolucionProgramada']=$fechaDevolucion->format("Y-m-d H:i:s"); //$ventaTemp->fechaDevolucion; 

            if ($ventaTemp->estadoId == 2 && $ventaTemp->estadoId_Anterior <> 2) {
                $venta['fechaSalida']=$fecha;
            }
            if($ventaTemp->estadoId == 3 && $ventaTemp->estadoId_Anterior <> 3){
                $venta['fechaDevolucion']=$fecha;
            }
            if($ventaTemp->estadoId == 3) {
                $venta['totalGarantia']=0;
            }

            // Modificar la venta 
            $result = $this->venta_model->modificarVenta($ventaId, $venta, $ventaDetailsTemp, $ventaPaymentsTemp, $estadoId_Anterior);

            // Imprimir el Ticket                
            // $this->imprimirTicket($ventaTemp);
            echo $result;
        }
        catch(\Exception $e) {
            echo 0;
        }
    }

    public function anularVenta() {
        try {
            $fecha = mdate('%Y-%m-%d %H:%i:%s');
            $usuarioId = (int)$this->session->userdata('user')['usuario_id'];
            $tiendaId = (int)$this->session->userdata('user')['tienda_sel'];
            $ventaId = $this->input->post('ventaId');
            $motivo = $this->input->post('motivo');
            $result = $this->venta_model->anularVenta($ventaId, $usuarioId, $tiendaId, $fecha, $motivo);
            echo true;
        } catch (\Exception $ex) {
            echo false;
        }        
    }

    public function obtenerClienteByNumero(){
        $numero=$this->input->post('numero');        
        $cliente= $this->venta_model->obtenerClienteByNumero($numero);
        echo json_encode($cliente);
    }

    public function verificaClienteDevoluciones() {
        $numero=$this->input->post('numero');        
        $devoluciones= $this->venta_model->verificaClienteDevoluciones($numero);
        echo json_encode($devoluciones);
    }
    
    public function getModalReserva(){
        $tiendas = $this->tienda_model->getList();        
        echo($this->load->view('modals/m-atender-reserva', array('tiendas' => $tiendas), true));
    }

    public function getModalCalendar() {
        echo($this->load->view('modals/m-calendar', array('title' => 'Modal'), true));
    }

    public function obtenerReserva(){
        $dni = $this->input->post('dni');

        // Verificar si tiene alguna reserva pendiente
        $reserva = $this->venta_model->obtenerReservas($dni);
        if(empty($reserva)){
            $data = [];
        }else{
            $cliente = $this->venta_model->obtenerClienteByNumero($dni);
            $data['cliente'] = $cliente;
            $data['reserva'] = $reserva;
        }                
        echo json_encode($data);
    }

    public function obtenerVentaById() {
        $ventaId = $this->input->post('ventaId');

        // Verificar si tiene alguna reserva pendiente
        $venta = $this->venta_model->obtenerVenta($ventaId);
        if(empty($venta)){
            $venta = [];
        }else{
            $cliente = $this->venta_model->obtenerClienteById($venta->clienteId);
            $venta->cliente_sel = $cliente[0];
            $venta->customer = $cliente[0];
        }                
        echo json_encode($venta);
    }

    public function atenderReserva() {
        $ventaId = $this->input->post('ventaId');
        $result = $this->venta_model->atenderReserva($ventaId);
        return $result;
    }    

    public function getModalAlquiler(){
        $tiendas = $this->tienda_model->getList();        
        echo($this->load->view('modals/m-atender-alquiler', array('tiendas' => $tiendas), true));
    }

    public function getModalDevolucion() {
        $tiendas = $this->tienda_model->getList();        
        echo($this->load->view('modals/m-atender-devolucion', array('tiendas' => $tiendas), true));
    }

    public function obtenerAlquiler(){
        $dni = $this->input->post('dni');

        // Verificar si tiene alguna reserva pendiente
        $alquiler = $this->venta_model->obtenerAlquiler($dni);
        if(empty($alquiler)){
            $data = [];
        }else{
            $cliente = $this->venta_model->obtenerClienteByNumero($dni);
            $data['cliente'] = $cliente;
            $data['alquiler'] = $alquiler;
        }                
        echo json_encode($data);
    }

    public function atenderAlquiler() {
        $ventaId = $this->input->post('ventaId');
        $result = $this->venta_model->atenderAlquiler($ventaId);
        return $result;
    } 

    public function imprimirTicket($ticket) {
        $this->generar_ticket->imprimirTicket($ticket);
    }

    public function calendar()
    {
        $datos = [
            'page' => 'sales/calendar-test'
        ];
        $this->load->view('init', $datos);
    }
    
    public function descuentos() {
        $ventaId = $this->uri->segment(3);
        $vendedores = $this->user_model->getList();
        $tiendas = $this->tienda_model->getList();
        $venta = $this->venta_model->obtenerVenta($ventaId);
        $usuario = $this->session->userdata('user');
        if(empty($venta)){
            $venta = [];
        }else{
            $cliente = $this->venta_model->obtenerClienteById($venta->clienteId);
            $venta->customer = $cliente[0];
        } 

        $js = ['sale-model.js?v=1.0', 'sale--v2.js?v=1.0'];
        $css = [];
        $datos = [
            'page' => 'sales/list-descounts',    
            'js' => $js,
            'css' => $css,
            'vendedores' => $vendedores,
            'tiendas' => $tiendas,
            'venta' => $venta,
            'usuario' => $usuario
        ];
        $this->load->view('init', $datos);
    }

    public function liquidacion() {
        // $ventaId = $this->uri->segment(3);
        // $vendedores = $this->user_model->getList();
        $tiendas = $this->tienda_model->getList();
        // $venta = $this->venta_model->obtenerVenta($ventaId);
        $usuario = $this->session->userdata('user');
        $tiendaId = $usuario['tienda_sel'];
        // if(empty($venta)){
        //     $venta = [];
        // }else{
        //     $cliente = $this->venta_model->obtenerClienteById($venta->clienteId);
        //     $venta->customer = $cliente[0];
        // } 

        $js = ['sales/liquidation.js'];
        $css = [];
        $datos = [
            'page' => 'sales/liquidation',    
            'js' => $js,
            // 'css' => $css,
            // 'vendedores' => $vendedores,
            'tiendas' => $tiendas,
            'tiendaId' => $tiendaId,
            // 'tienda' => $tienda,
            // 'venta' => $venta,
            'usuario' => $usuario
        ];
        $this->load->view('init', $datos);
    }

    public function consultarLiquidacionTienda() {
        $fecha = $this->input->post('fecha');
        $tiendaId = $this->input->post('tiendaId');
        if (!$fecha) {
            echo "Seleccione una fecha";
        }
        $dia = substr($fecha, 0, 2); $mes = substr($fecha, 3, 2); $ano = substr($fecha, 6, 4);

        $fecha = new DateTime("$ano-$mes-$dia");
        $rs = $this->venta_model->obtenerResumenLiquidacion($fecha->format('Ymd'), $tiendaId);
        echo json_encode($rs);
    }

    public function consultarDetalleLiquidacion() {
        $fechaDesde = $this->input->post('fechaDesde');
        $fechaHasta = $this->input->post('fechaHasta');
        $tiendaId = $this->input->post('tiendaId');

        $dia = substr($fechaDesde, 0, 2); $mes = substr($fechaDesde, 3, 2); $ano = substr($fechaDesde, 6, 4);
        $fechaDesde = new DateTime("$ano-$mes-$dia");
        $dia = substr($fechaHasta, 0, 2); $mes = substr($fechaHasta, 3, 2); $ano = substr($fechaHasta, 6, 4);
        $fechaHasta = new DateTime("$ano-$mes-$dia");
        $rs = $this->venta_model->obtenerDetalleLiquidacion($fechaDesde->format('Ymd'), $fechaHasta->format('Ymd'), $tiendaId);
        echo json_encode($rs);
    }

    public function obteneVentaById() {
        $ventaId = $this->input->post('ventaId');
        $venta = $this->venta_model->obtenerVenta($ventaId);
        echo json_encode($venta);
    }

    public function listarAnulados() {
        $fechaDesde = $this->input->post('fechaDesde');
        $fechaHasta = $this->input->post('fechaHasta');
        $tiendaId = $this->input->post('tiendaId');

        $dia = substr($fechaDesde, 0, 2); $mes = substr($fechaDesde, 3, 2); $ano = substr($fechaDesde, 6, 4);
        $fechaDesde = new DateTime("$ano-$mes-$dia");
        $dia = substr($fechaHasta, 0, 2); $mes = substr($fechaHasta, 3, 2); $ano = substr($fechaHasta, 6, 4);
        $fechaHasta = new DateTime("$ano-$mes-$dia");

        $anulados = $this->venta_model->listarAnulados($tiendaId, $fechaDesde->format('Ymd'), $fechaHasta->format('Ymd'));
        echo json_encode($anulados);
    }

    // echo var_dump($_SERVER);
    // $file = $_SERVER['DOCUMENT_ROOT']."/assets/files/Lista de códigos de barra - Inventario.xlsx";  
                
    // echo $file; 
    // echo "<br>";
    // if(file_exists($file)){
    //     header('Content-Description: File Transfer');
    //     header('Content-Type: application/octet-stream');
    //     header('Content-Disposition: attachment; filename="'.basename($file).'"');
    //     // header('Expires: 0');
    //     header('Cache-Control: must-revalidate');
    //     header('Pragma: public');
    //     header('Content-Length: ' . filesize($file));
    //     readfile($file);
    //     exit;
    // }            
    // else {
    //     echo "No existe";
    // }     
    // exit();

    // echo "<br>";
    // $file = base_url()."assets/files/Lista de códigos de barra - Inventario.xlsx";
    // echo $file; echo "<br>";
    // $filename="Mi archivo.xlsx";    
}

/* End of file Controllername.php */

?>