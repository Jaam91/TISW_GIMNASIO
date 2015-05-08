<?php

class DisciplinaController extends Controller
{

	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
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
				'actions'=>array('index','view', 'opcionesModulo'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('crearDisciplina','update', 'admin'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','lista', 'habilitar'),
				'roles'=>array('Administrador'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionOpcionesModulo()
	{
		$this->render('opcionesModulo');
	}
	
	public function actionView($id, $tipo)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id), 'tipo'=>$tipo,
		));
	}

	public function actionCrearDisciplina()
	{
		$model=new Disciplina;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Disciplina']))
		{
			$model->attributes=$_POST['Disciplina'];
			$model->estado='habilitado';
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_disciplina,'tipo'=>1));
		}

		$this->render('crearDisciplina',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Disciplina']))
		{
			$model->attributes=$_POST['Disciplina'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_disciplina, 'tipo'=>2));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		$modelAct=Actividad::model();
		$disciplina=$this->loadModel($id);
		$actividad=Actividad::model()->findAllByAttributes(array('id_disciplina'=>$id), array('condition'=>'estado=:estado',
																							  'params'=>array(':estado'=>'habilitado')));
		$cantidad=0;
		foreach ($actividad as $act) {
			if($act->cantidad_clientes!=0)
			{
				$cantidad++;
				break;
			}
		}

		if($actividad!=NULL AND $cantidad!=0)  // No se puede eliminar
		
			$this->render('error', array('id'=>$id ,'nombre'=>$disciplina->nombre, 'actividad'=>$actividad, 'modelAct'=>$modelAct));
		else
		{
			$disciplina->estado="eliminado";
			if($disciplina->save())
				$this->render('eliminacion', array('nombre'=>$disciplina->nombre));
		}

	}

	public function actionHabilitar($id)
	{
		$model = $this->loadModel($id);
		$model->estado = 'habilitado';
		if($model->save())
			if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('lista'));
	}

	public function actionLista()
	{
		$model=new Disciplina('search');
		$model->unsetAttributes(); 

		$this->render('lista',array(
			'model'=>$model,
		));	
	}


	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Disciplina');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	public function actionAdmin()
	{
		$model=new Disciplina('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Disciplina']))
			$model->attributes=$_GET['Disciplina'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Disciplina::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='disciplina-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
