<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('admin_model');
        $this->load->model('cliente_model');
        $this->load->helper('date');
        $this->load->helper('file');
        $this->load->helper(array('form', 'url'));
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
        redirect('/cliente/listar');
    }

    public function listar() {    
        $clientes = []; //$this->cliente_model->getList();
        $datos = [
            'page' => 'customers/list-customers',
            'js' => ['multiselect/bootstrap-multiselect.min', 'customer'],
            'css' => ['multiselect/bootstrap-multiselect.min'],
            'clientes' => $clientes
        ];
        $this->load->view('init', $datos); 
    }

    public function listarJson() {
        $clientes = $this->cliente_model->getList();
        $data['data'] = $clientes;        
        echo json_encode($data);
    }

    public function listarItems(){
        $clientes = $this->cliente_model->getList();
        echo($this->load->view('customers/list-customers-items', array('clientes' => $clientes), true));
    }


    public function getModalCliente() {
        echo($this->load->view('modals/m-registrar-cliente', array('title' => 'Modal'), true));
    }

    public function obtenerClienteByNumero(){
        $numero=$this->input->post('numero');        
        $cliente= $this->cliente_model->obtenerClienteByNumero($numero);
        $historial = $this->cliente_model->obtenerClienteHistorial($numero);
        $data = [];
        $data['cliente'] = $cliente;
        $data['historial'] = $historial;
        echo json_encode($data);
    }

    public function registrar() {
        try {
            $fecha = mdate('%Y-%m-%d %H:%i:%s');
            $usuario = (int)$this->session->userdata('user')['usuario_id'];

            $cliente = [
                'clienteId' => $this->input->post('customerId_Add'),
                'tipo_persona' => 1,
                'tipo_documento' => $this->input->post('tipoDocumento_Add'),
                'nro_documento' => $this->input->post('nroDocumento_Add'),
                'nombres' => $this->input->post('nombres_Add'),
                'apellido_paterno' => $this->input->post('apellidos_Add'),            
                'apellido_materno' => '',            
                'direccion' => $this->input->post('direccion_Add'),
                'email' => $this->input->post('email_Add'),
                'telefono' => $this->input->post('telefono_Add'),
                'celular' => $this->input->post('celular_Add'),
                'observaciones' => $this->input->post('observaciones_Add'),
                'usuarioId_created' => $usuario,  
                'usuarioId_updated' => $usuario,  
                'created_at' => $fecha,
                'updated_at' => $fecha
            ]; 

            if($cliente['clienteId']==0) {
                header('Content-Type-Action: insert');
                $clienteId=$this->cliente_model->registrarCliente($cliente);
            }
            else {
                header('Content-Type-Action: update');
                // $this->output->set_header('X-PJAX-URL: http://mySite.com/library', false);
                $clienteId = $cliente['clienteId'];
                $this->cliente_model->modificarCliente($cliente);                
            }

            $pathFoto='assets/img/customers/'.$clienteId.'/';
            if (!file_exists($pathFoto)) {
                mkdir($pathFoto, 0777, true);
            }

            $config['upload_path'] = 'assets/img/customers/'.$clienteId.'/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 100;
            $config['max_width'] = 1024;
            $config['max_height'] = 768;

            $this->load->library('upload', $config);   
            $pathFoto = "";         
            if($this->upload->do_upload('fotoCliente_Add')){
                // $data = $this->upload->data('fotoCliente_Add'); 
                $data = $this->upload->data();
                $path = $data['file_name'];                
                $this->cliente_model->modificarFoto($clienteId, $path);
                // echo json_encode($data);
            }
            else {
                // echo $this->upload->display_errors();
                // die('Ocurrio un error al subir la foto' . $this->upload->display_errors());
            }

            echo $clienteId;
        } catch (\Exception $e) {
            echo 0;
        }        
    }
}