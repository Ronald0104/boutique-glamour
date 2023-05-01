<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tienda extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('admin_model'); 
        $this->load->model('tienda_model');        
        $this->load->helper('date');
        $this->load->helper('file');
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
        redirect('/tienda/listar');
    }

    public function listar()
    {
        $usuario = $this->admin_model->logged_id();        
        if (in_array($usuario['rol_id'], ["1"])){
            $tiendas = $this->tienda_model->getList();
            $datos = [
                'page' => 'shops/list-shops',
                'css' => ['droparea'],
                'js' => ['droparea.min', 'shop'],                
                'tiendas' => $tiendas
            ];
            $this->load->view('init', $datos);
        } else {
            $page = "layouts/message";
            $mensaje = "NO TIENE AUTORIZACIÓN PARA ACCEDER A ESTE SITIO";
            $this->load->view('init', ['page'=>$page, 'mensaje'=>$mensaje]);            
        } 
    }

    public function obtener() {
        $tiendaId = $this->input->post('tiendaId');
        $tienda = $this->tienda_model->getListById($tiendaId);
        echo json_encode($tienda);
    }

    public function getModalTiendas(){
        $tiendas = $this->tienda_model->getListEnabled();  

        // Unicamente se cargaran las tiendas que tiene asignado
        $this->session->userdata('user')['tiendas'];
        
        echo($this->load->view('modals/m-select-tiendas', array('tiendas' => $tiendas), true));
    }

    public function add()
    {
        if ($this->admin_model->logged_id()) {
            if($this->input->post('nombre')){
                try{
                    $fecha = mdate('%Y-%m-%d %H:%i:%s');
                    $tienda = [
                        'nombre' => $this->input->post('nombre'),
                        'sub_nombre' => $this->input->post('sub_nombre'),
                        'direccion' => $this->input->post('direccion'),
                        'referencia' => $this->input->post('referencia'),
                        'foto' => $this->input->post('fotoPath'),
                        'telefono' => $this->input->post('telefono'),  
                        'estado' => $this->input->post('estado'),         
                        'created_at' => $fecha
                        // 'updated_at' => $fecha
                    ];
                    $token = $this->input->post('token');
                    // echo json_encode($usuario); exit();
                    $shop_id = $this->tienda_model->insert($tienda);
                    
                    // Mover la imagen de la tienda en su carpeta correspondiente
                    if(!empty($token)){
                        $folder="assets/img/shops/shop_".$shop_id."/";
                        if (!file_exists($folder)) {
                            mkdir($folder, 0777, true);
                        }
                        $imagenTempPath = "assets/img/shops/temp/".$token."/"; 
                        rename($imagenTempPath.$tienda['foto'], $folder.$tienda['foto']);
                        $this->admin_model->eliminarDirectorio($imagenTempPath);    // Crear un Heper para esta funcion
                    }

                    $result = TRUE;
                    if($result){
                        $error['code'] = 1;
                        $error['message'] = 'Tienda registrada correctamente';
                    }
                    echo json_encode($error);
                }
                catch(Exception $e) {
                    $error['code'] = 0;
                    $error['message'] = $e->getMessage();                
                    // $msj = 'Error al registrar';
                    // write_file('log_error.txt', $msj);
                    echo json_encode($error);                    
                }  
           }
        }
    }

    public function edit() {
        if($this->input->post('nombre_edit')){
            try{
                $fecha = mdate('%Y-%m-%d %H:%i:%s');
                $tiendaId = $this->input->post('tiendaId_edit');
                $tienda = [
                    'nombre' => $this->input->post('nombre_edit'),
                    'sub_nombre' => $this->input->post('sub_nombre_edit'),
                    'direccion' => $this->input->post('direccion_edit'),
                    'referencia' => $this->input->post('referencia_edit'),
                    'foto' => $this->input->post('fotoPath_edit'),
                    'telefono' => $this->input->post('telefono_edit'),  
                    'estado' => $this->input->post('estado_edit'),      
                    'created_at' => $fecha
                ];
                $token = $this->input->post('token_edit');
                // echo json_encode($usuario); exit();
                $shop_id = $this->tienda_model->update($tienda, $tiendaId);
                
                // Mover la imagen de la tienda en su carpeta correspondiente
                if(!empty($token)){
                    $folder="assets/img/shops/shop_".$tiendaId."/";
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                    }
                    $imagenTempPath = "assets/img/shops/temp/".$token."/"; 
                    rename($imagenTempPath.$tienda['foto'], $folder.$tienda['foto']);
                    $this->admin_model->eliminarDirectorio($imagenTempPath);    // Crear un Heper para esta funcion
                }

                $result = TRUE;
                if($result){
                    $error['code'] = 1;
                    $error['message'] = 'Tienda actualizada correctamente';
                }
                echo json_encode($error);
            }
            catch(Exception $e) {
                $error['code'] = 0;
                $error['message'] = $e->getMessage();                
                // $msj = 'Error al registrar';
                // write_file('log_error.txt', $msj);
                echo json_encode($error);                    
            }  
       }
    }

    public function loadFoto()
    {    
        $upl = array_shift($_FILES); 

        // $msj = read_file('log_error.txt');
        // $msj .= serialize(json_encode($upl)) ."\n";  
        // write_file('log_error.txt', $msj);   

        // Generacion del token
        // $p = new OAuthProvider();
        // $token = $p->generateToken(4);
        // echo strlen($t),  PHP_EOL;
        // echo bin2hex($t), PHP_EOL;

        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.', PHP_VERSION);
        
            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
        }
        $version = PHP_VERSION_ID;
        if($version< 700){
            $token = $this->admin_model->generarTokenSeguro_php5(50);
        }else {
            $token = $this->admin_model->generarTokenSeguro(50);
        }

        // Validar que el token no se encuentre en la tabla tbl_temp_imagen

        // $upload_image= $upl["name"];
        $folder="assets/img/shops/temp/".$token."/"; 
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        move_uploaded_file($upl["tmp_name"], "$folder".$upl["name"]);
        $fecha = mdate('%Y-%m-%d %H:%i:%s');
        $this->admin_model->setImagenTemp($token, $upl["name"], $fecha);

        die(json_encode( array('file_name' => $upl['name'], 'file' => $upl, 'token' => $token)));
        // echo "Foto cargada correctamente";
    }

}