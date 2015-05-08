<?php
/* @var $this DisciplinaController */
/* @var $model Disciplina */

$this->breadcrumbs=array(
	'Opciones'=>array('opcionesModulo'),
	'Gestión de disciplinas',
);

$this->menu=array(
	array('label'=>'Ingresar Disciplina', 'url'=>array('crearDisciplina')),
	array('label'=>'Gestión de Disciplinas', 'url'=>array('admin')),
	array('label'=>'Habilitar Disciplina', 'url'=>array('lista')),
);
?>

<h2>Disciplinas</h2>



<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'disciplina-grid',
	'dataProvider'=>$model->search('habilitado'),
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
            'template'=>'{update}{eliminar}',
            'buttons'=> array(
				"update"=>array(
            			'label' => 'modificar',
            			'imageUrl'=>'images/modificar.png',
            			'visible' => '$data->nombre != "Pagar Gimnasio"',
                        ),
				"eliminar"=>array(					
            	            'label'=>'eliminar', // titulo del enlace del botón nuevo
            	            'click'=>'function(){return confirm("¿Está seguro que desea eliminar esta Disciplina?");}',
		    				'imageUrl'=>'images/eliminar.png',
           					'url'=>'CHtml::normalizeUrl(array("delete","id"=>$data->primarykey))',
           					'visible' => '$data->nombre != "Pagar Gimnasio"',          					
						),

          		),
        ),
	),
)); ?>
