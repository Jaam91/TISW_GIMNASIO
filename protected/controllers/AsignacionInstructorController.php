<?php

class AsignacionInstructorController extends Controller
{

	public $layout='//layouts/column2';


	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'lista'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','lista', 'instructor','elegir','registrar','opcion'),
				'roles'=>array('Administrador'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionOpcion()
	{
		$this->render('opciones');
	}

	public function actionLista()  // Lista de Clientes
	{
		$model=new Usuario('search');
		$model->unsetAttributes();

		$this->render('lista',array(
			'model'=>$model,
		));
	}

	public function actionElegir($rut) // Recibe rut del cliente, ahora elegimos la Disciplina 
	{
		$model = new Disciplina;

		$criteria = new CDbCriteria;
		$criteria->select = 'nombre';
		$criteria->condition = 'estado=:estado AND nombre<>:nom';
		$criteria->params = array(':estado'=>'habilitado', 'nom'=>'Pagar Gimnasio');

		$lista= Disciplina::model()->findAll($criteria);
		$nombre = Usuario::model()->NombreCompleto($rut);

		if(isset($_POST['Disciplina']))
		{
			$model->attributes = $_POST['Disciplina'];
			$this->redirect(array('instructor', 'disc'=>$model->nombre, 'nombre'=>$nombre, 'rut'=>$rut));
		}
		$this->render('_formDisciplina', array('model'=>$model, 'nombre'=>$nombre, 'lista'=>$lista));

	}

	public function actionInstructor($disc, $nombre, $rut)
	{
		$model = new Usuario;

		if($disc == "Musculación")
			$this->render('personal_t', array('model'=>$model, 'rut'=>$rut));

		else
			$this->render('instructor', array('model'=>$model, 'rut'=>$rut, 'aux'=>"121212-2"));
	}

	public function actionRegistrar($rut_instructor, $rut)
	{
		$instructor = Instructor::model()->findByPk($rut_instructor);

		$registro = new asignacionInstructor;
		$registro->rut_instructor = $rut_instructor;
		$registro->rut_cliente = $rut;

		if($instructor->tipo == 'Personal Trainer')
			$registro->id_actividad = NULL;
		else{
			$criteria = new CDbCriteria;
			$criteria->select = 'id_actividad, cantidad_clientes';
			$criteria->condition= 'nombre=:nombre';
			$criteria->params= array(':nombre'=>$instructor->tipo);
			$aux = Actividad::model()->find($criteria);
			/*
			$aux = Actividad::model()->findAll(array('select'=>'id_actividad','condition'=>'nombre=:nombre', 
																'params'=>array(':nombre'=>$instructor->tipo)));*/  
			$registro->id_actividad = $aux->id_actividad;
		}
		$registro->estado = "habilitado";
		if($registro->save()){

			// Sumamos la cantidad de clientes de la actividad
			$suma = Actividad::model()->findByPk($registro->id_actividad);
			$suma->cantidad_clientes = $suma->cantidad_clientes + 1;
			if($suma->save())		
				$this->redirect(array('view', 'id'=>$registro->id_asignacion));
		}
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AsignacionInstructor']))
		{
			$model->attributes=$_POST['AsignacionInstructor'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_asignacion));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionAdmin()
	{
		$model=new AsignacionInstructor('search');
		$model->unsetAttributes();  
		if(isset($_GET['AsignacionInstructor']))
			$model->attributes=$_GET['AsignacionInstructor'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=AsignacionInstructor::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function nombreActividad($data)
	{
		if($data->id_actividad == NULL)
			return "Personal Trainer";
		else{
			$tipo = Actividad::model()->findByPk($data->id_actividad);
			return $tipo->nombre;
		}
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='asignacion-instructor-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
