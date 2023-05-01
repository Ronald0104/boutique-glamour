<?php
defined('BASEPATH')OR exit('No direct script access allowed'); 

class Admin_model extends CI_Model {
	//
    function logged_id() {
        return $this->session->userdata('user'); 
    }

	//
    function check_login($username, $password) {
        // $this->db->from($table);
        $this->db->select('*'); 
        $this->db->where('usuario', $username); 
        $this->db->where('clave', $password); 
        $query = $this->db->get('tbl_usuario'); 

        if ($query->num_rows() == 0) {
            return FALSE; 
        }else {
            // return TRUE;
            return $query-> result(); 
        }
    }

    function obtener_tiendas($usuarioId) {
        // $query = $this->db->get_where('tbl_tienda_usuario', array('usuarioId' => $usuarioId));
        $sql = "SELECT a.usuarioId, a.tiendaId, b.nombre AS 'tienda', b.direccion
        FROM tbl_tienda_usuario a
        INNER JOIN tbl_tienda b ON b.id = a.tiendaId
        WHERE a.usuarioId = ? ";

        $usuarioId = $this->db->escape_str($usuarioId);
        $params = [$usuarioId];
        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function save_sesion($userid, $ip, $fecha) {
        $data = [
            'usuario_id' => $userid, 
            'ip_address' => $ip, 
            'token' => $fecha, 
            'created_at' => $fecha
        ]; 
        $result = $this->db->insert('tbl_sesion', $data); 
        return $result; 
    }

    public function loadFotoTemp($controller)
    {    
        $upl = array_shift($_FILES); 
        $msj = read_file('log_error.txt');
        $msj .= serialize(json_encode($upl)) ."\n";  
        write_file('log_error.txt', $msj);   

        $token = $this->admin_model->generarTokenSeguro(50);

        // Validar que el token no se encuentre en la tabla tbl_temp_imagen

        $folder="assets/img/".$controller."/temp/".$token."/"; 
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        move_uploaded_file($upl["tmp_name"], "$folder".$upl["name"]);
        $fecha = mdate('%Y-%m-%d %H:%i:%s');
        $this->setImagenTemp($token, $upl["name"], $fecha);

        die(json_encode( array('file_name' => $upl['name'], 'file' => $upl, 'token' => $token)));
    }

    public function setImagenTemp($token, $imagenPath, $fecha) {
        try {
            $data = [
                'token' => $token, 
                'imagen_path' => $imagenPath,
                'created_at' => $fecha
            ]; 
            $this->db->insert('tbl_tmp_imagen', $data); 
            return TRUE; 
        }
        catch(Exception $e) {
            return FALSE; 
        }
    }

    // PHP 5
    function generarTokenSeguro_php5($longitud)
    {
        if ($longitud < 4) {
            $longitud = 4;
        }
        return bin2hex(openssl_random_pseudo_bytes(($longitud - ($longitud % 2)) / 2));
    }

    // PHP 7
    function generarTokenSeguro($longitud) {
        if ($longitud < 4) {
            $longitud = 4; 
        }
        return bin2hex(random_bytes(($longitud - ($longitud % 2))/2)); 
    }

    function eliminarDirectorio($carpeta) {
        foreach (glob($carpeta . "/*") as $archivos_carpeta){             
            if (is_dir($archivos_carpeta)){
                eliminarDirectorio($archivos_carpeta);
            }
            else {
                unlink($archivos_carpeta);
            }
        }
        rmdir($carpeta);
     }

    
     function listarOpciones($n = 10) {        
        $sql = "SELECT a.nombre, a.imagenPath, a.urlPath
        FROM tbl_opciones_main a
        ORDER BY a.orden
        LIMIT 0, 10";

        $n = $this->db->escape_str($n);
        $params = [$n];
        $query = $this->db->query($sql, $params);
        return $query->result();
    }
    
     // function eliminar_directorio($dir){
    //     $result = false;
    //     if ($handle = opendir("$dir")){
    //     $result = true;
    //     while ((($file=readdir($handle))!==false) && ($result)){
    //     if ($file!='.' && $file!='..'){
    //     if (is_dir("$dir/$file")) {
    //     $result = eliminar_directorio("$dir/$file"); 
    //     }else {
    //     $result = unlink("$dir/$file"); }}}
    //     closedir($handle); 
    //     if ($result) {
    //     $result = rmdir($dir); 
    //     }}
    //     return $result; 
    // }
    
}