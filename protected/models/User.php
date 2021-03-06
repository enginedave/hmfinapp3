<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property integer $role
 * @property string $last_login_time
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 * @property Account[] $accounts
 * @property Category[] $categories
 * @property Payee[] $payees
 */
class User extends HmfinappActiveRecord
{
	// the _repeat suffix is added to the password to allow the compare rule 
	// to be used to check the two passwords are equal
	public $password_repeat;
	
	const TYPE_BASIC=0;
	const TYPE_PREMIUM=1;
	const TYPE_ADMIN=2;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password, password_repeat, role', 'required'),
			array('email','unique'),
			array('password', 'compare'), //this will compare password and password_repeat
			array('email', 'length', 'max'=>100),
			array('password', 'length', 'max'=>150),
			array('role','numerical','integerOnly'=>true),
			array('last_login_time, password_repeat', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, password, role, last_login_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'accounts' => array(self::HAS_MANY, 'Account', 'user_id'),
			'categories' => array(self::HAS_MANY, 'Category', 'user_id'),
			'payees' => array(self::HAS_MANY, 'Payee', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'password' => 'Password',
			'role' => 'Role',
			'last_login_time' => 'Last Login Time',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('role',$this->role);
		$criteria->compare('last_login_time',$this->last_login_time,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	// perform one-way encryption on the password before we store it in
	// the database
	protected function afterValidate()
	{
		parent::afterValidate();
		$this->password = $this->encrypt($this->password);
	}
	
	// create or update the authAssignment for the user 
	protected function afterSave()
	{
		if($this->isNewRecord)
		{
			Yii::app()->authManager->assign('basic', $this->id);
		}
		else
		{
			$this->updateAuthAssignment();
		}
		parent::afterSave();
	}
	
	protected function afterDelete()
	{
		$this->deleteAuthAssignment($this->id);
		parent::afterDelete();
	}



	//**************** extra functions *****************

	public function encrypt($value)
	{
		return md5($value);
	}
	
	public function getTypeOptions()
	{
		return array(
			self::TYPE_BASIC=>'Basic',
			self::TYPE_PREMIUM=>'Premium',
			self::TYPE_ADMIN=>'Admin',
		);
	}
	
	
	
	
	
	//*********** private functions  **************
	
	private function updateAuthAssignment()
	{
		// clear the existing AuthAssignment by deleting the row from the database		
		$this->deleteAuthAssignment($this->id);

		//Yii::app()->authManager->assign('basic', 25) this equals user 25 being assigned to role 'basic'
		if ($this->role==0) Yii::app()->authManager->assign('basic', $this->id);
		if ($this->role==1) Yii::app()->authManager->assign('premium', $this->id);
		if ($this->role==2) Yii::app()->authManager->assign('administrator', $this->id);
	}
	
	private function deleteAuthAssignment($deluserid)
	{
		// clear the existing AuthAssignment by deleting the row from the database
		$sql = "DELETE FROM AuthAssignment WHERE userid=:userId";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userId", $deluserid, PDO::PARAM_INT);
		$command->execute();
	}
	
	public function getUserAccounts($theUser)
	{
		//query the Accounts table and return the list of THIS users accounts
		$sql = "SELECT id, name  FROM `tbl_account` WHERE user_id=:userId ORDER BY name ASC";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userId", $theUser, PDO::PARAM_INT);
		$rows = $command->queryAll();
		return $rows;
	}
	
	public function getUserCategorys($theUser)
	{
		//query the Category table and return the list of THIS users categorys
		$sql = "SELECT id, name FROM `tbl_category` WHERE user_id=:userId ORDER BY name ASC";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userId", $theUser, PDO::PARAM_INT);
		$rows = $command->queryAll();
		return $rows;	
	}
	
	public function getUserPayees($theUser)
	{
		//query the Payee table and return the list of THIS users payees
		$sql = "SELECT id, name FROM `tbl_payee` WHERE user_id=:userId ORDER BY name ASC";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userId", $theUser, PDO::PARAM_INT);
		$rows = $command->queryAll();
		return $rows;	
	}
}
