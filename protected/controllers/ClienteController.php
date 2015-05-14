<?php

class ClienteController extends Controller
{

	public $layout='//layouts/column2';


	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			 // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'Habilitar'),
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

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Cliente');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$model=Cliente::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cliente-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
