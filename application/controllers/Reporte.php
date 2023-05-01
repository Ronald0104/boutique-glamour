<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Reporte extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('reporte_model');
        $this->load->model('tienda_model');
        $this->load->model('inventario_model');
    }

    public function _remap($method){
        if ($this->admin_model->logged_id()) {
            $this->$method();
        }
        else {
            redirect('');
        }
    }

    public function index() {
        echo "Reportes del sistema"; 
    }

    public function reporteFlujoCaja() {
        $usuario = $this->admin_model->logged_id();        
        if (!in_array($usuario['rol_id'], ["1","2"])){
            $page = "layouts/message";
            $mensaje = "NO TIENE AUTORIZACIÓN PARA ACCEDER A ESTE SITIO";
            $this->load->view('init', ['page'=>$page, 'mensaje'=>$mensaje]);
        } else {
            $fechaDesde = new DateTime();
            $diaSemana = $fechaDesde->format('w');
            if($diaSemana==0)
                $diaSemana=7;
             
            --$diaSemana;
            $interval = new DateInterval("P".$diaSemana."D"); $interval->invert = 1;
    
            $fechaDesde->add($interval);
            $fechaHasta = new DateTime();
            $usuario = $this->session->userdata('user');
            $tiendas = $this->tienda_model->getList();
            $tiendaUsuario = $usuario['tienda_sel'];
            $data = [
                'js' => ['rpt-flujo-caja.js'],
                'page' => '/reporte/reporte-flujo-caja',
                'fechaDesde' => $fechaDesde,            
                'fechaHasta' => $fechaHasta,
                'listaTiendas' => $tiendas,
                'tiendaUsuario' => $tiendaUsuario
            ];    
            $this->load->view('init', $data);
        }       
    }

    public function reporteFlujoCaja_DataJson(){
        
        $tienda = $this->input->post('tienda');
        $reporte = $this->reporte_model->reporteFlujoCaja($tienda);
        echo json_encode($reporte);
    }

    public function reporteFlujoCaja_Content(){
        $fechaDesde = $this->input->post('fechaDesde');
        $fechaHasta = $this->input->post('fechaHasta');
        $tiendaId = $this->input->post('tienda');
        $mostrarSaldoInicial = $this->input->post('mostrarSaldoInicial');
        
        $dia = substr($fechaDesde, 0, 2); $mes = substr($fechaDesde, 3, 2); $ano = substr($fechaDesde, 6, 4);
        $fechaDesde = new DateTime("$ano-$mes-$dia");
        $dia = substr($fechaHasta, 0, 2); $mes = substr($fechaHasta, 3, 2); $ano = substr($fechaHasta, 6, 4);
        $fechaHasta = new DateTime("$ano-$mes-$dia");
        $reporte = $this->reporte_model->reporteFlujoCaja($tiendaId,$fechaDesde,$fechaHasta,$mostrarSaldoInicial);
                
        $content = "";
        $i = 1;
        foreach ($reporte as $key => $value) {
            $fecha = new DateTime($value->fecha);   
            if (!$mostrarSaldoInicial && $key == 0) {
                continue;
            }
            $content .= "<tr tabindex='0'>";
            $content .= "<td>".($i++)."</td>";
            $content .= "<td>".$fecha->format('d-m-Y H:i')."</td>";
            $content .= "<td>$value->tipo</td>";
            if($value->nroOperacion==""){
                $content .= "<td><a href='#' class='link-operacion' data-tipo='".$value->tipo."' data-operacion='".$value->operacionId."'><u>".str_pad($value->operacionId, 6, '0', STR_PAD_LEFT)."</u></a></td>";
            } else {
                $content .= "<td><a href='#' class='link-operacion' data-tipo='".$value->tipo."' data-operacion='".$value->operacionId."'><u>".$value->nroOperacion."</u></a></td>";
            }
            // $content .= "<td>".str_pad($value->operacionId, 6, '0', STR_PAD_LEFT)."</td>";
            $content .= "<td>$value->descripcion</td>";
            if ($value->tipo == "SALDO INICIAL"){
                $content .= "<td class='text-right'>".number_format(0, 2, '.', ',')."</td>";
            } else {
                $content .= "<td class='text-right'>".number_format($value->monto, 2, '.', ',')."</td>";
            }
            $content .= "<td class='text-right font-weight-bold'>".number_format($value->saldoFinal, 2, '.', ',')."</td>";
            $content .= "</tr>";
        }
        echo $content;
    }

    public function reportePendienteDevolucion(){
        $usuario = $this->session->userdata('user');
        $tiendas = $this->tienda_model->getList();
        $tiendaUsuario = $usuario['tienda_sel'];
        $data = [
            'js' => ['rpt-pend-dev.js'],
            'page' => '/reporte/reporte-pendiente-devolucion',
            'listaTiendas' => $tiendas,
            'tiendaUsuario' => $tiendaUsuario
        ];

        $this->load->view('init', $data);
    }

    public function reportePendienteDevolucion_Content(){        
        $tiendas = $this->input->post('tienda');
        $diasVencidos = $this->input->post('diasVencidos');        
        $tiendas = str_replace("\"", "",implode(",", $tiendas));
        // $dia = substr($fechaDesde, 0, 2); $mes = substr($fechaDesde, 3, 2); $ano = substr($fechaDesde, 6, 4);
        // $fechaDesde = new DateTime("$ano-$mes-$dia");
        // $dia = substr($fechaHasta, 0, 2); $mes = substr($fechaHasta, 3, 2); $ano = substr($fechaHasta, 6, 4);
        // $fechaHasta = new DateTime("$ano-$mes-$dia");
        $reporte = $this->reporte_model->reportePendienteDevolucion($tiendas, $diasVencidos);
                
        $content = "";
        $i = 1;
        foreach ($reporte as $key => $value) {           
            $content .= "<tr tabindex='0'>";
            $content .= "<td>".($i++)."</td>";
            $content .= "<td><a href='#' class='link-cliente' data-cliente='".$value->clienteId."' data-cliente-nro='".$value->nro_documento."'><u>".$value->nro_documento."</u></a></td>";
            $content .= "<td>".$value->cliente."</td>";
            $content .= "<td>".$value->telefono."</td>";     
            if($value->ventaCode==""){
                $content .= "<td><a href='#' class='link-venta' data-venta='".$value->ventaId."'><u>".$value->ventaCode0."</u></a></td>";
            }else {
                $content .= "<td><a href='#' class='link-venta' data-venta='".$value->ventaId."'><u>".$value->ventaCode."</u></a></td>";
            }   
            $content .= "<td>".$value->tienda."</td>";
            $content .= "<td>".$value->fechaSalida."</td>";
            $content .= "<td>".$value->fechaDevolucionProg."</td>";
            if($value->diasVencidos < 0){
                $content .= "<td>FALTAN ".abs($value->diasVencidos)." DÍA(S)</td>";
            }else {
                $content .= "<td>".$value->diasVencidos." DÍA(S) VENCIDOS</td>";
            }
            $content .= "</tr>";
        }
        echo $content;
    }

    public function reporteReservas(){
        $fechaDesde = new DateTime();
        // $diaSemana = $fechaDesde->format('w');
        // if($diaSemana==0)
        //     $diaSemana=7;
         
        // --$diaSemana;
        // $interval = new DateInterval("P".$diaSemana."D"); $interval->invert = 1;

        // $fechaDesde->add($interval);
        $fechaHasta = new DateTime();
        $fechaHasta->add(new DateInterval("P7D"));
        $usuario = $this->session->userdata('user');
        $tiendas = $this->tienda_model->getList();
        $tiendaUsuario = $usuario['tienda_sel'];
        $data = [
            'js' => ['rpt-reservas.js'],
            'page' => '/reporte/reporte-reservas',
            'listaTiendas' => $tiendas,
            'tiendaUsuario' => $tiendaUsuario,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta
        ];

        $this->load->view('init', $data);
    }

    public function reporteReservas_Content(){  
        $fechaDesde = $this->input->post('fechaDesde');
        $fechaHasta = $this->input->post('fechaHasta'); 
        $dia = substr($fechaDesde, 0, 2); $mes = substr($fechaDesde, 3, 2); $ano = substr($fechaDesde, 6, 4);
        $fechaDesde = new DateTime("$ano-$mes-$dia");
        $dia = substr($fechaHasta, 0, 2); $mes = substr($fechaHasta, 3, 2); $ano = substr($fechaHasta, 6, 4);
        $fechaHasta = new DateTime("$ano-$mes-$dia");

        $tiendas = $this->input->post('tienda');
        $diasFaltantes = $this->input->post('diasFaltantes'); 
        $mostrarDetallado =   $this->input->post('mostrarDetallado');      
        $tiendas = str_replace("\"", "",implode(",", $tiendas));
        $reporte = $this->reporte_model->reporteReservas($tiendas, $fechaDesde, $fechaHasta, $diasFaltantes, $mostrarDetallado);
                
        $content = "";
        $i = 1;
        foreach ($reporte as $key => $value) {           
            $content .= "<tr tabindex='0'>";
            $content .= "<td>".($i++)."</td>";
            $content .= "<td><a href='#' class='link-cliente' data-cliente='".$value->clienteId."' data-cliente-nro='".$value->nro_documento."'><u>".$value->nro_documento."</u></a></td>";
            $content .= "<td>".$value->cliente."</td>";
            if ($value->ventaCode == "") {
                $content .= "<td><a href='#' class='link-venta' data-venta='".$value->ventaId."'><u>".$value->ventaCode0."</u></a></td>";
            } else {
                $content .= "<td><a href='#' class='link-venta' data-venta='".$value->ventaId."'><u>".$value->ventaCode."</u></a></td>";
            }
            $content .= "<td>".$value->tienda."</td>";
            $content .= "<td>".$value->fechaRegistro."</td>";
            $content .= "<td>".$value->fechaReserva."</td>";
            $content .= "<td>".$value->diasReserva."</td>";
            if ($mostrarDetallado == 1) {
                $content .= "<td>".$value->code."</td>";
                $content .= "<td>".$value->nombreArticulo."</td>";
            }
            $content .= "</tr>";
        }
        echo $content;
    }

    public function reporteSaldosPendientes() {
        $fechaDesde = new DateTime();
        $diaSemana = $fechaDesde->format('w');
        if($diaSemana==0) $diaSemana=7;
         
        --$diaSemana;
        $interval = new DateInterval("P".$diaSemana."D"); $interval->invert = 1;

        $fechaDesde->add($interval);
        $fechaHasta = new DateTime();
        $usuario = $this->session->userdata('user');
        $tiendas = $this->tienda_model->getList();
        $tiendaUsuario = $usuario['tienda_sel'];
        $data = [
            'js' => ['rpt-saldos-pend.js'],
            'page' => '/reporte/reporte-saldos-pendientes',
            'fechaDesde' => $fechaDesde,            
            'fechaHasta' => $fechaHasta,
            'listaTiendas' => $tiendas,
            'tiendaUsuario' => $tiendaUsuario
        ];

        $this->load->view('init', $data);
    }

    public function reporteSaldosPendientes_Content(){  
        $fechaDesde = $this->input->post('fechaDesde');
        $fechaHasta = $this->input->post('fechaHasta'); 

        // $fecha = new DateTime();
        // $dia = date("d"); $mes = date("M"); $ano = date("Y");
        $dia = substr($fechaDesde, 0, 2); $mes = substr($fechaDesde, 3, 2); $ano = substr($fechaDesde, 6, 4);
        $fechaDesde = new DateTime("$ano-$mes-$dia");
        $dia = substr($fechaHasta, 0, 2); $mes = substr($fechaHasta, 3, 2); $ano = substr($fechaHasta, 6, 4);
        $fechaHasta = new DateTime("$ano-$mes-$dia");

        $tiendas = $this->input->post('tienda');
        // $diasFaltantes = $this->input->post('diasFaltantes'); 
        // $mostrarDetallado =   $this->input->post('mostrarDetallado');      
        $tiendas = str_replace("\"", "",implode(",", $tiendas));
        $reporte = $this->reporte_model->reporteSaldosPendientes($tiendas, $fechaDesde, $fechaHasta);
                
        $content = "";
        $i = 1;
        foreach ($reporte as $key => $value) {           
            $content .= "<tr tabindex='0'>";
            $content .= "<td>".($i++)."</td>";
            $content .= "<td><a href='#' class='link-cliente' data-cliente='".$value->clienteId."' data-cliente-nro='".$value->nroDocumento."'><u>".$value->nroDocumento."</u></a></td>";
            $content .= "<td>".$value->cliente."</td>";
            $content .= "<td><a href='#' class='link-venta' data-venta='".$value->ventaId."'><u>".$value->codigo."</u></a></td>";
            $content .= "<td>".$value->estado."</td>";
            $content .= "<td>".$value->tienda."</td>";
            $content .= "<td>".$value->fechaRegistro."</td>";
            $content .= "<td>".$value->fechaSalida."</td>";
            $content .= "<td>".$value->fechaDevolucion."</td>";
            $content .= "<td>".$value->precioTotal."</td>";
            $content .= "<td>".$value->totalSaldo."</td>";
            $content .= "</tr>";
        }
        echo $content;
    }

    public function reportePrendas(){
        $fechaDesde = new DateTime();
        // $diaSemana = $fechaDesde->format('w');
        // if($diaSemana==0) $diaSemana=7;         
        // --$diaSemana;
        // $interval = new DateInterval("P".$diaSemana."D"); $interval->invert = 1;

        // $fechaDesde->add($interval);
        $fechaHasta = new DateTime();
        $usuario = $this->session->userdata('user');
        $tiendas = $this->tienda_model->getList();
        $tiendaUsuario = $usuario['tienda_sel'];
        $categorias = $this->inventario_model->getListCategorias();
        $data = [
            'js' => ['rpt-prendas.js'],
            'page' => '/reporte/reporte-prendas',
            'fechaDesde' => $fechaDesde,            
            'fechaHasta' => $fechaHasta,
            'listaTiendas' => $tiendas,
            'tiendaUsuario' => $tiendaUsuario,
            'categorias' => $categorias
        ];

        $this->load->view('init', $data);
    }

    public function reportePrendas_Content(){        
        $categoriaId = $this->input->post('categoria');
        $tallas = $this->input->post('talla');  
        if ($tallas == null) {
            $tallas = 0;
        } else {               
            $tallas = str_replace("\"", "",implode(",", $tallas));   
        }        
        $colores = $this->input->post('color');   
        if ($colores == null) {
            $colores = 0;
        } else {
            $colores = str_replace("\"", "",implode(",", $colores));
        }
        $disenos = $this->input->post('diseno');        
        if ($disenos == null) {
            $disenos = 0;
        } else {
            $disenos = str_replace("\"", "",implode(",", $disenos));
        }
        $condicion = $this->input->post('condicion');

        $fechaDesde = $this->input->post('fechaDesde');
        $fechaHasta = $this->input->post('fechaHasta'); 
        $dia = substr($fechaDesde, 0, 2); $mes = substr($fechaDesde, 3, 2); $ano = substr($fechaDesde, 6, 4);
        $fechaDesde = new DateTime("$ano-$mes-$dia");
        $dia = substr($fechaHasta, 0, 2); $mes = substr($fechaHasta, 3, 2); $ano = substr($fechaHasta, 6, 4);
        $fechaHasta = new DateTime("$ano-$mes-$dia");
        $reporte = $this->reporte_model->reportePrendasDisponibles($categoriaId, $fechaDesde, $fechaHasta, $tallas, $colores, $disenos, $condicion);
                
        $content = "";
        $i = 1;
        foreach ($reporte as $key => $value) {           
            $content .= "<tr tabindex='0'>";
            $content .= "<td>".($i++)."</td>";
            // $content .= "<td><a href='#' class='link-cliente' data-cliente='".$value->clienteId."' data-cliente-nro='".$value->nro_documento."'><u>".$value->nro_documento."</u></a></td>";
            $content .= "<td>".$value->code."</td>";
            $content .= "<td>".$value->nombre."</td>";
            // $content .= "<td><a href='#' class='link-venta' data-venta='".$value->ventaId."'><u>".$value->ventaCode."</u></a></td>";
            $content .= "<td>".$value->categoria."</td>";
            $content .= "<td>".$value->estado."</td>";
            $content .= "<td>".$value->condicion."</td>";
            $content .= "<td>".$value->talla."</td>";
            $content .= "<td>".$value->color."</td>";
            $content .= "<td>".$value->diseno."</td>";
            $content .= "</tr>";
        }
        echo $content;
    }

    public function reporteTopClientes(){
        $fechaDesde = new DateTime();
        $diaSemana = $fechaDesde->format('w');
        // if($diaSemana==0) $diaSemana=7;         
        // --$diaSemana;
        $interval = new DateInterval("P1Y"); $interval->invert = 1;
        $fechaDesde->add($interval);

        $fechaHasta = new DateTime();
        $usuario = $this->session->userdata('user');
        $tiendas = $this->tienda_model->getList();
        $tiendaUsuario = $usuario['tienda_sel'];
        $data = [
            'js' => ['rpt-top-clientes.js'],
            'page' => '/reporte/reporte-top-clientes',
            'fechaDesde' => $fechaDesde,            
            'fechaHasta' => $fechaHasta,
            'listaTiendas' => $tiendas,
            'tiendaUsuario' => $tiendaUsuario
        ];

        $this->load->view('init', $data);
    }

    public function reporteTopClientes_Content() {
        $cantidadMostrar = $this->input->post('cantidadMostrar');
        $fechaDesde = $this->input->post('fechaDesde');
        $fechaHasta = $this->input->post('fechaHasta'); 
        $dia = substr($fechaDesde, 0, 2); $mes = substr($fechaDesde, 3, 2); $ano = substr($fechaDesde, 6, 4);
        $fechaDesde = new DateTime("$ano-$mes-$dia");
        $dia = substr($fechaHasta, 0, 2); $mes = substr($fechaHasta, 3, 2); $ano = substr($fechaHasta, 6, 4);
        $fechaHasta = new DateTime("$ano-$mes-$dia");
        $reporte = $this->reporte_model->ReporteTopClientes($cantidadMostrar, $fechaDesde, $fechaHasta);
                
        $content = "";
        $i = 1;
        foreach ($reporte as $key => $value) {           
            $content .= "<tr tabindex='0'>";
            $content .= "<td>".($i++)."</td>";
            $content .= "<td><a href='#' class='link-cliente' data-cliente='".$value->clienteId."' data-cliente-nro='".$value->nroDocumento."'><u>".$value->nroDocumento."</u></a></td>";
            // $content .= "<td>".$value->nroDocumento."</td>";
            $content .= "<td>".$value->nombresApellidos."</td>";
            // $content .= "<td><a href='#' class='link-venta' data-venta='".$value->ventaId."'><u>".$value->ventaCode."</u></a></td>";
            $content .= "<td>".$value->fechaUltimaCompra."</td>";
            $content .= "<td>".$value->cantidad."</td>";
            $content .= "<td>".$value->total."</td>";    
            $content .= "</tr>";
        }
        echo $content;
    }

    public function reporteTopProductos() {
        $fechaDesde = new DateTime();
        $diaSemana = $fechaDesde->format('w');
        $interval = new DateInterval("P1Y"); $interval->invert = 1;
        $fechaDesde->add($interval);

        $fechaHasta = new DateTime();
        $usuario = $this->session->userdata('user');
        $tiendas = $this->tienda_model->getList();
        $tiendaUsuario = $usuario['tienda_sel'];
        $categorias = $this->inventario_model->getListCategorias();
        $data = [
            'js' => ['rpt-top-productos.js'],
            'page' => '/reporte/reporte-top-productos',
            'fechaDesde' => $fechaDesde,            
            'fechaHasta' => $fechaHasta,
            'categorias' => $categorias,
            'listaTiendas' => $tiendas,
            'tiendaUsuario' => $tiendaUsuario
        ];

        $this->load->view('init', $data);
    }

    public function reporteTopProductos_Content(){
        $cantidadMostrar = $this->input->post('cantidadMostrar');
        $fechaDesde = $this->input->post('fechaDesde');
        $fechaHasta = $this->input->post('fechaHasta'); 
        $dia = substr($fechaDesde, 0, 2); $mes = substr($fechaDesde, 3, 2); $ano = substr($fechaDesde, 6, 4);
        $fechaDesde = new DateTime("$ano-$mes-$dia");
        $dia = substr($fechaHasta, 0, 2); $mes = substr($fechaHasta, 3, 2); $ano = substr($fechaHasta, 6, 4);
        $fechaHasta = new DateTime("$ano-$mes-$dia");
        $categoriaId = $this->input->post('categoria');
        $tallas = $this->input->post('talla');  
        if ($tallas == null) {
            $tallas = 0;
        } else {               
            $tallas = str_replace("\"", "",implode(",", $tallas));   
        }        
        $colores = $this->input->post('color');   
        if ($colores == null) {
            $colores = 0;
        } else {
            $colores = str_replace("\"", "",implode(",", $colores));
        }
        $disenos = $this->input->post('diseno');        
        if ($disenos == null) {
            $disenos = 0;
        } else {
            $disenos = str_replace("\"", "",implode(",", $disenos));
        }        

        $reporte = $this->reporte_model->ReporteTopProductos($cantidadMostrar, $fechaDesde, $fechaHasta, $categoriaId, $tallas, $colores, $disenos);
        
        $content = "";
        $i = 1;
        foreach ($reporte as $key => $value) {           
            $content .= "<tr tabindex='0'>";
            $content .= "<td>".$value->item."</td>";            
            // $content .= "<td>".$value->code."</td>";
            $content .= "<td><a href='#' class='link-producto' data-producto='".$value->articuloId."'><u>".$value->code."</u></a></td>";
            $content .= "<td>".$value->nombreArticulo."</td>";
            $content .= "<td>".$value->caracteristicas."</td>";
            $content .= "<td>".$value->categoria."</td>";
            $content .= "<td>".$value->estado."</td>";
            // $content .= "<td><a href='#' class='link-cliente' data-cliente='".$value->clienteId."' data-cliente-nro='".$value->nroDocumento."'><u>".$value->nroDocumento."</u></a></td>";
            // // $content .= "<td>".$value->nroDocumento."</td>";
            // $content .= "<td>".$value->nombresApellidos."</td>";
            // // $content .= "<td><a href='#' class='link-venta' data-venta='".$value->ventaId."'><u>".$value->ventaCode."</u></a></td>";
            // $content .= "<td>".$value->fechaUltimaCompra."</td>";
            $content .= "<td>".$value->cantidad."</td>";
            $content .= "<td>".$value->total."</td>";    
            $content .= "</tr>";
        }
        echo $content;
    }

        
        
}


?>