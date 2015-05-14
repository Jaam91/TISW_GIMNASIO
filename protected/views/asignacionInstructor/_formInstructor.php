<?php
/* @var $this AsignacionInstructorController */
/* @var $model AsignacionInstructor */

$this->breadcrumbs=array(
	'Opciones'=>array('opcion'),
	'Gestión de Asignaciones'=>array('admin'),
	'Seleccione Instructor',
);

$this->menu=array(
	array('label'=>'Ingresar Asignación', 'url'=>array('asignacionInstructor/lista')),
	array('label'=>'Gestión de Asignaciones', 'url'=>array('asignacionInstructor/admin')),
);
?>

<h2>Ingresar nuevo Instructor</h2>

<h5>Seleccione al nuevo instructor y presione la opción guardar</h5>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'asignacion-instructor-grid',
	'dataProvider'=>$model->search3($tipo, $rut),
	'filter'=>$model,
	'columns'=>array(
		'rut_usuario',
		array(
   			'name'=>'primer_nombre',
   			'value' =>'$data->primer_nombre." ".$data->primer_apellido',
   			'filter'=>'',
		),
		array(
   			'name'=>'tipo',
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
			                'url'=>'$this->grid->controller->createUrl("asignar", array(
			                        "rut_instructor"         => $data->primaryKey,
			                        "id"    => "'.$id.'",                                                                 
			                ))',
            			),
          		),
        ),
	),
)); ?>

		<ul class="nav nav-list">
			<br><br>
  			<li class="">
  			
  	  			<td> <?php echo CHtml::link('Volver',array('admin'));?></td>
  			</li>
		</ul>
