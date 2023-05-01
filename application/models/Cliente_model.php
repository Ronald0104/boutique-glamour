<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model
{
    public function getList()
    {
        $query = $this->db->get('tbl_cliente');
        return $query->result();
    }

    public function getById($clienteId)
    {
        
    }

    public function getByNumero($numero)
    {
       
    }
    public function obtenerClienteByNumero($numero) {
        try{
            $query = $this->db->get_where('tbl_cliente', ['nro_documento' => $numero], 1);
            return $query->result();
        } catch(\Exception $e){
            return FALSE;
        }
    }
    public function obtenerClienteHistorial($numero) {
        try {
            $numero = $this->db->escape_str($numero);
            $sql = "SELECT a.clienteId, a.ventaId, LPAD(ventaId, 6, '0') AS 'codigo', a.tiendaId, b.nombre AS 'tienda', c.nombre AS 'operacion', 
            DATE_FORMAT(a.fechaRegistro, '%d/%m/%Y') AS 'fecha', a.estadoId, e.nombre AS 'estado', a.precioTotal AS 'totalVenta', a.totalSaldo
            FROM tbl_venta a
            LEFT JOIN tbl_tienda b ON b.id = a.tiendaId
            LEFT JOIN tbl_venta_tipo_operacion c ON c.id = a.tipoOperacionId
            LEFT JOIN tbl_venta_estado e ON e.id = a.estadoId
            LEFT JOIN tbl_cliente f ON f.clienteId = a.clienteId
            WHERE a.anulado = 0
            AND f.nro_documento = ?
            ORDER BY a.fechaRegistro DESC";
            $params = [$numero];
            $query = $this->db->query($sql, $params);
            return $query->result();
        }
        catch(\Exception $e) {
            return FALSE;
        }
    }
    public function registrarCliente($cliente) {
        try {
            $this->db->insert('tbl_cliente', $cliente);
            return $this->db->insert_id();
        } catch (\Exception $e) {
            // Registrar el log
            return FALSE;
        }
    } 

    public function modificarCliente($cliente) {
        try {
            $this->db->set('tipo_documento', $cliente['tipo_documento']);
            $this->db->set('nro_documento', $cliente['nro_documento']);
            $this->db->set('nombres', $cliente['nombres']);
            $this->db->set('apellido_paterno', $cliente['apellido_paterno']);
            $this->db->set('apellido_materno', $cliente['apellido_materno']);
            $this->db->set('direccion', $cliente['direccion']);
            $this->db->set('email', $cliente['email']);
            $this->db->set('telefono', $cliente['telefono']);
            $this->db->set('celular', $cliente['celular']);
            $this->db->set('observaciones', $cliente['observaciones']);
            $this->db->set('usuarioId_updated', $cliente['usuarioId_updated']);
            $this->db->set('updated_at', $cliente['updated_at']);
            $this->db->where('clienteId', $cliente['clienteId']);
            $this->db->update('tbl_cliente');
            return TRUE;
        } catch (\Exception $e){
            return FALSE;
        }
    }

    public function modificarFoto($clienteId, $pathFoto)
    {
        $this->db->set('path_foto', $pathFoto);
        $this->db->where('clienteId', $clienteId);
        $this->db->update('tbl_cliente');
    }
}