<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventario extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('admin_model');
        $this->load->model('tienda_model');
        $this->load->model('inventario_model');
        $this->load->helper('date');
        $this->load->helper('file');
    }

    // Generar Token de seguridad 
    public function _remap($method)
    {
        if ($this->admin_model->logged_id())
        {
            $this->$method();
        }
        else
        {
            redirect('');
        }
    }

    public function index()
    {
        redirect(base_url().'inventario/articulos');
    }

    /* Mantenimiento de Categorias */
    public function categorias()
    {
        if ($this->admin_model->logged_id())
        {
            $categorias = $this->inventario_model->getListCategorias();
            $datos = [
                'page' => 'inventory/list-categorys',
                'css' => ['droparea'],
                'js' => ['droparea.min', 'inventory/category'],
                'categorias' => $categorias
            ];
            $this->load->view('init', $datos);
        }
        else
        {
            redirect(base_url().'admin/login');
        }
    }

    public function category_list()
    {
        if ($this->admin_model->logged_id())
        {
            $categorias = $this->inventario_model->getListCategorias();
            $datos = ['categorias' => $categorias];
            echo ($this->load->view('inventory/list-categorys-items', $datos, true));
        // echo json_encode($categoria);
        }
    }

    public function categoriaById()
    {
        if ($this->admin_model->logged_id())
        {
            $categoriaId = $this->input->get('categoriaId');
            $categoria = $this->inventario_model->getListCategoriaById($categoriaId);
            echo json_encode($categoria);
        }
        else
        {
            redirect(base_url() . 'admin/login');
        }
    }

    public function category_add()
    {
        if ($this->admin_model->logged_id())
        {
            if ($this->input->post('nombre'))
            {
                try
                {
                    $fecha = mdate('%Y-%m-%d %H:%i:%s');
                    $categoria = [
                        'nombre' => $this->input->post('nombre'),
                        'descripcion' => $this->input->post('descripcion'),
                        'prefijo_code' => $this->input->post('prefijo'),
                        'imagen_path' => $this->input->post('fotoPath'),
                        'categoriaPadreId' => $this->input->post('categoriaPadreId'),
                        'estado' => 1,
                        'created_at' => $fecha
                        // 'updated_at' => $fecha
                    ];
                    $token = $this->input->post('token');
                    $categoria_id = $this->inventario_model->insert_categoria($categoria);

                    // Mover la imagen de la tienda en su carpeta correspondiente
                    if (!empty($token))
                    {
                        $folder = "assets/img/categorys/category_" . $categoria_id . "/";
                        if (!file_exists($folder))
                        {
                            mkdir($folder, 0777, true);
                        }
                        $imagenTempPath = "assets/img/temp/" . $token . "/";
                        rename($imagenTempPath . $categoria['imagen_path'], $folder . $categoria['imagen_path']);
                        $this->admin_model->eliminarDirectorio($imagenTempPath); // Crear un Heper para esta funcion
                    }

                    $result = TRUE;
                    if ($result)
                    {
                        $error['code'] = 1;
                        $error['message'] = 'categoria registrada correctamente';
                    }
                    echo json_encode($error);
                }
                catch (Exception $e)
                {
                    $error['code'] = 0;
                    $error['message'] = $e->getMessage();
                    // $msj = 'Error al registrar';
                    // write_file('log_error.txt', $msj);
                    echo json_encode($error);
                }
            }
        }
    }

    public function category_edit()
    {
        if ($this->admin_model->logged_id())
        {
            if ($this->input->post('nombre_edit'))
            {
                try
                {
                    $fecha = mdate('%Y-%m-%d %H:%i:%s');
                    $categoriaId = $this->input->post('categoriaId_edit');
                    $categoria = [
                        'nombre' => $this->input->post('nombre_edit'),
                        'descripcion' => $this->input->post('descripcion_edit'),
                        'prefijo_code' => $this->input->post('prefijo_edit'),
                        // 'imagen_path' => $this->input->post('fotoPath_edit'),
                        'categoriaPadreId' => $this->input->post('categoriaPadreId_edit'),
                        'estado' => 1
                        // 'created_at' => $fecha
                        // 'updated_at' => $fecha
                    ];
                    if ($this->input->post('fotoPath_edit') != "")
                    {
                        $categoria['imagen_path'] = $this->input->post('fotoPath_edit');
                    }
                    $token = $this->input->post('token_edit');
                    $result = $this->inventario_model->update_categoria($categoriaId, $categoria);

                    if ($result)
                    {
                        // Mover la imagen de la tienda en su carpeta correspondiente
                        if (!empty ($token))
                        {
                            $folder = "assets/img/categorys/category_" . $categoriaId . "/";
                            if (!file_exists($folder))
                            {
                                mkdir($folder, 0777, true);
                            }
                            $imagenTempPath = "assets/img/temp/" . $token . "/";
                            rename($imagenTempPath . $categoria['imagen_path'], $folder . $categoria['imagen_path']);
                            $this->admin_model->eliminarDirectorio($imagenTempPath); // Crear un Heper para esta funcion
                        }

                        $result = TRUE;
                        if ($result)
                        {
                            $error['code'] = 1;
                            $error['message'] = 'categoria registrada correctamente';
                        }
                    }
                    echo json_encode($error);
                }
                catch (Exception $e)
                {
                    $error['code'] = 0;
                    $error['message'] = $e->getMessage();
                    $msj = 'Error al registrar';
                    write_file('log_error.txt', $msj);
                    echo json_encode($error);
                }
            }
        }
    }
    /* *************************** */


    public function articulos()
    {
        if ($this->admin_model->logged_id())
        {
            //$articulos = $this->inventario_model->getListArticulos();
            //$categorias = $this->inventario_model->getListCategorias();
            $categorias = $this->inventario_model->getCategorias();
            $estados = $this->inventario_model->getListEstados();
            $datos = [
                'page' => 'inventory/list-articles',
                'css' => ['droparea', 'fileinput/fileinput.min', 'datatable/dataTables.bootstrap.min'],
                'js' => [
                    'droparea.min', 
                    'fileinput/fileinput.min', 
                    'fileinput/locales/es', 
                    'fileinput/themes/fas/theme.min', 
                    'inventory/article'
                ],
                //'fileinput/plugins/popper.min', 'datatable/jquery.dataTables.min','datatable/dataTables.bootstrap.min'],
                'categorias' => $categorias,
                'estados' => $estados,
                //'articulos' => $articulos
            ];

            $this->load->view('init', $datos);
        }
        else
        {
            redirect(base_url() . 'admin/login');
        }
    }

    public function articulos_Json()
    {
        $categoriaId = $this->input->post('categoria');
        $estadoId = $this->input->post('estado');
        $condicionId = $this->input->post('condicion');
        $tallas = $this->input->post('talla');  
        if ($tallas == null) {
            $tallas = 0;
        } else {               
            $tallas = str_replace("\"", "",implode(",", $tallas));   
        }        
        $colores = $this->input->post('color');   
        if ($colores == null) {
            $colores = 0;
        } else {
            $colores = str_replace("\"", "",implode(",", $colores));
        }
        $disenos = $this->input->post('diseno');        
        if ($disenos == null) {
            $disenos = 0;
        } else {
            $disenos = str_replace("\"", "",implode(",", $disenos));
        }
        $articulos = $this->inventario_model->getListArticulos($categoriaId, $estadoId, $condicionId, $tallas, $colores, $disenos);
        $data['data'] = $articulos;  
        echo json_encode($data);
    }

    // Funcion sin utilizar
    public function article_list()
    {
        if ($this->admin_model->logged_id())
        {
            $articulos = $this->inventario_model->getListArticulos();
            $categorias = $this->inventario_model->getListCategorias();
            $datos = [
                'categorias' => $categorias,
                'articulos' => $articulos
            ];
            echo ($this->load->view('inventory/list-articles-items', $datos, true));
        }
    }

    public function obtenerCorrelativo()
    {
        if ($this->admin_model->logged_id())
        {
            $categoriaId = $this->input->post('categoriaId');
            $correlativo = $this->inventario_model->getCorrelativo($categoriaId);
            $correlativo = $correlativo[0]->code;
            if (is_null($correlativo))
            {
                $prefijo = $this->inventario_model->getPrefijoCategoria($categoriaId);
                $prefijo = $prefijo[0]->prefijo_code;
                if (strlen($prefijo) == 3)
                    $correlativo = str_pad(1, 8, '0', STR_PAD_LEFT);
                else
                    $correlativo = str_pad(1, 7, '0', STR_PAD_LEFT);
                $correlativo = $prefijo . $correlativo;
            }
            else
            {
                $prefijo = $this->inventario_model->getPrefijoCategoria($categoriaId);
                $prefijo = $prefijo[0]->prefijo_code;
                $correlativo = substr($correlativo, -5) + 1;
                if (strlen($prefijo) == 3)
                    $correlativo = str_pad($correlativo, 8, '0', STR_PAD_LEFT);
                else
                    $correlativo = str_pad($correlativo, 7, '0', STR_PAD_LEFT);
                $correlativo = $prefijo . $correlativo;
            }
            echo $correlativo;
        }
    }

    public function articuloAgregar()
    {
        //$categorias = $this->inventario_model->getListCategorias(); // filtrar solo las categorias hijas
        $categorias = $this->inventario_model->getCategorias();
        $estados = $this->inventario_model->getListEstados();        
        $tiendas = $this->tienda_model->getList();
        $datos = [
            'categorias' => $categorias,
            'estados' => $estados,
            'tiendas' => $tiendas
        ];
        echo ($this->load->view('inventory/add-articles-modal', $datos, true));
    }

    public function listarTallasxCategoria(){
        $categoriaId = $this->input->post('categoriaId');
        $tallas = $this->inventario_model->listarTallasxCategoria($categoriaId); 
        echo json_encode($tallas);
    }

    public function listarColoresxCategoria(){
        $categoriaId = $this->input->post('categoriaId');
        $colores = $this->inventario_model->listarColoresxCategoria($categoriaId); 
        echo json_encode($colores);
    }

    public function listarDisenosxCategoria(){
        $categoriaId = $this->input->post('categoriaId');
        $disenos = $this->inventario_model->listarDisenosxCategoria($categoriaId); 
        echo json_encode($disenos);
    }

    public function agregarTallaxCategoria() {
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        $categoriaId = $this->input->post('categoriaId');
        $estado = $this->input->post('estado');
        echo $this->inventario_model->agregarTallaxCategoria($id, $nombre, $categoriaId, $estado);
    }

    public function agregarColorxCategoria() {
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        $categoriaId = $this->input->post('categoriaId');
        $estado = $this->input->post('estado');
        echo $this->inventario_model->agregarColorxCategoria($id, $nombre, $categoriaId, $estado);
    }

    public function agregarDisenoxCategoria() {
        $id = $this->input->post('id');
        $nombre = $this->input->post('nombre');
        $categoriaId = $this->input->post('categoriaId');
        $estado = $this->input->post('estado');
        echo $this->inventario_model->agregarDisenoxCategoria($id, $nombre, $categoriaId, $estado);
    }

    public function articuloAgregarAjax()
    {
        try
        {
            $fecha = mdate('%Y-%m-%d %H:%i:%s');
            $usuario = (int)$this->session->userdata('user')['usuario_id'];
            $estado = $this->input->post('estadoArticulo');
            $etapa = $this->input->post('etapaArticulo');
            if ($etapa == 5) $estado = 0;

            $articulo = [
                'articuloId' => $this->input->post('articuloId'),
                'code' => $this->input->post('PRD_codigoArticulo'),
                'nombre' => $this->input->post('nombreArticulo'),
                // 'descripcion' => $this->input->post('descripcion'),
                'categoriaId' => $this->input->post('categoriaArticulo'),
                // 'tipo' => 1,
                // 'unidadMedida' => $this->input->post('unidadMedida'),
                'marca' => $this->input->post('marcaArticulo'),
                'talla' => $this->input->post('tallaArticulo'),
                'color' => $this->input->post('colorArticulo'),
                'tela' => $this->input->post('telaArticulo'),                
                'modelo' => $this->input->post('disenoArticulo'),
                'tipo_prenda' => $this->input->post('tipoArticulo'),//) ? 0 : $this->input->post('tipoArticulo'),
                'caracteristicas' => $this->input->post('caracteristicasArticulo'),
                'condicion' => $this->input->post('condicionArticulo'),
                'estado' => $estado,
                'updated_at' => $fecha,
                'usuarioId_updated' => $usuario
            ];
            $articuloId = $articulo['articuloId'];
            $articulo_resumen = [
                'articuloId' => $articuloId,
                'stock_actual' => 1,
                'fecha_compra' => ($this->input->post('fechaCompraArticulo')=="") ? 'NULL' : $this->input->post('fechaCompraArticulo'),
                'precio_compra' => $this->input->post('precioCompraArticulo'),
                'precio_alquiler' => $this->input->post('precioAlquilerArticulo'),
                'precio_venta' => $this->input->post('precioVentaArticulo'),
                'tienda_actual' => $this->input->post('tiendaArticulo'),
                'tallaId' => $this->input->post('tallaArticuloSelect'),
                'colorId' => $this->input->post('colorArticuloSelect'),
                'disenoId' => $this->input->post('disenoArticuloSelect'),
                // 'usuarioId_created' => $usuario,  
                'usuarioId_updated' => $usuario,
                // 'created_at' => $fecha,
                'updated_at' => $fecha,
                'precio_ultimo' => 0,
                'estadoId' => $this->input->post('etapaArticulo')
            ];

            if ($articuloId == "0")
            {
                header('Content-Type-Action: Insert');
                $articulo['created_at'] = $fecha;
                $articulo['usuarioId_created'] = $usuario;
                $articuloId = $this->inventario_model->registrarArticulo($articulo);
            }
            else
            {
                header('Content-Type-Action: Update');
                $this->inventario_model->actualizarArticulo($articulo);
            }

            // Insertar en la tabla articulo resumen  
            if (!$this->inventario_model->existeArticuloResumen($articuloId))
            {       
                $articulo_resumen['articuloId'] = $articuloId;         
                $articulo_resumen['created_at'] = $fecha;
                $articulo_resumen['usuarioId_created'] = $usuario;
                $this->inventario_model->insert_articulo_resumen($articulo_resumen);
            }
            else
            {                
                $this->inventario_model->actualizarArticuloResumen($articulo_resumen);
            }

            // Mover la imagen del artículo en su carpeta correspondiente
            // if(!empty($token)){
            //     $folder="assets/img/articles/article_".$articuloId."/";
            //     if (!file_exists($folder)) {
            //         mkdir($folder, 0777, true);
            //     }
            //     $imagenTempPath = "assets/img/temp/".$token."/"; 
            //     rename($imagenTempPath.$categoria['imagen_path'], $folder.$categoria['imagen_path']);
            //     $this->admin_model->eliminarDirectorio($imagenTempPath);    // Crear un Heper para esta funcion
            // }

            $result = TRUE;
            $error = [];
            if ($result)
            {
                $error['code'] = 1;
                $error['message'] = 'articulo registrado correctamente';
            }
            echo json_encode($error);
        }
        catch (Exception $e)
        {
            $error = [];
            $error['code'] = 0;
            $error['message'] = $e->getMessage();
            // $msj = 'Error al registrar';
            // write_file('log_error.txt', $msj);
            echo json_encode($error);
        }

    }

    public function articuloActualizar() {
        // Recibe un array articulos
        $articles = json_decode($this->input->post('articulos'));
        
        $articulos = [];
        // $articulo;
        $fecha = mdate('%Y-%m-%d %H:%i:%s');
        $response = [];

        if (!empty($articles)){ 
            foreach ($articles as $article) {
                $code =  $article->code;  
                if (!$code) 
                    break;                

                $res = new stdClass();
                $res->code = $code;    
                try {
                    $article = $article->article;
                    $articulo = new stdClass();
                    $articulo->code = $code;   
                    $articulo->estado = 1; 
                    if(!empty($article->Nombre)) $articulo->nombre = $article->Nombre;    
                    if(!empty($article->Talla)) $articulo->talla = $article->Talla;    
                    if(!empty($article->Color)) $articulo->color = $article->Color;    
                    if(!empty($article->Marca)) $articulo->marca = $article->Marca;    
                    if(!empty($article->Caracteristicas)) $articulo->caracteristicas = $article->Caracteristicas;    
                    if(!empty($article->Tela)) $articulo->tela = $article->Tela;
                    if(!empty($article->CategoriaCodigo)) $articulo->categoriaId = $this->obtenerCategoriaByPrefijo($article->CategoriaCodigo)[0];
                    if(!empty($article->Tipo)) $articulo->tipo_prenda = $article->Tipo;

                    $articulo_resumen = new stdClass();
                    // if(!empty($article->Tienda)) $articulo_resumen->tienda_actual = $article->Tienda;
                    //$articulo_resumen->estadoId = $article->Estado
                    if(!empty($article->PrecioCompra)) $articulo_resumen->precio_compra = $article->PrecioCompra;
                    if(!empty($article->PrecioAlquiler)) $articulo_resumen->precio_alquiler = $article->PrecioAlquiler;
                    if(!empty($article->PrecioVenta)) $articulo_resumen->precio_venta = $article->PrecioVenta;
                    // $articulo->resumen = $articulo_resumen;

                    $articuloId = 0;
                    $existe = $this->inventario_model->existeArticulo($code);
                    if (!$existe){
                        $articuloId = $this->inventario_model->insert_articulo($articulo);
                        $articulo_resumen->articuloId = $articuloId;
                        $articulo_resumen->estadoId = 1;
                        $this->inventario_model->insert_articulo_resumen($articulo_resumen);
                    }
                    else {
                        $articuloId = $existe->articuloId;                        
                        $this->inventario_model->update_articulo($articuloId, $articulo);

                        if (!$this->inventario_model->existeArticuloResumen($articuloId)){
                            $articulo_resumen->articuloId = $articuloId;
                            $articulo_resumen->estadoId = 1;
                            $this->inventario_model->insert_articulo_resumen($articulo_resumen);
                        }
                        else {
                            $articulo_resumen->articuloId = $articuloId;
                            $this->inventario_model->update_articulo_resumen2($articuloId, $articulo_resumen);
                        }
                    }

                    // Si no se encuentra registrado lo registramos en caso contrario lo actualizamos
                    // $result = $this->inventario_model->update_articulo($articuloId, $articulo);

                    // $articulo = [];
                    // $articulo['code'] = $code;                    
                    // $articulo['nombre'] = $article->Nombre;
                    // if ($article->)
                    // $articulos[] = $articulo;  
                    
                    $res->errorCode = 1;                                    
                } catch (\Exception $ex) {
                    //
                    $res->errorCode = 0;
                }                
                $response[] = $res;                
            }
        }
        echo json_encode($response);
        // try{            
        //     $articuloCode = $this->input->post('articuloId_edit');
        //     $articulo = [
        //         'nombre' => $this->input->post('nombre_edit'),
        //         'code' => $this->input->post('code_edit'),
        //         'descripcion' => $this->input->post('descripcion_edit'),
        //         'categoriaId' => $this->input->post('categoria_edit'),
        //         'tipo' => 1,
        //         'unidadMedida' => $this->input->post('unidadMedida_edit'),
        //         'marca' => $this->input->post('marca_edit'),
        //         'modelo' => $this->input->post('modelo_edit'),
        //         'talla' => $this->input->post('talla_edit'),
        //         'color' => $this->input->post('color_edit'),
        //         'tela' => $this->input->post('tela_edit'),
        //         'caracteristicas' => $this->input->post('caracteristicas_edit'),
        //         'estado' => 1,
        //         // 'created_at' => $fecha,
        //         'updated_at' => $fecha
        //     ];
        //             // $token = $this->input->post('token');
        //             $result = $this->inventario_model->update_articulo($articuloId, $articulo);

        //             // Mover la imagen del artículo en su carpeta correspondiente
        //             // if(!empty($token)){
        //             //     $folder="assets/img/articles/article_".$articuloId."/";
        //             //     if (!file_exists($folder)) {
        //             //         mkdir($folder, 0777, true);
        //             //     }
        //             //     $imagenTempPath = "assets/img/temp/".$token."/"; 
        //             //     rename($imagenTempPath.$categoria['imagen_path'], $folder.$categoria['imagen_path']);
        //             //     $this->admin_model->eliminarDirectorio($imagenTempPath);    // Crear un Heper para esta funcion
        //             // }

        //             // $result = TRUE;
        //             if ($result)
        //             {
        //                 $error['code'] = 1;
        //                 $error['message'] = 'artículo actualizado correctamente';
        //             }
        //             echo json_encode($error);
        //         }
        //         catch (Exception $e)
        //         {
        //             $error['code'] = 0;
        //             $error['message'] = $e->getMessage();
        //             // $msj = 'Error al registrar';
        //             // write_file('log_error.txt', $msj);
        //             echo json_encode($error);
        //         }
                
        // echo json_encode($articles);
    }
    
    /* quitar esta opcion */
    public function article_add()
    {
        if ($this->admin_model->logged_id())
        {
            if ($this->input->post('nombre'))
            {
                try
                {
                    $fecha = mdate('%Y-%m-%d %H:%i:%s');
                    $articulo = [
                        'nombre' => $this->input->post('nombre'),
                        'code' => $this->input->post('code'),
                        'descripcion' => $this->input->post('descripcion'),
                        'categoriaId' => $this->input->post('categoria'),
                        'tipo' => 1,
                        'unidadMedida' => $this->input->post('unidadMedida'),
                        'marca' => $this->input->post('marca'),
                        'modelo' => $this->input->post('modelo'),
                        'talla' => $this->input->post('talla'),
                        'color' => $this->input->post('color'),
                        'tela' => $this->input->post('tela'),
                        'caracteristicas' => $this->input->post('caracteristicas'),
                        'estado' => 1,
                        'created_at' => $fecha,
                        'updated_at' => $fecha
                    ];
                    // $token = $this->input->post('token');
                    $articuloId = $this->inventario_model->insert_articulo($articulo);

                    // Insertar en la tabla articulo resumen
                    $fecha = mdate('%Y-%m-%d %H:%i:%s');
                    $usuario = (int)$this->session->userdata('user')['usuario_id'];
                    $articulo_resumen = [
                        'articuloId' => $articuloId,
                        'stock_actual' => 1,
                        'precio_compra' => 0,
                        'precio_venta' => 0,
                        'precio_alquiler' => 0,
                        'tienda_actual' => 1,
                        'usuarioId_created' => $usuario,
                        'usuarioId_updated' => $usuario,
                        'created_at' => $fecha,
                        'updated_at' => $fecha,
                        'precio_ultimo' => 0,
                        'estadoId' => 1
                    ];

                    $articuloId = $this->inventario_model->insert_articulo_resumen($articulo_resumen);
                    // Mover la imagen del artículo en su carpeta correspondiente
                    // if(!empty($token)){
                    //     $folder="assets/img/articles/article_".$articuloId."/";
                    //     if (!file_exists($folder)) {
                    //         mkdir($folder, 0777, true);
                    //     }
                    //     $imagenTempPath = "assets/img/temp/".$token."/"; 
                    //     rename($imagenTempPath.$categoria['imagen_path'], $folder.$categoria['imagen_path']);
                    //     $this->admin_model->eliminarDirectorio($imagenTempPath);    // Crear un Heper para esta funcion
                    // }

                    $error = [];
                    $result = TRUE;
                    if ($result)
                    {
                        $error['code'] = 1;
                        $error['message'] = 'categoria registrada correctamente';
                    }
                    echo json_encode($error);
                }
                catch (Exception $e)
                {
                    $error['code'] = 0;
                    $error['message'] = $e->getMessage();
                    // $msj = 'Error al registrar';
                    // write_file('log_error.txt', $msj);
                    echo json_encode($error);
                }
            }
        }
    }    

    public function article_add_simple()
    {
        if ($this->admin_model->logged_id())
        {
            if ($this->input->post('nombre_simple'))
            {
                try
                {
                    $fecha = mdate('%Y-%m-%d %H:%i:%s');
                    $articulo = [
                        'code' => $this->input->post('code_simple'),
                        'nombre' => $this->input->post('nombre_simple'),
                        'descripcion' => $this->input->post('nombre_simple'),
                        'categoriaId' => $this->input->post('categoria_simple'),
                        'tipo' => 1,
                        'estado' => 1,
                        'created_at' => $fecha,
                        'updated_at' => $fecha
                    ];

                    $articuloId = 0;
                    $articuloId = $this->inventario_model->insert_articulo($articulo);

                    if ($articuloId)
                    {
                        $error['code'] = 1;
                        $error['message'] = 'categoria registrada correctamente';
                    }
                    echo json_encode($error);
                }
                catch (Exception $e)
                {
                    $error['code'] = 0;
                    $error['message'] = $e->getMessage();
                    echo json_encode($error);
                }
            }
        }
    }

    public function articuloById()
    {
        if ($this->admin_model->logged_id())
        {    
            $data = [];
            $articuloId = $this->input->post('articuloId');
            $articulo = $this->inventario_model->getArticuloById($articuloId);
            $historial = $this->inventario_model->getArticuloHistorialById($articuloId);
            $data['articulo'] = $articulo;
            $data['historial'] = $historial;
            echo json_encode($data);        
        }
    }

    public function articuloByCode()
    {
        if ($this->admin_model->logged_id())
        {
            $data = [];
            $articuloCode = $this->input->post('articuloCode');
            $articuloId = $this->inventario_model->obtenerId($articuloCode);
            $articuloId = $articuloId->articuloId;
            $articulo = $this->inventario_model->getArticuloById($articuloId);
            $historial = $this->inventario_model->getArticuloHistorialById($articuloId);
            $data['articulo'] = $articulo;
            $data['historial'] = $historial;
            echo json_encode($data);
        }
    }

    public function articuloByDescription()
    {
        if ($this->admin_model->logged_id())
        {
            $descripcion = $this->input->post('descripcion');
            $articulo = $this->inventario_model->getListArticuloByDescripcion($descripcion);

            // Opcion 1: devolver json
            // Opcion 2: devolver texto
            echo json_encode($articulo);
        }
    }

    public function articuloByCodeFull()
    {
           $articuloCode = $this->input->post('articuloCode');  
           $articuloId = $this->inventario_model->obtenerId($articuloCode);
           $articuloId = $articuloId->articuloId;      
           //$articulo['articulo'] = $this->inventario_model->getArticuloByCode2($articuloCode);
           $articulo['articulo'] = $this->inventario_model->getArticuloById($articuloId);
           $articulo['articulo_reservas'] = $this->inventario_model->getArticuloReservas($articuloCode);
           echo json_encode($articulo);
    }

    public function article_edit()
    {
        if ($this->admin_model->logged_id())
        {
            if ($this->input->post('nombre_edit'))
            {
                try
                {
                    $fecha = mdate('%Y-%m-%d %H:%i:%s');
                    $articuloId = $this->input->post('articuloId_edit');
                    $articulo = [
                        'nombre' => $this->input->post('nombre_edit'),
                        'code' => $this->input->post('code_edit'),
                        'descripcion' => $this->input->post('descripcion_edit'),
                        'categoriaId' => $this->input->post('categoria_edit'),
                        'tipo' => 1,
                        'unidadMedida' => $this->input->post('unidadMedida_edit'),
                        'marca' => $this->input->post('marca_edit'),
                        'modelo' => $this->input->post('modelo_edit'),
                        'talla' => $this->input->post('talla_edit'),
                        'color' => $this->input->post('color_edit'),
                        'tela' => $this->input->post('tela_edit'),
                        'caracteristicas' => $this->input->post('caracteristicas_edit'),
                        'estado' => 1,
                        // 'created_at' => $fecha,
                        'updated_at' => $fecha
                    ];
                    // $token = $this->input->post('token');
                    $result = $this->inventario_model->update_articulo($articuloId, $articulo);

                    // Mover la imagen del artículo en su carpeta correspondiente
                    // if(!empty($token)){
                    //     $folder="assets/img/articles/article_".$articuloId."/";
                    //     if (!file_exists($folder)) {
                    //         mkdir($folder, 0777, true);
                    //     }
                    //     $imagenTempPath = "assets/img/temp/".$token."/"; 
                    //     rename($imagenTempPath.$categoria['imagen_path'], $folder.$categoria['imagen_path']);
                    //     $this->admin_model->eliminarDirectorio($imagenTempPath);    // Crear un Heper para esta funcion
                    // }

                    // $result = TRUE;
                    if ($result)
                    {
                        $error['code'] = 1;
                        $error['message'] = 'artículo actualizado correctamente';
                    }
                    echo json_encode($error);
                }
                catch (Exception $e)
                {
                    $error['code'] = 0;
                    $error['message'] = $e->getMessage();
                    // $msj = 'Error al registrar';
                    // write_file('log_error.txt', $msj);
                    echo json_encode($error);
                }
            }
        }
    }

    public function kardex()
    {
        if ($this->admin_model->logged_id())
        {
            $articulos = $this->inventario_model->getListArticulos();
            $categorias = $this->inventario_model->getListCategorias();
            $datos = [
                'page' => 'inventory/list-kardex',
                'css' => ['droparea', 'fileinput/fileinput.min', 'datatable/dataTables.bootstrap.min'],
                'js' => ['droparea.min', 'fileinput/fileinput.min', 'fileinput/locales/es', 'fileinput/themes/fas/theme.min', 'kardex'],
                // 'fileinput/plugins/popper.min', 'datatable/jquery.dataTables.min','datatable/dataTables.bootstrap.min',
                'categorias' => $categorias,
                'articulos' => $articulos
            ];

            $this->load->view('init', $datos);
        }
        else
        {
            redirect(base_url() . 'admin/login');
        }
    }

    public function kardex_registrar()
    {
        if ($this->admin_model->logged_id())
        {
            $tiendas = $this->tienda_model->getList();
            $categorias = $this->inventario_model->getListCategorias();
            $correlativo = $this->obtenerCorrelativoKardex(1);
            // $option = substr($this->uri->segment(3), 3, 1);
            $option = $this->uri->segment(3);
            $inicial = [
                'tipo' => $option,
                'correlativo' => $correlativo,
            ];
            $datos = [
                'page' => 'inventory/add-kardex',
                'css' => ['jquery-ui.min'],
                'js' => ['jquery-ui.min', 'kardex-mov'],
                'tiendas' => $tiendas,
                'categorias' => $categorias,
                'correlativo' => $correlativo,
                'inicial' => json_encode($inicial)
            ];

            // Obtener el codigo dependiente el tipo de operacion            
            $this->load->view('init', $datos);
        }
        else
        {
            redirect(base_url() . 'admin/login');
        }
    }

    public function obtenerCorrelativoKardex($op = 0)
    {
        if ($this->admin_model->logged_id())
        {
            $correlativo = $this->inventario_model->getCorrelativoKardex();
            $correlativo = $correlativo[0]->code;

            $prefijo = "KDX";
            if (is_null($correlativo))
            {
                $correlativo = str_pad(1, 7, '0', STR_PAD_LEFT);
                $correlativo = $prefijo . $correlativo;
            }
            else
            {
                $correlativo = substr($correlativo, -7);
                $correlativo = str_pad($correlativo + 1, 7, '0', STR_PAD_LEFT);
                $correlativo = $prefijo . $correlativo;
            }
            if ($op == 1)
            {
                return $correlativo;
            }
            else
            {
                echo $correlativo;
            }
        }
    }

    public function upload()
    {
        $css = ['fileinput/fileinput.min'];
        $js = ['fileinput/fileinput.min', 'article-upload'];
        $datos = [
            'css' => $css,
            'js' => $js,
            'page' => 'inventory/list-articles-upload',
        ];

        // Obtener el codigo dependiente el tipo de operacion        
        $this->load->view('init', $datos);
    }

    public function upload_ajax(){
        $fecha = new DateTime();
        // Guardar el archivo en el servidor
        // Verificar si el tipo es 
        $file = []; //new stdClass();
        // $file->id = 1;
        // $file->name = "Ronald";

        if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK) {
            $file['TmpPath'] = $_FILES['fileUpload']['tmp_name'];
            $file['Name'] = $_FILES['fileUpload']['name'];
            $file['Size'] = $_FILES['fileUpload']['size'];
            $file['Type'] = $_FILES['fileUpload']['type'];
            $file['NameCmps'] = explode(".", $file['Name']);
            $file['Extension'] = strtolower(end($file['NameCmps']));

            $pathFolder='assets/files/'.$fecha->format('Y-m-d');
            if (!file_exists($pathFolder)) {
                mkdir($pathFolder, 0777, true);
            }
            move_uploaded_file($file['TmpPath'], "$pathFolder/$file[Name]");
            $fileExcel = $pathFolder.'/'.$file['Name'];
            $this->load->library('Leerexcelclass', [$fileExcel]);
            $data = $this->leerexcelclass->obtenerDatosExcel();
            $file['data'] = $data;
        } else {

        }

        // foreach ($_FILES["pictures"]["error"] as $key => $error) {
        //     if ($error == UPLOAD_ERR_OK) {
        //         $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
        //         // basename() puede evitar ataques de denegación de sistema de ficheros;
        //         // podría ser apropiada más validación/saneamiento del nombre del fichero
        //         $name = basename($_FILES["pictures"]["name"][$key]);
        //         move_uploaded_file($tmp_name, "$uploads_dir/$name");
        //     }
        // }

        // if (!empty($token))
        // {
        //     $folder = "assets/img/categorys/category_" . $categoria_id . "/";
        //     if (!file_exists($folder))
        //     {
        //         mkdir($folder, 0777, true);
        //     }
        //     $imagenTempPath = "assets/img/temp/" . $token . "/";
        //     rename($imagenTempPath . $categoria['imagen_path'], $folder . $categoria['imagen_path']);
        //     $this->admin_model->eliminarDirectorio($imagenTempPath); // Crear un Heper para esta funcion
        // }
       
        // $config['upload_path'] = 'assets/img/customers/'.$clienteId.'/';
        // $config['allowed_types'] = 'gif|jpg|png';
        // $config['max_size'] = 100;
        // $config['max_width'] = 1024;
        // $config['max_height'] = 768;

        // $this->load->library('upload', $config);   
        // $pathFoto = "";         
        // if($this->upload->do_upload('fotoCliente_Add')){
        //     // $data = $this->upload->data('fotoCliente_Add'); 
        //     $data = $this->upload->data();
        //     $path = $data['file_name'];                
        //     $this->cliente_model->modificarFoto($clienteId, $path);
        //     // echo json_encode($data);
        // }
        // else {
        //     // echo $this->upload->display_errors();
        //     // die('Ocurrio un error al subir la foto' . $this->upload->display_errors());
        // }
        
        echo json_encode($file);
    }

    public function download_template() {
        $archivo = $_SERVER['DOCUMENT_ROOT'] . "/assets/files/plantilla-inventario.xlsx";
        header('Content-Disposition: attachment; filename=' . $archivo);
        header("Content-Type: application/vnd.openxmlformats-   officedocument.spreadsheetml.sheet");
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Length: '.filesize($archivo));
        readfile($archivo);
    }

    public function cargaMasiva()
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . "/assets/files/Lista-de-códigos-de-barra-Inventario-v2.xlsx";
        if (file_exists($file))
        {
            $this->load->library('Leerexcelclass', [$file]);
            $data = $this->leerexcelclass->obtenerDatosExcel();
            //echo var_dump($data[0][0]);
            log_message('info', 'test logging.');

            $table = "<table border=1 cellpadding=0 cellspacing=0>";
            $table .= "<tr><th>Item</th>";
            $table .= "<th>Código</th>";
            $table .= "<th>Marca</th>";
            $table .= "<th>Talla</th>";
            $table .= "<th>Color</th>";
            $table .= "<th>Tela</th>";
            $table .= "<th>Características</th>";
            $table .= "<th>Estado</th>";
            $table .= "<th>PeriodoCompra</th>";
            $table .= "<th>PrecioCompra</th>";
            $table .= "<th>PrecioAlquiler</th>";
            $table .= "<th>PrecioVenta</th></tr>";
            foreach ($data[0] as $key => $value)
            {
                if ($key === 0)
                    continue;
                // Insertar los articulos en caso no existan
                // Insertar las imagenes en caso tengan

                // Mover el Kardex

                $fecha = mdate('%Y-%m-%d %H:%i:%s');
                $articuloId = 0;
                $articulo = $this->inventario_model->getListArticuloByCode($value['Codigo']);
                if (!$articulo)
                {
                    // echo substr($value['Codigo'], 0, 4); echo "<br>";
                    // echo var_dump($value);
                    $categoria = $this->obtenerCategoriaByPrefijo(substr($value['Codigo'], 0, 4));
                    // echo var_dump($categoria);
                    $nombre = $categoria[1] . " " . $value['Color'] . " " . $value['Talla'] . " " . $value['Tela'];
                    $descripcion = $categoria[1] . " " . $value['Color'] . " " . $value['Talla'] . " " . $value['Tela'] . " " . $value['Marca'] . " " . $value['Caracteristicas'];
                    // echo $nombre; echo "<br>";
                    // echo $descripcion; echo "<br>";
                    $articulo = [
                        'nombre' => $nombre,
                        'code' => $value['Codigo'],
                        'descripcion' => $descripcion,
                        'categoriaId' => $categoria[0],
                        'tipo' => 1,
                        'unidadMedida' => 'UNIDAD',
                        'marca' => $value['Marca'],
                        'modelo' => '',
                        'talla' => $value['Talla'],
                        'color' => $value['Color'],
                        'tela' => $value['Tela'],
                        'caracteristicas' => $value['Caracteristicas'],
                        'estado' => 1,
                        'usuarioId_created' => $this->session->userdata('user')['usuario_id'],
                        'usuarioId_updated' => $this->session->userdata('user')['usuario_id'],
                        'created_at' => $fecha,
                        'updated_at' => $fecha
                    ];
                    $articuloId = $this->inventario_model->insert_articulo($articulo);
                // echo $articuloId; echo "<br>";
                }
                // echo var_dump($articulo);
                // $articuloId = $articulo[0]->articuloId;
                echo "Codigo de Articulo:" . $articuloId;
                // Insertar en la tabla resumen de articulo el stock, estado y en que tienda esta
                if ($articuloId > 0)
                {
                    $articulo_resumen = [
                        'articuloId' => $articuloId,
                        'stock_actual' => 1,
                        'precio_compra' => empty ($value['PrecioCompra']) ? 0 : floatval($value['PrecioCompra']),
                        'precio_venta' => 0,
                        'precio_alquiler' => 0,
                        'tienda_actual' => 1,
                        'estadoId' => 1,
                        'usuarioId_created' => $this->session->userdata('user')['usuario_id'],
                        'usuarioId_updated' => $this->session->userdata('user')['usuario_id'],
                        'created_at' => $fecha,
                        'updated_at' => $fecha
                    ];
                    $result = $this->inventario_model->update_articulo_resumen($articulo_resumen);
                    echo var_dump($result);
                }

                // echo var_dump($articulo);
                $table .= "<tr><td>$key</td>";
                $table .= "<td>$value[Codigo]</td>";
                $table .= "<td>$value[Marca]</td>";
                $table .= "<td>$value[Talla]</td>";
                $table .= "<td>$value[Color]</td>";
                $table .= "<td>$value[Tela]</td>";
                $table .= "<td>$value[Caracteristicas]</td>";
                $table .= "<td>$value[Estado]</td>";
                $table .= "<td>$value[PeriodoCompra]</td>";
                $table .= "<td>$value[PrecioCompra]</td>";
                $table .= "<td>$value[PrecioAlquiler]</td>";
                $table .= "<td>$value[PrecioVenta]</td><tr>";
            // if($key == 10) break;
            }
            $table .= "</table>";

            echo $table;
        // Insertar los datos
        }
    }

    public function obtenerCategoriaByPrefijo($prefijo)
    {
        $categoria = [];
        switch ($prefijo) {
            case 'TSAC':
                $categoria[0] = 2; $categoria[1] = 'Terno Saco'; break;
            case 'TPAN':
                $categoria[0] = 3; $categoria[1] = 'Terno Pantalón'; break;
            case 'SSAC':
                $categoria[0] = 5; $categoria[1] = 'Smokings Saco'; break;
            case 'SCHA':
                $categoria[0] = 6; $categoria[1] = 'Smokings Chaleco'; break;
            case 'SPAN':
                $categoria[0] = 7; $categoria[1] = 'Smokings Pantalón'; break;
            case 'CAM0':
                $categoria[0] = 8; $categoria[1] = 'Camisas'; break;
            case 'COR0':
                $categoria[0] = 9; $categoria[1] = 'Corbatas'; break;
            case 'VES':
                $categoria[0] = 10; $categoria[1] = 'Vestidos'; break;
            case 'CAR':
                $categoria[0] = 11; $categoria[1] = 'Carteras'; break;
            case 'ZAP':
                $categoria[0] = 12; $categoria[1] = 'Zapatos'; break;    
            case 'SAN':
                $categoria[0] = 13; $categoria[1] = 'Sandalias'; break;    
            default:
                # code...
                break;
        }
        return $categoria;
    }
}

?>