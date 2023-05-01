<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('admin_model');
        $this->load->model('user_model');
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

    public function index()
    {
        redirect(base_url().'user/list');
    }

    public function listar()
    {
        $usuario = $this->admin_model->logged_id();
        
        if (in_array($usuario['rol_id'], ["1"])){
            $usuarios = $this->user_model->listar();
            $tiendas = $this->tienda_model->getList();
            $roles = $this->list_roles();
            $datos = [
                'page' => 'users/list-users',
                'js' => ['multiselect/bootstrap-multiselect.min', 'user'],
                'css' => ['multiselect/bootstrap-multiselect.min'],
                'usuarios' => $usuarios,
                'tiendas' => $tiendas,
                'roles' => $roles
            ];
            $this->load->view('init', $datos); 
        } else {
            $page = "layouts/message";
            $mensaje = "NO TIENE AUTORIZACIÓN PARA ACCEDER A ESTE SITIO";
            $this->load->view('init', ['page'=>$page, 'mensaje'=>$mensaje]);            
        }            
    }

    public function list_items()
    {
        if ($this->admin_model->logged_id()) {
            $usuarios = $this->user_model->getList(); 
            $datos = ['usuarios' => $usuarios]; 
            echo($this->load->view('users/list-users-items', $datos, true));
        }
    }

    public function show()
    {
        if ($this->admin_model->logged_id()) {
            $usuarioId = $this->input->get('usuario_id');
            $tiendas_usuario = $this->tienda_model->list_user($usuarioId);
            $usuario = $this->user_model->getListById($usuarioId);   
            $usuario[0]->tiendas = $tiendas_usuario;
            echo json_encode($usuario);
        }
    }
    public function add()
    {
        // $name = $this->input->post('nombres');
        if ($this->admin_model->logged_id()) {
            if($this->input->post('nombres')){
                // Validar los campos obligatorios
                $log = read_file('log_error.txt');
                $log .= "registrando usuario \n";
                write_file('log_error.txt', $log);

                $error = ['code' => 1, 'message' => ''];
                // Esto debe estar en el modelo
                try{
                    // Validar que el usuario no se encuentre registrado 
                    $result = $this->user_model->validarUsuario($this->input->post('usuario'));                   
                    if ($result)                 
                        throw new Exception('El usuario ingresado ya existe');
                    
                    $fecha = mdate('%Y-%m-%d %H:%i:%s');
                    $usuario = [
                        'nombre' => $this->input->post('nombres'),
                        'apellido_paterno' => $this->input->post('apellidoPaterno'),
                        'apellido_materno' => $this->input->post('apellidoMaterno'),
                        'direccion' => $this->input->post('direccion'),
                        'celular' => $this->input->post('celular'),
                        'telefono' => $this->input->post('telefono'),
                        'email' => $this->input->post('email'),
                        'usuario' => $this->input->post('usuario'),
                        'clave' => sha1($this->input->post('clave')),
                        'estado' => $this->input->post('estado'),
                        'rol_id' => $this->input->post('rol'),
                        'created_at' => $fecha,
                        'updated_at' => $fecha
                    ];
                    // echo json_encode($usuario); exit();
                    $usuarioId = 0;
                    $usuarioId = $this->user_model->insert($usuario);
                    
                    if($usuarioId){
                        // Asignar tienda
                        $tiendas = $this->input->post('tiendas');
                        // $usuarioId = $this->admin_model->logged_id();
                        // $usuarioId = $usuarioId['usuario_id'];
                        $this->tienda_model->delete_user($usuarioId);
                        if(!empty($tiendas)){        
                            if (is_array($tiendas)){
                                foreach ($tiendas as $tiendaId) {
                                    $this->tienda_model->add_user($tiendaId, $usuarioId, $fecha);
                                }
                            }
                            else {
                                $tiendaId = $tiendas;
                                $this->tienda_model->add_user($tiendaId, $usuarioId, $fecha);
                            }
                        }

                        $error['code'] = 1;
                        $error['message'] = 'Usuario registrado correctamente';
                    }
                    echo json_encode($error);
                }
                catch(Exception $e) {
                    $error['code'] = 0;
                    $error['message'] = $e->getMessage();                
                    $msj = 'Error al registrar';
                    write_file('log_error.txt', $msj);
                    echo json_encode($error);                    
                }                
            }else {
                echo "No es una peticion POST."; //$this->input->post('nombres');
            }
        }else {
            redirect(base_url().'admin/login');
        }
    }

    public function edit()
    {
        if ($this->admin_model->logged_id()) {
            if($this->input->post('usuarioId_edit')){
                // Validar los campos obligatorios
                $log = read_file('log_error.txt');
                $log .= "actualizando usuario \n";
                write_file('log_error.txt', $log);

                $error = ['code' => 1, 'message' => ''];
                try{
                    // Validar que el usuario no se encuentre registrado en caso se haya modificado
                    // $result = $this->user_model->validarUsuario($this->input->post('usuario'));                   
                    // if ($result)                 
                        // throw new Exception('El usuario ingresado ya existe');                                    

                    $fecha = mdate('%Y-%m-%d %H:%i:%s');
                    $usuarioId = $this->input->post('usuarioId_edit');
                    $usuario = [
                        'nombre' => $this->input->post('nombres_edit'),
                        'apellido_paterno' => $this->input->post('apellidoPaterno_edit'),
                        'apellido_materno' => $this->input->post('apellidoMaterno_edit'),
                        'direccion' => $this->input->post('direccion_edit'),
                        'celular' => $this->input->post('celular_edit'),
                        'telefono' => $this->input->post('telefono_edit'),
                        'email' => $this->input->post('email_edit'),
                        // 'usuario' => $this->input->post('usuario'),
                        'estado' => $this->input->post('estado_edit'),
                        'rol_id' => $this->input->post('rol_edit'),
                        'updated_at' => $fecha
                    ];

                    // Validar el cambio de clave
                    if($this->input->post('clave_edit')<>"")
                        $usuario['clave'] = sha1($this->input->post('clave_edit'));

                    // echo json_encode($usuario); exit();
                    $result = $this->user_model->update($usuarioId, $usuario);
                    
                    if($result){
                        // Asignar tienda
                        $tiendas = $this->input->post('tiendas_edit');
                        // $usuarioId = $this->admin_model->logged_id();
                        // $usuarioId = $usuarioId['usuario_id'];
                        $this->tienda_model->delete_user($usuarioId);

                        if (!empty($tiendas)) {
                            if (is_array($tiendas)){
                                foreach ($tiendas as $tiendaId) {
                                    $this->tienda_model->add_user($tiendaId, $usuarioId, $fecha);
                                }
                            }
                            else {
                                $tiendaId = $tiendas;
                                $this->tienda_model->add_user($tiendaId, $usuarioId, $fecha);
                            }
                        }                         

                        $error['code'] = 1;
                        $error['message'] = 'Usuario actualizado correctamente';
                    }
                    echo json_encode($error);
                }
                catch(Exception $e) {
                    $error['code'] = 0;
                    $error['message'] = $e->getMessage();                
                    $msj = 'Error al registrar';
                    write_file('log_error.txt', $msj);
                    echo json_encode($error);                    
                }                
            }else {
                echo "No es una peticion POST."; //$this->input->post('nombres');
            }
        }else {
            redirect(base_url().'admin/login');
        }
    }

    public function delete()
    {
        # code...
    }

    public function list_roles()
    {   
        return $this->user_model->getListRoles();
    }
}    