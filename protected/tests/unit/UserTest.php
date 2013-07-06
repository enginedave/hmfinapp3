<?php
class UserTest extends CDbTestCase
{
	public $fixtures = array(
		'accounts'=>'Account',
		'users'=>'User',
		'authAss'=>':AuthAssignment',//use : as this is table name not ActiveRecord
	);

	public function testCreate()
	 {
	 	//CREATE a new user
	 	$newUser=new User;
	 	$newUserEmail = 'testUser@gmail.com';
	 	$newUser->setAttributes(
	 		array(
	 			'email'=>$newUserEmail,
	 			'password'=>'password',
	 			'password_repeat'=>'password',
	 			'role'=>'0',
	 			'last_login_time'=>'',
	 		)
	 	);
	 	
	 	$this->assertTrue($newUser->save());//validation applied
	 	
	 	//read back the newly craeted User
	 	$retreivedUser = User::model()->findByPk($newUser->id);
	 	$this->assertTrue($retreivedUser instanceof User);
	 	$this->assertEquals($newUserEmail, $retreivedUser->email);
	 	
	 	//test the authAssignment has been written
	 	$sql = "SELECT * FROM AuthAssignment WHERE userid=5";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		
		$rolefromdb = ($rows[0]['itemname']);
		//print_r($rolefromdb);
		$this->assertEquals($rolefromdb, 'basic');
	 	
	 }
	 
	 public function testRead()
	 {
	 	//$retreivedUser = $this->users('user1');
	 	$retreivedUser = User::model()->findByPk(1);//the first asset
	 	$this->assertTrue($retreivedUser instanceof User);
	 	$this->assertEquals('user1@test.com', $retreivedUser->email);
	 }
	 
	 public function testUpdate()
	 {
	 	//$user = $this->users('user2'); //gets the second user from the database (fixture data)
	 	$user = User::model()->findByPk(2);
	 	//UPDATE account
	 	$updatedUserEmail = 'user2@test.com_updated';
	 	$user->email = $updatedUserEmail;
	 	$user->role = 2;//make administrator previous value 1 see fixtures
		$user->password = 'password';
		$user->password_repeat = 'password';
	 	$this->assertTrue($user->save());
	 	//read by to test 
	 	$updatedUser = User::model()->findByPk($user->id);
	 	$this->assertEquals($updatedUserEmail, $updatedUser->email);
	 	
	 	//check the authAssignment has been updated 
		$sql = "SELECT * FROM AuthAssignment WHERE userid=2";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		
		$rolefromdb = ($rows[0]['itemname']);
		//print_r($rolefromdb);
		$this->assertEquals($rolefromdb, 'administrator');
	 }
	 
	 public function testDelete()
	 {
	 	//$user = $this->users('user4');//from fixture data
	 	$user = User::model()->findByPk(4);
	 	$savedUserId = $user->id;
	 	$this->assertTrue($user->delete());
		$deletedUser = User::model()->findByPk($savedUserId);
		$this->assertEquals(NULL, $deletedUser);
		
		//test that the authAssignment has also been deleted 
		$sql = "SELECT * FROM AuthAssignment WHERE userid=4";
		$rows = Yii::app()->db->createCommand($sql)->queryAll();
		$this->assertTrue(empty($rows));
	 }
	 
	 public function testGetTypes()
	 {
	 	$options = User::model()->typeOptions;
	 	$this->assertTrue(is_array($options));
	 	$this->assertTrue(3 == count($options));
	 	$this->assertTrue(in_array('Basic', $options));
	 	$this->assertTrue(in_array('Premium', $options));
	 	$this->assertTrue(in_array('Admin', $options));
	 	
	 }
	 
}
