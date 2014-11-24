<?php 
function aleatorio() {
	$str = "ABCDEFGHJKMNOPQRSTUVWXYZabcdefghjkmnopqrstuvwxyz1234567890";
	$cad = "";
	for($i=0;$i<8;$i++) {
	$cad .= substr($str,rand(0,58),1);
	}
	return $cad;
}

function mes_a_palabra($fecha){
//PASAR EL MES DE LA FECHA DE NUMEROS A PALABRA
$i=split('-',$fecha); 
$dia=$i[0]; 
$mes=$i[1]; 
$ano=$i[2]; 
  switch ($mes) {
    case "1":
		$mes_palabras="Enero";
      break;    
    case "2":
		$mes_palabras="Febrero";
      break;    
    case "3":
		$mes_palabras="Marzo";
      break;    
    case "4":
		$mes_palabras="Abril";
      break;    
    case "5":
		$mes_palabras="Mayo";
      break;    
    case "6":
		$mes_palabras="Junio";
      break;    
    case "7":
		$mes_palabras="Julio";
      break;    
    case "8":
		$mes_palabras="Agosto";
      break;    
    case "9":
		$mes_palabras="Septiembre";
      break;    
    case "10":
		$mes_palabras="Octubre";
      break;    
    case "11":
		$mes_palabras="Noviembre";
      break;    
    case "12":
		$mes_palabras="Diciembre";
      break;    
  }
return $mes_palabras; 
}

function mes_a_palabra2($mes){
//PASAR EL MES DE NUMEROS A PALABRA
 switch ($mes) {
    case "1":
		$mes_palabras="Enero";
      break;    
    case "2":
		$mes_palabras="Febrero";
      break;    
    case "3":
		$mes_palabras="Marzo";
      break;    
    case "4":
		$mes_palabras="Abril";
      break;    
    case "5":
		$mes_palabras="Mayo";
      break;    
    case "6":
		$mes_palabras="Junio";
      break;    
    case "7":
		$mes_palabras="Julio";
      break;    
    case "8":
		$mes_palabras="Agosto";
      break;    
    case "9":
		$mes_palabras="Septiembre";
      break;    
    case "10":
		$mes_palabras="Octubre";
      break;    
    case "11":
		$mes_palabras="Noviembre";
      break;    
    case "12":
		$mes_palabras="Diciembre";
      break;    
  }
return $mes_palabras; 
}
?>