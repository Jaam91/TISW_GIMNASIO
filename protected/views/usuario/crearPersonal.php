<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Opciones'=>array('ingresar'),
	'Ingresar Personal',
);

$this->menu=array(
	array('label'=>'Ingresar Personal', 'url'=>array('crearPersonal')),
	array('label'=>'Gestión del Personal', 'url'=>array('admin', 'id'=>1)),
	array('label'=>'Habilitar Personal', 'url'=>array('lista', 'id'=>1)),
);
?>

<h2>Ingresar Usuario de Personal</h2>

<?php $this->renderPartial('_formPersonal', array('model'=>$model, 'lista'=>$lista, 'id'=>0,
												'admin'=>$admin, 'actividad'=>$actividad)); ?>