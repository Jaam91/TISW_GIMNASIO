<?php $this->breadcrumbs=array(
	'Opciones'=>array('asignacionInstructor/opcion'),
	'Clientes'=>array('asignacionInstructor/lista'),
	'Disciplina'=>array('asignacionInstructor/elegir', 'rut'=>$rut),
	'Instructor',
);
?>


<h2>Asignación de Personal Trainer</h2>
<p> Seleccione un Personal Trainer y presione la opción Asignar</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'asignacion-instructor-grid',
	'dataProvider'=>$model->search2(),
	'filter'=>$model,
	'columns'=>array(
		//'rut_usuario',
		array(
			'header'=>'Rut Instructor',
			'name'=>'rut_usuario',
			'value'=>'$data->rut_usuario',
		),
		array(
   			'name'=>'primer_nombre',
   			'value' =>'$data->primer_nombre',
		),
		array(
   			'name'=>'primer_apellido',
   			'value' =>'$data->primer_apellido',
		),
		/*
		array(
   			'name'=>'tipo',  // sobreescribir el atributo rol
   			'value' =>'$data->instructor->tipo',
		),*/
		array(
   			'name'=>'horario',  
   			'value' =>'$data->instructor->horario',
		),

		array(
            'class' => 'CButtonColumn',
            'template'=>'{asignar}',
            'buttons'=> array(
				"asignar"=>array(
            	            'label'=>'asignar', // titulo del enlace del botón nuevo
		    				'imageUrl'=>'images/asignar.png',
		    				'click'=>'function(){return confirm("¿Está seguro que desea asignar este Personal Trainer?");}',
			                'url'=>'$this->grid->controller->createUrl("registrar", array(
			                        "rut_instructor"         => $data->primaryKey,
			                        "rut"    => "'.$rut.'",                                                                 
			                ))',
            			),
          		),
        ),               
	),
)); ?>