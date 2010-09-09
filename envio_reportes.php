<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set("memory_limit","256M");
ini_set('max_execution_time', 3000);
ini_set('include_path', ini_get('include_path').':libs/');
ini_set('display_errors',1);
include("includes.php");
require 'class.phpmailer.php';
// load library
echo  mktime();
/** PHPExcel */
include 'PHPExcel.php';
/** PHPExcel_Writer_Excel5 */
include 'PHPExcel/Writer/Excel5.php';


$sql =  "
    SELECT 
        nombre,
        apellido,
        email,
        a.nombre_area as area,
        a.abve_nombre_area as abr_area
    FROM (
        SELECT 
            u.id_area as id,
            u.nombre_usuario as nombre,
            u.apellidos_usuario as apellido,
            u.email_usuario as email
        FROM usuarios u 
        WHERE id_rol = 3 
        ) as u	
    INNER JOIN areas a ON a.id_area = u.id              
";
					
$q = new Consulta($sql);
$users = $q->getRows();
// mailer
ob_start();
$fecha = date("d-m-Y");
require 'Templates/mail/reporte.php'; 
$content = ob_get_contents();
ob_end_clean();
#dump($users); exit;

# Create a excel file!



$mail = new PHPMailer();

$mail->WordWrap = 50;
$mail->IsSMTP();
$mail->Host = "10.10.11.5";
$mail->SetFrom('webmaster@sernanp.gob.pe', 'Webmaster SERNANP');
# Loop the user to sent a email;

foreach($users as $k=>$user){
    # SQL to the report
    $sql = "
        SELECT
            dr.id_documento_reporte AS id,
            dr.numero_registro AS registro,
            dr.numero_documento AS documento,
            dr.remitente AS remitente,
            DATE_FORMAT( dr.fecha_registro , '%d-%m-%Y ' ) AS fecha,
			dr.ubicacion AS ubicacion, 
            IF( p.tiempo_horas_respuesta_prioridad, 
                DATE_FORMAT( ADDDATE(dr.fecha_registro, 
                    p.tiempo_horas_respuesta_prioridad/24  ) , '%d-%m-%Y ' )
                , '-')  AS fecha_r,
            dr.estado,
            dr.asunto AS asunto,
            dr.prioridad,
            IF( p.tiempo_horas_respuesta_prioridad, (
                    DATEDIFF( 
                        ADDDATE(dr.fecha_registro, 
                          p.tiempo_horas_respuesta_prioridad/24  ),
                        CURDATE() 
                          ) 
                      ) , 0) AS dias_faltantes  
		FROM
            documentos_reporte AS dr
        LEFT JOIN 
            prioridades as p ON p.nombre_prioridad = dr.prioridad
		WHERE 
            dr.ubicacion like '$user->abr_area%'
            AND dr.estado not like 'A'
        ORDER BY
            dias_faltantes DESC
    ";
    
    $q = new Consulta($sql);
    $docs = $q->getRows();
    
    
    if( count($docs) > 0) {
    
        // Create new PHPExcel object
        echo date('H:i:s') . " Create new PHPExcel object - <b>$user->nombre</b>\n<br />";
        $objPHPExcel = new PHPExcel();

        // Set properties
        echo date('H:i:s') . " Set properties\n<br />";
        $objPHPExcel->getProperties()->setCreator("Enrique Juan de Dios");
        $objPHPExcel->getProperties()->setLastModifiedBy("Enrique Juan de Dios");
        $objPHPExcel->getProperties()->setTitle ("Reporte de".date("d-m-Y")." - Area" ) ;
        $objPHPExcel->getProperties()->setSubject("Reporte de".date("d-m-Y"));
        $objPHPExcel->getProperties()->setDescription("Reporte de".date("d-m-Y")." - Area");
        
        $boldFont = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
            'font'=>array(
                'bold'=>true
            )
        );
        

        // Add some data
        echo date('H:i:s') . " Add some data\n<br />";
        $objPHPExcel->setActiveSheetIndex(0);
        $aSheet = $objPHPExcel->getActiveSheet();
        $aSheet->SetCellValue("A1", "N. Registro" );
        $aSheet->SetCellValue("B1", "Remitente" );
        $aSheet->SetCellValue("C1", "Documento" );
        $aSheet->SetCellValue("D1", "Registrado");
        $aSheet->SetCellValue("E1", "Resp. Aprox" );
        $aSheet->SetCellValue("F1", "Estado" );
        $aSheet->SetCellValue("G1", "Ubicacion" );
        $aSheet->SetCellValue("H1", "Dias" );
        $aSheet->getStyle('A1:H1')->applyFromArray($boldFont);
        
        foreach( $docs as $i=>$doc ){
            $c=$i+2;
            $aSheet->SetCellValue("A$c", $doc->registro );
            $aSheet->SetCellValue("B$c", $doc->remitente );
        /* 
          */  
            $aSheet->SetCellValue("C$c", $doc->documento );
            $aSheet->SetCellValue("D$c", $doc->fecha);
            $aSheet->SetCellValue("E$c", $doc->fecha_r );
            $aSheet->SetCellValue("F$c", $doc->estado );
            $aSheet->SetCellValue("G$c", $doc->ubicacion );
            $aSheet->SetCellValue("H$c", $doc->dias_faltantes );
        }
        $aSheet->getStyle("A2:H$c")->getFont()->setSize(9);
        
        $aSheet->getColumnDimension('A')->setWidth (20);
        $aSheet->getColumnDimension('B')->setWidth (50);
        $aSheet->getColumnDimension('C')->setWidth (40);
        $aSheet->getColumnDimension('D')->setWidth (12);
        $aSheet->getColumnDimension('E')->setWidth (12);
        $aSheet->getColumnDimension('F')->setWidth (10);
        $aSheet->getColumnDimension('G')->setWidth (10);
        $aSheet->getColumnDimension('H')->setWidth (6);

        //-----Put in a Title-----
        $aSheet->insertNewRowBefore(1, 2);//Some empty rows for space 
        $aSheet->insertNewRowBefore(1, 2);//Some empty rows for space 
        $aSheet->insertNewRowBefore(1, 2);//Some empty rows for space 
        $aSheet->setCellValue('A4', $user->area );
        $aSheet->setCellValue('A5', 'Reporte de Atención de documentos'.date("d-m-Y")." $user->abr_area" );
        $aSheet->getStyle('A4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_DARKYELLOW);
        $aSheet->getStyle('A4')->getFont()->setSize(16); 
        $aSheet->getStyle('A5')->getFont()->setSize(12); 
        
        // Add a drawing to the worksheet
        echo date('H:i:s') . " Add a drawing to the worksheet\n<br/>";
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $objDrawing->setPath('./public_root/imgs/logo-oficial.jpg');
        $objDrawing->setHeight(46);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setResizeProportional(false);
        $objDrawing->setWorksheet( $aSheet );
        
        // Rename sheet
        echo date('H:i:s') . " Rename sheet\n<br />";
        $aSheet->setTitle("Area $user->abr_area"); 

                
        // Save Excel 2000 file
        echo date('H:i:s') . " Write to Excel5 format\n<br />";
        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter->save("temp/reporte$k.xls");

        /**************End save*****************/

        

        /*
    */
        #$xls->generateAndSaveXML($_SERVER['DOCUMENT_ROOT'] . '/temp/', 'my-test.xls');
        $mail->Subject = $user->abr_area.": Reporte de Atencion de Documentos:".date('d-m-Y');
        $mail->Body = $content;
        #echo $user->email;
        $mail->AddAddress('juandedioz@gmail.com');
        $mail->AddAddress('jcondori@sernanp.gob.pe');
        $mail->AddAddress('ycoyla@sernanp.gob.pe');
        #$mail->AddAddress($user->email);
        $mail->IsHTML(true);
        $mail->AddAttachment("./temp/reporte$k.xls","reporte-$user->abr_area.xls");
        if(!$mail->Send()){
           echo 'Message was not sent.';
           echo 'Mailer error: ' . $mail->ErrorInfo;
        }else{
           echo 'Message has been sent.<br /><br />';
        }
        $mail->ClearAddresses();
        $mail->ClearAttachments();
        # Delete created File
        @unlink("/temp/reporte$k.xls");
    }
    sleep(1);
}


?>
  