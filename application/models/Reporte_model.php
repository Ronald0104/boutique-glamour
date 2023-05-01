<?php
defined('BASEPATH')OR exit('No direct script access allowed'); 

class Reporte_model extends CI_Model {

    // Los querys los tendre en otro archivo para un mejor control
    public function reporteFlujoCaja($tiendaId, $fechaDesde, $fechaHasta, $mostrarSaldoInicial) {
        /*
        $sql = "SELECT a.fechaRegistro, a.ventaId, 'INGRESO' AS 'tipo', 
        CASE WHEN a.estadoId IN (1, 2, 3) THEN 'ALQUILER' WHEN estadoId = 4 THEN 'VENTA' END AS 'descripcion',
        a.precioTotal AS 'total', a.totalPagado, @saldoAcumulado := @saldoAcumulado + a.totalPagado AS 'saldo'
        FROM tbl_venta a
        CROSS JOIN (SELECT @saldoAnterior :=0, @saldoAcumulado := 0) a
        WHERE DATE_FORMAT(a.fechaRegistro, '%Y%m%d') BETWEEN '20190601' AND '20190631'
        AND tiendaId = ?
        AND estadoId NOT IN (5)
        ORDER BY fechaRegistro ASC, ventaId ASC";
        */
        
        $sql = "SELECT DATE_FORMAT(X.fecha, '%d-%m-%Y %H:%i') AS 'fecha', CASE WHEN X.tipo = 'INGRESO' THEN LPAD(X.operacionId,6,'0') ELSE X.operacionId END AS 'operacionId', X.nroOperacion, X.tipo, X.descripcion, X.monto, @saldoAcumulado := @saldoAcumulado + CASE WHEN X.tipo = 'INGRESO' THEN 1 ELSE 1 END * IFNULL(X.monto, 0) AS 'saldoFinal'
        FROM (
        SELECT CONVERT(?, DATE) AS 'fecha', '000000' AS 'operacionId', '000000' AS 'nroOperacion', 'SALDO INICIAL' AS 'tipo',
            'SALDO INICIAL' AS 'descripcion', SUM(a.ingreso)-SUM(a.salida) AS 'monto', SUM(a.ingreso)-SUM(a.salida) AS 'saldo'
        FROM tbl_venta_pago a
        INNER JOIN tbl_venta b ON b.ventaId = a.ventaId
        WHERE DATE_FORMAT(a.fechaRegistro, '%Y%m%d')<?
        AND b.tiendaId = ?
        AND 1 = ?
        UNION ALL 
        SELECT fecha AS 'fecha', '000001' AS 'operacionId', '000001' AS 'nroOperacion', 'OTROS INGRESOS' AS 'tipo', descripcion, importe AS 'monto', importe AS 'saldo' 
        FROM tbl_ingreso 
        WHERE DATE_FORMAT(fecha, '%Y%m%d') BETWEEN ? AND ?
        AND tiendaId = ?
        UNION ALL 
        SELECT b.fechaRegistro, a.ventaId, a.numeroComprobante AS 'nroOperacion', 'INGRESO' AS 'tipo', 
        CASE WHEN a.estadoId IN (1, 2, 3) THEN 'ALQUILER' WHEN a.estadoId = 4 THEN 'VENTA' END AS 'descripcion',
        b.monto AS 'pagado', 0 AS saldo
        FROM tbl_venta a
        LEFT JOIN (
            SELECT ventaId, fechaRegistro, SUM(ingreso) - SUM(salida) AS 'monto'
            FROM tbl_venta_pago 
            GROUP BY ventaId, fechaRegistro	
        ) b ON b.ventaId = a.ventaId
        WHERE DATE_FORMAT(b.fechaRegistro, '%Y%m%d') BETWEEN ? AND ?
        AND a.estadoId NOT IN (5)
        AND a.tiendaId = ?
        UNION ALL
        SELECT a.fecha_documento, a.compraId, a.code as 'nroOperacion', 'EGRESO' AS 'tipo', a.descripcion, b.monto * -1 AS 'pagado', 0 AS 'saldo'
        FROM tbl_compra a
        LEFT JOIN tbl_compra_distribucion b ON b.compraId = a.compraId AND b.monto > 0
        WHERE a.anulado = 0
        AND DATE_FORMAT(a.fecha_documento, '%Y%m%d') BETWEEN ? AND ?
        AND b.tiendaId = ?
        ) X
        CROSS JOIN (SELECT @saldoAnterior :=0, @saldoAcumulado := 0) Y
        ORDER BY X.fecha ASC, X.operacionId ASC";

        $fechaAnterior = clone $fechaDesde;
        $interval = new DateInterval('P1D'); $interval->invert = 1;
        $fechaAnterior->add($interval);    

        $tiendaId = $this->db->escape_str($tiendaId);
        $mostrarSaldoInicial = $this->db->escape_str($mostrarSaldoInicial);
        $params = [
            $fechaAnterior->format('Y-m-d'),
            $fechaDesde->format('Ymd'),
            $tiendaId,
            $mostrarSaldoInicial,
            $fechaDesde->format('Ymd'),
            $fechaHasta->format('Ymd'),
            $tiendaId, 
            $fechaDesde->format('Ymd'),
            $fechaHasta->format('Ymd'),
            $tiendaId, 
            $fechaDesde->format('Ymd'),
            $fechaHasta->format('Ymd'),
            $tiendaId
        ];
        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function reportePendienteDevolucion($tiendas, $diasVencidos)
    {
        $tiendas = $this->db->escape_str($tiendas);
        $diasVencidos = $this->db->escape_str($diasVencidos);

        $sql = "SELECT a.clienteId, c.nro_documento, UPPER(CONCAT(RTRIM(c.apellido_paterno), ' ', RTRIM(c.apellido_materno), ', ', c.nombres)) AS 'cliente', c.telefono, 
        a.ventaId, LPAD(a.ventaId, 6, '0') AS 'ventaCode0', IFNULL(a.numeroComprobante,'') AS 'ventaCode', a.tiendaId, d.nombre AS 'tienda', DATE_FORMAT(a.fechaSalida, '%d/%m/%Y')  AS 'fechaSalida',
        DATE_FORMAT(a.fechaDevolucionProgramada, '%d/%m/%Y') AS 'fechaDevolucionProg', 
        DATEDIFF(CURDATE(), CONVERT(a.fechaDevolucionProgramada, DATE)) AS 'diasVencidos'
        FROM tbl_venta a
        INNER JOIN tbl_cliente c ON c.clienteId = a.clienteId
        INNER JOIN tbl_tienda d ON d.id = a.tiendaId
        WHERE a.tipoOperacionId = 1
        AND a.estadoId = 2
        AND a.tiendaId IN (" . $tiendas . ")";
        if ($diasVencidos > 0) {
            $sql.="AND DATEDIFF(CURDATE(), CONVERT(a.fechaDevolucionProgramada, DATE)) > ?";
            $params = [$diasVencidos];
        } else {
            $params = [];
        }
        $sql.="ORDER BY diasVencidos DESC";    
        
        // $params = [$tiendas, $diasVencidos];
        
        $query = $this->db->query($sql, $params);
        return $query->result();
    }

    public function ReporteReservas($tiendas, $fechaDesde, $fechaHasta, $diasFaltantes, $mostrarDetallado) {
        $tiendas = $this->db->escape_str($tiendas);
        // $fechaDesde = $this->db->escape_str($fechaDesde);
        // $fechaHasta = $this->db->escape_str($fechaHasta);
        $diasFaltantes = $this->db->escape_str($diasFaltantes);

        $sql = "SELECT a.clienteId, c.nro_documento, UPPER(CONCAT(RTRIM(c.apellido_paterno), ' ', RTRIM(c.apellido_materno), ', ', c.nombres)) AS 'cliente', c.telefono, 
        a.ventaId, LPAD(a.ventaId, 6, '0') AS 'ventaCode0', a.numeroComprobante AS 'ventaCode', a.tiendaId, d.nombre AS 'tienda', 
        DATE_FORMAT(a.fechaRegistro, '%d/%m/%Y')  AS 'fechaRegistro',
        DATE_FORMAT(a.fechaSalidaProgramada, '%d/%m/%Y')  AS 'fechaReserva',
        DATEDIFF(CONVERT(a.fechaSalidaProgramada, DATE), CURDATE()) AS 'diasReserva',
        CONCAT(ABS(DATEDIFF(CONVERT(a.fechaSalidaProgramada, DATE), CURDATE())), CASE WHEN DATEDIFF(CONVERT(a.fechaSalidaProgramada, DATE), CURDATE()) < 0 THEN ' DIA(S) VENCIDOS' ELSE 'DIA(S) FALTANTES' END) AS 'diasReservaDescri'";

        if ($mostrarDetallado == 1) {
            $sql.=", f.code, CASE WHEN f.code = 'GEN00000001' THEN e.descripcion ELSE f.nombre END AS 'nombreArticulo'";
        }
        
        $sql.=" FROM tbl_venta a
        INNER JOIN tbl_cliente c ON c.clienteId = a.clienteId
        INNER JOIN tbl_tienda d ON d.id = a.tiendaId";

        if ($mostrarDetallado == 1){
            $sql.=" LEFT JOIN tbl_venta_detalle e ON e.ventaId = a.ventaId
                LEFT JOIN tbl_articulo f ON f.articuloId = e.articuloId";
        }
        
        $sql.=" WHERE a.tipoOperacionId = 1
        AND a.estadoId = 1
        AND a.tiendaId IN (" . $tiendas . ")";

        $sql.=" AND DATE_FORMAT(a.fechaSalidaProgramada, '%Y%m%d') BETWEEN ? AND ?";
        #AND DATEDIFF(CONVERT(a.fechaSalidaProgramada, DATE), CURDATE()) > 0
        $sql.=" ORDER BY diasReserva, ventaCode ASC";

        // $params = [$diasFaltantes];
        $params = [ $fechaDesde->format('Ymd'), $fechaHasta->format('Ymd')];
        $query = $this->db->query($sql, $params);
        return $query->result();        
    }

    public function ReporteSaldosPendientes($tiendas, $fechaDesde, $fechaHasta) {
        $tiendas = $this->db->escape_str($tiendas);
        // $fechaDesde = $this->db->escape_str($fechaDesde);
        // $fechaHasta = $this->db->escape_str($fechaHasta);
        // $diasFaltantes = $this->db->escape_str($diasFaltantes);

        $sql = "SELECT a.ventaId, LPAD(a.ventaId, 6, '0') AS 'codigo', a.tipoOperacionId, b.nombre AS 'tipoOperacion', 
            a.clienteId, d.nro_documento AS 'nroDocumento',	d.telefono, a.estadoId, e.nombre AS 'estado',
            UPPER(CONCAT(d.apellido_paterno, ' ', d.apellido_materno, ', ', d.nombres)) AS 'cliente',
            a.vendedorId, UPPER(CONCAT(c.apellido_paterno, ' ', c.apellido_materno, ', ', c.nombre)) AS 'vendedor',
            DATE_FORMAT(a.fechaRegistro, '%d/%m/%Y') AS 'fechaRegistro', 
            DATE_FORMAT(IFNULL(a.fechaSalida, a.fechaSalidaProgramada), '%d/%m/%Y') AS 'fechaSalida', 
            DATE_FORMAT(IFNULL(a.fechaDevolucion, a.fechaDevolucionProgramada), '%d/%m/%Y') AS 'fechaDevolucion',
            a.tiendaId, f.nombre AS 'tienda', a.precioTotal, a.totalSaldo
        FROM tbl_venta a
        INNER JOIN tbl_venta_tipo_operacion b ON b.id = a.tipoOperacionId
        INNER JOIN tbl_usuario c ON c.usuario_id = a.vendedorId
        INNER JOIN tbl_cliente d ON d.clienteId = a.clienteId
        LEFT JOIN tbl_venta_estado e ON e.id = a.estadoId
        INNER JOIN tbl_tienda f ON f.id = a.tiendaId
        WHERE a.anulado = 0
        AND a.totalSaldo > 0
        AND DATE_FORMAT(IFNULL(a.fechaSalida, a.fechaSalidaProgramada), '%Y%m%d') BETWEEN ? AND ? 
        AND a.tiendaId IN (" . $tiendas . ")";
        // $sql.=" AND DATE_FORMAT(a.fechaRegistro, '%Y%m%d') BETWEEN ? AND ?";    
        $sql.=" ORDER BY a.fechaRegistro";

        // $params = [$diasFaltantes];
        $params = [$fechaDesde->format('Ymd'), $fechaHasta->format('Ymd')];
        $query = $this->db->query($sql, $params);
        return $query->result();    
    }

    public function ReportePrendasDisponibles($categoriaId, $fechaDesde, $fechaHasta, $tallas, $colores, $disenos, $condicion) {
        if ($categoriaId == 1) $categoriaId = "2,3";
        if ($categoriaId == 4) $categoriaId = "5,6,7";

        $interval = new DateInterval("P1D"); $interval->invert = 1;
        $fechaDesde->add($interval);
        $fechaHasta->add(new DateInterval('P1D'));

        // NO CONSIDERAR LOS ARTICULOS RESERVADOS O ALQUILADOS        
        $sql0 = "SELECT x.articuloId
        FROM tbl_venta_detalle x
        INNER JOIN tbl_venta y ON y.ventaId = x.ventaId
        WHERE y.anulado = 0 AND y.tipoOperacionId = 1
        AND y.estadoId NOT IN (4, 5)	-- NO VENDIDOS NI DE BAJA
        AND y.estadoId IN (1)	        -- RESERVAS
        AND (
            (CONVERT(y.fechaSalidaProgramada, DATE)<=CONVERT('".$fechaDesde->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)>=CONVERT('".$fechaDesde->format('Ymd')."',DATE)) OR
            (CONVERT(y.fechaSalidaProgramada, DATE)<=CONVERT('".$fechaHasta->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)>=CONVERT('".$fechaHasta->format('Ymd')."',DATE)) OR            
            (CONVERT(y.fechaSalidaProgramada, DATE)>=CONVERT('".$fechaDesde->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)<=CONVERT('".$fechaHasta->format('Ymd')."',DATE)) OR
            (CONVERT(y.fechaSalidaProgramada, DATE)<=CONVERT('".$fechaDesde->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)>=CONVERT('".$fechaHasta->format('Ymd')."',DATE))
        )
        UNION
        SELECT x.articuloId
        FROM tbl_venta_detalle x
        INNER JOIN tbl_venta y ON y.ventaId = x.ventaId
        WHERE y.anulado = 0 AND y.tipoOperacionId = 1
        AND y.estadoId NOT IN (4, 5)	-- NO VENDIDOS NI DE BAJA
        AND y.estadoId IN (2)	        -- ALQUILADOS
        AND (
            (CONVERT(y.fechaSalida, DATE)<=CONVERT('".$fechaDesde->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)>=CONVERT('".$fechaDesde->format('Ymd')."',DATE)) OR
            (CONVERT(y.fechaSalida, DATE)<=CONVERT('".$fechaHasta->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)>=CONVERT('".$fechaHasta->format('Ymd')."',DATE)) OR   
            (CONVERT(y.fechaSalida, DATE)>=CONVERT('".$fechaDesde->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)<=CONVERT('".$fechaHasta->format('Ymd')."',DATE)) OR
            (CONVERT(y.fechaSalida, DATE)<=CONVERT('".$fechaDesde->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)>=CONVERT('".$fechaHasta->format('Ymd')."',DATE))
        )";

        $query0 = $this->db->query($sql0);
        $items = $query0->result();  
        $codigos = [];    
        foreach ($items as $key) {
            $codigos[] = $key->articuloId;
        }
        if (count($codigos)>0) {
            $codigos = str_replace("\"", "",implode(",", $codigos));            
        } else {
            $codigos = 0;
        }

        $sql = "SELECT a.articuloId, a.code, a.nombre, a.categoriaId, c.nombre AS 'categoria', a.condicion, b.tallaId, d1.nombre AS 'talla',
        b.colorId, d2.nombre AS 'color', b.disenoId, d3.nombre AS 'diseno', b.estadoId, e.nombre AS 'estado'
        FROM tbl_articulo a
        LEFT JOIN tbl_articulo_resumen b ON b.articuloId = a.articuloId
        LEFT JOIN tbl_categoria c ON c.categoriaId = a.categoriaId
        LEFT JOIN tbl_articulo_talla_categoria d1 ON d1.id = b.tallaId
        LEFT JOIN tbl_articulo_color_categoria d2 ON d2.id = b.colorId
        LEFT JOIN tbl_articulo_diseno_categoria d3 ON d3.id = b.disenoId
        LEFT JOIN tbl_articulo_estado e ON e.id = b.estadoId
        WHERE b.estadoId NOT IN (4, 5) ";

        $sql .= "AND a.categoriaId IN (".$categoriaId.") ";
        if ($tallas <> 0) {        
            $sql .= "AND IFNULL(b.tallaId,0) IN (".$tallas.") ";
        }
        if ($colores <> 0) {
            $sql .= "AND IFNULL(b.colorId, 0) IN (".$colores.") ";
        }
        if ($disenos <> 0) {
            $sql .= "AND IFNULL(b.disenoId,0) IN (".$disenos.") ";
        }
        if ($codigos <> 0) {
            $sql .= "AND a.articuloId NOT IN (".$codigos.") ";
        }
        // if ($condicion <> "0") {
        // $sql .= "AND a.condicion = '".$condicion."'";
        $sql .= "AND a.condicion = CASE WHEN '".$condicion."'='TODOS' THEN a.condicion ELSE '".$condicion."' END";
        // }
        
        // NO CONSIDERAR LOS ARTICULOS RESERVADOS O ALQUILADOS
        /* RESERVAS PARA UNA FECHA*/
        /*
        $sql .= "AND a.articuloId NOT IN (	    
        SELECT x.articuloId
        FROM tbl_venta_detalle x
        INNER JOIN tbl_venta y ON y.ventaId = x.ventaId
        WHERE y.anulado = 0 AND y.tipoOperacionId = 1
        AND y.estadoID NOT IN (4)	-- NO VENDIDOS
        AND y.estadoId IN (1)	    -- RESERVAS
        AND (
            (CONVERT(y.fechaSalidaProgramada, DATE)<=CONVERT('".$fechaDesde->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)>=CONVERT('".$fechaDesde->format('Ymd')."',DATE)) OR
            (CONVERT(y.fechaSalidaProgramada, DATE)<=CONVERT('".$fechaHasta->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)>=CONVERT('".$fechaHasta->format('Ymd')."',DATE)) OR            
            (CONVERT(y.fechaSalidaProgramada, DATE)>=CONVERT('".$fechaDesde->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)<=CONVERT('".$fechaHasta->format('Ymd')."',DATE)) OR
            (CONVERT(y.fechaSalidaProgramada, DATE)<=CONVERT('".$fechaDesde->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)>=CONVERT('".$fechaHasta->format('Ymd')."',DATE))
	    )
        UNION
        SELECT x.articuloId
        FROM tbl_venta_detalle x
        INNER JOIN tbl_venta y ON y.ventaId = x.ventaId
        WHERE y.anulado = 0 AND y.tipoOperacionId = 1
        AND y.estadoID NOT IN (4)	-- NO VENDIDOS
        AND y.estadoId IN (2)	    -- ALQUILADOS
        AND (
            (CONVERT(y.fechaSalida, DATE)<=CONVERT('".$fechaDesde->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)>=CONVERT('".$fechaDesde->format('Ymd')."',DATE)) OR
            (CONVERT(y.fechaSalida, DATE)<=CONVERT('".$fechaHasta->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)>=CONVERT('".$fechaHasta->format('Ymd')."',DATE)) OR   
            (CONVERT(y.fechaSalida, DATE)>=CONVERT('".$fechaDesde->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)<=CONVERT('".$fechaHasta->format('Ymd')."',DATE)) OR
            (CONVERT(y.fechaSalida, DATE)<=CONVERT('".$fechaDesde->format('Ymd')."',DATE) AND CONVERT(y.fechaDevolucionProgramada, DATE)>=CONVERT('".$fechaHasta->format('Ymd')."',DATE))
        )
        )";
        */

        $query = $this->db->query($sql);
        return $query->result();   
    }

    public function ReporteTopClientes($cantidadMostrar, $fechaDesde, $fechaHasta) {
        // $tiendas = $this->db->escape_str($tiendas);
        // $fechaDesde = $this->db->escape_str($fechaDesde);
        // $fechaHasta = $this->db->escape_str($fechaHasta);
        // $diasFaltantes = $this->db->escape_str($diasFaltantes);

        $sql = "SELECT a.clienteId, b.nro_documento AS 'nroDocumento', CONCAT(b.nombres, ' ', b.apellido_paterno) AS 'nombresApellidos', 
            SUM(c.ingreso) - SUM(c.salida) AS 'total', COUNT(DISTINCT a.ventaId) AS 'cantidad', DATE_FORMAT(MAX(a.fechaRegistro), '%d/%m/%Y %H:%m') AS 'fechaUltimaCompra'
        FROM tbl_venta a
        INNER JOIN tbl_cliente b ON b.clienteId = a.clienteId
        LEFT JOIN tbl_venta_pago c ON c.ventaId = a.ventaId
        WHERE DATE_FORMAT(a.fechaRegistro, '%Y%m%d') BETWEEN ? AND ?
        AND a.anulado = 0
        GROUP BY a.clienteId, b.nro_documento, b.nombres, b.apellido_paterno
        ORDER BY 4 DESC
        LIMIT 0, $cantidadMostrar";

        // $sql = "SELECT a.ventaId, LPAD(a.ventaId, 6, '0') AS 'codigo', a.tipoOperacionId, b.nombre AS 'tipoOperacion', 
        //     a.clienteId, d.nro_documento AS 'nroDocumento',	d.telefono, a.estadoId, e.nombre AS 'estado',
        //     UPPER(CONCAT(d.apellido_paterno, ' ', d.apellido_materno, ', ', d.nombres)) AS 'cliente',
        //     a.vendedorId, UPPER(CONCAT(c.apellido_paterno, ' ', c.apellido_materno, ', ', c.nombre)) AS 'vendedor',
        //     DATE_FORMAT(a.fechaRegistro, '%d/%m/%Y') AS 'fechaRegistro', 
        //     DATE_FORMAT(IFNULL(a.fechaSalida, a.fechaSalidaProgramada), '%d/%m/%Y') AS 'fechaSalida', 
        //     DATE_FORMAT(IFNULL(a.fechaDevolucion, a.fechaDevolucionProgramada), '%d/%m/%Y') AS 'fechaDevolucion',
        //     a.tiendaId, f.nombre AS 'tienda', a.precioTotal, a.totalSaldo
        // FROM tbl_venta a
        // INNER JOIN tbl_venta_tipo_operacion b ON b.id = a.tipoOperacionId
        // INNER JOIN tbl_usuario c ON c.usuario_id = a.vendedorId
        // INNER JOIN tbl_cliente d ON d.clienteId = a.clienteId
        // LEFT JOIN tbl_venta_estado e ON e.id = a.estadoId
        // INNER JOIN tbl_tienda f ON f.id = a.tiendaId
        // WHERE a.anulado = 0
        // AND a.totalSaldo > 0
        // AND DATE_FORMAT(IFNULL(a.fechaSalida, a.fechaSalidaProgramada), '%Y%m%d') BETWEEN ? AND ? 
        // AND a.tiendaId IN (" . $tiendas . ")";
        // // $sql.=" AND DATE_FORMAT(a.fechaRegistro, '%Y%m%d') BETWEEN ? AND ?";    
        // $sql.=" ORDER BY a.fechaRegistro";

        // $params = [$diasFaltantes];
        $params = [$fechaDesde->format('Ymd'), $fechaHasta->format('Ymd')];
        $query = $this->db->query($sql, $params);
        return $query->result();   
    }

    public function ReporteTopProductos($cantidadMostrar, $fechaDesde, $fechaHasta, $categoriaId, $tallas = 0, $colores = 0, $disenos = 0) {
        if ($categoriaId == 1) $categoriaId = "2,3";
        if ($categoriaId == 4) $categoriaId = "5,6,7";

        $sql = "SELECT @rownum := @rownum + 1 AS 'item', BS.* FROM (
            SELECT #@rownum := @rownum + 1 AS 'item', 
            a.articuloId, b.code, b.nombre AS 'nombreArticulo', #a.ventaId, a.importeTotal, 
            CONCAT(g2.nombre, '/', g1.nombre, '/', g3.nombre) AS 'caracteristicas',
            b.categoriaId, d.nombre AS 'categoria', e.precio_compra, e.precio_venta, e.precio_alquiler,
            e.estadoId, f.nombre AS 'estado',
            SUM(a.importeTotal) AS 'total', COUNT(DISTINCT c.ventaId) AS 'cantidad'
            FROM tbl_venta_detalle a
            INNER JOIN tbl_articulo b ON b.articuloId = a.articuloId
            INNER JOIN tbl_venta c ON c.ventaId = a.ventaId
            INNER JOIN tbl_categoria d ON d.categoriaId = b.categoriaId
            LEFT JOIN tbl_articulo_resumen e ON e.articuloId = b.articuloId
            LEFT JOIN tbl_articulo_estado f ON f.id = e.estadoId
            LEFT JOIN tbl_articulo_talla_categoria g1 ON g1.id = e.tallaId
            LEFT JOIN tbl_articulo_color_categoria g2 ON g2.id = e.colorId
            LEFT JOIN tbl_articulo_diseno_categoria g3 ON g3.id = e.disenoId
            WHERE c.anulado = 0 ";

        if ($categoriaId<>"0") {
            $sql.= "AND d.categoriaId IN (".$categoriaId.") ";
        }      
        if ($tallas <> 0) {        
            $sql .= "AND IFNULL(e.tallaId,0) IN (".$tallas.") ";
        }
        if ($colores <> 0) {
            $sql .= "AND IFNULL(e.colorId, 0) IN (".$colores.") ";
        }
        if ($disenos <> 0) {
            $sql .= "AND IFNULL(e.disenoId,0) IN (".$disenos.") ";
        }    
        $sql.="GROUP BY a.articuloId, b.code, b.nombre, b.categoriaId, d.nombre
            HAVING SUM(a.importeTotal)>0
            ORDER BY Total DESC ) AS BS, 
            (SELECT @rownum := 0) R
            LIMIT 0, $cantidadMostrar";

            //
            // $params = [$fechaDesde->format('Ymd'), $fechaHasta->format('Ymd')];
        $query = $this->db->query($sql);
        return $query->result();  
    }
}

?>