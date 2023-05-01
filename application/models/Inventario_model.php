<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario_model extends CI_Model 
{

    public function getListCategorias()
    {   
        $query = $this->db->get('tbl_categoria');
        return $query->result();        
    }

    public function getCategorias() {
        $query = $this->db->get_where('tbl_categoria', array('EsPadre'=>NULL));
        return $query->result(); 
    }

    public function getListCategoriaById($categoriaId)
    {
        $this->db->select('*');
        $this->db->where('categoriaId', $categoriaId);
        $query = $this->db->get('tbl_categoria');
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    public function listarTallasxCategoria($categoriaId) {
        if ($categoriaId == 2 || $categoriaId == 3) $categoriaId = 1;
        if ($categoriaId == 5 || $categoriaId == 6 || $categoriaId == 7) $categoriaId = 4;
        $categoriaId = $this->db->escape_str($categoriaId);
        $sql = "SELECT a.id, a.nombre, a.estado FROM tbl_articulo_talla_categoria a WHERE a.estado = 1 AND a.categoriaId = ? ORDER BY 2;";
        $query = $this->db->query($sql, [$categoriaId]);
        return $query->result();
    }

    public function listarColoresxCategoria($categoriaId) {
        if ($categoriaId == 2 || $categoriaId == 3) $categoriaId = 1;
        if ($categoriaId == 5 || $categoriaId == 6 || $categoriaId == 7) $categoriaId = 4;
        $categoriaId = $this->db->escape_str($categoriaId);
        $sql = "SELECT a.id, a.nombre, a.estado FROM tbl_articulo_color_categoria a WHERE a.estado = 1 AND a.categoriaId = ? ORDER BY 2;";
        $query = $this->db->query($sql, [$categoriaId]);
        return $query->result();
    }

    public function listarDisenosxCategoria($categoriaId) {
        if ($categoriaId == 2 || $categoriaId == 3) $categoriaId = 1;
        if ($categoriaId == 5 || $categoriaId == 6 || $categoriaId == 7) $categoriaId = 4;
        $categoriaId = $this->db->escape_str($categoriaId);
        $sql = "SELECT a.id, a.nombre, a.estado FROM tbl_articulo_diseno_categoria a WHERE a.estado = 1 AND a.categoriaId = ? ORDER BY 2;";
        $query = $this->db->query($sql, [$categoriaId]);
        return $query->result();
    }

    public function agregarTallaxCategoria($id, $nombre, $categoriaId, $estado){
        if ($id == 0){
            $this->db->insert('tbl_articulo_talla_categoria', ["nombre"=>$nombre, "categoriaId"=>$categoriaId, "estado"=>$estado]);
            return $this->db->insert_id();
        } else {
            $this->db->where('id', $id);
            $this->db->update('tbl_articulo_talla_categoria', ["nombre"=>$nombre, "categoriaId"=>$categoriaId, "estado"=>$estado]);
            return $id;
        }        
    }

    public function agregarColorxCategoria($id, $nombre, $categoriaId, $estado){
        if ($id == 0){
            $this->db->insert('tbl_articulo_color_categoria', ["nombre"=>$nombre, "categoriaId"=>$categoriaId, "estado"=>$estado]);
            return $this->db->insert_id();
        } else {
            $this->db->where('id', $id);
            $this->db->update('tbl_articulo_color_categoria', ["nombre"=>$nombre, "categoriaId"=>$categoriaId, "estado"=>$estado]);
            return $id;
        }        
    }

    public function agregarDisenoxCategoria($id, $nombre, $categoriaId, $estado){
        if ($id == 0){
            $this->db->insert('tbl_articulo_diseno_categoria', ["nombre"=>$nombre, "categoriaId"=>$categoriaId, "estado"=>$estado]);
            return $this->db->insert_id();
        } else {
            $this->db->where('id', $id);
            $this->db->update('tbl_articulo_diseno_categoria', ["nombre"=>$nombre, "categoriaId"=>$categoriaId, "estado"=>$estado]);
            return $id;
        }        
    }

    public function insert_categoria($categoria)
    {
        try{
            $this->db->insert('tbl_categoria', $categoria);
            return $this->db->insert_id();
        }
        catch(Exception $e) {
            $log = read_file('log_error.txt');
            $log .= "error al registrar tienda \n";
            write_file('log_error.txt', $log);            
            return FALSE;
        }
    }

    public function update_categoria($categoriaId, $categoria)
    {
        try {
            $this->db->where('categoriaId', $categoriaId);
            $this->db->update('tbl_categoria', $categoria);
            return TRUE;
        }
        catch(Exception $e) {            
            // $log = read_file('log_error.txt');
            // $log .= "error al actualizar categoria \n";
            // write_file('log_error.txt', $log);            
            return ['code' => 0, 'message' => $e->getMessage()];
        }
    }

    public function getCorrelativo($categoriaId)
    {
        try {            
            $this->db->select_max('code');
            $this->db->where('categoriaId', $categoriaId);
            $query = $this->db->get('tbl_articulo');
            return $query->result();
        }
        catch(Exception $e) {
            return ['code' => 0, 'message' => $e->getMessage()];
        }
    }

    public function getPrefijoCategoria($categoriaId)
    {
        try {
            $this->db->select('prefijo_code');
            $this->db->where('categoriaId', $categoriaId);
            $query = $this->db->get('tbl_categoria');
            return $query->result();
        }
        catch(Exception $e) {
            return ['code' => 0, 'message' => $e->getMessage()];
        }
    }

    public function existeArticulo($articuloCode)
    {
        $query = $this->db->get_where('tbl_articulo', ["code"=>$articuloCode]);
        if ($query->num_rows() == 0) 
            return FALSE;
        else
            return $query->result()[0];    
    }

    public function insert_articulo($articulo)
    {
        try{
            $this->db->insert('tbl_articulo', $articulo);
            return $this->db->insert_id();            
        }
        catch(Exception $e) {
            $log = read_file('log_error.txt');
            $log .= "error al registrar artículo \n";
            write_file('log_error.txt', $log);            
            return FALSE;
        }
    }

    public function update_articulo($articuloId, $articulo)
    {
        try {
            $this->db->where('articuloId', $articuloId);
            $this->db->update('tbl_articulo', $articulo);
            return TRUE;
        }
        catch(Exception $e) {            
            // $log = read_file('log_error.txt');
            // $log .= "error al actualizar categoria \n";
            // write_file('log_error.txt', $log);            
            return ['code' => 0, 'message' => $e->getMessage()];
        }
    }

    public function registrarArticulo($articulo)
    {
        try{
            $this->db->insert('tbl_articulo', $articulo);
            return $this->db->insert_id();            
        }
        catch(Exception $e) {
            $log = read_file('log_error.txt');
            $log .= "error al registrar artículo \n";
            write_file('log_error.txt', $log);            
            return FALSE;
        }
    }

    public function actualizarArticulo($articulo)
    {
        try {            
            $this->db->set('nombre', $articulo['nombre']);
            $this->db->set('code', $articulo['code']);
            $this->db->set('categoriaId', $articulo['categoriaId']);
            $this->db->set('marca', $articulo['marca']);
            $this->db->set('talla', $articulo['talla']);
            $this->db->set('color', $articulo['color']);
            $this->db->set('tela', $articulo['tela']);
            $this->db->set('modelo', $articulo['modelo']);
            $this->db->set('condicion', $articulo['condicion']);
            $this->db->set('tipo_prenda', $articulo['tipo_prenda']);
            $this->db->set('caracteristicas', $articulo['caracteristicas']);
            $this->db->set('estado', $articulo['estado']);
            $this->db->set('caracteristicas', $articulo['caracteristicas']);
            $this->db->set('updated_at', $articulo['updated_at']);
            $this->db->set('usuarioId_updated', $articulo['usuarioId_updated']);
            $this->db->where('articuloId', $articulo['articuloId']);
            $this->db->update('tbl_articulo');
            return TRUE;            
        } catch (\Exception $e) {
            return FALSE;
        }
    }

    public function existeArticuloResumen($articuloId)
    {
        $query = $this->db->get_where('tbl_articulo_resumen', ["articuloId"=>$articuloId]);
        if ($query->num_rows() == 0) 
            return FALSE;
        else
            return TRUE;    
    }

    public function insert_articulo_resumen($articulo_resumen) {
        try{
            $this->db->insert('tbl_articulo_resumen', $articulo_resumen);
            return $this->db->insert_id();            
        }
        catch(Exception $e) {
            $log = read_file('log_error.txt');
            $log .= "error al registrar artículo \n";
            write_file('log_error.txt', $log);            
            return FALSE;
        }
    }

    public function update_articulo_resumen2($articuloId, $articulo_resumen) {
        try {
            $this->db->where('articuloId', $articuloId);
            $this->db->update('tbl_articulo_resumen', $articulo_resumen);
            return TRUE;
        }
        catch(Exception $e) {            
            return FALSE; 
        }
    }

    public function update_articulo_resumen($articulo_resumen){
        $log = read_file('log_error.txt');
        try {
            $query = $this->db->get_where('tbl_articulo_resumen', ["articuloId"=>$articulo_resumen['articuloId']]);
            if ($query->num_rows() == 0) {
                $this->db->insert('tbl_articulo_resumen', $articulo_resumen);
                $log .= 'registrando el articulo' .$articulo_resumen['articuloId']. "\n";
                write_file('log_error.txt', $log);  
                return TRUE;
            } else {
                $this->db->set('estadoId', $articulo_resumen['estadoId']);
                $this->db->set('tienda_actual', $articulo_resumen['tienda_actual']);
                $this->db->where('articuloId',$articulo_resumen['articuloId']);
                $this->db->update('tbl_articulo_resumen');
                $log .= 'actualizando el articulo' .$articulo_resumen['articuloId']. "\n";
                write_file('log_error.txt', $log);  
                return TRUE;
            }                    
        } catch (\Exception $e) {
            // $log = read_file('log_error.txt');
            $log .= "error al registrar artículo \n";
            write_file('log_error.txt', $log);            
            return FALSE;
        }
    }

    public function actualizarArticuloResumen($articulo_resumen) {
        try {
            $this->db->set('precio_compra', $articulo_resumen['precio_compra']);
            $this->db->set('precio_alquiler', $articulo_resumen['precio_alquiler']);
            $this->db->set('precio_venta', $articulo_resumen['precio_venta']);
            $this->db->set('tienda_actual', $articulo_resumen['tienda_actual']);
            $this->db->set('fecha_compra', $articulo_resumen['fecha_compra']);
            $this->db->set('estadoId', $articulo_resumen['estadoId']);
            $this->db->set('tallaId', $articulo_resumen['tallaId']);
            $this->db->set('colorId', $articulo_resumen['colorId']);
            $this->db->set('disenoId', $articulo_resumen['disenoId']);
            $this->db->where('articuloId', $articulo_resumen['articuloId']);
            $this->db->update('tbl_articulo_resumen');
            return TRUE;
        } catch (\Exception $e) {
            return FALSE;
        }
    }

    public function obtenerId($articuloCode) {
        $this->db->select("articuloId");
        $query = $this->db->get_where('tbl_articulo', ["code"=>$articuloCode]);
        return $query->result()[0];
    }

    public function getArticuloById($articuloId)
    {
        try {            
            $this->db->select("tbl_articulo.articuloId, tbl_articulo.code as 'codigo', tbl_articulo.nombre, tbl_articulo.descripcion, tbl_articulo.categoriaId, tbl_categoria.nombre as 'categoria', tbl_articulo.unidadMedida, tbl_articulo.marca, tbl_articulo.modelo as 'diseno', tbl_articulo.talla, tbl_articulo.color, tbl_articulo.tela, tbl_articulo.caracteristicas, tbl_articulo.estado as 'activo', tbl_articulo.tipo_prenda as 'tipoPrenda', tbl_articulo.created_at as 'fechaCreacion', tbl_articulo_resumen.fecha_compra as 'fechaCompra', tbl_articulo_resumen.estadoId, tbl_articulo_estado.nombre as 'estado', tbl_articulo_resumen.precio_compra as 'precioCompra', tbl_articulo_resumen.precio_alquiler as 'precioAlquiler', tbl_articulo_resumen.precio_venta as 'precioVenta', tbl_articulo_resumen.precio_ultimo as 'precioUltimo', tbl_articulo_resumen.tienda_actual as 'tiendaId', tbl_tienda.nombre as 'tienda', tbl_categoria.Tipo as 'tipo', tbl_articulo.condicion, tbl_articulo_resumen.tallaId, tbl_articulo_resumen.colorId,
            tbl_articulo_resumen.disenoId");
            $this->db->from('tbl_articulo');
            $this->db->join('tbl_categoria', 'tbl_categoria.categoriaId = tbl_articulo.categoriaId');   
            $this->db->join('tbl_articulo_resumen', 'tbl_articulo_resumen.articuloId = tbl_articulo.articuloId', 'left');
            $this->db->join('tbl_articulo_estado', 'tbl_articulo_estado.id = tbl_articulo_resumen.estadoId', 'left');   
            $this->db->join('tbl_tienda', 'tbl_articulo_resumen.tienda_actual = tbl_tienda.id', 'left');
            $this->db->where('tbl_articulo.articuloId', $articuloId); 
            //$this->db->where('tbl_articulo.estado', 1);          
            $query = $this->db->get();

            if ($query->num_rows() == 0) {
                return FALSE;
            } else {
                return $query->result()[0];
            }
        } catch (\Exception $ex) {
            return FALSE;
        }        
    }
 
    public function getArticuloByCode($articuloCode)
    {
        try {
            $this->db->select("tbl_articulo.articuloId, tbl_articulo.code as 'codigo', tbl_articulo.nombre, tbl_articulo.descripcion, tbl_articulo.categoriaId, tbl_categoria.nombre as 'categoria', tbl_articulo.unidadMedida, tbl_articulo.marca, tbl_articulo.modelo as 'diseno', tbl_articulo.talla, tbl_articulo.color, tbl_articulo.tela, tbl_articulo.caracteristicas, tbl_articulo.estado as 'activo', tbl_articulo.tipo_prenda as 'tipoPrenda', tbl_articulo.created_at as 'fechaCreacion', tbl_articulo_resumen.fecha_compra as 'fechaCompra', tbl_articulo_resumen.estadoId, tbl_articulo_estado.nombre as 'estado', tbl_articulo_resumen.precio_compra as 'precioCompra', tbl_articulo_resumen.precio_alquiler as 'precioAlquiler', tbl_articulo_resumen.precio_venta as 'precioVenta', tbl_articulo_resumen.precio_ultimo as 'precioUltimo', tbl_articulo_resumen.tienda_actual as 'tiendaId', tbl_tienda.nombre as 'tienda', tbl_categoria.Tipo as 'tipo', tbl_articulo.condicion, tbl_articulo_resumen.tallaId, tbl_articulo_resumen.colorId,
            tbl_articulo_resumen.disenoId");
            $this->db->from('tbl_articulo');
            $this->db->join('tbl_categoria', 'tbl_categoria.categoriaId = tbl_articulo.categoriaId');   
            $this->db->join('tbl_articulo_resumen', 'tbl_articulo_resumen.articuloId = tbl_articulo.articuloId', 'left');
            $this->db->join('tbl_articulo_estado', 'tbl_articulo_estado.id = tbl_articulo_resumen.estadoId', 'left');   
            $this->db->join('tbl_tienda', 'tbl_articulo_resumen.tienda_actual = tbl_tienda.id', 'left');
            $this->db->where('tbl_articulo.code', $articuloCode); 
            // $this->db->where('tbl_articulo.estado', 1);          
            $query = $this->db->get();

            if ($query->num_rows() == 0) {
                return FALSE;
            } else {
                return $query->result();
            }
        } catch (\Exception $e) {
            // return $e->getMessage();
            // Guardar en los logs, implementar log4php
            return FALSE;
        }            
    }

    public function getArticuloHistorialById($articuloId) 
    {
        try {
            // $sql = "SELECT a.articuloId, a.CODE, a.nombre, LPAD(c.ventaId, 7, '0') AS 'ventaId', c.tiendaId, t.nombre AS 'tienda', c.vendedorId, 
            //     CONCAT(e.nombre, ' ', e.apellido_paterno) AS 'vendedor', c.clienteId, CONCAT(cl.nombres, ' ', cl.apellido_paterno) AS 'cliente',
            //     c.tipoOperacionId, tp.nombre AS 'tipoOperacion', c.estadoId, es.nombre AS 'estado', d.importeTotal, 
            //     c.fechaSalida, c.fechaDevolucion, c.fechaSalidaProgramada, c.fechaDevolucionProgramada
            // FROM tbl_articulo a
            //     INNER JOIN tbl_venta_detalle d ON d.articuloId = a.articuloId 
            //     INNER JOIN tbl_venta c ON c.ventaId = d.ventaId AND IFNULL(c.anulado, 0) = 0
            //     LEFT JOIN tbl_tienda t ON t.id = c.tiendaId
            //     LEFT JOIN tbl_usuario e ON e.usuario_id = c.vendedorId
            //     LEFT JOIN tbl_cliente cl ON cl.clienteId = c.clienteId
            //     LEFT JOIN tbl_venta_tipo_operacion tp ON tp.id = c.tipoOperacionId
            //     LEFT JOIN tbl_venta_estado es ON es.id = c.estadoId
            // WHERE a.articuloId = ?
            // ORDER BY 4 DESC ";

            $sql = "SELECT 
                d.ventaId, LPAD(d.ventaId, 6, '0') AS 'ventaCode', d.tipoOperacionId, f.nombre AS 'tipoOperacion',
                d.estadoId, UPPER(g.nombre) AS 'estado', e.clienteId, e.nro_documento AS 'nroDocumento', 
                UPPER(CONCAT(e.nombres, ' ',e.apellido_paterno)) AS 'cliente',
                DATE_FORMAT(d.fechaSalida, '%d/%m/%Y') AS 'fechaAlquiler', 
                DATE_FORMAT(d.fechaDevolucion, '%d/%m/%Y') AS 'fechaDevolucion', c.importeTotal
            FROM tbl_articulo a
                LEFT JOIN tbl_articulo_resumen b ON b.articuloId = a.articuloId
                LEFT JOIN tbl_venta_detalle c ON c.articuloId = a.articuloId
                LEFT JOIN tbl_venta d ON d.ventaId = c.ventaId
                LEFT JOIN tbl_cliente e ON e.clienteId = d.clienteId
                LEFT JOIN tbl_venta_tipo_operacion f ON f.id = d.tipoOperacionId
                LEFT JOIN tbl_venta_estado g ON g.id = d.estadoId
            WHERE d.anulado = 0
            AND c.articuloId = ?
            ORDER BY d.ventaId DESC ";

            $articuloId = $this->db->escape_str($articuloId);
            $params = [$articuloId];
            $query = $this->db->query($sql, $params);  
            return $query->result();
        } catch(\Exception $e) {
            return false;
        }
    }
    
    public function getListArticuloByDescripcion($descripcion)
    {
        $this->db->select("tbl_articulo.articuloId, tbl_articulo.code as 'codigo', tbl_articulo.nombre, tbl_articulo.descripcion, tbl_articulo.categoriaId, tbl_categoria.nombre as 'categoria', tbl_articulo_resumen.estadoId, tbl_articulo_estado.nombre as 'estado', tbl_articulo_resumen.precio_alquiler as 'precioAlquiler'");
        $this->db->from('tbl_articulo');
        $this->db->join('tbl_categoria', 'tbl_categoria.categoriaId = tbl_articulo.categoriaId');   
        // $this->db->join('tbl_articulo_stock_tienda', 'tbl_articulo_stock_tienda.articuloId = tbl_articulo.articuloId', 'left');
        $this->db->join('tbl_articulo_resumen', 'tbl_articulo_resumen.articuloId = tbl_articulo.articuloId', 'left');
        $this->db->join('tbl_articulo_estado', 'tbl_articulo_estado.id = tbl_articulo_resumen.estadoId', 'left');    
        $this->db->like('tbl_articulo.nombre', $descripcion);     
        $this->db->where('tbl_articulo.estado', 1);   
        $this->db->or_like('tbl_articulo.descripcion', $descripcion);
        $this->db->limit(20);        
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    public function getArticuloReservas($articuloCode)
    {
        $sql = "SELECT a.articuloId, a.code AS 'articuloCode', d.ventaId, d.tiendaId, d.fechaSalidaProgramada AS 'fechaSalida', 
                d.fechaDevolucionProgramada AS 'fechaDevolucion'
            FROM tbl_articulo a
            INNER JOIN tbl_articulo_resumen b ON b.articuloId = a.articuloId
            INNER JOIN tbl_venta_detalle c ON c.articuloId = b.articuloId
            INNER JOIN tbl_venta d ON d.ventaId = c.ventaId
            WHERE d.estadoId = 1
            AND a.code = ?
            AND d.fechaSalidaProgramada >= CURDATE()";

        $articuloCode = $this->db->escape_str($articuloCode);
        $params = [$articuloCode];
        $query = $this->db->query($sql, $params);  
        return $query->result();
    }

    public function getListArticulos($categoriaId = 0, $estadoId = 0, $condicionId = 0, $tallas = 0, $colores = 0, $disenos = 0)
    {
        // $query = $this->db->get('tbl_articulo');
        /*
        $this->db->select("tbl_articulo.articuloId, tbl_articulo.code, tbl_articulo.nombre, tbl_articulo.descripcion, tbl_articulo.categoriaId, tbl_categoria.nombre As 'categoria', tbl_articulo.unidadMedida, tbl_articulo.marca, tbl_articulo.modelo, tbl_articulo.talla, tbl_articulo.color, tbl_articulo.tela, tbl_articulo_resumen.estadoId, tbl_articulo_estado.nombre as 'estado', tbl_articulo.caracteristicas, tbl_articulo.carpeta_path,tbl_articulo_resumen.stock_actual, tbl_articulo_resumen.precio_compra, tbl_articulo_resumen.precio_venta, tbl_articulo_resumen.precio_alquiler");
        $this->db->from('tbl_articulo');
        $this->db->join('tbl_categoria', 'tbl_articulo.categoriaId = tbl_categoria.categoriaId');
        $this->db->join('tbl_articulo_resumen', 'tbl_articulo_resumen.articuloId = tbl_articulo.articuloId', 'left');
        $this->db->join('tbl_articulo_estado', 'tbl_articulo_estado.id = tbl_articulo_resumen.estadoId', 'left');  
        $this->db->where('tbl_articulo.estado', 1);
        $this->db->where('tbl_articulo.categoriaId', 1);
        $this->db->order_by('tbl_articulo.articuloId', 'ASC');
        $query = $this->db->get();
        */
        if ($categoriaId == 1) $categoriaId = "2,3";
        if ($categoriaId == 4) $categoriaId = "5,6,7";        

        $sql = " SELECT a.articuloId, a.code, a.nombre, a.descripcion, a.categoriaId, b.nombre AS 'categoria', a.unidadMedida, a.marca, a.modelo, 
        a.talla AS 'talla0', a.color as 'color0', a.tela as 'tela0', 
        IFNULL(e1.nombre,'') AS 'talla', IFNULL(e2.nombre,'') AS 'color', IFNULL(e3.nombre,'') AS 'tela',
        c.estadoId, d.nombre AS 'estado', a.caracteristicas, a.carpeta_path, c.stock_actual,
        c.precio_compra, c.precio_venta, c.precio_alquiler, a.condicion
        FROM tbl_articulo a
        INNER JOIN tbl_categoria b ON b.categoriaId = a.categoriaId
        LEFT JOIN tbl_articulo_resumen c ON c.articuloId = a.articuloId    
        LEFT JOIN tbl_articulo_estado d ON d.id = c.estadoId    
        LEFT JOIN tbl_articulo_talla_categoria e1 ON e1.id = c.tallaId
        LEFT JOIN tbl_articulo_color_categoria e2 ON e2.id = c.colorId
        LEFT JOIN tbl_articulo_diseno_categoria e3 ON e3.id = c.disenoId
        WHERE 
        IFNULL(c.estadoId, '0') =  IF(? = '0',IFNULL(c.estadoId, '0'), ?)   
        AND IFNULL(a.condicion, '0') =  IF(? = '0',IFNULL(a.condicion, '0'), ?) ";   

        //IFNULL(a.categoriaId, '0') = IF(? = '0',IFNULL(a.categoriaId, '0'), ?)
        if ($categoriaId <> 0) {
            $sql .= "AND IFNULL(a.categoriaId, '0') IN (".$categoriaId.") ";
        }
        if ($tallas <> 0) {        
            $sql .= "AND IFNULL(c.tallaId,0) IN (".$tallas.") ";
        }
        if ($colores <> 0) {
            $sql .= "AND IFNULL(c.colorId, 0) IN (".$colores.") ";
        }
        if ($disenos <> 0) {
            $sql .= "AND IFNULL(c.disenoId,0) IN (".$disenos.") ";
        }

        $sql .= "ORDER BY a.articuloId ASC ";
        
        $categoriaId = $this->db->escape_str($categoriaId);
        $estadoId = $this->db->escape_str($estadoId);
        $condicionId = $this->db->escape_str($condicionId);
        // $params = array($categoriaId, $categoriaId, $estadoId, $estadoId, $condicionId, $condicionId);
        $params = array($estadoId, $estadoId, $condicionId, $condicionId);
        $query = $this->db->query($sql, $params);
        return $query->result();        
    }

    public function getCorrelativoKardex()
    {
        try {            
            $this->db->select_max('code');
            $query = $this->db->get('tbl_kardex_movimiento');
            return $query->result();
        }
        catch(Exception $e) {
            return ['code' => 0, 'message' => $e->getMessage()];
        }
    }

    public function insertar_kardex(){

    }

    public function getListEstados()
    {
        $query = $this->db->get('tbl_articulo_estado');
        return $query->result();
    }
}