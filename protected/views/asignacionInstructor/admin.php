<?php
/* @var $this AsignacionInstructorController */
/* @var $model AsignacionInstructor */

$this->breadcrumbs=array(
	'Opciones'=>array('opcion'),
	'Gestión de Asignaciones',
);

$this->menu=array(
	array('label'=>'Ingresar Asignación', 'url'=>array('asignacionInstructor/lista')),
	array('label'=>'Gestión de Asignaciones', 'url'=>array('asignacionInstructor/admin')),
);
?>

<h2>Gestión de Asignaciones</h2>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'asignacion-instructor-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id_asignacion',
		array(
   			'name'=>'rut_cliente',
   			'value' =>'$data->rutCliente->rutUsuario->primer_nombre." ".
   					  $data->rutCliente->rutUsuario->primer_apellido." ".
   					  $data->rutCliente->rutUsuario->segundo_apellido',
   			'filter'=>'',
		),
		array(
   			'name'=>'rut_instructor',
   			'value' =>'$data->rutInstructor->rutUsuario->primer_nombre." ".
   					  $data->rutInstructor->rutUsuario->primer_apellido." ".
   					  $data->rutInstructor->rutUsuario->segundo_apellido',
   			'filter'=>'',
		),

    array(
      'name'=>'id_actividad',
      'value' => array($this, 'nombreActividad'),
      'filter'=>'',
    ),
		array(
            'class' => 'CButtonColumn',
            'template'=>'{update}{eliminar}',
            'buttons'=> array(
				"update"=>array(
            			'label' => 'modificar',
            			'imageUrl'=>'images/modificar.png', 
                        ),
				"eliminar"=>array(					
            	            'label'=>'eliminar', // titulo del enlace del botón nuevo
            	            'click'=>'function(){return confirm("¿Está seguro que desea eliminar esta Asignación?");}',
		    				          'imageUrl'=>'images/eliminar.png',
           					      'url'=>'CHtml::normalizeUrl(array("delete","id"=>$data->primarykey))',          					
						),

          		),
        ),
	),
)); ?>
