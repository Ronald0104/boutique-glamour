<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    public $usuario_id;
    public $nombre;
    public $apellido_paterno;
    public $apellido_materno;
    public $usuario;
    public $clave;
    public $rol_id;
    public $estado;
    public $email;
    public $created_at;
    public $updated_at;

    
    function listar() {
        $query = $this->db->query("SELECT a.usuario_id, a.nombre, a.apellido_paterno, a.apellido_materno, a.usuario, a.email, a.celular, a.direccion, a.rol_id, b.nombre AS 'rol', a.estado
        FROM tbl_usuario a
        LEFT JOIN tbl_rol b ON b.id = a.rol_id; ");

        return $query->result();
    }

    function getList()
    {
        $query = $this->db->query(" SELECT a.usuario_id, a.nombre, a.apellido_paterno, a.apellido_materno, a.usuario, a.email, a.celular, a.direccion, a.rol_id, b.nombre AS 'rol', a.estado
        FROM tbl_usuario a
        LEFT JOIN tbl_rol b ON b.id = a.rol_id; ");

        return $query->result();
    }

    // function getListByRol($rol) {
    //     $this->db->select();
    //     $this->db->where()
    // }

    function getListById($usuarioId)
    {
        try {
            if(empty($usuarioId) || !is_numeric($usuarioId))
                throw new Exception("Ingreso el id del usuario");

            $query = $this->db->query(" SELECT a.usuario_id, a.nombre, a.apellido_paterno, a.apellido_materno, a.usuario, a.email, a.celular, a.telefono, a.direccion, a.rol_id, b.nombre AS 'rol', a.estado
            FROM tbl_usuario a
            LEFT JOIN tbl_rol b ON b.id = a.rol_id
            WHERE a.usuario_id = $usuarioId");
    
            return $query->result();
        }
        catch(Exception $e){
            return ['code' => 0, 'message' => $e->getMessage()];
        }
    }

    public function insert($usuario)
    {
        try {
            // return json_encode($usuario);
            $usuarioId = $this->db->insert('tbl_usuario', $usuario);
            // $error = $this->db->_error_message();
            // if(isset($error)){
            //     return "Error al registrar";
            // }
            $usuarioId = $this->db->insert_id();
            return $usuarioId;
        }
        catch(Exception $e) {
            
            $log = read_file('log_error.txt');
            $log .= "error al registrar usuario \n";
            write_file('log_error.txt', $log);
            
            return "ERROR MODEL";
            // $result = $e->getMessage();
        }
        // return "model"; //$result;
    }

    public function update($usuarioId, $usuario)
    {
        try {
            $this->db->where('usuario_id', $usuarioId);
            $this->db->update('tbl_usuario', $usuario);
            return TRUE;
        }
        catch(Exception $e) {            
            $log = read_file('log_error.txt');
            $log .= "error al actualizar usuario \n";
            write_file('log_error.txt', $log);            
            return ['code' => 0, 'message' => $e->getMessage()];
        }
    }
    
    function check_login($username, $password)
    {
        // $this->db->from($table);
        $this->db->select('*');
        $this->db->where('usuario', $username);
        $this->db->where('clave', $password);
        $query = $this->db->get('tbl_usuario');

        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            // return TRUE;
            return $query->result();
        }
    }

    public function getListRoles()
    {
        $query = $this->db->get('tbl_rol');
        return $query->result();
    }   

    public function validarUsuario($usuario)
    {
        $this->db->select('*');
        $this->db->from('tbl_usuario');
        $this->db->where('usuario', $usuario);
        $query = $this->db->get();
        return $query->result();
    }
}