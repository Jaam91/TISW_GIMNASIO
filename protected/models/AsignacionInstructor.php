<?php


class AsignacionInstructor extends CActiveRecord
{
	public $id_dependencia;
	public $nombre_actividad;
	public $nombre_cliente;
	public $apellido_cliente;
	public $nombre_instructor;
	public $apellido_instructor;

	public function tableName()
	{
		return 'asignacion_instructor';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rut_cliente','required'),
			array('rut_instructor', 'required'),
			array('rut_instructor, rut_cliente', 'length', 'max'=>10),
			array('id_actividad', 'numerical'),
			array('estado', 'length', 'max'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_asignacion, rut_instructor, rut_cliente, id_actividad, estado, nombre_actividad, 
			nombre_cliente, apellido_cliente, nombre_instructor,apellido_instructor','safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'actividad0' => array(self::BELONGS_TO, 'Actividad', 'id_actividad'),
			'rutCliente' => array(self::BELONGS_TO, 'Cliente', 'rut_cliente'),
			'rutInstructor' => array(self::BELONGS_TO, 'Instructor', 'rut_instructor'),
			'administradors' => array(self::MANY_MANY, 'Administrador', 'gestiona_asignacion(id_asignacion, rut_administrador)'),
			'instructors' => array(self::MANY_MANY, 'Instructor', 'gestiona_progreso(id_asignacion, rut_instructor)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id_asignacion' => 'Id Asignacion',
			'rut_instructor' => 'Nombre Instructor',
			'rut_cliente' => 'Nombre Cliente',
			'id_actividad' => 'Actividad',
			'estado' => 'Estado',
			'nombre_actividad' => 'Actividad',
			'nombre_cliente' => 'Nombre Cliente'
		);
	}


	public function search()
	{	

		$criteria=new CDbCriteria;
		$criteria->with = array('actividad0', 'rutCliente', 'rutInstructor');

		$criteria->compare('t.rut_instructor',$this->rut_instructor,true);
		$criteria->compare('t.rut_cliente',$this->rut_cliente,true);
		$criteria->compare('id_actividad',$this->id_actividad,true);
		$criteria->compare('actividad0.nombre',$this->nombre_actividad,true);
		$criteria->compare('rutInstructor.profesion',$this->nombre_cliente,true);

		$criteria->compare('t.estado','=habilitado',true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function listaActividades($rut)  // Lista de actividades inscritas de un cliente
	{
		$criteria=new CDbCriteria;
		$criteria->compare('rut_cliente',$rut,true);
		$criteria->compare('id_actividad','<>NULL',true);
		$criteria->compare('id_dependencia',$this->id_dependencia,true);
		$criteria->compare('estado','=habilitado',true);

		return new CActiveDataProvider($this, array( // EN UN DATA PROVIDER
			'criteria'=>$criteria,
		));
	}

	public function listaActividadesArray($rut)  // Lista de actividades inscritas de un cliente
	{
		$actividad = Actividad::model()->tableName();
		$criteria = new CDbCriteria;
		$criteria->select = 't.id_actividad';
		$criteria->join= 'left join '.$actividad.' A on (A.id_actividad = t.id_actividad)';
		$criteria->condition ='t.estado=:estado AND rut_cliente=:rut AND t.id_actividad<>:act';
		$criteria->params = array(':estado'=>'habilitado', ':rut'=>$rut, ':act'=>'NULL');
		return AsignacionInstructor::model()->findAll($criteria);
	}


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/*public function verificarEliminacionActividad($actividad){

		$criteria = new CDbCriteria;
		$criteria->condition ='nombre_actividad =:actividad AND estado=:estado';
		$criteria->params = array(':actividad'=>$actividad, ':estado'=>'habilitado');

		$lista = AsignacionInstructor::model()->findAll($criteria);

		if($lista == NULL){  // NO HAY CLIENTES EN ESA ACTIVIDAD
			return 1;
		}
		else{
			$array = array();  // aca guardamos los rut de los clientes en la actividad
			$cont = 0;

			foreach($lista as $li){   // $lista guarda el array de objetos que cumplieron la condicion dentro de ASIGNACION INSTRUCTOR
				$array[$cont]= new Cliente;
				$array[$cont]->rut_usuario = $li->rut_cliente;
				$cont++;
			}
		}
	}*/

	public function verificarPersonalTrainer($rut) //Saber si al cliente se le asignó un personal trainer
	{
		$lista = $this::model()->findAll(array('condition'=>'estado=:estado AND rut_cliente=:rut',
											'params'=>array(':estado'=>'habilitado',':rut'=>$rut)));
		foreach ($lista as $l)
		{
			if($l->id_actividad == NULL)
				return 1;
		}
	}


}
