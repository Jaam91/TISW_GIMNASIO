<?php
/* @var $this AdministradorController */
/* @var $model Administrador */

$this->breadcrumbs=array(
	'Opciones'=>array('usuario/ingresar'),
	'Gestionar',
);

$this->menu=array(
	array('label'=>'Ingresar Personal', 'url'=>array('crearPersonal')),
	array('label'=>'Gestión del Personal', 'url'=>array('admin', 'id'=>1)),
	array('label'=>'Habilitar Personal', 'url'=>array('lista', 'id'=>1)),
);
?>

<h2>Administrar Usuarios del Personal</h2>

<h3><p>Cuentas de usuario en el sistema</p></h3>
<p>Edite o elimine las cuentas fácilmente con los iconos al costado derecho en la tabla</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'administrador-grid',
	'dataProvider'=>$model->search("","habilitado"),
	'filter'=>$model,
	'columns'=>array(
		'rut_usuario',
		array(
   			'name'=>'primer_nombre',
   			'value' =>'$data->primer_nombre." ".$data->primer_apellido',
   			'filter'=>'',
		),
		'rol',
		array(
   			'name'=>'tipo',
   			'value' =>array($this, 'tipoInstructor'),
   			'filter'=>'',
		),
		array(
			'name'=>'horario',
			'value' =>array($this, 'horarioInstructor'),
			'filter'=>'',
		),
		array(
            'class' => 'CButtonColumn',
            'template'=>'{no_permitido}{update}{eliminar}',
            'buttons'=> array(
				"update"=>array(
            			'label' => 'modificar',
            			'imageUrl'=>'images/modificar.png',
            			'visible' => '$data->rut_usuario != Yii::app()->user->name',
                        ),
				"eliminar"=>array(					
            	            'label'=>'eliminar', // titulo del enlace del botón nuevo
            	            'click'=>'function(){return confirm("¿Está seguro que desea eliminar este Usuario?");}',
		    				'imageUrl'=>'images/eliminar.png',
           					'url'=>'CHtml::normalizeUrl(array("delete","id"=>$data->primarykey))',
           					'visible' => '$data->rut_usuario != Yii::app()->user->name',           					
						),
				"no_permitido"=>array(
            	            'label'=>'NO PERMITIDO', // titulo del enlace del botón nuevo
		    				'imageUrl'=>'images/no_disponible.png',
		    				'visible' => '$data->rut_usuario == Yii::app()->user->name',  //<< el condicional
            			),

          		),
        ),
	),
)); ?>
