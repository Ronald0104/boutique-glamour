
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {


    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->helper('date');
    }

    function index() {
        echo "<pre>";
        echo var_dump($this->admin_model->logged_id());
        echo "</pre>";
    }

    function ejecutarConsulta(){ 
        // $sql= "insert into tbl_rol (nombre, descripcion) values ('Vendedor', 'Vendedor de tienda');";
        $sql = "update tbl_venta set estadoid = 6 where created_at>='20191115' and tipooperacionid=3";
        $res = $this->db->query($sql);
        $sql = "select * from tbl_venta where created_at>='20191115' and tipooperacionid=3";
        $res = $this->db->query($sql);

        
        echo "<pre>" ;
        echo var_dump($res->result());
        echo "<pre>" ;
    }

    function obtenerFechaHora() {
        $fecha = mdate('%Y-%m-%d %H:%i:%s');
        echo $fecha;
    }

    function phpVersion() {
        echo phpinfo();
    }
}
?>
<!-- update tbl_rol set nombre = 'Encargado', descripcion = 'Encargado de tienda' where id = 2; -->
<!-- insert into tbl_rol (nombre, descripcion) values ('Vendedor', 'Vendedor de tienda'); -->