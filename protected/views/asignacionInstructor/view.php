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

if($numero == 1):?>
	<h2>¡Registro de Asignación de Instructor Exitoso!</h2>
<?php endif;

if($numero == 2):?>
	<h2>¡Nuevo Instructor asignado con Éxito!</h2>
<?php endif;

if($model->id_actividad == NULL){  // Asignacion de Personal Trainer

	$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'rut_instructor','value'=>$model->rutInstructor->rutUsuario->primer_nombre.' '.
												$model->rutInstructor->rutUsuario->primer_apellido),
		array('name'=>'rut_cliente','value'=>$model->rutCliente->rutUsuario->primer_nombre.' '.
											 $model->rutCliente->rutUsuario->primer_apellido),
		array('header'=>'Tipo','name'=>'id_actividad','value'=>'Personal Trainer'),
	),
)); }
else
{
	$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'rut_instructor','value'=>$model->rutInstructor->rutUsuario->primer_nombre.' '.
												$model->rutInstructor->rutUsuario->primer_apellido),
		array('name'=>'rut_cliente','value'=>$model->rutCliente->rutUsuario->primer_nombre.' '.
											 $model->rutCliente->rutUsuario->primer_apellido),
		array('name'=>'id_actividad','value'=>$model->actividad0->nombre),
		),
	)); }

if($numero == 1):?>
		<ul class="nav nav-list">
			<br><br>
  			<li class="">
  	  			<td> <?php echo CHtml::link('Registrar nueva Asignación',array('lista'));?></td>
  			</li>
		</ul>
<?php endif;


if($numero == 2):?>
		<ul class="nav nav-list">
			<br><br>
  			<li class="">
  	  			<td> <?php echo CHtml::link('Gestión de Asignaciones',array('admin'));?></td>
  			</li>
		</ul>
<?php endif;