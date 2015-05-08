<?php
/* @var $this ClienteController */
/* @var $model Cliente */

$this->breadcrumbs=array(
	'Opciones'=>array('opcion'),
	'Clientes',
);

$this->menu=array(
	array('label'=>'Ingresar Asignación', 'url'=>array('asignacionInstructor/lista')),
	array('label'=>'Gestión de Asignaciones', 'url'=>array('asignacionInstructor/admin')),
);
?>

<h2>Lista de Clientes Inscritos</h2>

<p>Seleccione al cliente y presione la opción Siguiente</p>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cliente-grid',
	'dataProvider'=>$model->search("Cliente","habilitado"),
	'filter'=>$model,
	'columns'=>array(
		'rut_usuario',
		array(
   			'name'=>'primer_nombre',
   			'value' =>'$data->primer_nombre." ".$data->primer_apellido',
   			'filter'=>'',
		),
		#'telefono_emergencia',
		#'peso',
		#'altura',
		#'enfermedades_previas',
		array(
            'class' => 'CButtonColumn',
            'template'=>'{asistencia}',
            'buttons'=> array(
				"asistencia"=>array(
            			'label' => 'Siguiente',
            			'imageUrl'=>'images/siguiente.png',
            			'url'=>'CHtml::normalizeUrl(array("elegir","rut"=>$data->primarykey))',
                        ),

          		),
        ),
	),
)); ?>
