<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('admin_model');
		$this->load->helper('date');


    }

	public function index()
	{
		redirect(base_url('').'admin/login');
	}

	// No se utiliza
	public function login2() // _validation
	{
		if ($this->admin_model->logged_id()) {
			redirect('/admin/panel');
		}
		else {
			$this->form_validation->set_rules('username', 'Usuario', 'required');
			$this->form_validation->set_rules('password', 'Clave', 'required');	
			$this->form_validation->set_message('required', 'Campo requerido');
	
			if ($this->form_validation->run() == TRUE) {	
				$username = $this->input->post('username');
				$password = sha1($this->input->post('password')); // Desencriptamos la contraseña
				
				$resp= $this->admin_model->check_login($username, $password);
	
				if (!$resp == FALSE) {
					// Generación del Token de seguridad					
					foreach ($resp as $user) {
						$session_data['user'] = array(
							'usuario_id' => $user->usuario_id,
							'usuario' => $user->usuario,
							'nombre' => $user->nombre,
							'apellido_paterno' => $user->apellido_paterno,
							'apellido_materno' => $user->apellido_materno,
							'rol_id' => $user->rol_id
						);
						
						// Guardar la sesion en Base de datos
						$ip = $this->getUserIpAddress();
						$time = time();
						$this->admin_model->save_sesion($user->usuario_id, $ip, mdate('%Y-%m-%d %H:%i:%s', $time));

						// Guardamos la sesion en el servidor
						$this->session->set_userdata($session_data);
					}
					
					// Pantalla Principal
					redirect('/admin/main');
				}else {		
					// $this->session->set_flashdata('error', 'Usuario o Clave incorrectos');
					// redirect(base_url() . 'index.php/admin/login');
					$data['error'] = "Usuario o clave incorrecto.";
					$this->load->view('login', $data);
				}
				
			}else {
				$this->load->view('login');
			}
		}		
	}

	public function login() {
		if ($this->admin_model->logged_id()) {
			redirect('/admin/panel');
		}
		else {
			// Cargar datos de la compania
			$this->load->view('login');
		}
	}

	public function login_ajax() {
		$username = $this->input->post('username');
		$password = sha1($this->input->post('password')); // Desencriptamos la contraseña
							
		$users = $this->admin_model->check_login($username, $password);	
		if ($users) {				
			// Generación del Token de seguridad					
			foreach ($users as $user) {
				$session_data['user'] = array(
					'usuario_id' => $user->usuario_id,
					'usuario' => $user->usuario,
					'nombre' => $user->nombre,
					'apellido_paterno' => $user->apellido_paterno,
					'apellido_materno' => $user->apellido_materno,
					'rol_id' => $user->rol_id
				);

				// Cargar las tiendas del usuario	
				$tiendas = $this->admin_model->obtener_tiendas($user->usuario_id);	
				if(!empty($tiendas)) {
					$session_data['user']['tiendas'] = $tiendas;
					$session_data['user']['tienda_sel'] = $tiendas[0]->tiendaId;
				}else {
					$session_data['user']['tiendas'] = [];
					$session_data['user']['tienda_sel'] = 0;
				}
			
				// Guardar la sesion en Base de datos
				$ip = $this->getUserIpAddress();
				$time = time();
				$this->admin_model->save_sesion($user->usuario_id, $ip, mdate('%Y-%m-%d %H:%i:%s', $time)); // Rev				

				// Guardamos la sesion en el servidor
				$this->session->set_userdata($session_data);
			}
			
			// Si el usuario no tiene asignada ninguna tienda advertirle que no podra registrar ninguna operación

			$data['error'] = "";
			$data['user'] = $session_data;
			echo json_encode($data);
		}
		else {
			$data['error'] = "Usuario o Clave incorrecto";
			echo json_encode($data);
		} 			
	}

	public function logout()
	{
		$this->session->unset_userdata('user');
		redirect(base_url().'admin/login');	
	}

	public function panel()
	{
		if ($this->admin_model->logged_id()) {
			$user =  $this->session->userdata('user');
			$datos = [ 'page' => 'main', 'user' => $user ];
			$this->load->view('init', $datos);
		} else {
			redirect(base_url().'admin/login');
		}
	}

	public function empresa() {
		if ($this->admin_model->logged_id()) {
			$company = ""; // Obtener los datos de la empresa
			$datos = [
				'page' => 'admin/company'
			];
			$this->load->view('init', $datos);		
		} else {
			redirect(base_url().'admin/login');
		}
	}

	public function obtenerUsuario() {
		$user = $this->session->userdata('user');
		echo json_encode($user);
	}

	public function cambiarTienda()
	{
		$tiendaId = $this->input->post('tiendaId');
		$session_data['user'] = $this->session->userdata('user');
		$session_data['user']['tienda_sel'] = $tiendaId;
		$this->session->set_userdata($session_data);
		return 1;
	}

	
	
	function getUserIpAddress() {

		foreach ( [ 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ] as $key ) {
	
			// Comprobamos si existe la clave solicitada en el array de la variable $_SERVER 
			if ( array_key_exists( $key, $_SERVER ) ) {
	
				// Eliminamos los espacios blancos del inicio y final para cada clave que existe en la variable $_SERVER 
				foreach ( array_map( 'trim', explode( ',', $_SERVER[ $key ] ) ) as $ip ) {
	
					// Filtramos* la variable y retorna el primero que pase el filtro
					if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) {
						return $ip;
					}
				}
			}
		}
	
		return '?'; // Retornamos '?' si no hay ninguna IP o no pase el filtro
	} 

	public function loadFotoTemp()
	{
		$upl = array_shift($_FILES); 
		try {
			// $msj = read_file('log_error.txt');
			// $msj .= serialize(json_encode($upl)) ."\n";  
			// write_file('log_error.txt', $msj);   			
		}
		catch(Exception $e){
			die(json_encode(['file_name'=> $e->getMessage()]));			
		}

        $token = $this->admin_model->generarTokenSeguro(50);
		$folderPath = $this->input->post('folderPath');
        // Validar que el token no se encuentre en la tabla tbl_temp_imagen

        $folder="assets/img/temp/".$token."/"; 
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        move_uploaded_file($upl["tmp_name"], "$folder".$upl["name"]);
        $fecha = mdate('%Y-%m-%d %H:%i:%s');
        $this->admin_model->setImagenTemp($token, $upl["name"], $fecha);

        die(json_encode( array('file_name' => $upl['name'], 'file' => $upl, 'token' => $token)));
	}

    // public function index()
    // {
    //     if($this->admin->logged_id())
	// 	{
	// 		redirect("/welcome");
    //     }
    //     else{
	// 		// echo "entro aqui";
	// 		//set form validation
	//         $this->form_validation->set_rules('username', 'Username', 'required');
	//         $this->form_validation->set_rules('password', 'Password', 'required');

	//         //set message form validation
	//         $this->form_validation->set_message('required', '<div class="alert alert-danger" style="margin-top: 3px">
	//                 <div class="header"><b><i class="fa fa-exclamation-circle"></i> {field}</b></div></div>');

	//         //cek validasi
	// 		if ($this->form_validation->run() == TRUE) {

	// 			//get data dari FORM
	//             $username = $this->input->post("username", TRUE);
	//             $password = MD5($this->input->post('password', TRUE));
	            
	//             //checking data via model
	//             $checking = $this->admin->check_login('tbl_users', array('username' => $username), array('password' => $password));
	            
	//             //jika ditemukan, maka create session
	//             if ($checking != FALSE) {
	//                 foreach ($checking as $apps) {

	//                     $session_data = array(
	//                         'user_id'   => $apps->id_user,
	//                         'user_name' => $apps->username,
	//                         'user_pass' => $apps->password,
	//                         'user_nama' => $apps->nama_user
	//                     );
	//                     //set session userdata
	//                     $this->session->set_userdata($session_data);

	//                     redirect('welcome/');

	//                 }
	//             }else{
    //                 $data['error'] = '<div class="col-sm-6 col-sm-offset-3 form-box">
    //                     <div class="alert alert-danger">
	//                 	<div class="header"><b><i class="fa fa-exclamation-circle"></i> ERROR</b> Usuario o clave incorrectos!</div></div></div>';
    //                 $this->load->view('login', $data);
	//             }

	//         }else{
    //             $data['error']='<div class="alert alert-danger">test</div>';
	//             $this->load->view('login', $data);
	//         }

	// 	}
    // }
}

?>