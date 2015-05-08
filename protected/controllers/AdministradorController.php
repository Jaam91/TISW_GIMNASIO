<?php

class AdministradorController extends Controller
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
				'actions'=>array('index','view','view2','view3','asistencia','registrar', 'invitado'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update',  'pago', 'registrarPago', 'view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete', 'habilitar'),
				'roles'=>array('Administrador'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actionView($nombre, $nombre_d)  // Vista para el Pago de un Cliente
	{
		$this->render('view',array('nombre'=>$nombre, 'nombre_d'=>$nombre_d));
	}

	public function actionView2($nombre, $dependencia) // Vista para el registro asistencia de CLiente
	{
		$this->render('asistencia',array('nombre'=>$nombre, 'dependencia'=>$dependencia,'num'=>1));
	}

	public function actionView3()  // Vista para el registro asistencia de Cliente NO Inscrito
	{
		$this->render('asistencia',array('num'=>2));
	}

	public function actionAsistencia()
	{
		$model=new Usuario('search');
		$model->unsetAttributes();  
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		$this->render('lista',array(
			'model'=>$model,
		));
	}

	public function actionInvitado()
	{
		$model=new Usuario;

		if(isset($_POST["Usuario"]))
		{

			$model->attributes=$_POST["Usuario"];

			// Llenando la tabla Gestiona Asistencia "Historial de Asistencias"
			$registro = new GestionaAsistencia;
			$registro->rut_cliente = NULL; 
			$registro->id_dependencia = 1;   // 1 es Gimnasio Central
			$registro->fecha = date('Y-m-d');
			$registro->hora_ingreso = date('H:i:s');

			if($registro->save()){
				$this->redirect(array('view3'));
			}
		}

		$this->render('_formCliente', array('model'=>$model));
	}

	public function actionRegistrar($id)  // Registrar Asistencia
	{
		$model = new Dependencia; // Se ocupa para retornar el id_dependencia del Formulario
		$nombre = Usuario::model()->NombreCompleto($id); // Nombre completo del cliente

		if(isset($_POST["Dependencia"]))
		{
			$model->attributes=$_POST["Dependencia"];
			$model = Dependencia::model()->findByPk($model->id_dependencia); // Obtengo el nombre de la id_dependencia seleccionada

			// Llenando la tabla Gestiona Asistencia "Historial de Asistencias"
			$registro = new GestionaAsistencia;
			$registro->rut_cliente = $id;

			if($model->nombre != '*Gimnasio Central')
				$registro->id_dependencia = $model->id_dependencia;
			else
				$registro->id_dependencia = 1;

			$registro->fecha = date('Y-m-d');
			$registro->hora_ingreso = date('H:i:s');

			if($registro->save()){
				$this->redirect(array('view2','nombre'=>$nombre, 'dependencia'=>$model->nombre));
			}
		}

		$lista = Dependencia::model()->findAll(); // Listado de Dependencias		
		$actividad = AsignacionInstructor::model()->listaActividades($id); // Actividades inscritas por el cliente
		$p_trainer= AsignacionInstructor::model()->verificarPersonalTrainer($id); // 1 si tiene personal trainer

		$this->render('opcion', array('model'=>$model,'lista'=>$lista, 'rut'=>$id, 'actividad'=>$actividad, 'nombre'=>$nombre,'p_trainer'=>$p_trainer));

	}

	public function actionVerAsistencia(){
	
	}

	public function actionPago()  // Registrar Pago
	{
		$model=new Usuario('search');
		$model->unsetAttributes();  
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		$this->render('lista2',array(
			'model'=>$model,
		));
	}


	public function actionRegistrarPago($rut_cliente){

		$resultado = AsignacionInstructor::model()->findAll(array('condition'=>'estado=:estado AND rut_cliente=:rut',
															'params'=>array(':estado'=>'habilitado',':rut'=>$rut_cliente)));

		$model = new Disciplina;
		$nombre = Usuario::model()->NombreCompleto($rut_cliente);

		if(isset($_POST["Disciplina"]))
		{
			$model->attributes = $_POST["Disciplina"];
	
			//$monto = Disciplina::model()->findAllByAttributes(array('nombre'=>$model->nombre), array('select'=>'id_disciplina, valor_mensualidad'));
			$monto = Disciplina::model()->find(array('condition'=>'nombre=:nombre','params'=>array(':nombre'=>$model->nombre)));

			$registro = new GestionaPago;
			$registro->rut_cliente = $rut_cliente;
			$registro->id_disciplina = $monto->id_disciplina;
			$registro->fecha = date('Y-m-d');
			$registro->hora = new CDbExpression('NOW()');
			$registro->monto = $monto->valor_mensualidad;

			if($registro->save())
			{
				$this->redirect(array('view', 'nombre'=>$nombre, 'nombre_d'=>$monto->nombre));
			}	
		}

		// Saber que disciplinas debe pagar el cliente. //ESTO DEBE ESTAR EN UNA FUNCION
		if($resultado == null){
			$lista = array();
			$lista[0]= new AuxiliarPagoForm;
			$lista[0]->nombre = 'Pagar Gimnasio';
		}
		else{
			$lista = array();
			$cont=0;
			$aux = 0;
			$aux2=0;
			
			foreach($resultado as $r){
				
				if($r->id_actividad == NULL){
					$lista[$cont]= new AuxiliarPagoForm;
					$lista[$cont]->nombre = 'Musculación';
					$cont++;
					$aux = 1;
				}
				else{
					if($aux2==0){
						$lista[$cont]= new AuxiliarPagoForm;
						$lista[$cont]->nombre = 'Fitness';
						$cont++;
						$aux2=1;
					}
				}
				if($aux == 1 and $aux2 == 1){
					$cont--;
					break;
				}
			}
		}
		////////////////////////////////////////////////////////

		$this->render('_formPago', array('model'=>$model, 'nombre'=>$nombre, 'lista'=>$lista));	
							

	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Administrador');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	public function loadModel($id)
	{
		$model=Administrador::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='administrador-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


}
