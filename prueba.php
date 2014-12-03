<?php

//HACIENDO PRUEBAS PARA AGREGAR HOJA EN BLANCO AL FINAL DEL DUCUMENTO PDF
//MODIFICADO DIRECTAMENTE DESDE GITHUB (Para ver si al hacer fetch en la consola en local se actualiza)
require_once('fpdf.php');
require_once('fpdi.php');

$pdf = new FPDI();
$pagecount = $pdf->setSourceFile('20120710163425093.pdf');

            for ($i = 1; $i <= $pagecount; $i++) { 
                   $tplidx = $pdf->ImportPage($i); 
                   $s = $pdf->getTemplatesize($tplidx); 
                   $pdf->AddPage($s['w'] > $s['h'] ? 'L' : 'P', array($s['w'], $s['h'])); 
                   $pdf->useTemplate($tplidx); 
            } 


//$tplidx = $pdf->importPage(1, '/MediaBox');

//$pdf->addPage();
//$pdf->useTemplate($tplidx, 10, 10, 90);

$pdf->Output('newpdf.pdf', 'F');
?>
