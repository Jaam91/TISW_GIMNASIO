<?php
/* @var $this AsignacionInstructorController */
/* @var $model AsignacionInstructor */

$this->breadcrumbs=array(
	'Registro',
);

$this->menu=array(
	array('label'=>'Ingresar Asignación', 'url'=>array('lista')),
	array('label'=>'Gestión de Asignaciones', 'url'=>array('admin')),
);
?>

<h2>¡Registro de Asignación de Instructor Exitoso!</h2>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_asignacion',
		'rut_instructor',
		'rut_cliente',
		'actividad',
		'estado',
	),
)); ?>

		<ul class="nav nav-list">
			<br><br>
  			<li class="">
  	  			<td> <?php echo CHtml::link('Registrar nueva Asignación',array('lista'));?></td>
  			</li>
		</ul>