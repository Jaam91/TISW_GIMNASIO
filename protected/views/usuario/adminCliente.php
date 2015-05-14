<?php
/* @var $this ClienteController */
/* @var $model Cliente */

$this->breadcrumbs=array(
	'Opciones'=>array('usuario/ingresar'),
	'Gestionar',
);


$this->menu=array(
	array('label'=>'Ingresar Cliente', 'url'=>array('crearCliente')),
	array('label'=>'Gestión de Clientes', 'url'=>array('admin', 'id'=>2)),
	array('label'=>'Habilitar Cliente', 'url'=>array('lista', 'id'=>2)),
	
);
?>

<h2>Administrar Clientes</h2>

<h3><p>Cuentas de usuario de Clientes en el sistema</p></h3>
<p>Edite o elimine las cuentas fácilmente con los iconos al costado derecho en la tabla</p>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cliente-grid',
	'dataProvider'=>$model->search("Cliente","habilitado"),
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
            'class' => 'CButtonColumn',
            'template'=>'{update}{eliminar}',
            'buttons'=> array(
				"update"=>array(
            			'label' => 'modificar',
            			'imageUrl'=>'images/modificar.png',
            			'url'=>'CHtml::normalizeUrl(array("updateCliente","id"=>$data->primarykey))',
                        ),
				"eliminar"=>array(					
            	            'label'=>'eliminar', // titulo del enlace del botón nuevo
            	            'click'=>'function(){return confirm("¿Está seguro que desea eliminar este Cliente?");}',
		    				'imageUrl'=>'images/eliminar.png',
           					'url'=>'CHtml::normalizeUrl(array("deleteCliente","id"=>$data->primarykey))',        					
						),

          		),
        ),
	),
)); ?>
