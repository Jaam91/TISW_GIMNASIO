<?php

class InformeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'informe2', 'opcionesModulo'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	public function actionOpcionesModulo()
	{
		$this->render('opcionesModulo');
	}
	public function actionCreate()
	{
		$model=new Informe;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Informe']))
		{
			$model->attributes=$_POST['Informe'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_informe));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionInforme2()
	{
		$model= Actividad::model()->findAll(array('condition'=>'estado=:estado', 'params'=>array(':estado'=>'habilitado')));

		//Informacion que contendrá el informe2

		///////////////////////////////////////

		//Creación del informe.

		$mPDF1 = Yii::app()->ePdf->mpdf('utf-8','A4','','',15,15,35,25,9,9,'P'); 
		//$mPDF1->useOnlyCoreFonts = true;
  		//$mPDF1->SetTitle("Yises - Informe");
	 	$mPDF1->SetWatermarkText("Gimnasio Hipertrofia");
	 	$mPDF1->showWatermarkText = true;
	 	$mPDF1->watermark_font = 'DejaVuSansCondensed';
	 	$mPDF1->watermarkTextAlpha = 0.1;
	 	$mPDF1->SetDisplayMode('fullpage');
	 	$mPDF1->WriteHTML($this->renderPartial('informe2', array('model'=>$model), true));
	 	$mPDF1->Output('Informe Mensual'.date('YmdHis')-30,'I');
  		exit;

	}
	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Informe']))
		{
			$model->attributes=$_POST['Informe'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_informe));
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Informe');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Informe('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Informe']))
			$model->attributes=$_GET['Informe'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Informe the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Informe::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Informe $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='informe-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
