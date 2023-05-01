<?php 
require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';
defined('BASEPATH') OR exit('No direct script access allowed');

class Leerexcelclass {
    private $filepath;

    public function __construct($params)
    {
        $this->filepath = $params[0];    
    }
    
    public function obtenerDatosExcel()
    {
        $filepath = $this->filepath;
        $objReader = PHPExcel_IOFactory::createReaderForFile($filepath); 
        $worksheetInfo = $objReader->listWorksheetInfo($filepath);

        $objReader->setIncludeCharts(FALSE);
        $objPHPExcel = $objReader->load($filepath);

        $listas = array();

        for ($numHoja=0; $numHoja <=0; $numHoja++) { 
            $lastRow = $worksheetInfo[$numHoja]['totalRows'];
            //$lastRow = 100;
            $sheet = $objPHPExcel->getSheet($numHoja);
            $listas[] = $this->leerHojaInventario($sheet, $lastRow);
        }

        return $listas;
    }

    private function leerHojaInventario($sheet, $lastRow){
        $data = array();
    	$totales = array();
        $currentRow = 1;
        
        $inicioTabla = null;

        // if ($lastRow >= 510) {
        //     $lastRow = 25;
        // }
        
		while ($currentRow <= $lastRow) {    
            $cellinfo = $this->cellInfo($sheet->getCellByColumnAndRow(0, $currentRow), $sheet);            

            if(empty($inicioTabla)){
				if(!empty($cellinfo['value'])){
                    $inicioTabla = $currentRow;
                    $currentRow++;
                    continue;
                }         				
            }

            if (!empty($inicioTabla)) {
                if (empty($cellinfo['value'])) {
                    $currentRow++;
                    continue;
                }
                $data[] = array(
                    'Codigo' => $this->cellInfo($sheet->getCellByColumnAndRow(0, $currentRow), $sheet)['value'],
                    'Nombre' => $this->cellInfo($sheet->getCellByColumnAndRow(1, $currentRow), $sheet)['value'],
                    'Categoria' => $this->cellInfo($sheet->getCellByColumnAndRow(2, $currentRow), $sheet)['value'],
                    'CategoriaCodigo' => $this->cellInfo($sheet->getCellByColumnAndRow(3, $currentRow), $sheet)['value'],
                    'Marca' => $this->cellInfo($sheet->getCellByColumnAndRow(4, $currentRow), $sheet)['value'],
                    'Talla' => $this->cellInfo($sheet->getCellByColumnAndRow(5, $currentRow), $sheet)['value'],
                    'Color' => $this->cellInfo($sheet->getCellByColumnAndRow(6, $currentRow), $sheet)['value'],
                    'Tela' => $this->cellInfo($sheet->getCellByColumnAndRow(7, $currentRow), $sheet)['value'],
                    'Diseno' => $this->cellInfo($sheet->getCellByColumnAndRow(8, $currentRow), $sheet)['value'],
                    'Caracteristicas' => $this->cellInfo($sheet->getCellByColumnAndRow(9, $currentRow), $sheet)['value'],
                    'Tienda' => $this->cellInfo($sheet->getCellByColumnAndRow(10, $currentRow), $sheet)['value'],
                    'Tipo' => $this->cellInfo($sheet->getCellByColumnAndRow(11, $currentRow), $sheet)['value'],
                    'Estado' => $this->cellInfo($sheet->getCellByColumnAndRow(12, $currentRow), $sheet)['value'],
                    'FechaCompra' => $this->cellInfo($sheet->getCellByColumnAndRow(13, $currentRow), $sheet)['value'],
                    'PrecioCompra' => $this->cellInfo($sheet->getCellByColumnAndRow(14, $currentRow), $sheet)['value'],
                    'PrecioAlquiler' => $this->cellInfo($sheet->getCellByColumnAndRow(15, $currentRow), $sheet)['value'],
                    'PrecioVenta' => $this->cellInfo($sheet->getCellByColumnAndRow(16, $currentRow), $sheet)['value']
                );
            }        
			$currentRow++;
		}
		if(!empty($data)){
			//$this->table(array_keys($data[0]),$data);
	        //$this->table(array_keys($totales),array($totales));
		}
        // return array("data"=>$data, "totales"=>$totales);
        return $data;
    }

    // Validar que el excel tenga la estructura correcta para Crear un objeto Articulo
    private function leerHoja($sheet, $lastRow)
    {
    	$data = array();
    	$totales = array();
        $currentRow = 1;
        
        $inicioTabla = null;

        if ($lastRow >= 510) {
            $lastRow = 25;
        }
        
		while ( $currentRow <= $lastRow) {
			$cell = $sheet->getCellByColumnAndRow(0, $currentRow);
            $cellinfo = $this->cellInfo($cell, $sheet);
            $cellinfo = $cellinfo['value'];

            $cell2 = $sheet->getCellByColumnAndRow(1, $currentRow);
            $cellinfo2 = $this->cellInfo($cell2, $sheet);
            $cellinfo2 = $cellinfo2['value'];

            $cell3 = $sheet->getCellByColumnAndRow(2, $currentRow);
            $cellinfo3= $this->cellInfo($cell3, $sheet);
            $cellinfo3 = floatval($cellinfo3['value']);            

            $cellinfo = $this->cellInfo($sheet->getCellByColumnAndRow(0, $currentRow), $sheet);
            if(empty($inicioTabla)){
				if(!empty($cellinfo['value'])){
                    $inicioTabla = $currentRow;
                }         				
            }
            
            if (!empty($inicioTabla)) {
                $data[] = array(
                    'Codigo' => $this->cellInfo($sheet->getCellByColumnAndRow(0, $currentRow), $sheet)['value'],
                    'Marca' => $this->cellInfo($sheet->getCellByColumnAndRow(1, $currentRow), $sheet)['value'],
                    'Talla' => $this->cellInfo($sheet->getCellByColumnAndRow(2, $currentRow), $sheet)['value'],
                    'Color' => $this->cellInfo($sheet->getCellByColumnAndRow(3, $currentRow), $sheet)['value'],
                    'Tela' => $this->cellInfo($sheet->getCellByColumnAndRow(4, $currentRow), $sheet)['value'],
                    'Caracteristicas' => $this->cellInfo($sheet->getCellByColumnAndRow(5, $currentRow), $sheet)['value'],
                    'Estado' => $this->cellInfo($sheet->getCellByColumnAndRow(6, $currentRow), $sheet)['value'],
                    'PeriodoCompra' => $this->cellInfo($sheet->getCellByColumnAndRow(7, $currentRow), $sheet)['value'],
                    'PrecioCompra' => $this->cellInfo($sheet->getCellByColumnAndRow(8, $currentRow), $sheet)['value'],
                    'PrecioAlquiler' => $this->cellInfo($sheet->getCellByColumnAndRow(9, $currentRow), $sheet)['value'],
                    'PrecioVenta' => $this->cellInfo($sheet->getCellByColumnAndRow(10, $currentRow), $sheet)['value']
                );
            }
            
			// 
			// if(!empty($inicioTabla)){
			// 	$cellinfo = $this->cellInfo($sheet->getCellByColumnAndRow(0,$currentRow),$sheet);
			// 	if(empty($cellinfo['value'])){
			// 		$totales = array(
			// 			"total_facturar"=>floatval($this->cellInfo($sheet->getCellByColumnAndRow(3,$currentRow),$sheet)['value']),
			// 			"total_prestamos"=>floatval($this->cellInfo($sheet->getCellByColumnAndRow(4,$currentRow),$sheet)['value'])
			// 			);
			// 		break;
			// 	}
			// 	$data[] = array(
			// 		"nro"=>$cellinfo['value'],
			// 		"dni"=>$this->cellInfo($sheet->getCellByColumnAndRow(1,$currentRow),$sheet)['value'],				
			// 		);
            // }

			$currentRow++;
		}
		if(!empty($data)){
			//$this->table(array_keys($data[0]),$data);
	        //$this->table(array_keys($totales),array($totales));
		}
        // return array("data"=>$data, "totales"=>$totales);
        return $data;
    }

    private function cellInfo($cell, $sheet)
	{
		$info = array();
		$info['row'] = $cell->getRow();
		$info['colName'] = $cell->getColumn();
		$info['col'] = PHPExcel_Cell::columnIndexFromString($info['colName'])-1;
		$info['name'] = $cell->getCoordinate();
		$info['dataType'] = $cell->getDataType();
		$info['value'] = $cell->getValue();
		if($info['dataType']=='f'){
			$info['value'] = $cell->getCalculatedValue();
		}else if($info['dataType']=='e'){
			$info['value'] = '';
		}
		$style = $sheet->getStyleByColumnAndRow($info['col'], $info['row']);
		$info['numberFormat'] = $style->getNumberFormat()->getFormatCode();
		$info['fontColor'] = $style->getFont()->getColor()->getARGB();
		$fill = $style->getFill();
		$info['fillType'] = $fill->getFillType();
		$info['fillColor'] = $fill->getStartColor()->getRGB();
		$info['borderBottomType'] = $style->getBorders()->getBottom()->getBorderStyle();
		return $info;
	}

}

// 

// $filePath = "archivos/Lista de códigos de barra - Inventario.xlsx";
// $excel = new LeerExcel();
// $data = $excel->obtenerDatosExcel($filePath);

// var_dump($data);
// die();

/*
$vals = array();
$cadena = array();
foreach ($listas as $hoja) {
    foreach ($hoja['data'] as $rp) {
        if($rp['retencion'] > 0){
            $vals[] = $this->codProceso;
            $vals[] = $rp['dni'];
            $vals[] = $rp['retencion'];
            $cadena[] = '(?,?,?,0)';
        }
    }
}


*/

// Validar que el tipo de archivo 
// echo var_dump($_POST);
// echo var_dump($_FILES);

// // En caso existe un imagen 
// if(!empty($_FILES)) {
//     $path_temp = $_FILES['foto']['tmp_name'];
//     $name = $_FILES['foto']['name'];
//     move_uploaded_file($path_temp, "archivos/$name");
// }

// Una vez cargada la imagen la mostramos en en una tabla HTML

?>