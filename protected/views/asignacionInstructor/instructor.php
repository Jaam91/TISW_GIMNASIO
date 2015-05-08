<?php $this->breadcrumbs=array(
	'Opciones'=>array('asignacionInstructor/opcion'),
	'Clientes'=>array('asignacionInstructor/lista'),
	'Disciplina'=>array('asignacionInstructor/elegir', 'rut'=>$rut),
	'Instructor',
);
?>


<h2>Asignación de Instructor Fitness</h2>
<p> Seleccione un Instructor y presione la opción Asignar</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'asignacion-instructor-grid',
	'dataProvider'=>$model->search2("habilitado", ""),
	'filter'=>$model,
	'columns'=>array(
		array(
			'header'=>'Rut Instructor',
			'name'=>'rut_usuario',
			'value'=>'$data->rut_usuario',
		),
		array(
   			'name'=>'primer_nombre',
   			'value' =>'$data->primer_nombre." ".$data->primer_apellido." ".$data->segundo_apellido',
   			'filter'=>'',
		),
		array(
   			'name'=>'tipo',  // sobreescribir el atributo rol
   			'value' =>'$data->instructor->tipo',
   			'filter'=>'',
		),
		array(
   			'name'=>'horario',  
   			'value' =>'$data->instructor->horario',
   			'filter'=>'',
		),

		array(
            'class' => 'CButtonColumn',
            'template'=>'{asignar}',
            'buttons'=> array(
				"asignar"=>array(
            	            'label'=>'asignar', // titulo del enlace del botón nuevo
		    				'imageUrl'=>'images/asignar.png',
		    				'click'=>'function(){return confirm("¿Está seguro que desea asignar este Instructor?");}',
			                'url'=>'$this->grid->controller->createUrl("registrar", array(
			                        "rut_instructor"         => $data->primaryKey,
			                        "rut"    => "'.$rut.'",                                                                 
			                ))',
            			),

          		),
        ),
	),
)); ?>
