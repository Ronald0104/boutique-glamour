<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compra_model extends CI_Model 
{

    public function listarTipoGasto() {
        try {            
            $query = $this->db->get_where('tbl_tipo_gasto', array('estado => 1'));  
            return $query->result();
        } catch (\Exception $e) {
            return false;
        }        
    }

    public function obtenerCorrelativoCompra() {
        try {
            $sql = "SELECT CONCAT('CXP', LPAD(IFNULL(SUBSTR(IFNULL(MAX(CODE),0), 4, 7), '1') + 1,7,'0')) AS 'correlativo' FROM tbl_compra";
            $query = $this->db->query($sql);
            return $query->result();
        } catch(\Exception $e) {
            return false;
        }
    }

    public function listarTipoComprobante() {
        try {
            $this->db->select();
            $query = $this->db->get_where('tbl_tipo_comprobante', array( 'estado' => 1));
            return $query->result();
        } catch(\Exception $e) {
            return false;
        }
    }

    public function listarCompras($tipoGasto, $fechaDesde, $fechaHasta, $tienda) {
        try {
            $sql = "SELECT a.compraId, code AS 'codigo', e.nombre AS 'tienda', a.proveedor, a.tipo_documento AS 'tipoDocumentoId', b.nombre AS 'tipoDocumento',
            a.numero_documento AS 'numeroDocumento', IFNULL(a.tipoGastoId, 0) AS 'tipoGastoId', c.nombre AS 'tipoGasto',
            DATE_FORMAT(a.fecha_documento, '%d/%m/%Y') AS 'fechaCompra', a.descripcion, a.total AS 'importeTotal',  d.monto AS 'importeTienda'
            FROM tbl_compra a
            LEFT JOIN tbl_tipo_comprobante b ON b.id = a.tipo_documento
            LEFT JOIN tbl_tipo_gasto c ON c.id = a.tipoGastoId
            LEFT JOIN tbl_compra_distribucion d ON d.compraId = a.compraId
            LEFT JOIN tbl_tienda e ON e.id = d.tiendaId
            WHERE anulado = 0
            AND DATE_FORMAT(a.fecha_documento, '%Y%m%d') BETWEEN ? AND ? ";            

            if ($tipoGasto != "") {
                $tipoGasto = $this->db->escape_str($tipoGasto);
                $sql .= " AND a.tipoGastoId = " . $tipoGasto ." ";
            }
            if ($tienda != 0) {
                $sql .= " AND d.tiendaId = " . $tienda . " ";
            }
            $sql .= "ORDER BY a.compraId ";
            
            $fechaDesde = $this->db->escape_str($fechaDesde);
            $fechaHasta = $this->db->escape_str($fechaHasta);
            $params = [$fechaDesde, $fechaHasta];
            $query = $this->db->query($sql, $params);            
            return $query->result();
        } catch(\Exception $e){
            return false;
        }
    }

    public function obtenerCompraById($compraId) {
        try {
            $sql = "SELECT compraId, code AS 'codigo', proveedor, tipo_documento AS 'tipoDocumentoId', b.nombre AS 'tipoDocumento', 
            a.numero_documento AS 'numeroDocumento', IFNULL(a.tipoGastoId, 0) AS 'tipoGastoId', c.nombre AS 'tipoGasto', 
            DATE_FORMAT(a.fecha_documento, '%d/%m/%Y') AS 'fechaCompra', a.descripcion, a.total AS 'importeTotal'
            FROM tbl_compra a
            LEFT JOIN tbl_tipo_comprobante b ON b.id = a.tipo_documento
            LEFT JOIN tbl_tipo_gasto c ON c.id = a.tipoGastoId
            WHERE a.compraId = ?";

            $compraId = $this->db->escape_str($compraId);            
            $query = $this->db->query($sql, array('compraId' => $compraId));    
            $compra = $query->result()[0];     
            
            $this->db->from('tbl_compra_distribucion', array('compraId' => $compraId));
            $this->db->join('tbl_tienda', 'tbl_tienda.id = tbl_compra_distribucion.tiendaId');
            $this->db->select("tbl_compra_distribucion.compraId, tbl_compra_distribucion.tiendaId, tbl_tienda.nombre as 'tienda', tbl_compra_distribucion.porcentaje, tbl_compra_distribucion.monto");  
            $this->db->where("tbl_compra_distribucion.compraId = $compraId");      
            $query2 = $this->db->get();
            $compra->distribucion = $query2->result();
            return $compra;
        } catch(\Exception $e) {
            return false;            
        }
    }

    public function registrarCompra($compra, $distribucionTiendas){
        try{
            $this->db->insert('tbl_compra', $compra);
            $compraId = $this->db->insert_id();

            foreach ($distribucionTiendas as $tienda) {
                $item['compraId'] = $compraId;
                $item['tiendaId'] = $tienda['tiendaId'];
                $item['porcentaje'] = $tienda['porcentajeTienda'];
                $item['monto'] = $tienda['montoTienda'];
                $this->db->insert('tbl_compra_distribucion', $item);
            }
            return $compraId;
        } catch(\Exception $e){
            return false;
        }
    }

    public function actualizarCompra($compra, $distribucionTiendas){
        try {
            $this->db->set('tipo_documento', $compra['tipo_documento']);
            $this->db->set('numero_documento', $compra['numero_documento']);
            $this->db->set('fecha_documento', $compra['fecha_documento']);
            $this->db->set('descripcion', $compra['descripcion']);
            $this->db->set('proveedor', $compra['proveedor']);
            $this->db->set('tipoGastoId', $compra['tipoGastoId']);
            $this->db->set('total', $compra['total']);
            $this->db->where('compraId', $compra['compraId']);
            $this->db->update('tbl_compra');
            
            $this->db->where('compraId', $compra['compraId']);
            $this->db->delete('tbl_compra_distribucion');

            foreach ($distribucionTiendas as $tienda) {
                $item['compraId'] =  $compra['compraId'];
                $item['tiendaId'] = $tienda['tiendaId'];
                $item['porcentaje'] = $tienda['porcentajeTienda'];
                $item['monto'] = $tienda['montoTienda'];
                $this->db->insert('tbl_compra_distribucion', $item);
            }

            return true;
        } catch(\Exception $e){
            return false;
        }
    }

    public function anularCompra($compraId) {
        try {
            $this->db->set('anulado', 1);
            $this->db->where('compraId', $compraId);
            $this->db->update('tbl_compra');
            return true;
        } catch(\Exception $e) {
            return false;
        }
    }

    public function consultarDetalleCompra($fechaDesde, $fechaHasta, $tiendaId) {
        try {
            $sql = "";

            $fechaDesde = $this->db->escape_str($fechaDesde);
            $fechaHasta = $this->db->escape_str($fechaHasta);
            $tiendaId = $this->db->escape_str($tiendaId);
            $params = array($fechaDesde, $fechaHasta, $tiendaId);
            $result = $this->db->query($sql, $params);
            return $result->result();
        } catch (\Exception $ex) {
            return FALSE;
        }
    }

}