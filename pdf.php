<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nuevo</title>
</head>
     
<body>
<?php  
$path1=$_GET['path1'];
$nombre=$_GET['nombre']; ?>
DOCUMENTO: <?php echo $nombre;?>
<object data="<?php echo $path1.$nombre?>" type="application/pdf" width="700" height="300">
  alt : <a href="<?php echo $path1.$nombre?>">PDF</a>
</object>
</body>

</html>
