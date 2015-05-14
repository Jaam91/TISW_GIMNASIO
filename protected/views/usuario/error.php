<?php

// 1 es Delete
if($num == 1):

$this->breadcrumbs=array(
	'Gestionar'=>array('admin', 'id'=>1),
	'Error en Eliminación',
);
?>

<h2>Error en Eliminación de Instructor</h2>

	<br><br>	
	<div style="text-align: left"><b>El Instructor <?php echo $nombre ?> no puede ser eliminado,
		 porque tiene clientes inscritos en una Actividad. -Se recomienda Eliminar la Asignación Vigente</b></br><br>

		<div style="text-align: left"><b>La actividad asignada es la siguiente: <?php echo $actividad?></b></br></br>

<?php endif; 

// 2 es Update
if($num == 2):

	$this->breadcrumbs=array(
		'Gestionar'=>array('admin', 'id'=>1),
		'Error en Modificación',
	);
	?>

	<h2>Error en Modificación de Tipo de Instructor</h2>	
	
	<br><br>	
	<div style="text-align: left"><b>El Instructor <?php echo $nombre ?> no puede cambiar su Actividad,
		 porque tiene clientes inscritos en aquella Actividad. -Se recomienda Eliminar la Asignación Vigente</b></br><br>

	<div style="text-align: left"><b>La actividad asignada es la siguiente: <?php echo $actividad?></b></br></br>
<?php endif;?>


	<ul class="nav nav-list">
	  <li class="">
   			 <td> <?php echo CHtml::link('Eliminar asignación',array('asignacionInstructor/admin'));?></td> 
	  </li>
	</ul>

	<ul class="nav nav-list">
	  <li class="">
   			 <td> <?php echo CHtml::link('Volver',array('admin', 'id'=>1));?></td> 
	  </li>
	</ul>	

<?php if($num == 2):
?>
	<h5>Nota: Los cambios de Información Personal si se aplicaron</h5>

<?php endif;?>