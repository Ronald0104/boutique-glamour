<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('compra_model');
        $this->load->model('tienda_model');
        $this->load->helper('date');
    }

    public function _remap($method)
    {
        if ($this->admin_model->logged_id()) {
            $this->$method();
        }
        else {
            redirect('');
        }
    }

    public function index() {
        $usuario = $this->admin_model->logged_id();
        
        if (in_array($usuario['rol_id'], ["1","2"])){
            redirect('compras/listar');
        } else {
            $page = "layouts/message";
            $mensaje = "NO TIENE AUTORIZACIÓN PARA ACCEDER A ESTE SITIO";
            $this->load->view('init', ['page'=>$page, 'mensaje'=>$mensaje]);            
        } 
    }

    function listar() {
        $fechaDesde = new DateTime();
        $diaSemana = $fechaDesde->format('w');
        $restar = 0;
        if($diaSemana==0){
            $diaSemana=7;
            $restar = 7;
        }
        // else if($diaSemana==1){
        //     $diaSemana=;
        // }
         
        --$diaSemana; 
        $diaSemana = 7;       
        $interval = new DateInterval("P".$diaSemana."D"); $interval->invert = 1;

        $fechaDesde = $fechaDesde->add($interval);

        $fechaHasta = new DateTime();
        $tiendas = $this->tienda_model->getList();
        $tipoGasto = $this->compra_model->listarTipoGasto();
        $usuario = $this->session->userdata('user');
        $tiendaId = $usuario['tienda_sel'];
        $data = [
            'page' => 'compras/list-purchases',
            'js' => ['purchase.js?v1.0'],
            'tiendas' => $tiendas,
            'tipoGasto' => $tipoGasto,
            'fechaDesde' => $fechaDesde->format('d/m/Y'),
            'fechaHasta' => $fechaHasta->format('d/m/Y'),
            'usuario' => $usuario,
            'tiendaId' => $tiendaId
        ];
        $this->load->view('init', $data);
    }

    public function modalRegistrar()
    {
        $tipoGasto = $this->compra_model->listarTipoGasto();
        $tipoComprobante = $this->compra_model->listarTipoComprobante();
        $tiendas = $this->tienda_model->getListEnabled();
        $data = [
            'tipoGasto' => $tipoGasto,
            'tipoComprobante' => $tipoComprobante,
            'tiendas' => $tiendas
        ];
        echo $this->load->view('compras/add-purchase-modal', $data, true);
    }
    
    public function obtenerCorrelativoCompra() {
        $correlativo = $this->compra_model->obtenerCorrelativoCompra()[0];        
        echo $correlativo->correlativo;        
    }

    public function listarTipoComprobante() {
        $tipoComprobante = $this->compra_model->listarTipoComprobante();
        echo $tipoComprobante;
    }

    public function listarCompras() {
        $tipoGasto = $this->input->post('tipoGasto');

        $fechaDesde = $this->input->post('fechaDesde');
        $dia = substr($fechaDesde, 0, 2); $mes = substr($fechaDesde, 3, 2); $ano = substr($fechaDesde, 6, 4);
        $fechaDesde = new DateTime("$ano-$mes-$dia");

        $fechaHasta = $this->input->post('fechaHasta');
        $dia = substr($fechaHasta, 0, 2); $mes = substr($fechaHasta, 3, 2); $ano = substr($fechaHasta, 6, 4);
        $fechaHasta = new DateTime("$ano-$mes-$dia");

        $tienda = $this->input->post('tienda');

        $compras = $this->compra_model->listarCompras($tipoGasto, $fechaDesde->format('Ymd'), $fechaHasta->format('Ymd'), $tienda);
        $data['data'] = $compras;
        echo json_encode($data);
    }

    public function obtenerCompraById() {
        $compraId = $this->input->post('compraId');
        $compra = $this->compra_model->obtenerCompraById($compraId);
        echo json_encode($compra);
    }

    public function registrarCompra() {
        try{
            $compra = $this->input->post('compra');
            $fecha = mdate('%Y-%m-%d %H:%i:%s');
            $usuario = (int)$this->session->userdata('user')['usuario_id']; 
            
            // Obtener el codigo de compra
            $codigo = $this->compra_model->obtenerCorrelativoCompra()[0]->correlativo;

            $objCompra = [
                'code' => $codigo,
                'proveedorId' => 1,
                'proveedor' => $compra['proveedor'],
                'tipo_documento' => $compra['tipoComprobante'],
                'numero_documento' => $compra['numeroComprobante'],
                'fecha_documento' => $compra['fechaCompra'],
                'fecha_vencimiento' => $compra['fechaCompra'],
                'descripcion' => $compra['descripcionCompra'],
                'monedaId' => 1,
                'subtotal' => 0,
                'impuesto' => 0,
                'total' => $compra['importeTotal'],
                'estadoId' => 2,
                'loteId' => 1,
                'condicionPagoId' => 0,
                'tipoGastoId' => $compra['tipoGasto'],
                'anulado' => 0,
                'usuarioId_created' => $usuario,  
                'usuarioId_updated' => $usuario,  
                'created_at' => $fecha,
                'updated_at' => $fecha    
            ];

            $distribucionTienda = $compra['distribucionTienda'];
            
            $result = $this->compra_model->registrarCompra($objCompra, $distribucionTienda);
            // Distribucion de compra en tiendas            
            // echo json_encode($objCompra);

            echo $result;
        }
        catch(\Exception $e){
            echo 0;
        }
    }

    public function actualizarCompra() {
        try {
            $compra = $this->input->post('compra');
            $fecha = mdate('%Y-%m-%d %H:%i:%s');
            $usuario = (int)$this->session->userdata('user')['usuario_id']; 

            $objCompra = [
                'compraId' => $compra['id'],                              
                'proveedor' => $compra['proveedor'],
                'tipo_documento' => $compra['tipoComprobante'],
                'numero_documento' => $compra['numeroComprobante'],
                'fecha_documento' => $compra['fechaCompra'],
                'descripcion' => $compra['descripcionCompra'],
                'total' => $compra['importeTotal'],  
                'tipoGastoId' => $compra['tipoGasto'],
                'usuarioId_updated' => $usuario,  
                'updated_at' => $fecha    
            ];
            $distribucionTienda = $compra['distribucionTienda'];
            $result = $this->compra_model->actualizarCompra($objCompra, $distribucionTienda);
            echo $result;
        } catch (\Exception $e) {
            echo 0;
        }
    }

    public function anularCompra() {
        try {
            $compraId = $this->input->post('compraId');
            $result = $this->compra_model->anularCompra($compraId);
            echo $result;
        } catch(\Exception $e) {
            echo false;
        }
    }

    public function consultarDetalleCompras() {
        $fechaDesde = $this->input->post('fechaDesde');
        $fechaHasta = $this->input->post('fechaHasta');
        $tiendaId = $this->input->post('tiendaId');

        $dia = substr($fechaDesde, 0, 2); $mes = substr($fechaDesde, 3, 2); $ano = substr($fechaDesde, 6, 4);
        $fechaDesde = new DateTime("$ano-$mes-$dia");
        $dia = substr($fechaHasta, 0, 2); $mes = substr($fechaHasta, 3, 2); $ano = substr($fechaHasta, 6, 4);
        $fechaHasta = new DateTime("$ano-$mes-$dia");
        $rs = $this->compra_model->obtenerDetalleCompras($fechaDesde->format('Ymd'), $fechaHasta->format('Ymd'), $tiendaId);
        echo json_encode($rs);
    }
}

?>