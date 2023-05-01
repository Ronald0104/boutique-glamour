<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venta_model extends CI_Model 
{

    public function obtenerNroVenta() {
        try {
            $this->db->select_max('ventaId');
            $query = $this->db->get('tbl_venta');  
            return $query->result();
        } catch (\Exception $e) {
            return false;
        }
        
    }

    public function obtenerClienteById($clienteId) {
        try{
            $query = $this->db->get_where('tbl_cliente', ['clienteId' => $clienteId], 1);
            return $query->result();
        } catch(\Exception $e){
            return FALSE;
        }
    }

    public function obtenerClienteByNumero($numero) {
        try{
            $query = $this->db->get_where('tbl_cliente', ['nro_documento' => $numero], 1);
            return $query->result();
        } catch(\Exception $e){
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

    public function registrarVenta($venta, $venta_details, $venta_payments){
        try {
            // Insertar en cabecera de venta
            $this->db->insert('tbl_venta', $venta);
            $id = $this->db->insert_id();
            $item = [];
            // Insertar el detalle
            $estadoId_Item = 1;
            if((int)$venta['estadoId'] == 1){
                $estadoId_Item = 2;
            }
            else if ((int)$venta['estadoId'] == 2){
                $estadoId_Item = 3;
            }
            else if((int)$venta['estadoId'] == 4){
                $estadoId_Item = 4;
            }

            // Insertamos en el detalle y actualizamos en estado del articulo
            foreach ($venta_details as $key => $value) {
                $item['ventaId'] = $id;
                $item['item'] = $key+1;
                $item['articuloId'] = $value->id;
                $item['cantidad'] = 1;
                $item['precioVenta'] = $value->precio;
                $item['importeTotal'] = $value->precio;
                $this->db->insert('tbl_venta_detalle', $item);

                $this->db->set('estadoId', $estadoId_Item);
                $this->db->set('precio_ultimo', $value->precio);
                $this->db->set('usuarioId_updated', $venta['usuarioId_updated']);
                $this->db->set('updated_at', $venta['updated_at']);
                $this->db->where('articuloId', $value->id);
                $this->db->update('tbl_articulo_resumen');

                // Registrar la bitacora historial
                // Registrar el movimiento de alquiler de la prenda
            }

            // Registramos en pago
            foreach ($venta_payments as $key => $value) {
                $payment['ventaId'] = $id;
                $payment['tipoPagoId'] = $value->tipoPagoId;
                $payment['tipoOperacionId'] = 0;
                $payment['ingreso'] = $value->ingreso;
                $payment['salida'] = $value->salida;
                $payment['nroTarjeta'] = $value->nroTarjeta;
                $payment['created_at'] = $venta['created_at'];
                $payment['usuarioId'] = $venta['usuarioId_created'];
                $this->db->insert('tbl_venta_pago', $payment);
            }

            // Registramos en historial del estado
            $data_history = array(
                'ventaId' => $id,
                'estadoId' => $venta['estadoId'],
                'vendedorId' => $venta['vendedorId'],
                'tiendaId' => $venta['tiendaId'],
                'usuarioId_created' => $venta['usuarioId_created'],
                'created_at' => $venta['created_at'],
                'observaciones' => ''
            );
            $this->db->insert('tbl_venta_estado_historial', $data_history);

            // return TRUE;
            return $id;
        }
        catch(\Exception $e){
            // return FALSE;
            return 0;
        }
    }

    public function modificarVenta($venta, $venta_details, $venta_payments){
        try {
            // Actualizar cabecera de venta
            $this->db->set('fechaSalidaProgramada', $venta['fechaSalidaProgramada']);
            $this->db->set('fechaDevolucionProgramada', $venta['fechaDevolucionProgramada']);
            $this->db->set('observaciones', $venta['observaciones']);
            $this->db->set('dejoDocumento', $venta['dejoDocumento']);
            $this->db->set('dejoRecibo', $venta['dejoRecibo']);
            $this->db->set('precioTotal', $venta['precioTotal']);
            $this->db->set('totalEfectivo', $venta['totalEfectivo']);
            $this->db->set('totalTarjeta', $venta['totalTarjeta']);
            $this->db->set('totalVuelto', $venta['totalVuelto']);
            $this->db->set('totalPagado', $venta['totalPagado']);
            $this->db->set('totalSaldo', $venta['totalSaldo']);
            $this->db->set('estadoId', $venta['estadoId']);
            $this->db->set('usuarioId_updated', $venta['usuarioId_updated']);
            $this->db->set('updated_at', $venta['updated_at']);
            $this->db->where('ventaId', $venta['ventaId']);
            $this->db->update('tbl_venta');

            // Actualizar el estado
            $item = [];

            // Insertar el detalle
            $estadoId_Item = 1;
            if((int)$venta['estadoId'] == 1){   // Reservado
                $estadoId_Item = 2;
            }
            else if ((int)$venta['estadoId'] == 2){ // Alquilado
                $estadoId_Item = 3;
            }
            else if((int)$venta['estadoId'] == 4){  // Vendido
                $estadoId_Item = 4;
            }

            // Insertamos en el detalle y actualizamos en estado del articulo
            foreach ($venta_details as $key => $value) {
                if($value->accion==1) {            // Actualizar
                    $this->db->set('precioVenta', $value->precio);
                    $this->db->set('importeTotal', $value->precio);
                    $this->db->where('ventaId', $venta['ventaId']);
                    $this->db->where('articuloId', $value->id);
                    $this->db->update('tbl_venta_detalle');
                } else if ($value->accion==2) {    // Insertar
                    $item['ventaId'] = $venta['ventaId'];
                    $item['item'] = $key + 1;
                    $item['articuloId'] = $value->id;
                    $item['cantidad'] = 1;
                    $item['precioVenta'] = $value->precio;
                    $item['importeTotal'] = $value->precio;
                    $this->db->insert('tbl_venta_detalle', $item);
                } else if ($value->accion==3) {    // Eliminar
                    $this->db->where('ventaId', $venta['ventaId']);
                    $this->db->where('articuloId', $value->id);
                    $this->db->delete('tbl_venta_detalle');
                    $estadoId_Item = 1;
                }
                
                $this->db->set('estadoId', $estadoId_Item);
                if ($estadoId_Item == "2" || $estadoId_Item == "3" || $estadoId_Item == "4"){
                    $this->db->set('precio_ultimo', $value->precio);
                }
                $this->db->set('usuarioId_updated', $venta['usuarioId_updated']);
                $this->db->set('updated_at', $venta['updated_at']);
                $this->db->where('articuloId', $value->id);
                $this->db->update('tbl_articulo_resumen');

                // Registrar la bitacora historial
                // Registrar el movimiento de alquiler de la prenda
            }

            // Registramos en pago
            foreach ($venta_payments as $key => $value) {
                if ($value->id = 0) {
                    $payment['ventaId'] = $venta['ventaId'];
                    $payment['tipoPagoId'] = $value->tipoPagoId;
                    $payment['tipoOperacionId'] = 0;
                    $payment['ingreso'] = $value->ingreso;
                    $payment['salida'] = $value->salida;
                    $payment['nroTarjeta'] = $value->nroTarjeta;
                    $payment['created_at'] = $venta['updated_at'];
                    $payment['usuarioId'] = $venta['usuarioId_updated'];
                    $this->db->insert('tbl_venta_pago', $payment);
                }                
            }

            // Registramos en historial del estado si es que ha cambiado de estado
            $data_history = array(
                'ventaId' => $venta['ventaId'],
                'estadoId' => $venta['estadoId'],
                'vendedorId' => $venta['vendedorId'],
                'tiendaId' => $venta['tiendaId'],
                'usuarioId_created' => $venta['usuarioId_updated'],
                'created_at' => $venta['updated_at'],
                'observaciones' => ''
            );
            $this->db->insert('tbl_venta_estado_historial', $data_history);

            // return TRUE;
            return 1;
        }
        catch(\Exception $e){
            // return FALSE;
            return 0;
        }
    }

    public function listarVentas($fechaDesde, $fechaHasta, $tiendaId = 0) {
        $sql = "SELECT a.ventaId, a.tiendaId, a.vendedorId, CONCAT(d.nombre, ' ', d.apellido_paterno) AS 'vendedor', a.clienteId, 
        b.nro_documento AS 'clienteDNI', CONCAT(b.nombres, ' ', b.apellido_paterno) AS 'cliente', a.estadoId, c.nombre AS 'estado', 
		a.created_at AS 'fechaCreacion', a.fechaRegistro, a.fechaSalida, a.fechaSalidaProgramada, a.fechaDevolucionProgramada, a.precioTotal, a.totalPagado, a.totalSaldo
        FROM tbl_venta a
        INNER JOIN tbl_venta_estado c ON c.id = a.estadoId
        INNER JOIN tbl_usuario d ON d.usuario_id = a.vendedorId
        INNER JOIN tbl_cliente b ON b.clienteId = a.clienteId
        WHERE DATE_FORMAT(a.fechaRegistro, '%Y%m%d') BETWEEN ? AND ?
        AND a.tiendaId = CASE WHEN ? = 0 THEN a.tiendaId ELSE ? END 
        ORDER BY a.ventaId DESC";

        //$params = ["'".$this->db->escape($fechaDesde)."'", $this->db->escape($fechaHasta), $this->db->escape($tiendaId), $this->db->escape($tiendaId)];
        $fechaDesde = $this->db->escape_str($fechaDesde);
        $fechaHasta = $this->db->escape_str($fechaHasta);
        $params = [$fechaDesde, $fechaHasta, $tiendaId, $tiendaId];
        
        // $query = $this->db->query($sql, array('20190403', '20190404', 0, 1));
        $query = $this->db->query($sql, $params);

        return $query->result();
    }

    public function obtenerVenta($ventaId) {
        // Venta Cabecera
        $sql = "SELECT a.ventaId, LPAD(a.ventaId, 6,'0') AS 'codigoVentaId', a.tiendaId, b.nombre AS 'tienda', 
        a.vendedorId, CONCAT(c.nombre, ' ', c.apellido_paterno) AS 'vendedor', 
        a.clienteId, CONCAT(d.nombres, ' ', d.apellido_paterno) AS 'cliente', 
        a.estadoId, e.nombre AS 'estado', a.observaciones, a.created_at AS 'fechaCreacion', a.fechaRegistro,
        a.fechaSalidaProgramada, a.fechaDevolucionProgramada, a.fechaSalida, a.fechaDevolucion,	
        a.precioTotal, a.totalEfectivo, a.totalTarjeta, a.totalVuelto, a.totalPagado, a.totalSaldo, a.dejoDocumento, a.dejoRecibo
        FROM tbl_venta a
        INNER JOIN tbl_tienda b ON b.id = a.tiendaId
        INNER JOIN tbl_usuario c ON c.usuario_id = a.vendedorId
        INNER JOIN tbl_cliente d ON d.clienteId = a.clienteId
        INNER JOIN tbl_venta_estado e ON e.id = a.estadoId
        WHERE a.ventaId = ?";

        $ventaId = $this->db->escape_str($ventaId);
        $query = $this->db->query($sql, array($ventaId));
        $reserva = $query->result();
        $reserva = $reserva[0];

        // Venta Detalle
        $sql2 = "SELECT a.ventaId, a.articuloId, b.code AS 'articuloCode', b.nombre AS 'articuloNombre', a.precioVenta, c.estadoId, d.nombre AS 'estado', c.precio_alquiler AS 'precioAlquiler', c.precio_ultimo AS 'precioUltimo', e.Tipo AS 'tipo'
        FROM tbl_venta_detalle a
        INNER JOIN tbl_articulo b ON b.articuloId = a.articuloId
        INNER JOIN tbl_articulo_resumen c ON c.articuloId = a.articuloId
        INNER JOIN tbl_articulo_estado d ON d.id = c.estadoId
        INNER JOIN tbl_categoria e ON e.categoriaId = b.categoriaId
        WHERE a.ventaId = ?";
        $query2 = $this->db->query($sql2, array($ventaId));        
        $reserva->detalle = $query2->result();   
        
        // Venta Pago
        $sql3 = "SELECT a.id as 'pagoId', a.ventaId, a.tipoPagoId, b.descripcion AS 'tipoPago', ingreso, salida, nroTarjeta, created_at as 'fecha'
        FROM tbl_venta_pago a
        INNER JOIN tbl_tipo_pago b ON b.tipoPagoId = a.tipoPagoId
        WHERE a.ventaId = ? ";
        $query3 = $this->db->query($sql3, array($ventaId));        
        $reserva->pago = $query3->result(); 

        // Venta Historial Estado
        $sql4 = "SELECT a.id as 'historialId', a.ventaId, a.estadoId, b.nombre AS 'estado', a.vendedorId, 
        CONCAT(c.nombre, ' ', c.apellido_paterno) AS 'vendedor', a.tiendaId, d.nombre AS 'tienda', 
        a.usuarioId_created AS 'usuarioId', CONCAT(e.nombre, ' ', e.apellido_paterno) AS 'usuario',
        a.created_at AS 'fecha', observaciones	
        FROM tbl_venta_estado_historial a
        INNER JOIN tbl_venta_estado b ON b.id = a.estadoId
        INNER JOIN tbl_usuario c ON c.usuario_id = a.vendedorId
        INNER JOIN tbl_tienda d ON d.id = a.tiendaId
        INNER JOIN tbl_usuario e ON e.usuario_id = a.usuarioId_created 
        WHERE a.ventaId = ? ";
        $query4 = $this->db->query($sql4, array($ventaId));        
        $reserva->historial = $query4->result(); 
     
        return $reserva;
    }
   
    public function obtenerReservas($dni) {
        $sql = "SELECT a.ventaId, CONCAT('VTA', LPAD(a.ventaId,4,'0')) AS 'codigoVentaId', a.tiendaId, b.nombre AS 'tienda', 
        a.vendedorId, CONCAT(c.nombre, ' ', c.apellido_paterno) AS 'vendedor', a.clienteId, a.precioTotal,
        a.fechaSalidaProgramada, a.fechaDevolucionProgramada
        FROM tbl_venta a
        INNER JOIN tbl_tienda b ON b.id = a.tiendaId
        INNER JOIN tbl_usuario c ON c.usuario_id = a.vendedorId
        INNER JOIN tbl_cliente d ON d.clienteId = a.clienteId
        WHERE a.estadoId = 1
        AND d.nro_documento = ?";

        $dni = $this->db->escape_str($dni);
        $query = $this->db->query($sql, array($dni));
        $reservas = $query->result();

        foreach ($reservas as $key => $reserva) {
            $sql2 = "SELECT a.ventaId, a.articuloId, b.code AS 'articuloCode', b.nombre AS 'articuloNombre', a.precioVenta, 
            c.estadoId, d.nombre AS 'estado', c.precio_ultimo
            FROM tbl_venta_detalle a
            INNER JOIN tbl_articulo b ON b.articuloId = a.articuloId
            INNER JOIN tbl_articulo_resumen c ON c.articuloId = a.articuloId
            INNER JOIN tbl_articulo_estado d ON d.id = c.estadoId
            WHERE a.ventaId = ?";

            $reservaId = $this->db->escape_str($reserva->ventaId);
            $query2 = $this->db->query($sql2, array($reservaId));
            $reservas[$key]->detalle = $query2->result();            
        }    
        return $reservas;
    }

    public function atenderReserva($ventaId) {
        $res = 1;
        try {
            // Actualizamos el estado de la reserva
            $this->db->set('estadoId', 2);
            $this->db->where('ventaId', $ventaId);
            $this->db->update('tbl_venta');

            $query = $this->db->get_where('tbl_venta_detalle', array('ventaId' => $ventaId), 10);
            $result = $query->result();

            // Actualizamos el estado de los articulos
            foreach ($result as $value) {
                $this->db->set('estadoId', 3);
                $this->db->where('articuloId', $value->articuloId);
                $this->db->update('tbl_articulo_resumen');
            }
        } catch (\Exception $ex) {
            $res = 0;
        }
        return $res;
    }


    public function obtenerAlquiler($dni) {
        $sql = "SELECT a.ventaId, CONCAT('VTA', LPAD(a.ventaId,4,'0')) AS 'codigoVentaId', a.tiendaId, b.nombre AS 'tienda', 
        a.vendedorId, CONCAT(c.nombre, ' ', c.apellido_paterno) AS 'vendedor', a.clienteId, a.precioTotal,
        a.fechaSalidaProgramada, a.fechaDevolucionProgramada
        FROM tbl_venta a
        INNER JOIN tbl_tienda b ON b.id = a.tiendaId
        INNER JOIN tbl_usuario c ON c.usuario_id = a.vendedorId
        INNER JOIN tbl_cliente d ON d.clienteId = a.clienteId
        WHERE a.estadoId = 2
        AND d.nro_documento = ?";

        $dni = $this->db->escape_str($dni);
        $query = $this->db->query($sql, array($dni));
        $alquileres = $query->result();

        foreach ($alquileres as $key => $alquiler) {
            $sql2 = "SELECT a.ventaId, a.articuloId, b.code AS 'articuloCode', b.nombre AS 'articuloNombre', a.precioVenta, 
            c.estadoId, d.nombre AS 'estado', c.precio_ultimo
            FROM tbl_venta_detalle a
            INNER JOIN tbl_articulo b ON b.articuloId = a.articuloId
            INNER JOIN tbl_articulo_resumen c ON c.articuloId = a.articuloId
            INNER JOIN tbl_articulo_estado d ON d.id = c.estadoId
            WHERE a.ventaId = ?";

            $alquilerId = $this->db->escape_str($alquiler->ventaId);
            $query2 = $this->db->query($sql2, array($alquilerId));
            $alquileres[$key]->detalle = $query2->result();            
        }    
        return $alquileres;
    }

    public function atenderAlquiler($ventaId) {
        $res = 1;
        try {
            // Actualizamos el estado de la reserva
            $this->db->set('estadoId', 3);
            $this->db->where('ventaId', $ventaId);
            $this->db->update('tbl_venta');

            $query = $this->db->get_where('tbl_venta_detalle', array('ventaId' => $ventaId), 10);
            $result = $query->result();

            // Actualizamos el estado de los articulos
            foreach ($result as $value) {
                $this->db->set('estadoId', 1);
                $this->db->where('articuloId', $value->articuloId);
                $this->db->update('tbl_articulo_resumen');
            }
        } catch (\Exception $ex) {
            $res = 0;
        }
        return $res;
    }
}