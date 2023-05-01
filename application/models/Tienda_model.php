<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tienda_model extends CI_Model 
{
    private $id;
    private $nombre;
    private $direccion;
    private $foto;

    public function getList()
    {
        $query = $this->db->get('tbl_tienda');
        return $query->result();
    }

    public function getListEnabled()
    {
        $query = $this->db->get_where('tbl_tienda', array('estado'=>1));
        return $query->result();
    }

    public function getListById($tiendaId)
    {
        $query = $this->db->get_where('tbl_tienda', array('id'=> $tiendaId));
        return $query->result();
    }

    public function insert($tienda)
    {
        try {
            $result = $this->db->insert('tbl_tienda', $tienda);
            return $this->db->insert_id();;
        }
        catch(Exception $e) {            
            $log = read_file('log_error.txt');
            $log .= "error al registrar tienda \n";
            write_file('log_error.txt', $log);            
            return FALSE;
        }
    }

    public function update($tienda, $tiendaId) {
        try {
            $this->db->where('id', $tiendaId);
            $this->db->update('tbl_tienda', $tienda);
            return TRUE;
        }
        catch(Exception $e) {            
            $log = read_file('log_error.txt');
            $log .= "error al actualizar tienda \n";
            write_file('log_error.txt', $log);            
            return FALSE;
        }
    }

    public function add_user($tiendaId, $usuarioId, $fecha)
    {
        $tienda_usuario = [
            'tiendaId' => $tiendaId,
            'usuarioId' => $usuarioId,
            'estado' => 1,
            'fecha' => $fecha
        ];
        $result = $this->db->insert('tbl_tienda_usuario', $tienda_usuario);
    }

    public function delete_user($usuarioId){
        $this->db->where('usuarioId', $usuarioId);
        $this->db->delete('tbl_tienda_usuario');
    }

    public function list_user($usuarioId)
    {
        $this->db->select('tbl_tienda_usuario.tiendaId, tbl_tienda.nombre');
        $this->db->from('tbl_tienda_usuario');
        $this->db->join('tbl_tienda', 'tbl_tienda_usuario.tiendaId = tbl_tienda.id');
        $this->db->where('tbl_tienda_usuario.usuarioId', $usuarioId);
        $query = $this->db->get();
        return $query->result();
    }
}
?>