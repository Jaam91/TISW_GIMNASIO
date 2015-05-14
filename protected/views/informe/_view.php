<?php
/* @var $this InformeController */
/* @var $data Informe */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_informe')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_informe), array('view', 'id'=>$data->id_informe)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />


</div>