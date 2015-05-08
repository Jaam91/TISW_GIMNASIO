<html>
<head>

<?php

$this->breadcrumbs=array(
	'Gestion de disciplinas'=>array('admin'),
	'Resultado eliminación',
);
?>

<h2>Éxito en la eliminación de la disciplina</h2>

</head>
<body>
	<br><br>	
	<div style="text-align: left"><b>¡La disciplina <?php echo $nombre ?> se ha eliminado exitosamente!</b> </br></br>

	

	<ul class="nav nav-list">
	  <li class="">
   			 <td> <?php echo CHtml::link('Volver',array('disciplina/admin'));?></td> 
	  </li>
	</ul>	
</body>
</html>