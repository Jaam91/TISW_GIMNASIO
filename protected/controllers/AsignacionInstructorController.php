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
				'actions'=>array('admin','delete','lista', 'instructor','elegir','registrar','opcion', 'asignar'),
				'roles'=>array('Administrador'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionView($id, $numero)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id), 'numero'=>$numero,
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
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		$this->render('lista',array(
			'model'=>$model,
		));
	}

	public function actionElegir($rut) // Recibe rut del cliente, ahora elegimos la Disciplina 
	{
		$model = new Disciplina;
		$nombre = Usuario::model()->NombreCompleto($rut);

		if(isset($_POST['Disciplina']))
		{
			$model->attributes = $_POST['Disciplina'];
			$this->redirect(array('instructor', 'disc'=>$model->nombre, 'nombre'=>$nombre, 'rut'=>$rut));
		}
		$act = AsignacionInstructor::model()->listaActividadesArray($rut); // Actividades inscritas por el cliente
		$contador = Actividad::model()->contarActividad();  // cantidad total de actividades Fitness
		$p_trainer= AsignacionInstructor::model()->verificarPersonalTrainer($rut); // 1 si tiene personal trainer
		
		$cont= count($act);  // cantidad de actividades inscritas por el cliente
		$contador= count($contador);

		$array = array();
		if($p_trainer != 1)
		{
			$array[0]= new AuxiliarPagoForm;
			$array[0]->nombre= 'Musculación';

			if($cont != $contador){
				$array[1]= new AuxiliarPagoForm;
				$array[1]->nombre= 'Fitness';
			}
			$actividad = AsignacionInstructor::model()->listaActividades($rut);
			$this->render('_formDisciplina', array('model'=>$model, 'nombre'=>$nombre, 
							'lista'=>$array, 'actividad'=>$actividad, 'p_trainer'=>$p_trainer));
		}
		else{
			if($cont != $contador){
				$array[0]= new AuxiliarPagoForm;
				$array[0]->nombre= 'Fitness';
				$actividad = AsignacionInstructor::model()->listaActividades($rut);
				$this->render('_formDisciplina', array('model'=>$model, 'nombre'=>$nombre, 
						'lista'=>$array, 'actividad'=>$actividad, 'p_trainer'=>$p_trainer));
			}
			else{
				$actividad = AsignacionInstructor::model()->listaActividades($rut);
				$this->render('error', array('nombre'=>$nombre, 
						'actividad'=>$actividad, 'p_trainer'=>$p_trainer));
			}
		}

	}

	public function actionInstructor($disc, $nombre, $rut)
	{
		$model=new Usuario('search');
		$model->unsetAttributes();  
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		if($disc == "Musculación"){
			$this->render('personal_t', array('model'=>$model, 'rut'=>$rut));
		}

		else{
			$lista= Usuario::model()->instructores($rut);
			$this->render('instructor', array('model'=>$model, 'rut'=>$rut, 'lista'=>$lista));
		}
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

			if($registro->id_actividad != NULL){
				// Sumamos la cantidad de clientes de la actividad
				$suma = Actividad::model()->findByPk($registro->id_actividad);
				$suma->cantidad_clientes = $suma->cantidad_clientes + 1;

				if($suma->save())		
					$this->redirect(array('view', 'id'=>$registro->id_asignacion, 'numero'=>1));
			}
			else	
				$this->redirect(array('view', 'id'=>$registro->id_asignacion, 'numero'=>1));
		}
	}

	public function actionUpdate($id)
	{
		$asignacion = $this->loadModel($id);
		$model = new Usuario;

		if($asignacion->id_actividad == NULL)
			$tipo= 'Personal Trainer';
		else{
			$act = Actividad::model()->findByPk($asignacion->id_actividad);
			$tipo= $act->nombre;
		}

		$this->render('_formInstructor',array(
			'model'=>$model,
			'tipo'=>$tipo,
			'id'=>$asignacion->id_asignacion,
			'rut'=>$asignacion->rut_instructor,
		));
	}

	public function actionAsignar($id, $rut_instructor)  // Se asigna el nuevo instructor
	{
		$model = $this->loadModel($id);
		$model->rut_instructor = $rut_instructor;

		if($model->save())
			$this->redirect(array('view', 'id'=>$id, 'numero'=>2));
	}

	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$model->estado = "eliminado";
		if($model->save()){
			if(!isset($_GET['ajax']))
						$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

		}
		
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
