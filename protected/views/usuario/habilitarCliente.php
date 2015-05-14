<?php
/* @var $this AdministradorController */
/* @var $model Administrador */

$this->breadcrumbs=array(
	'Opciones'=>array('usuario/ingresar'),
	'Habilitar',
);

$this->menu=array(
	array('label'=>'Ingresar Cliente', 'url'=>array('usuario/crearCliente')),
	array('label'=>'Gestión de Clientes', 'url'=>array('admin', 'id'=>2)),
	array('label'=>'Habilitar Cliente', 'url'=>array('lista', 'id'=>2)),
);
?>

<h2>Habilitar Cliente</h2>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cliente-grid',
	'dataProvider'=>$model->search("Cliente","eliminado",""),
	'filter'=>$model,
	'columns'=>array(
		'rut_usuario',
		array(
   			'name'=>'primer_nombre',
   			'value' =>'$data->primer_nombre',
		),
		array(
   			'name'=>'primer_apellido',
   			'value' =>'$data->primer_apellido',
		),
		array(
			'name'=>'telefono',
			'value' =>'$data->cliente->telefono_emergencia',
		),
		array(
			'name'=>'peso',
			'value' =>'$data->cliente->peso',
		),		
		array(
			'name'=>'altura',
			'value' =>'$data->cliente->altura',
		),
		array(
			'class'=>'CButtonColumn',
			'template'=> '{habilitar}',
			'buttons'=>array(
				"habilitar"=>array(					
            	            'label'=>'habilitar', // titulo del enlace del botón nuevo
            	            'click'=>'function(){return confirm("¿Seguro que desea habilitar este Usuario?");}',
		    				'imageUrl'=>'images/habilitar.png',
           					'url'=>'CHtml::normalizeUrl(array("habilitar","rut"=>$data->primarykey))',
					),
				),
		),
	),
)); ?>
