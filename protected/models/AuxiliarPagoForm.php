<?php

class AuxiliarPagoForm extends CFormModel
{
	public $nombre;

	public function rules()
	{

		return array(
				array("nombre",'required'),
			);
	}
}?>