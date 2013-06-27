<?php
class UserTest extends CDbTestCase
{
	public $fixtures = array(
		'accounts'=>'Account',
		'users'=>'User',
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
	 			'role'=>'basic',
	 			'last_login_time'=>'',
	 		)
	 	);
	 	
	 	$this->assertTrue($newUser->save());
	 	
	 	//read back the newly craeted User
	 	$retreivedUser = User::model()->findByPk($newUser->id);
	 	$this->assertTrue($retreivedUser instanceof User);
	 	$this->assertEquals($newUserEmail, $retreivedUser->email);
	 }
	 
	 public function testRead()
	 {
	 	$retreivedUser = $this->users('user1');
	 	$this->assertTrue($retreivedUser instanceof User);
	 	$this->assertEquals('user1@test.com', $retreivedUser->email);
	 }
	 
	 public function testUpdate()
	 {
	 	$user = $this->users('user2'); //gets the second user from the database (fixture data)
	 	//UPDATE account
	 	$updatedUserEmail = 'user2@test.com_updated';
	 	$user->email = $updatedUserEmail;
	 	$this->assertTrue($user->save(false));
	 	//read by to test 
	 	$updatedUser = User::model()->findByPk($user->id);
	 	$this->assertEquals($updatedUserEmail, $updatedUser->email);
	 }
	 
	 public function testDelete()
	 {
	 	$user = $this->users('user4');//from fixture data
	 	$savedUserId = $user->id;
	 	$this->assertTrue($user->delete());
		$deletedUser = User::model()->findByPk($savedUserId);
		$this->assertEquals(NULL, $deletedUser);
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
