<?php
/* @var $this DisciplinaController */
/* @var $model Disciplina */

$this->breadcrumbs=array(
	'Opciones'=>array('opcionesModulo'),
	'Modificar',
);

$this->menu=array(
	array('label'=>'Ingresar Disciplina', 'url'=>array('crearDisciplina')),
	array('label'=>'Gestión de Disciplinas', 'url'=>array('admin')),
	array('label'=>'Habilitar Disciplina', 'url'=>array('lista')),
);
?>

<h2>Modificar Disciplina <?php echo $model->nombre; ?></h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>