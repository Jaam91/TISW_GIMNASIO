<?php

class GrupoMuscularForm extends CFormModel
{
	public $grupo_muscular;

	public function rules()
	{

		return array(
				array("grupo_muscular",'required'),
			);
	}
}?>