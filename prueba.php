<?php

//HACIENDO PRUEBAS PARA AGREGAR HOJA EN BLANCO AL FINAL DEL DUCUMENTO PDF
//MODIFICADO DIRECTAMENTE DESDE GITHUB (Para ver si al hacer fetch en la consola en local se actualiza)
//Agregando mas comentarios, para ver como actualiza el archivo en local
//Para sincronizar el archivo local con el remoto modificado en github (online)
//en linea de comando en el pc local hacer un git fetch y luego un git merge origin
//esos 2 comandos se pueden resumir en git push
//ahora estoy modificando en local y enviaré los cambios a github (repositorio remoto en internet)
//en local los comando son git add -A   y   luego git commit -m "Mensaje referencial al cambio"
// estos 2 comandos se resumen en git commit -am "Mensaje referencial al cambio"
// y finalmente para enviar los cambios el comando es git push -u origin master
// ahora modificado desde la casa.
// se modificó el nombre de usuario para mi notebook i7
// Para recibir los cambios en local en el pc del trabajo el comando es git fetch   y   luego git merge origin master 



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
