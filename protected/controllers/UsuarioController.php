<?php

class UsuarioController extends Controller
{

	public $layout='//layouts/column2';


	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view' ,'ingresar'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('crearCliente', 'crearPersonal','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'lista'),
				'roles'=>array('Administrador'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actionView($id, $tipo)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id), 'tipo'=>$tipo,
		));
	}

	public function actionIngresar()
	{
		$this->render('ingresar');
	}

	public function actionCrearPersonal()
	{
		$model=new Usuario;
		$admin = new Administrador;
		$instructor = new Instructor;  

		if(isset($_POST['Usuario']))
		{
			$model->attributes=$_POST['Usuario'];
			$model->estado = "habilitado";
			if($model->save()){

				//Si el rol escogido es Administrador, se asigna rol Administrador al usuario.
				if($model->rol == 'Administrador'){

					Yii::app()->authManager->assign("Administrador", $model->rut_usuario);
					$admin->attributes=$_POST['Instructor'];
					$admin->rut_usuario = $model->rut_usuario;

					if($admin->save())
						$this->redirect(array('view','id'=>$model->rut_usuario, 'tipo'=>1));
				}
				else{
					Yii::app()->authManager->assign("Instructor", $model->rut_usuario);
					$instructor->attributes=$_POST['Instructor'];     // *******************************

					$instructor->rut_usuario = $model->rut_usuario;					

					if($instructor->save())
						$this->redirect(array('view','id'=>$model->rut_usuario, 'tipo'=>1));
				}
			}
		}
		$lista= Authitem::model()->findAll(array('condition'=>'name=:name OR name=:name2',  // Roles de Personal
											'params'=>array(':name'=>'Administrador', ':name2'=>'Instructor')));

		// Lista de actividades FITNESS Y PERSONAL TRAINER
		$actividad = Actividad::model()->findAll(array("select"=>"id_actividad, nombre",'condition'=>'estado=:estado AND rut_instructor!=:tipo',
											'params'=>array(':estado'=>'habilitado', ':tipo'=>'NULL')));
		// Le agregamos el Personal Trainer
		$array= array();
		$cont=1;
		$array[0]= new Actividad;
		$array[0]->nombre = "Personal Trainer";

		foreach($actividad as $a){
			$array[$cont] = new Actividad;
			$array[$cont]->nombre = $a->nombre;
			$cont++;
		}


		$this->render('crearPersonal',array(
			'model'=>$model,
			'lista'=>$lista,
			'admin'=>$instructor,  // Se ocupa el Index Instructor porque sus atributos en comun con Administrador abarca más
			'actividad'=>$array,
		));
	}

	public function actionCrearCliente()
	{
		$model=new Usuario;
		$cliente =new Cliente;

		if(isset($_POST['Cliente']))
		{
			$model->attributes=$_POST['Usuario'];
			$model->rol='Cliente';
			$model->estado= "habilitado";
			$cliente->attributes=$_POST['Cliente'];

			if($model->save())
			{
				//Rol Cliente
				Yii::app()->authManager->assign("Cliente", $model->rut_usuario);
				$cliente->rut_usuario=$model->rut_usuario;
				if($cliente->save())
				{
					$this->redirect(array('view','id'=>$model->rut_usuario, 'tipo'=>2));
				}
			}
		}
		$this->render('crearCliente',array(
			'model'=>$model,
			'cliente'=>$cliente,
		));
	}

	public function actionAdmin($id)  // Lista de usuarios con estado "habilitado" 
	{
		$model=new Usuario('search');
		$model->unsetAttributes();  
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		if($id == 1){
			$this->render('adminPersonal',array(
			'model'=>$model,
			));
		}
		else{
			$this->render('adminCliente',array(
			'model'=>$model,
			));
		}
	}

	public function actionLista($id)   // Lista de usuarios con estado "eliminado"  
	{
		$model=new Usuario('search');
		$model->unsetAttributes();  
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		if($id == 1){
			$this->render('habilitarPersonal',array(
			'model'=>$model,
			));
		}
		else{
			$this->render('habilitarCliente',array(
				'model'=>$model,
			));
		}
	}


	public function actionDelete($id)
	{
		$usuario = Usuario::model()->findByPk($id);
		$usuario->estado = "eliminado";

		if($usuario->save()){

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

		}
	}

	public function actionHabilitar($rut)
	{
		$usuario = Usuario::model()->findByPk($rut);
		$usuario->estado = "habilitado";

		if($usuario->save()){

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('lista'));
		}
	}


	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);		

		if(isset($_POST['Usuario']))
		{
			$model->attributes=$_POST['Usuario'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->rut_usuario));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	public function actionIndex()
	{

		//Creo los roles: Administrador, Instructor y Cliente.
		#Yii::app()->authManager->createRole("Administrador");
		#Yii::app()->authManager->createRole("Instructor");
		#Yii::app()->authManager->createRole("Cliente");

		$dataProvider=new CActiveDataProvider('Usuario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}



	public function loadModel($id)
	{
		$model=Usuario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function tipoInstructor($data)
	{
		if($data->rol == 'Administrador')
			return "";
		else{
			$criteria = new CDbCriteria;
			$criteria->select = 'tipo'; // select fields which you want in output
			$criteria->condition = 'rut_usuario=:rut';
			$criteria->params = array(':rut'=>$data->rut_usuario);
			$tipo= Instructor::model()->find($criteria);
			return $tipo->tipo;
		}
	}

	public function horarioInstructor($data)
	{
		if($data->rol == 'Administrador')
			return "";
		else{
			$criteria = new CDbCriteria;
			$criteria->select = 'horario'; // select fields which you want in output
			$criteria->condition = 'rut_usuario=:rut';
			$criteria->params = array(':rut'=>$data->rut_usuario);
			$horario= Instructor::model()->find($criteria);
			return $horario->horario;
		}
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
