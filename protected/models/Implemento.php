<?php


class Implemento extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'implemento';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_dependencia, nombre', 'required'),
			array('nombre','unique'),
			array('id_dependencia', 'length', 'max'=>5),
			array('tipo, estado, estado_funcional', 'length', 'max'=>12),
			array('ano', 'length', 'max'=>4),
			array('grupo_muscular, nombre', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_implemento, nombre, id_dependencia, tipo, ano, grupo_muscular, estado, estado_funcional', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'administradors' => array(self::MANY_MANY, 'Administrador', 'gestiona_implemento(id_implemento, rut_administrador)'),
			'idDependencia' => array(self::BELONGS_TO, 'Dependencia', 'id_dependencia'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_implemento' => 'Id Implemento',
			'nombre'=>'Nombre',
			'id_dependencia' => 'Dependencia',
			'tipo' => 'Tipo',
			'ano' => 'Año',
			'grupo_muscular' => 'Grupo Muscular',
			'estado_funcional'=> 'Estado Funcional',
			'estado' => 'Estado',
		);
	}


	public function search($id)
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id_implemento',$this->id_implemento);
		$criteria->compare('id_dependencia',$id);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('ano',$this->ano,true);
		$criteria->compare('grupo_muscular',$this->grupo_muscular,true);
		$criteria->compare('estado',$this->estado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchImplemento($estado)
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id_implemento',$this->id_implemento);
		$criteria->compare('id_dependencia',$this->id_dependencia);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('ano',$this->ano,true);
		$criteria->compare('grupo_muscular',$this->grupo_muscular,true);
		$criteria->compare('estado_funcional',$this->estado_funcional,true);
		$criteria->compare('estado',$estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function grupoMuscular()
	{
		$array = array();
		$array[0]='Abdomen';
		$array[1]='Biceps';
		$array[2]='Cuadriceps';
		$array[3]='Espalda';
		$array[4]='Femorales';
		$array[5]='Glúteos';
		$array[6]='Hombro';
		$array[7]='Pecho';
		$array[8]='Trapecio';
		$array[9]='Triceps';
		$array[10]='-Otro-';

		$cont=0;
		$lista = array();

		while($cont < 11){
			$lista[$cont] = new GrupoMuscularForm;
			$lista[$cont]->grupo_muscular = $array[$cont];
			$cont++;
		}
		return $lista;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
