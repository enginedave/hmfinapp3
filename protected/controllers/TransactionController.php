<?php

class TransactionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	// @var private property containing the associated user model instance
	private $_user = null;
	protected $userAccounts = null;
	protected $userCategorys = null;
	protected $userPayees = null;
	

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//usercontext loads the currently logged in user and limits operations on Transactions to those Accounts owned by him.
			'userContext + create, view, update, delete',
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
		$transaction = $this->loadModel($id);
		//if account owned by this user save the model else throw exception
		if($this->userOwnsAccount($transaction->acc_id))
		{
			$this->render('view',array(
				'model'=>$transaction,
				));
		}
		else throw new CHttpException(403,'You are not authorized to view this Transaction.');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Transaction;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Transaction']))
		{
			$model->attributes=$_POST['Transaction'];
			//if account owned by this user save the model else throw exception
			if($this->userOwnsAccount($model->acc_id))
			{
				if($model->save()) $this->redirect(array('view','id'=>$model->id));
			}
			else throw new CHttpException(403,'You are not authorized to add a Transaction to this account.');
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

		if(isset($_POST['Transaction']))
		{
			$model->attributes=$_POST['Transaction'];
			//if account owned by this user save the model else throw exception
			if($this->userOwnsAccount($model->acc_id))
			{
				if($model->save()) $this->redirect(array('view','id'=>$model->id));
			}
			else throw new CHttpException(403,'You are not authorized to update a Transaction on this account.');
		}
		
		//if account owned by this user save the model else throw exception
		if($this->userOwnsAccount($model->acc_id))
		{
			$this->render('update',array(
					'model'=>$model,
				));
		}
		else throw new CHttpException(403,'You are not authorized to update a Transaction on this account.');	
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$transaction = $this->loadModel($id);
		//if account owned by this user save the model else throw exception
		if($this->userOwnsAccount($transaction->acc_id))
		{
			if(Yii::app()->request->isPostRequest)
			{
				// we only allow deletion via POST request
				$this->loadModel($id)->delete();

				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
			else
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
		else throw new CHttpException(403,'You are not authorized to delete this Transaction.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Transaction');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Transaction('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Transaction']))
			$model->attributes=$_GET['Transaction'];

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
		$model=Transaction::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='transaction-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	//since Transactions will belong to Accounts owned by the currently logged in user need to ensure 
	//that the post array is not modified to a different account
	public function filterUserContext($filterChain)
	{
		//load the associated user and accounts for this transaction which will be the currently
		//logged in user and his or her accounts
		$uid = Yii::app()->user->id;
		$this->loadUser($uid);
		$this->loadUserAccounts($uid);
		$this->loadUserCategorys($uid);
		$this->loadUserPayees($uid);

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
	
	protected function loadUserAccounts($user_id)
	{
		if ($this->userAccounts===null)
		{
			$this->userAccounts=User::model()->getUserAccounts($user_id);
			if($this->userAccounts===null)
			{
				throw new CHttpException(404,'The requested accounts do not exist');
			}
		}
		//return $this->userAccounts;
	}
	
	protected function loadUserCategorys($user_id)
	{
		if ($this->userCategorys===null)
		{
			$this->userCategorys=User::model()->getUserCategorys($user_id);
			if($this->userCategorys===null)
			{
				throw new CHttpException(404,'The requested categorey do not exist');
			}
		}
	}
	
	protected function loadUserPayees($user_id)
	{
		if ($this->userPayees===null)
		{
			$this->userPayees=User::model()->getUserPayees($user_id);
			if($this->userPayees===null)
			{
				throw new CHttpException(404,'The requested payees do not exist');
			}
		}
	}
	
	protected function userOwnsAccount($accid)
	{
		foreach($this->userAccounts as $account)
		{
			$ownsThisAccount = false;
			//test that one of the id's match 
			if ($account['id']==$accid) 
			{
				$ownsThisAccount = true;
				break;
			}		
		}
		return $ownsThisAccount;
	}
	
}
