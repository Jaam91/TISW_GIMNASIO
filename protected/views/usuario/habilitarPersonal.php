<?php
/* @var $this AdministradorController */
/* @var $model Administrador */

$this->breadcrumbs=array(
	'Opciones'=>array('usuario/ingresar'),
	'Habilitar',
);

$this->menu=array(
	array('label'=>'Ingresar Personal', 'url'=>array('crearPersonal')),
	array('label'=>'Gestión del Personal', 'url'=>array('admin', 'id'=>1)),
	array('label'=>'Habilitar Personal', 'url'=>array('lista', 'id'=>1)),
);
?>

<h2>Habilitar Personal</h2>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'administrador-grid',
	'dataProvider'=>$model->search("","eliminado", ""),
	'filter'=>$model,
	'columns'=>array(
		'rut_usuario',
		'primer_nombre',
		'primer_apellido',
		'rol',
		array(
   			'name'=>'tipo',
   			'value' =>array($this, 'tipoInstructor'),

		),
		array(
			'name'=>'horario',
			'value' =>array($this, 'horarioInstructor'),

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
