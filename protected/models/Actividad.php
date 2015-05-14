<?php


class Actividad extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'actividad';
	}

	

	public function rules()
	{

		return array(
			array('nombre, id_disciplina, id_dependencia', 'required'),
			array('id_disciplina', 'numerical'),
			array('id_dependencia', 'numerical'),
			array('nombre', 'length', 'max'=>30),
			array('nombre', 'unique'),
			array('estado', 'length', 'max'=>12),
			array('cantidad_clientes', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_actividad, nombre, id_disciplina, id_dependencia,estado', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{

		return array(
			'rutUsuario' => array(self::BELONGS_TO, 'Instructor', 'rut_instructor'),
			'idDisciplina' => array(self::BELONGS_TO, 'Disciplina', 'id_disciplina'),
			'asignacionInstructors' => array(self::HAS_MANY, 'AsignacionInstructor', 'id_actividad'),
			'idDependencia' => array(self::BELONGS_TO, 'Dependencia', 'id_dependencia'),
			'administradors' => array(self::MANY_MANY, 'Administrador', 'gestiona_actividad(id_actividad, rut_administrador)'),
		);
	}


	public function attributeLabels()
	{
		return array(
			'nombre' => 'Nombre',
			'id_disciplina' => 'Disciplina',
			'id_dependencia' => 'Id Dependencia',
			'estado' => 'Estado',
			'cantidad_clientes' => 'Cantidad Clientes',
		);
	}


	public function search($estado)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_actividad', $this->id_actividad);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('id_disciplina',$this->id_disciplina);
		$criteria->compare('id_dependencia',$this->id_dependencia);
		$criteria->compare('estado','='.$estado,true);
		$criteria->compare('cantidad_clientes', '='.$this->cantidad_clientes,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchClientes($cantidad_clientes, $id_dependencia)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('cantidad_clientes', '>'.$cantidad_clientes,true);
		$criteria->compare('id_dependencia', '='.$id_dependencia,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));		
	}

	public function contarActividad()
	{
		$disciplina = Disciplina::model()->tableName();
		$criteria= new CDbCriteria;
		$criteria->select= 'id_actividad,t.nombre';
		$criteria->join = 'left join '.$disciplina.' D on (D.id_disciplina = t.id_disciplina)';	
		$criteria->condition= 't.estado=:estado AND D.nombre<>:nom';
		$criteria->params= array(':estado'=>'habilitado', ':nom'=>'Musculación');

		return Actividad::model()->findAll($criteria);
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}
