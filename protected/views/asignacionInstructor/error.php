<?php

$this->breadcrumbs=array(
	'Clientes'=>array('asignacionInstructor/lista'),
	'Error',
);
?>

<html>
<head>
<h2>Error en Asignación de Instructor</h2>

</head>
<body>
	<br><br>	
	<div style="text-align: left"><b>El Cliente <?php echo $nombre ?> ya está inscrito en TODAS las actividades del Gimnasio</b></br><br>

	<br><br>
<br><h3>Lista de Actividadas inscritas por el cliente: <?php echo $nombre?></h3>

<?php if($p_trainer == 1):?>
	<h5>- Cliente con Personal Trainer</h5>
<?php endif;	

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'unidad-medica-grid',
	'dataProvider'=>$actividad,
	'columns'=>array(
		array(
			'header'=>'Nombre Actividad',
			'name'=>'id_actividad',
			'value'=>'$data->actividad0->nombre',
			'filter'=> false,
		),
		array(
			'header'=>'Dependencia',
			'name'=>'id_dependencia',
			'value'=>'$data->actividad0->idDependencia->nombre',
			'filter'=> false,
		),
	),
)); ?>

	<ul class="nav nav-list">
	  <li class="">
   			 <td> <?php echo CHtml::link('Volver',array('lista', 'id'=>1));?></td> 
	  </li>
	</ul>	

</body>
</html>
