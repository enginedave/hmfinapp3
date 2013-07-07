<?php

class AccountController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	// @var private property containing the associated user model instance
	private $_user = null;
	

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//usercontext loads the currently logged in user and limits operations on Accounts to those owned by him.
			'userContext + create, index, admin, view, update, delete',
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
				'actions'=>array('index','view'),
				'roles' => array('basic'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'roles' => array('basic'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles' => array('basic'),
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
		$requestedAccount = $this->loadModel($id);
		if($requestedAccount->user_id == $this->_user->id)
		{
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
		}
		else
		{
			throw new CHttpException(403,'You are not authorized to perform this action.');
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Account;
		$model->user_id = $this->_user->id;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Account']))
		{
			$model->attributes=$_POST['Account'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if ($model->user_id == $this->_user->id)
		{
			if(isset($_POST['Account']))
			{
				$model->attributes=$_POST['Account'];
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}

			$this->render('update',array(
				'model'=>$model,
			));
		}
		else
		{
			throw new CHttpException(403,'You are not authorized to perform this action.');
		}
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model=$this->loadModel($id);
		if ($model->user_id == $this->_user->id)
		{		
			if(Yii::app()->request->isPostRequest)
			{
				// we only allow deletion via POST request
				$model->delete();

				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
			else
			{
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
			}
		}
		else
		{
			throw new CHttpException(403,'You are not authorized to perform this action.');
		}
	}

	/**
	 * Lists all models belonging to this user.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Account', array(
			'criteria'=>array(
				'condition'=>'user_id=:userId',
				'params'=>array(':userId'=>$this->_user->id),
			),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Account('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Account']))
			$model->attributes=$_GET['Account'];
			
		//limit the list of accounts to those by the currently logged in user	
		$model->user_id = $this->_user->id;

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Account::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='account-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	//since Accounts belong to users the following sets up a User context 
	//for the accounts
	public function filterUserContext($filterChain)
	{
		//load the associated user for this account which will be the Id of the currently
		//logged in user
		$this->loadUser(Yii::app()->user->id);
		
		//continue to process the filter
		$filterChain->run();
	}
	
	protected function loadUser($user_id)
	{
		if($this->_user===null)
		{
			$this->_user=User::model()->findbyPk($user_id);
			if($this->_user===null)
			{
				throw new CHttpException(404,'The requested user does not
				exist.');
			}
		
		}
		return $this->_user;
	}
	
}
