<?php 
require_once('Connections/gestor.php');
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
//$hostname = '{mail.verificarfirma.cl/notls}';

//$username = 'contacto@verificarfirma.cl';
$username = 'cbrcorreos@gmail.com';
$password = '91829182';
 
/* Intento de conexión */

$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());



/* Recuperamos los emails */

$emails = imap_search($inbox,'UNSEEN'); //UNSEEN -> SIN LEER


/* Si obtenemos los emails, accedemos uno a uno... */

if($emails) {



    /* variable de salida */

    $output = '';



    /* Colocamos los nuevos emails arriba */

    rsort($emails);



    /* por cada email... */

    foreach($emails as $email_number) {



        /* Obtenemos la información específica para este email */

        $overview = imap_fetch_overview($inbox,$email_number,0); //CABECERA

        $message = base64_decode(imap_fetchbody($inbox, $email_number, 1)); //CUERPO
        /* Mostramos la información de la cabecera del email */
        	$asunto=$overview[0]->subject;
        	if ($asunto=='Solicitud Documentos CBR Chillan') {
				$ide= "<strong>PEDIDO WEB  "; 
				$ide2= "</strong>"; 
        		$caratula=trim(substr ($message,strpos($message,$ide)+20,-(strlen ($message)-stripos($message,$ide2))));
        		$asunto=$asunto;
				$ide= "<td>E-Mail</td>"; 
				$ide2= "Forma"; 
	       		$email=trim(substr ($message,strpos($message,$ide)+15,-(strlen ($message)-stripos($message,$ide2)+1)));
                $ide= "<td>"; 
                $ide2= "</td>"; 
                $email=trim(substr ($email,strpos($email,$ide)+4,-(strlen ($email)-stripos($email,$ide2))));
                echo "CARATULA : ".$caratula."<br/>";
                echo "EMAIL : ".$email."<br/><br/>";
//              INGRESA DATOS A LA BASE DE DATOS
                $sql="INSERT INTO caratula (caratula,email) VALUES ('$caratula', '$email')";
                mysql_query($sql,$gestor);
          	}
        imap_delete($inbox,$email_number); //MARCA CORREO COMO ELIMINADO
    }
    imap_expunge($inbox);  //Borra definitivamente los correos marcados para eliminación
} 



/* Cerramos la connexión */

imap_close($inbox);

?>