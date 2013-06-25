<?php
class AccountTest extends CDbTestCase
{
	public $fixtures = array(
		'accounts'=>'Account',
		'users'=>'User',
	);

	public function testCreate()
	 {
	 	//CREATE a new account
	 	$newAccount=new Account;
	 	$newAccountName = 'my test santander';
	 	$newAccountType = 'one acc';
	 	$newAccountBalance = '1234.45';
	 	$newAccount->setAttributes(
	 		array(
	 			'user_id'=>1,
	 			'name'=>$newAccountName,
	 			'type'=>$newAccountType,
	 			'balance'=>$newAccountBalance,
	 			//remove 'create_time'=>'2013-03-15 00:00:00',
	 			//remove 'create_user_id'=>1,
	 			//remove 'update_time'=>'2013-03-15 00:00:00',
	 			//remove 'update_user_id'=>1 
	 		)
	 	);
	 	//set the application user id to the first user in the test database populated 
		//by the fixture data
	 	Yii::app()->user->setId($this->users('user1')->id);
	 	$this->assertTrue($newAccount->save());

	 	//READ back the newly created account
	 	$retreivedAccount = Account::model()->findByPk($newAccount->id);
	 	$this->assertTrue($retreivedAccount instanceof Account);
	 	$this->assertEquals($newAccountName, $retreivedAccount->name);
	 	$this->assertEquals(Yii::app()->user->id, $retreivedAccount->create_user_id);

	 }

	 public function testRead(){
	 	$retreivedAccount = $this->accounts('account1');
	 	$this->assertTrue($retreivedAccount instanceof Account);
	 	$this->assertEquals('account name one', $retreivedAccount->name);
	 }

	 public function testUpdate(){
	 	$account = $this->accounts('account2'); //gets the second account from the database (fixture data)
	 	//UPDATE account
	 	$updatedAccountName = 'updated account name for one';
	 	$account->name = $updatedAccountName;
	 	$this->assertTrue($account->save(false));
	 	//read by to test 
	 	$updatedAccount = Account::model()->findByPk($account->id);
	 	$this->assertEquals($updatedAccountName, $updatedAccount->name);
	 }

	 //delete not working as the databse wont delete the account as it violates an integrity - a referenced relation.
	 public function testDelete(){
	 	$account = $this->accounts('account3');//get the third set of fixture data from the database as it does not have an transactions in the fixture data as if it did it would cause a referential integrity error on deletion.
	 	$savedAccountId = $account->id;
	 	$this->assertTrue($account->delete());
	 	$deletedAccount = Account::model()->findByPk($savedAccountId);
	 	$this->assertEquals(NULL, $deletedAccount);
	 }
}
