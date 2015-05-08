<?php
/* @var $this DisciplinaController */
/* @var $model Disciplina */

$this->breadcrumbs=array(
	'Opciones'=>array('opcionesModulo'),
	'Lista',
);

$this->menu=array(
	array('label'=>'Ingresar Disciplina', 'url'=>array('crearDisciplina')),
	array('label'=>'Gestión de Disciplinas', 'url'=>array('admin')),
	array('label'=>'Habilitar Disciplina', 'url'=>array('lista')),
);
?>

<h2>Habilitar Disciplinas</h2>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'disciplina-grid',
	'dataProvider'=>$model->search('eliminado'),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(
   			'name'=>'valor_mensualidad',
   			'value' =>'$data->signoPeso($data->valor_mensualidad)',
   			'filter'=>'',
		),

		array(
            'class' => 'CButtonColumn',
            'template'=>'{habilitar}',
            'buttons'=> array(
				"habilitar"=>array(					
            	            'label'=>'habilitar', // titulo del enlace del botón nuevo
            	            'click'=>'function(){return confirm("¿Está seguro que desea habilitar esta Disciplina?");}',
		    				'imageUrl'=>'images/habilitar.png',
           					'url'=>'CHtml::normalizeUrl(array("Habilitar","id"=>$data->primarykey))',         					
						),

          		),
        ),
	),
)); ?>
