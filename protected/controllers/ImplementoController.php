<?php

class ImplementoController extends Controller
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
				'actions'=>array('index','view', 'opcionesModulo'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('crearImplemento','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles'=>array('Administrador'),
			),
			array('deny',   // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionOpcionesModulo()
	{
		$this->render('opcionesModulo');
	}

	public function actionView($id, $valor)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'valor'=>$valor,
		));
	}

	public function actionCrearImplemento()
	{
		$cont=0;
		$model=new Implemento;
		$historial=new GestionaImplemento;
		

		$grupoMuscular = Implemento::model()->grupoMuscular();


		
		$lista=Dependencia::model()->findAll(array('condition'=>'nombre<>:nombre AND estado=:estado',
											       'params'=>array(':nombre'=>'*Gimnasio Central', ':estado'=>'habilitado')));

		$disciplinas=Disciplina::model()->findAll(array('condition'=>'nombre !=:nombre',
														'params'=>array(':nombre'=>'Pagar Gimnasio')));

		if(isset($_POST['Implemento']))
		{
			$model->attributes=$_POST['Implemento'];
			$model->estado='habilitado';
			
			if($model->save())
			{/*
				$historial->id_implemento = $model->id_implemento;
				$historial->rut_administrador = Yii::app()->user->name;
				$historial->fecha = date('Y-m-d');
				$historial->hora = new CDbExpression('NOW()');
				$historial->accion= 'Ingresar';

				if($historial->save())*/
					$this->redirect(array('view','id'=>$model->id_implemento, 'valor'=>0));
			}
		}

		$this->render('crearImplemento',array(
			'model'=>$model,
			'lista'=>$lista,
			'disciplinas'=>$disciplinas,
			'grupoMuscular'=>$grupoMuscular,
		));
	}

	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$historial=new GestionaImplemento;
		$grupoMuscular = Implemento::model()->grupoMuscular();  // es un $THIS

		$lista=Dependencia::model()->findAll(array('condition'=>'id_dependencia<>:id',
											       'params'=>array(':id'=>'*Gimnasio Central')));

		$disciplinas=Disciplina::model()->findAll(array('condition'=>'nombre !=:nombre',
														'params'=>array(':nombre'=>'Pagar Gimnasio')));

		if(isset($_POST['Implemento']))
		{
			$model->attributes=$_POST['Implemento'];
			if($model->save())
			{/*
				$historial->id_implemento = $model->id_implemento;
				$historial->rut_administrador = Yii::app()->user->name;
				$historial->fecha = date('Y-m-d');
				$historial->hora = new CDbExpression('NOW()');
				$historial->accion= 'Modificar';

				if($historial->save())*/
				$this->redirect(array('view','id'=>$model->id_implemento, 'valor'=>1));
			}
				
		}

		$this->render('update',array(
			'model'=>$model,
			'lista'=>$lista,
			'disciplinas'=>$disciplinas,
			'grupoMuscular'=>$grupoMuscular,
		));
	}

	
	public function actionDelete($id)
	{
		$historial=new GestionaImplemento;
		$implemento=$this->loadModel($id);
		$implemento->estado='eliminado';		
		
		$historial->id_implemento = $id;
		$historial->rut_administrador = Yii::app()->user->name;
		$historial->fecha = date('Y-m-d');
		$historial->hora = new CDbExpression('NOW()');
		$historial->accion= 'Eliminar';

		//if($historial->save())

		if($implemento->save())
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Implemento');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new Implemento('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Implemento']))
			$model->attributes=$_GET['Implemento'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Implemento the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Implemento::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Implemento $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='implemento-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
