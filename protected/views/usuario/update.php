<?php  if($tipo == 1):

$this->breadcrumbs=array(
	'Opciones'=>array('ingresar'),
	'Gestionar'=>array('admin', 'id'=>1),
	'Modificar Personal',
);

$this->menu=array(
	array('label'=>'Ingresar Personal', 'url'=>array('crearPersonal')),
	array('label'=>'Gestión del Personal', 'url'=>array('admin', 'id'=>1)),
	array('label'=>'Habilitar Personal', 'url'=>array('lista', 'id'=>1)),
);
?>

<h2>Modificar Personal </h2>

<?php 
if($id == 3)
	$this->renderPartial('_formAdmin', array('model'=>$model, 'admin'=>$admin));
else
	$this->renderPartial('_formPersonal', array('model'=>$model, 'lista'=>$lista, 'id'=>4,
												'admin'=>$admin, 'actividad'=>$actividad));
endif; ?>

<?php  if($tipo == 2):

$this->breadcrumbs=array(
	'Opciones'=>array('ingresar'),
	'Gestionar'=>array('admin', 'id'=>2),
	'Modificar Cliente',
);

$this->menu=array(
	array('label'=>'Ingresar Cliente', 'url'=>array('crearCliente')),
	array('label'=>'Gestión de Clientes', 'url'=>array('admin', 'id'=>2)),
	array('label'=>'Habilitar Cliente', 'url'=>array('lista', 'id'=>2)),
);
?>

<h2>Modificar Cliente </h2>

<?php $this->renderPartial('_formCliente', array('model'=>$model, 'cliente'=>$cliente));
endif; ?>
