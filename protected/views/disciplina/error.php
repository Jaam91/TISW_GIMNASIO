<?php

$this->breadcrumbs=array(
	'Gestion de disciplinas'=>array('admin'),
	'Resultado eliminación',
);
?>

<html>
<head>

<h2>Error en Eliminación de la disciplina</h2>

</head>
<body>
	<br><br>	
	<div style="text-align: left"><b>Disciplina <?php echo $nombre ?> no puede ser eliminada porque:</b></br></br>

	
	<?php
			echo "<li>"."<div style='text-align: left'>".'Actualmente se realizan las siguienes actividades.'."</li>";

	 		$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'actividad-grid',
			'dataProvider'=>$modelAct->searchClientes(0, $id),
			'filter'=>$modelAct,
			'columns'=>array(
				array(
   					'name'=>'nombre',
   					'value' =>'$data->nombre',
   					'filter'=>'',
				),
				array(
   					'name'=>'id_disciplina',
   					'value' =>'$data->id_disciplina',
   					'filter'=>'',
				),
				array(
   					'name'=>'id_dependencia',
   					'value' =>'$data->id_dependencia',
   					'filter'=>false,
				),
				array(
   					'name'=>'rut_instructor',
   					'value' =>'$data->rutUsuario->rutUsuario->primer_nombre." ".$data->rutUsuario->rutUsuario->primer_apellido',
   					'filter'=>'',
				),
				array(
   					'name'=>'cantidad_clientes',
   					'value' =>'$data->cantidad_clientes',
   					'filter'=>'',
				),
			),
		));
	?>

	<ul class="nav nav-list">
	  <li class="">
   			 <td> <?php echo CHtml::link('Volver',array('disciplina/admin'));?></td> 
	  </li>
	</ul>	
</body>
</html>
