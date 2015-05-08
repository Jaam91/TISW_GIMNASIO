<?php
/* @var $this UsuarioController */
/* @var $model Usuario */

$this->breadcrumbs=array(
	'Opciones'=>array('ingresar'),
	'Ingresar Cliente',
);

$this->menu=array(
	array('label'=>'Ingresar Cliente', 'url'=>array('crearCliente')),
	array('label'=>'Gestión de Clientes', 'url'=>array('admin', 'id'=>2)),
	array('label'=>'Habilitar Cliente', 'url'=>array('lista', 'id'=>2)),
);
?>

<h2>Ingresar Cliente</h2>

<?php $this->renderPartial('_formCliente', array('model'=>$model, 'cliente'=>$cliente)); ?>