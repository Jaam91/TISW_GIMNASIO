<?php

class UsuarioController extends Controller
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
				'actions'=>array('index','view' , 'view2','ingresar'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('crearCliente', 'crearPersonal','updatePersonal','updateCliente',),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','deletePersonal', 'deleteCliente', 'lista', 'habilitar', 'error'),
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

	public function actionView2($id, $tipo)
	{
		$this->render('view2', array(
			'model'=>$this->loadModel($id), 'tipo'=>$tipo
		));
	}

	public function actionError($actividad, $nombre, $num)
	{
		$this->render('error', array(
			'actividad'=>$actividad, 'nombre'=>$nombre, 'num'=>$num,
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


	public function actionDeletePersonal($id)
	{
		$usuario = $this->loadModel($id);

		if($usuario->rol == 'Instructor'){  // es instructor

			$instructor= Instructor::model()->findByPk($id);
			$actividad = AsignacionInstructor::model()->find(array("select"=>"id_actividad",
								'condition'=>'estado=:estado AND rut_instructor=:rut',
								'params'=>array(':estado'=>'habilitado', ':rut'=>$id)));

			if($actividad != NULL){	// Usuario tiene asignaciones vigentes
				if($actividad->id_actividad == NULL){

					$nombre = Usuario::model()->nombreCompleto($id);
					$this->redirect(array('error','actividad'=>'Personal Trainer', 'nombre'=>$nombre, 'num'=>1));
				}			
				else{
					$act = Actividad::model()->findByPk($actividad->id_actividad);

					$nombre = Usuario::model()->nombreCompleto($id);
				    $this->redirect(array('error','actividad'=>$act->nombre, 'nombre'=>$nombre, 'num'=>1));
				}
			}
			else{
				$usuario->estado = "eliminado";
				if($usuario->save()){
					$instructor->tipo='No definido';
					$instructor->horario='No definido';

					if($instructor->save())

						if($usuario->rol == 'Cliente'){
							if(!isset($_GET['ajax']))
								$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'id'=>2));
						}
						else{ // administrador o instructor
							if(!isset($_GET['ajax']))
								$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'id'=>1));
						}
				}
			}
		}
		else{  // es administrador
			$usuario->estado = "eliminado";
			if($usuario->save())
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'id'=>1));
		}
	}

	public function actionDeleteCliente($id)
	{
		$usuario = $this->loadModel($id);

			// veo todas las asignaciones del cliente
		$actividad = AsignacionInstructor::model()->findAll(array(  
								'condition'=>'estado=:estado AND rut_cliente=:rut',
								'params'=>array(':estado'=>'habilitado', ':rut'=>$id)));



		$usuario->estado = "eliminado";
		if($usuario->save())
		{
			if($actividad != NULL){  // hay que eliminar sus asignaciones
			
				foreach ($actividad as $act){
					echo $act->id_actividad;
					$act->estado = "eliminado";
					$act->save();
				}

			}
			if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin', 'id'=>2));

		}

	}

	public function actionHabilitar($rut)
	{
		$usuario = Usuario::model()->findByPk($rut);
		$usuario->estado = "habilitado";

		if($usuario->save()){

			if($usuario->rol == 'Cliente'){
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('lista', 'id'=>2));
			}
			else{ // administrador o instructor
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('lista', 'id'=>1));
			}		
		}
	}

	public function actionUpdatePersonal($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Usuario']))
		{
			$model->attributes=$_POST['Usuario'];
			if($model->save()){
				if($model->rol == 'Administrador'){
					$aux = Authassignment::model()->find(array('condition'=>'itemname=:name AND userid=:rut',
											'params'=>array(':name'=>'Administrador', ':rut'=>$model->rut_usuario)));

					if($aux == NULL)
						Yii::app()->authManager->assign("Administrador", $model->rut_usuario);
					$admin= Administrador::model()->findByPk($id);
					$admin->attributes=$_POST['Administrador'];
					$admin->rut_usuario = $model->rut_usuario;

					if($admin->save())
						$this->redirect(array('view2','id'=>$model->rut_usuario, 'tipo'=>3));
				}
				else{ 
					// Hipotética actividad anterior del Instructor				
					$actividad = AsignacionInstructor::model()->find(array("select"=>"id_actividad",
											'condition'=>'estado=:estado AND rut_instructor=:rut',
											'params'=>array(':estado'=>'habilitado', ':rut'=>$model->rut_usuario)));

					$instructor= Instructor::model()->findByPk($id);
					$instructor->attributes=$_POST['Instructor'];  
					$instructor->rut_usuario = $model->rut_usuario;
					
					$aux = 0;
					if($actividad != NULL){	// Usuario tiene asignaciones vigentes
						if($actividad->id_actividad == NULL){
							if('Personal Trainer' != $instructor->tipo){
								$nombre = Usuario::model()->nombreCompleto($model->rut_usuario);
								$aux = 1;
								$this->redirect(array('error','actividad'=>'Personal Trainer', 'nombre'=>$nombre, 'num'=>2));
							}
						}
						else{
							$act = Actividad::model()->findByPk($actividad->id_actividad);
							if($act->nombre != $instructor->tipo){ 
			// Instructor cambió su actividad, pero tiene asignaciones vigentes con su anterior actividad
								$nombre = Usuario::model()->nombreCompleto($model->rut_usuario);
								$aux = 1;
								$this->redirect(array('error','actividad'=>$act->nombre, 'nombre'=>$nombre, 'num'=>2));
							}							
						}
					}
					if($aux==0){

					$aux = Authassignment::model()->find(array('condition'=>'itemname=:name AND userid=:rut',
											'params'=>array(':name'=>'Instructor', ':rut'=>$model->rut_usuario)));

					if($aux == NULL)  // ya está asignado el rol al instructor
						Yii::app()->authManager->assign("Instructor", $model->rut_usuario);
					

					if($instructor->save())
						$this->redirect(array('view2','id'=>$model->rut_usuario, 'tipo'=>4));
					}
				}
			}
		}
		$lista= Authitem::model()->findAll(array('condition'=>'name=:name OR name=:name2',  // Roles de Personal
											'params'=>array(':name'=>'Administrador', ':name2'=>'Instructor')));


		$instructor= Instructor::model()->findByPk($id);

		if($instructor == NULL)  // ES ADMINISTRADOR
		{
			$instructor = new Instructor;
			$administrador= Administrador::model()->findByPk($id);
			$this->render('update',array(
				'model'=>$model,
				'admin'=>$administrador,  // Se ocupa el Index Instructor porque sus atributos en comun con Administrador abarca más
				'tipo'=>1,  
				'id'=>3// 3 es administrador
			));
		}
		else{
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

			$this->render('update',array(
					'model'=>$model,
					'lista'=>$lista,
					'admin'=>$instructor,  // Se ocupa el Index Instructor porque sus atributos en comun con Administrador abarca más
					'actividad'=>$array,
					'tipo'=>1,  
					'id'=>4  // 4 es instructor
				));
		}
	}

	public function actionUpdateCliente($id)
	{
		$model= $this->loadModel($id);
		$cliente = Cliente::model()->findByPk($id);
		if(isset($_POST['Cliente']))
		{
			$model->attributes=$_POST['Usuario'];
			$cliente->attributes=$_POST['Cliente'];

			if($model->save())
			{
				$cliente->rut_usuario=$model->rut_usuario;
				if($cliente->save())
				{
					$this->redirect(array('view2','id'=>$model->rut_usuario, 'tipo'=>2));
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'cliente'=>$cliente,
			'tipo'=>2,
		));
	}


	public function actionIndex()
	{
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
