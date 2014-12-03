<?php
  include('Barcode.php');
  include('funciones.php');
  $path1=$_GET['path1'];
  $archivo=$path1.$_GET['nombre']; 

  $aleatorio=aleatorio();
  $code=$aleatorio.time(); // TEXTO A DEL CODIGO BARRAS ;)
  // -------------------------------------------------- //
  //                  PROPERTIES
  // -------------------------------------------------- //
  
  // download a ttf font here for example : http://www.dafont.com/fr/nottke.font
  //$font     = './NOTTB___.TTF';
  // - -
  
  $fontSize = 10;   // GD1 in px ; GD2 in point
  $marge    = 0;   // between barcode and hri in pixel
  $x        = 100;  // barcode center
  $y        = 30;  // barcode center
  $height   = 50;   // barcode height in 1D ; module size in 2D
  $width    = 1;    // barcode height in 1D ; not use in 2D
  $angle    = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation
  $type     = 'code128';
  
  // -------------------------------------------------- //
  //                    USEFUL
  // -------------------------------------------------- //
  
  function drawCross($im, $color, $x, $y){
    imageline($im, $x - 10, $y, $x + 10, $y, $color);
    imageline($im, $x, $y- 10, $x, $y + 10, $color);
  }
  
  // -------------------------------------------------- //
  //            ALLOCATE GD RESSOURCE
  // -------------------------------------------------- //
  $im     = imagecreatetruecolor(210, 170);
//  $im2    = imagecreatefrompng("imagen/mensaje_barcode.png");

  $black  = ImageColorAllocate($im,0x00,0x00,0x00);
  $white  = ImageColorAllocate($im,0xff,0xff,0xff);
  $red    = ImageColorAllocate($im,0xff,0x00,0x00);
  $blue   = ImageColorAllocate($im,0x00,0x00,0xff);
  $font="arial.ttf";
  imagefilledrectangle($im, 0, 0, 210, 170, $white);
  $im2 =imagecreatefrompng('imagen/mensaje_barcode.png');
  
  // -------------------------------------------------- //
  //                      BARCODE
  // -------------------------------------------------- //
  $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);
  imagecopyresampled($im,$im2,0,$y+45,0,0,205,100,310,100);
 //   imagecopy($im, $im2, 0, 95, 0, 0, 350, 360);
    imagestring($im, 55, 20, $y+30, $code, $black);

  // -------------------------------------------------- //
  //                        HRI
  // -------------------------------------------------- //
  if ( isset($font) ){
    $box = imagettfbbox($fontSize, 0, $font, $data['hri']);
    $len = $box[2] - $box[0];
    Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
//    imagettftext($im, $fontSize, $angle, $x + 20, $y + 20, $black, "arial.tff", $code);

  }
  // -------------------------------------------------- //
  //                     ROTATE
  // -------------------------------------------------- //
  // Beware ! the rotate function should be use only with right angle
  // Remove the comment below to see a non right rotation
  /** /
  $rot = imagerotate($im, 45, $white);
  imagedestroy($im);
  $im     = imagecreatetruecolor(900, 300);
  $black  = ImageColorAllocate($im,0x00,0x00,0x00);
  $white  = ImageColorAllocate($im,0xff,0xff,0xff);
  $red    = ImageColorAllocate($im,0xff,0x00,0x00);
  $blue   = ImageColorAllocate($im,0x00,0x00,0xff);
  imagefilledrectangle($im, 0, 0, 900, 300, $white);
  
  // Barcode rotation : 90°
  $angle = 90;
  $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);
  Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
  imagettftext($im, $fontSize, $angle, $x + $xt, $y + $yt, $blue, $font, $data['hri']);
  imagettftext($im, 10, 0, 60, 290, $black, $font, 'BARCODE ROTATION : 90°');
  
  // barcode rotation : 135
  $angle = 135;
  Barcode::gd($im, $black, $x+300, $y, $angle, $type, array('code'=>$code), $width, $height);
  Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
  imagettftext($im, $fontSize, $angle, $x + 300 + $xt, $y + $yt, $blue, $font, $data['hri']);
  imagettftext($im, 10, 0, 360, 290, $black, $font, 'BARCODE ROTATION : 135°');
  
  // last one : image rotation
  imagecopy($im, $rot, 580, -50, 0, 0, 300, 300);
  imagerectangle($im, 0, 0, 299, 299, $black);
  imagerectangle($im, 299, 0, 599, 299, $black);
  imagerectangle($im, 599, 0, 899, 299, $black);
  imagettftext($im, 10, 0, 690, 290, $black, $font, 'IMAGE ROTATION');
  /**/

  // -------------------------------------------------- //
  //                    MIDDLE AXE
  // -------------------------------------------------- //
//  imageline($im, $x, 0, $x, 250, $red);
//  imageline($im, 0, $y, 250, $y, $red);
  
  // -------------------------------------------------- //
  //                  BARCODE BOUNDARIES
  // -------------------------------------------------- //
//  for($i=1; $i<5; $i++){
//    drawCross($im, $blue, $data['p'.$i]['x'], $data['p'.$i]['y']);
//  }
  
  // -------------------------------------------------- //
  //                    GENERATE
  // -------------------------------------------------- //
  header('Content-type: image/png');
  imagepng($im,'imagen/barcode.png',0);
  imagepng($im);

require_once('fpdf.php');
require_once('fpdi.php');

$pdf = new FPDI();
$pagecount = $pdf->setSourceFile($archivo);

            for ($i = 1; $i <= $pagecount; $i++) { 
                   $tplidx = $pdf->ImportPage($i); 
                   $s = $pdf->getTemplatesize($tplidx); 
                   $pdf->AddPage($s['w'] > $s['h'] ? 'L' : 'P', array($s['w'], $s['h'])); 
                   $pdf->useTemplate($tplidx); 
            } 


//$tplidx = $pdf->importPage(1, '/MediaBox');

//$pdf->addPage();
//$pdf->useTemplate($tplidx, 10, 10, 90);
$pdf->Image('imagen/barcode.png',160,280,50);             
imagedestroy($im);
$destino='firmar/'.$code.'.pdf';
$pdf->Output($destino, 'F');
if(file_exists($destino)) {
  unlink($archivo);
}

?>