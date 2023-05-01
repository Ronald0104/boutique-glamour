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

    public function obtenerNroTicket($tiendaId) {
        try {
            $tiendaId = $this->db->escape_str($tiendaId);
            $sql = "SELECT a.id, a.tipoDoc, a.serie, a.numeroActual
            FROM tbl_serie a
            INNER JOIN tbl_serie_tienda b ON b.serieId = a.id 
            WHERE b.tiendaId = ? AND a.tipoDoc = 'NV' AND a.estado = 1";

            $params = [$tiendaId];
            $query = $this->db->query($sql, $params);
            return $query->result();
        } catch (\Exception $ex) {
            return false;
        }
    }
    
    public function obtenerCorrelativo($tipoDoc, $serieDoc) {
        try {
            $tipoDoc = $this->db->escape_str($tipoDoc);
            $serieDoc = $this->db->escape_str($serieDoc);
            $sql = "SELECT LPAD(CAST(MAX(numeroDoc) AS SIGNED)+1,6,'0') AS 'numeroDoc' FROM tbl_venta 
            WHERE tipoDoc = ? AND serieDoc = ?";

            $params = [$tipoDoc,$serieDoc];
            $query = $this->db->query($sql, $params);
            return $query->result();
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function verificaExisteCorrelativo($tipoDoc, $serieDoc, $numeroDoc) {
        try {
            $query = $this->db->get_where('tbl_venta', ['tipoDoc'=>$tipoDoc, 'serieDoc'=>$serieDoc, 'numeroDoc'=>$numeroDoc]);
            return $query->result();
        } catch (\Exception $ex) {
            return false;
        }
    }
    
    public function incrementarCorrelativo($tipoDoc, $serieDoc) {
        try {
            $tipoDoc = $this->db->escape_str($tipoDoc);
            $serieDoc = $this->db->escape_str($serieDoc);
            $sql = "UPDATE tbl_serie SET numeroActual = LPAD(CAST(numeroActual AS SIGNED)+1,6,'0') 
            WHERE tipoDoc = ? AND serie = ? ";

            $params = [$tipoDoc, $serieDoc];
            $result = $this->db->query($sql, $params);
            return $result;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function actualizarCorrelativo($tipoDoc, $serieDoc, $numeroDoc) {
        try {
            $tipoDoc = $this->db->escape_str($tipoDoc);
            $serieDoc = $this->db->escape_str($serieDoc);
            $sql = "UPDATE tbl_serie SET numeroActual = ? 
            WHERE tipoDoc = ? AND serie = ? ";

            $params = [$numeroDoc, $tipoDoc, $serieDoc];
            $result = $this->db->query($sql, $params);
            return $result;
        } catch (\Exception $ex) {
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

    public function verificaClienteDevoluciones($numero) {
        try{
            $numero = $this->db->escape_str($numero);

            $sql = "SELECT a.clienteId, c.nro_documento, UPPER(CONCAT(RTRIM(c.apellido_paterno), ' ', RTRIM(c.apellido_materno), ', ', c.nombres)) AS 'cliente', c.telefono, a.ventaId, LPAD(a.ventaId, 6, '0') AS 'ventaCode', a.tiendaId, d.nombre AS 'tienda', DATE_FORMAT(a.fechaSalida, '%d/%m/%Y')  AS 'fechaSalida',
            DATE_FORMAT(a.fechaDevolucionProgramada, '%d/%m/%Y') AS 'fechaDevolucionProg', 
            DATEDIFF(CURDATE(), CONVERT(a.fechaDevolucionProgramada, DATE)) AS 'diasVencidos'
            FROM tbl_venta a
            INNER JOIN tbl_cliente c ON c.clienteId = a.clienteId
            INNER JOIN tbl_tienda d ON d.id = a.tiendaId
            WHERE a.tipoOperacionId = 1
            AND a.estadoId = 2
            AND c.nro_documento = ?
            ORDER BY diasVencidos DESC";

            $params = [$numero];
            $query = $this->db->query($sql, $params);
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
        $this->db->trans_start(); # Starting Transaction
        //$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

        try {                       
            // Insertar en cabecera de venta
            $this->db->insert('tbl_venta', $venta);
            $id = $this->db->insert_id();
            $item = [];

            $estadoId_Item = 1;
            $condicion = "";
            // Insertar el detalle
            if ($venta['tipoOperacionId'] == 1) {
                if((int)$venta['estadoId'] == 1){
                    $estadoId_Item = 2;
                }
                else if ((int)$venta['estadoId'] == 2){
                    $estadoId_Item = 3;
                }
                else if((int)$venta['estadoId'] == 4){
                    $estadoId_Item = 4;
                }
                else if((int)$venta['estadoId'] == 5){
                    $estadoId_Item = 0;
                }
            } else if ($venta['tipoOperacionId'] == 2) {
                $estadoId_Item = 4;
            }
        
            // else if((int)$venta['estadoId'] == 5){
            //     $estadoId_Item = 1;
            // }
            // else if((int)$venta['estadoId'] == 6){
            //     $estadoId_Item = 1;
            // }

            // Insertamos en el detalle y actualizamos en estado del articulo
            foreach ($venta_details as $key => $value) {
                $item['ventaId'] = $id;
                $item['item'] = $key+1;
                $item['articuloId'] = $value->articuloId;
                $item['cantidad'] = 1;
                $item['precioVenta'] = $value->precio;
                $item['importeTotal'] = $value->precio;
                $item['descripcion'] = $value->nombre;
                $this->db->insert('tbl_venta_detalle', $item);


                $this->db->set('estadoId', $estadoId_Item);
                $this->db->set('precio_ultimo', $value->precio);
                $this->db->set('usuarioId_updated', $venta['usuarioId_updated']);
                $this->db->set('updated_at', $venta['updated_at']);
                $this->db->where('articuloId', $value->articuloId);
                $this->db->update('tbl_articulo_resumen');

                // ACTUALIZAR LA CONDICION Y LOS ESTADOS DE LAS PRENDAS
                if ($venta['tipoOperacionId'] == 1) {
                    $this->db->set('condicion', "USADO");
                    $this->db->set('usuarioId_updated', $venta['usuarioId_updated']);
                    $this->db->set('updated_at', $venta['updated_at']);
                    $this->db->where('articuloId', $value->articuloId);
                    $this->db->update('tbl_articulo');
                }

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
				$payment['fechaRegistro'] = $venta['fechaRegistro'];
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

            $this->db->trans_complete(); # Completing transaction

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return 0;
            } 
            else {
                $this->db->trans_commit();
                return $id;
            }
            // return TRUE;
            // return $id;
        }
        catch(\Exception $e){
            // return FALSE;
            $this->db->trans_rollback();
            return 0;
        }        
    }

    public function modificarVenta($ventaId, $venta, $venta_details, $venta_payments, $estadoId_Anterior){
        try {
            // Actualizar cabecera de venta
            // $this->db->set('fechaSalidaProgramada', $venta['fechaSalidaProgramada']);
            // $this->db->set('fechaDevolucionProgramada', $venta['fechaDevolucionProgramada']);
            // $this->db->set('observaciones', $venta['observaciones']);
            // $this->db->set('dejoDocumento', $venta['dejoDocumento']);
            // $this->db->set('dejoRecibo', $venta['dejoRecibo']);
            // $this->db->set('precioTotal', $venta['precioTotal']);
            // $this->db->set('totalEfectivo', $venta['totalEfectivo']);
            // $this->db->set('totalTarjeta', $venta['totalTarjeta']);
            // $this->db->set('totalVuelto', $venta['totalVuelto']);
            // $this->db->set('totalPagado', $venta['totalPagado']);
            // $this->db->set('totalSaldo', $venta['totalSaldo']);
            // $this->db->set('totalGarantia', $venta['totalGarantia']);
            // $this->db->set('estadoId', $venta['estadoId']);
            // $this->db->set('tiendaId', $venta['tiendaId']);
            // $this->db->set('usuarioId_updated', $venta['usuarioId_updated']);
            // $this->db->set('updated_at', $venta['updated_at']);
            $this->db->where('ventaId', $ventaId);
            $this->db->update('tbl_venta', $venta);

            // Actualizar el estado
            $item = [];

            // Insertar el detalle
            $estadoId_Item = 1;
            if ($venta['tipoOperacionId'] == 1) {
                if((int)$venta['estadoId'] == 1){   // Reservado
                    $estadoId_Item = 2;
                }
                else if ((int)$venta['estadoId'] == 2){ // Alquilado
                    $estadoId_Item = 3;
                }
                else if ((int)$venta['estadoId'] == 3){ // Devuelto
                    $estadoId_Item = 1;
                }
                else if((int)$venta['estadoId'] == 4){  // Vendido
                    $estadoId_Item = 4;
                }
                else if((int)$venta['estadoId'] == 5){  // Anulado
                    $estadoId_Item = 1;  // Depende que no tenga otras reservas
                }
                else if((int)$venta['estadoId'] == 6){  // Servicio
                    $estadoId_Item = 1;
                }
            } else if ($venta['tipoOperacionId'] == 2) {
                $estadoId_Item = 4;
            }

            // Insertamos en el detalle y actualizamos en estado del articulo
            // Registramos el historial de modificaciones que se realice
            // Obtenemos el numero de edicion            
            $this->db->select_max('numeroEdicion');            
            $query = $this->db->get_where('tbl_venta_detalle_historial', array('ventaId' => $ventaId), 1);            
            if ($query->num_rows() == 0){
                $numeroEdicion = 1;
            } else {
                $n = $query->result()[0]; 
                $numeroEdicion = $n->numeroEdicion + 1;
            }            

            foreach ($venta_details as $key => $value) {
                if($value->accion==1) {            // Actualizar
                    // Registramos el historial si se modifico
                    if ($value->precio <> $value->precioAnterior) {
                        $itemHistory['ventaId'] = $ventaId;
                        $itemHistory['numeroEdicion'] = $numeroEdicion;
                        $itemHistory['articuloId'] = $value->articuloId;
                        $itemHistory['detalleId'] = $value->id;
                        $itemHistory['cantidad'] = 1;
                        $itemHistory['precioVenta'] = $value->precioAnterior;
                        $itemHistory['importeTotal'] = $value->precioAnterior;
                        $itemHistory['accion'] = 'MODIFICADO';
                        $itemHistory['usuarioId_created'] = $venta['usuarioId_updated'];
                        $this->db->insert('tbl_venta_detalle_historial', $itemHistory);
                    }

                    $this->db->set('precioVenta', $value->precio);
                    $this->db->set('importeTotal', $value->precio);
                    $this->db->where('ventaId', $ventaId);
                    // $this->db->where('articuloId', $value->id);
                    $this->db->where('id', $value->id);
                    $this->db->update('tbl_venta_detalle');
                } else if ($value->accion==2) {    // Insertar
                    $item['ventaId'] = $ventaId;
                    $item['item'] = $key + 1;
                    $item['articuloId'] = $value->articuloId;
                    $item['cantidad'] = 1;
                    $item['precioVenta'] = $value->precio;
                    $item['importeTotal'] = $value->precio;
                    $item['descripcion'] = $value->nombre;
                    $this->db->insert('tbl_venta_detalle', $item);
                } else if ($value->accion==3) {    // Eliminar
                    // Registramos su historial si se elimino
                    $itemHistory['ventaId'] = $ventaId;
                    $itemHistory['numeroEdicion'] = $numeroEdicion;
                    $itemHistory['articuloId'] = $value->articuloId;
                    $itemHistory['detalleId'] = $value->id;
                    $itemHistory['cantidad'] = 1;
                    $itemHistory['precioVenta'] = $value->precioAnterior;
                    $itemHistory['importeTotal'] = $value->precioAnterior;
                    $itemHistory['accion'] = 'ELIMINADO';
                    $itemHistory['usuarioId_created'] = $venta['usuarioId_updated'];
                    $this->db->insert('tbl_venta_detalle_historial', $itemHistory);
                                       
                    $this->db->where('ventaId', $ventaId);
                    // $this->db->where('articuloId', $value->id);
                    $this->db->where('id', $value->id);
                    $this->db->delete('tbl_venta_detalle');
                    $estadoId_Item = 1;
                }
                
                // liberar la prenda
                $this->db->set('estadoId', $estadoId_Item);
                if ($estadoId_Item == "2" || $estadoId_Item == "3" || $estadoId_Item == "4"){
                    $this->db->set('precio_ultimo', $value->precio);
                }
                $this->db->set('usuarioId_updated', $venta['usuarioId_updated']);
                $this->db->set('updated_at', $venta['updated_at']);
                $this->db->where('articuloId', $value->articuloId);
                $this->db->update('tbl_articulo_resumen');

                if ($venta['tipoOperacionId'] == 1) {
                    $this->db->set('condicion', "USADO");
                    $this->db->set('usuarioId_updated', $venta['usuarioId_updated']);
                    $this->db->set('updated_at', $venta['updated_at']);
                    $this->db->where('articuloId', $value->articuloId);
                    $this->db->update('tbl_articulo');
                }
                // Registrar la bitacora historial
                // Registrar el movimiento de alquiler de la prenda
            }

            // Registramos en pago
            foreach ($venta_payments as $key => $value) {
                if ($value->id == 0) {
                    $payment['ventaId'] = $ventaId;
                    $payment['tipoPagoId'] = $value->tipoPagoId;
                    $payment['tipoOperacionId'] = 0;
                    $payment['ingreso'] = $value->ingreso;
                    $payment['salida'] = $value->salida;
                    $payment['nroTarjeta'] = $value->nroTarjeta;                    
                    $payment['usuarioId'] = $venta['usuarioId_updated'];
                    $payment['fechaRegistro'] = $venta['updated_at'];
                    $payment['created_at'] = $venta['updated_at'];
                    $payment['updated_at'] = $venta['updated_at'];
                    $payment['usuarioId_created'] = $venta['usuarioId_updated'];
                    $payment['usuarioId_updated'] = $venta['usuarioId_updated'];
                    $this->db->insert('tbl_venta_pago', $payment);
                }                
            }

            // Registramos en historial del estado si es que ha cambiado de estado
            if ($venta['estadoId'] != $estadoId_Anterior){
                $data_history = array(
                    'ventaId' => $ventaId,
                    'estadoId' => $venta['estadoId'],
                    'vendedorId' => $venta['vendedorId'],
                    'tiendaId' => $venta['tiendaId'],
                    'usuarioId_created' => $venta['usuarioId_updated'],
                    'created_at' => $venta['updated_at'],
                    'observaciones' => ''
                );
                $this->db->insert('tbl_venta_estado_historial', $data_history);
            }            
            
            // return TRUE;
            return 1;
        }
        catch(\Exception $e){
            // return FALSE;
            return 0;
        }
    }

    public function anularVenta($ventaId, $usuarioId, $tiendaId, $fecha, $motivo) {
        try {
            $this->db->set('anulado', 1);
            $this->db->set('usuarioId_updated', $usuarioId);
            $this->db->set('updated_at', $fecha);
            $this->db->where('ventaId', $ventaId);
            $this->db->update('tbl_venta');    

            // $this->db->where('ventaId', $ventaId);
            // $this->db->delete('tbl_venta');

            // Registramos en la tabla de anulados
            $data_delete = array(
                'ventaId' => $ventaId,
                'observacion' => $motivo,
                'usuarioId_created' => $usuarioId,
                'created_at' => $fecha
            );
            $this->db->insert('tbl_venta_anulada', $data_delete);

            // Registramos en historial del estado
            $data_history = array(
                'ventaId' => $ventaId,
                'estadoId' => 5,
                'vendedorId' => $usuarioId,
                'tiendaId' => $tiendaId,
                'usuarioId_created' => $usuarioId,
                'created_at' => $fecha,
                'observaciones' => 'REGISTRO ANULADO'
            );            
            $this->db->insert('tbl_venta_estado_historial', $data_history);
            return true;
        }
        catch(\Exception $e) {
            return false;
        }        
    }

    public function procesarDevolucion($ventaId, $fechaDevolucion, $observaciones, $tiendaId, $usuarioId, $fecha) {
        try {
            $this->db->set('fechaDevolucion', $fechaDevolucion);            
            $this->db->set('usuarioId_updated', $usuarioId);
            $this->db->set('updated_at', $fecha);
            $this->db->where('ventaId', $ventaId);
            $this->db->update('tbl_venta');

            $data_history = array(
                'ventaId' => $ventaId,
                'estadoId' => 3,
                'vendedorId' => $usuarioId,
                'tiendaId' => $tiendaId,
                'usuarioId_created' => $usuarioId,
                'created_at' => $fecha,
                'observaciones' => $observaciones
            );
            $this->db->insert('tbl_venta_estado_historial', $data_history);                    
        }
        catch(\Exception $e) {
            return 0;
        }
    }

    public function obtenerDetallaVenta($ventaId)
    {
        try {
            $ventaId = $this->db->escape_str($ventaId);

            $sql = "SELECT a.id, a.ventaId, a.articuloId, a.importeTotal, a.descripcion, b.code, b.nombre as 'articulo', b.categoriaId,
            c.nombre as 'categoria', b.condicion, d.estadoId, e.nombre as 'estado'
            FROM tbl_venta_detalle a
            LEFT JOIN tbl_articulo b on b.articuloId = a.articuloId
            LEFT JOIN tbl_categoria c on c.categoriaId = b.categoriaId
            LEFT JOIN tbl_articulo_resumen d on d.articuloId = b.articuloId
            LEFT JOIN tbl_articulo_estado e on e.id = d.estadoId
            where a.ventaId = ?";
            
            $query = $this->db->query($sql, array($ventaId));        
            return $query->result();  
        }
        catch(\Exception $e) {
            return 0;
        }
    }

    public function listarVentas($fechaDesde, $fechaHasta, $tiendaId = 0, $estadoId = 0, $vendedorId = 0) {
        $sql = " SELECT a.ventaId, IFNULL(a.numeroComprobante,'') AS 'numeroOperacion', a.tiendaId, a.vendedorId, CONCAT(d.nombre, ' ', d.apellido_paterno) AS 'vendedor', a.clienteId, 
        b.nro_documento AS 'clienteDNI', CONCAT(b.nombres, ' ', b.apellido_paterno) AS 'cliente', a.estadoId, 
        c.nombre AS 'estado', a.created_at AS 'fechaCreacion', a.fechaRegistro, a.fechaSalida, 
        a.fechaSalidaProgramada, a.fechaDevolucionProgramada, a.precioTotal, e.totalPagado, IFNULL(f.totalPagadoAnterior, 0) AS 'totalPagadoAnterior',
        a.precioTotal - IFNULL(e.totalPagado, 0) - IFNULL(f.totalPagadoAnterior, 0) as 'totalSaldo', a.totalSaldo as 'totalSaldo2',
        e.totalEfectivo, e.totalTarjeta, IFNULL(a.totalGarantia, 0) AS 'totalGarantia'
        FROM (
            SELECT ventaId, SUM(ingreso) - SUM(salida) AS 'totalPagado',
            SUM(CASE WHEN tipoPagoId IN (1, 4) THEN ingreso - salida ELSE 0 END) AS 'totalEfectivo',
            SUM(CASE WHEN tipoPagoId IN (2, 3) THEN ingreso - salida ELSE 0 END) AS 'totalTarjeta'
            FROM tbl_venta_pago
            WHERE DATE_FORMAT(fechaRegistro, '%Y%m%d') BETWEEN ? AND ?
            GROUP BY ventaId
        ) e
        INNER JOIN tbl_venta a ON a.ventaId = e.ventaId
        INNER JOIN tbl_venta_estado c ON c.id = a.estadoId
        INNER JOIN tbl_usuario d ON d.usuario_id = a.vendedorId
        INNER JOIN tbl_cliente b ON b.clienteId = a.clienteId
        LEFT JOIN (
            SELECT ventaId, IFNULL(SUM(ingreso),0) - IFNULL(SUM(salida),0) AS 'totalPagadoAnterior'
            FROM tbl_venta_pago
            WHERE DATE_FORMAT(fechaRegistro, '%Y%m%d') < ?
            GROUP BY ventaId
        ) f ON f.ventaId = a.ventaId
        WHERE a.anulado = 0    
        AND a.tiendaId = CASE WHEN ? = 0 THEN a.tiendaId ELSE ? END 
        AND a.estadoId = CASE WHEN ? = 0 THEN a.estadoId ELSE ? END 
        AND a.vendedorId = CASE WHEN ? = 0 THEN a.vendedorId ELSE ? END        
        ORDER BY a.ventaId DESC ";

        // SELECT ventaId, WEEK(fechaRegistro, 1) AS 'Semana', IFNULL(SUM(ingreso),0) - IFNULL(SUM(salida),0) AS 'totalPagadoAnterior'
        // FROM tbl_venta_pago
        // WHERE DATE_FORMAT(fechaRegistro, '%Y%m%d') < ?
        // GROUP BY ventaId, WEEK(fechaRegistro, 1)

        //$params = ["'".$this->db->escape($fechaDesde)."'", $this->db->escape($fechaHasta), $this->db->escape($tiendaId), $this->db->escape($tiendaId)];
        $fechaDesde = $this->db->escape_str($fechaDesde);
        $fechaHasta = $this->db->escape_str($fechaHasta);
        $tiendaId = $this->db->escape_str($tiendaId);
        $estadoId = $this->db->escape_str($estadoId);
        $vendedorId = $this->db->escape_str($vendedorId);
        $params = [$fechaDesde, $fechaHasta, $fechaDesde, $tiendaId, $tiendaId, $estadoId, $estadoId, $vendedorId, $vendedorId];
        
        // $query = $this->db->query($sql, array('20190403', '20190404', 0, 1));
        $query = $this->db->query($sql, $params);

        return $query->result();
    }

    public function obtenerVenta($ventaId) {
        // Venta Cabecera
        $sql = "SELECT a.ventaId, IFNULL(a.numeroComprobante,'') AS 'nroOperacion', LPAD(a.ventaId, 6,'0') AS 'codigoVentaId', a.tiendaId, b.nombre AS 'tienda', 
        a.vendedorId, CONCAT(c.nombre, ' ', c.apellido_paterno) AS 'vendedor', 
        a.clienteId, CONCAT(d.nombres, ' ', d.apellido_paterno) AS 'cliente', 
        a.estadoId, e.nombre AS 'estado', a.observaciones, a.created_at AS 'fechaCreacion', a.created_at AS 'fecha',
        a.fechaRegistro, a.etapaId, a.tipoOperacionId AS 'tipoId',
        a.fechaSalidaProgramada, a.fechaSalida AS 'fechaSalida', 
        a.fechaDevolucionProgramada, a.fechaDevolucion,	
        a.precioTotal, a.totalEfectivo, a.totalTarjeta, a.totalVuelto, a.totalPagado, a.totalSaldo, a.totalGarantia, a.dejoDocumento, a.dejoRecibo, a.anulado
        FROM tbl_venta a
        INNER JOIN tbl_tienda b ON b.id = a.tiendaId
        INNER JOIN tbl_usuario c ON c.usuario_id = a.vendedorId
        INNER JOIN tbl_cliente d ON d.clienteId = a.clienteId
        INNER JOIN tbl_venta_estado e ON e.id = a.estadoId
        WHERE a.ventaId = ? ";

        $ventaId = $this->db->escape_str($ventaId);
        $query = $this->db->query($sql, array($ventaId));
        $reserva = $query->result();
        $reserva = $reserva[0];

        // Venta Detalle
        $sql2 = "SELECT a.id, a.ventaId, a.articuloId, b.code AS 'articuloCode', b.code AS 'codigo',
        b.nombre AS 'articuloNombre', b.descripcion AS 'articuloDescripcion', 
        CASE WHEN b.code = 'GEN00000001' THEN IFNULL(a.descripcion, '') ELSE b.nombre END AS 'nombre',
        IFNULL(a.descripcion, '') AS 'descripcion',
        a.precioVenta, a.precioVenta AS 'precio', c.estadoId, d.nombre AS 'estado', c.precio_alquiler AS 'precioAlquiler', c.precio_ultimo AS 'precioUltimo', e.Tipo AS 'tipo',
        a.cantidad, IFNULL(a.descripcion, '') AS 'descripcion_alternativa', b.categoriaId, e.nombre AS 'categoria'
        FROM tbl_venta_detalle a
        INNER JOIN tbl_articulo b ON b.articuloId = a.articuloId
        INNER JOIN tbl_articulo_resumen c ON c.articuloId = a.articuloId
        LEFT JOIN tbl_articulo_estado d ON d.id = c.estadoId
        INNER JOIN tbl_categoria e ON e.categoriaId = b.categoriaId
        WHERE a.ventaId = ?";
        $query2 = $this->db->query($sql2, array($ventaId));        
        $reserva->details = $query2->result();   
        
        // Venta Pago
        $sql3 = "SELECT a.id as 'pagoId', a.ventaId, a.tipoPagoId, b.descripcion AS 'tipoPago', a.ingreso, a.salida, a.nroTarjeta, 
            a.fechaRegistro AS 'fecha', a.usuarioId, UPPER(CONCAT(c.nombre, ' ', c.apellido_paterno)) AS 'usuario'
        FROM tbl_venta_pago a
        INNER JOIN tbl_tipo_pago b ON b.tipoPagoId = a.tipoPagoId
        INNER JOIN tbl_usuario c ON c.usuario_id = a.usuarioId
        WHERE a.ventaId = ? ";
        $query3 = $this->db->query($sql3, array($ventaId));        
        $reserva->payments = $query3->result(); 

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

    public function obtenerAlquileresCliente($dni) {

    }

    public function obtenerAlquiler($dni) {
        $dni = $this->db->escape_str($dni);

        $sql = "SELECT a.ventaId, LPAD(a.ventaId,6,'0') AS 'codigoVentaId', a.tiendaId, b.nombre AS 'tienda', 
        a.vendedorId, CONCAT(c.nombre, ' ', c.apellido_paterno) AS 'vendedor', 
        a.clienteId, CONCAT(d.nombres, ' ', d.apellido_paterno, ' ', d.apellido_materno) AS 'cliente', 
        a.precioTotal, a.totalSaldo,
        a.fechaSalidaProgramada, a.fechaDevolucionProgramada
        FROM tbl_venta a
        INNER JOIN tbl_tienda b ON b.id = a.tiendaId
        INNER JOIN tbl_usuario c ON c.usuario_id = a.vendedorId
        INNER JOIN tbl_cliente d ON d.clienteId = a.clienteId
        WHERE a.tipoOperacionId = 1
        AND a.estadoId = 2
        AND d.nro_documento = ?";
        
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


    public function obtenerResumenLiquidacion($fecha, $tiendaId) {
        try {
            $sql = "SELECT b.usuarioId AS 'usuarioId', UPPER(CONCAT(c.nombre,' ',c.apellido_paterno)) AS 'usuario', COUNT(*) AS 'cantidad',
            SUM(CASE WHEN b.tipoPagoId = 1 THEN ingreso - salida ELSE 0 END) AS 'efectivo',
            SUM(CASE WHEN b.tipoPagoId = 2 THEN ingreso - salida ELSE 0 END) AS 'tarjeta'
            FROM tbl_venta a
            INNER JOIN tbl_venta_pago b ON b.ventaId = a.ventaId
            INNER JOIN tbl_usuario c ON c.usuario_id = b.usuarioId
            WHERE DATE_FORMAT(b.created_at, '%Y%m%d') = ?
            AND a.tiendaId = ?
            GROUP BY b.usuarioId, c.nombre, c.apellido_paterno";
        
            $fecha = $this->db->escape_str($fecha);
            $tiendaId = $this->db->escape_str($tiendaId);
            $params = array($fecha, $tiendaId);
            $result = $this->db->query($sql, $params);
            return $result->result();
        } catch (\Exception $ex) {
            return FALSE;
        }        
    }
    
    public function obtenerDetalleLiquidacion($fechaDesde, $fechaHasta, $tiendaId) {
        try {
            // $sql = "SELECT LPAD(a.ventaId,6,'0') AS 'ventaId', IFNULL(a.numeroComprobante,'') AS 'nroOperacion', a.clienteId, c.nro_documento AS 'clienteNro', 
            // UPPER(CONCAT(c.nombres, ' ', c.apellido_paterno)) AS 'cliente', b.usuarioId, 
            // UPPER(CONCAT(d.nombre, ' ', d.apellido_paterno)) AS 'usuario', 
            // DATE_FORMAT(b.created_at, '%d/%m/%Y %H:%i') AS 'fechaHora1', 
            // DATE_FORMAT(MAX(b.fechaRegistro), '%d/%m/%Y %H:%i') AS 'fechaHora', 
            // b.tipoPagoId, a.precioTotal AS 'importeTotal',
            // SUM(CASE WHEN b.tipoPagoId IN (1, 4) THEN b.ingreso - b.salida ELSE 0 END) AS 'efectivo',
            // SUM(CASE WHEN b.tipoPagoId NOT IN (1, 4) THEN b.ingreso - b.salida ELSE 0 END) AS 'tarjeta'
            // FROM tbl_venta a
            // INNER JOIN tbl_venta_pago b ON b.ventaId = a.ventaId
            // INNER JOIN tbl_cliente c ON c.clienteId = a.clienteId
            // INNER JOIN tbl_usuario d ON d.usuario_id = b.usuarioId
            // WHERE DATE_FORMAT(b.fechaRegistro, '%Y%m%d') BETWEEN ? AND ?
            // AND a.tiendaId = ?
            // AND a.anulado = 0
            // GROUP BY a.ventaId, a.clienteId, c.nombres, c.apellido_paterno, b.usuarioId, d.nombre, d.apellido_paterno
            // ORDER BY b.created_at";

            $sql="SELECT LPAD(a.ventaId,6,'0') AS 'ventaId', IFNULL(a.numeroComprobante,'') AS 'nroOperacion', a.clienteId, c.nro_documento AS 'clienteNro', 
            UPPER(CONCAT(c.nombres, ' ', c.apellido_paterno)) AS 'cliente', b.usuarioId, 
            UPPER(CONCAT(d.nombre, ' ', d.apellido_paterno)) AS 'usuario', 
            DATE_FORMAT(b.created_at, '%d/%m/%Y %H:%i') AS 'fechaHora1', 
            DATE_FORMAT(MAX(b.fechaRegistro), '%d/%m/%Y %H:%i') AS 'fechaHora', 
            b.tipoPagoId, a.precioTotal AS 'importeTotal',
            SUM(CASE WHEN b.tipoPagoId IN (1, 4) THEN b.ingreso - b.salida ELSE 0 END) AS 'efectivo',
            SUM(CASE WHEN b.tipoPagoId NOT IN (1, 4) THEN b.ingreso - b.salida ELSE 0 END) AS 'tarjeta'
            FROM tbl_venta a
            INNER JOIN tbl_venta_pago b ON b.ventaId = a.ventaId
            INNER JOIN tbl_cliente c ON c.clienteId = a.clienteId
            INNER JOIN tbl_usuario d ON d.usuario_id = b.usuarioId
            WHERE DATE_FORMAT(b.fechaRegistro, '%Y%m%d') BETWEEN ? AND ?
            AND a.tiendaId = ?
            AND a.anulado = 0
            GROUP BY a.ventaId, a.numeroComprobante, a.clienteId, c.nro_documento, c.nombres, c.apellido_paterno, b.usuarioId, d.nombre, d.apellido_paterno, b.created_at, b.tipoPagoId, a.precioTotal
            ORDER BY b.created_at";

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

    public function listarAnulados($tiendaId, $fechaDesde, $fechaHasta) {
        try {
            $sql = "SELECT a.ventaId, IFNULL(b.numeroComprobante, '') AS 'nroOperacion', b.clienteId, 
            CONCAT(c.nombres, ' ', c.apellido_paterno, ' ', c.apellido_materno) AS 'cliente', 
            DATE_FORMAT(a.created_at, '%Y/%m/%d %h%:%m') AS 'fechaAnulacion', a.usuarioId_created AS 'usuarioIdAnulacion',
            CONCAT(d.nombre, ' ', d.apellido_paterno) AS 'usuarioAnulacion', a.observacion AS 'motivo', b.precioTotal AS 'importe'
            FROM tbl_venta_anulada a
            INNER JOIN tbl_venta b ON b.ventaId = a.ventaId
            LEFT JOIN tbl_cliente c ON c.clienteId = b.clienteId
            LEFT JOIN tbl_usuario d ON d.usuario_id = a.usuarioId_created
            WHERE b.tiendaId = ?
            AND DATE_FORMAT(a.created_at, '%Y%m%d') BETWEEN ? AND ?";

            $tiendaId = $this->db->escape_str($tiendaId);
            $fechaDesde = $this->db->escape_str($fechaDesde);
            $fechaHasta = $this->db->escape_str($fechaHasta);

            $params = array($tiendaId, $fechaDesde, $fechaHasta);
            $result = $this->db->query($sql, $params);
            return $result->result();
        } catch(\Exception $ex) {
            return FALSE;
        }
        
    }
}