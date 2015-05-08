<?php
/* @var $this DisciplinaController */
/* @var $model Disciplina */

$this->breadcrumbs=array(
	'Opciones'=>array('opcionesModulo'),
	'Gestión de disciplinas'=>array('admin'),
	'Resultado Ingreso',
);

$this->menu=array(
	array('label'=>'Ingresar Disciplina', 'url'=>array('crearDisciplina')),
	array('label'=>'Gestión de Disciplinas', 'url'=>array('admin')),
	array('label'=>'Habilitar Disciplina', 'url'=>array('lista')),
);

if($tipo == 1):?>
	<h3>¡La Disciplina <?php echo $model->nombre; ?> se ha ingresado exitosamente!</h3>
<?php endif;

if($tipo == 2):?>
	<h3>¡La Disciplina <?php echo $model->nombre; ?> se ha modificado exitosamente!</h3>
<?php endif;


$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
		'valor_mensualidad',
		'estado',
	),
)); ?>
