<?php


/*
This command line tool is designed to establish 3 roles or levels of users for the system
level 1 - a basic user who should be able to CRUD on all his	Accounts, Categories, Payees and Transactions
level 2 - a basic user + will have access to other features yet to be implemented?
level 3 - an administrator who can CRUD all users
													
	to run the command and build the auth use::::: /opt/lampp/bin/php hmfinapp3/protected/yiic shell hmfinapp3/protected/config/main.php 
	run this from the root project directory i.e. public_html
	
	**** also in the test database as well ******
	
*/

class RbacCommand extends CConsoleCommand

{
	private $_authManager;
	
	public function getHelp()
	{
		/*return <<<EOD
		USAGE
		rbac
		DESCRIPTION
		This command generates an initial RBAC authorization hierarchy.
		EOD;*/
	}
	
	/**
	* Execute the action.
	* @param array command line parameters specific for this command
	*/
	
	public function run($args)
	{
		//ensure that an authManager is defined as this is mandatory for creating an auth heirarchy
		if(($this->_authManager=Yii::app()->authManager)===null)
		{
			echo "Error: an authorization manager, named 'authManager' must be configured to use this command.\n";
			echo "If you already added 'authManager' component in application configuration,\n";
			echo "please quit and re-enter the yiic shell.\n";
			return;
		}
		
		//provide the opportunity for the user to abort the request
		echo "This command will create three roles: basic, premium, and administrator and the following premissions:\n";
		echo "CRUD + index and admin for user\n";
		echo "CRUD + index and admin for accounts\n";
		echo "CRUD + index and admin for categorys\n";
		echo "CRUD + index and admin for payees\n";
		echo "CRUD + index and admin for transactions\n";
		echo "Would you like to continue? [Yes|No] ";
		
		//check the input from the user and continue if they indicated yes to the above question
		if(!strncasecmp(trim(fgets(STDIN)),'y',1))
		{
			//first we need to remove all operations, roles, child relationship and assignments
			$this->_authManager->clearAll();

			//create the lowest level operations for users
			$this->_authManager->createOperation("createUser","create a new user");
			$this->_authManager->createOperation("readUser","read user information");
			$this->_authManager->createOperation("updateUser","update user information");
			$this->_authManager->createOperation("deleteUser","remove a user");
			$this->_authManager->createOperation("adminUser","administer user");
			$this->_authManager->createOperation("indexUser","view a list of users");
			
			//create the lowest level operations for accounts
			$this->_authManager->createOperation("createAccount","create a new account");
			$this->_authManager->createOperation("readAccount","read account information");
			$this->_authManager->createOperation("updateAccount","update account information");
			$this->_authManager->createOperation("deleteAccount","remove an account");
			$this->_authManager->createOperation("adminAccount","administer account");
			$this->_authManager->createOperation("indexAccount","view a list of accounts");
			
			//create the lowest level operations for categorys
			$this->_authManager->createOperation("createCategory","create a new category");
			$this->_authManager->createOperation("readCategory","read category information");
			$this->_authManager->createOperation("updateCategory","update category information");
			$this->_authManager->createOperation("deleteCategory","remove a category");
			$this->_authManager->createOperation("adminCategory","administer category");
			$this->_authManager->createOperation("indexCategory","view a list of categorys");
			
			//create the lowest level operations for payees
			$this->_authManager->createOperation("createPayee","create a new payee");
			$this->_authManager->createOperation("readPayee","read payee information");
			$this->_authManager->createOperation("updatePayee","update payee information");
			$this->_authManager->createOperation("deletePayee","remove a payee");
			$this->_authManager->createOperation("adminPayee","administer payee");
			$this->_authManager->createOperation("indexPayee","view a list of payees");
			
			//create the lowest level operations for transactions
			$this->_authManager->createOperation("createTransaction","create a new transaction");
			$this->_authManager->createOperation("readTransaction","read transaction information");
			$this->_authManager->createOperation("updateTransaction","update transaction information");
			$this->_authManager->createOperation("deleteTransaction","remove a transaction");
			$this->_authManager->createOperation("adminTransaction","administer transaction");
			$this->_authManager->createOperation("indexTransaction","view a list of transactions");
			
			
			//create the "basic" user role and add the appropriate permissions as children to this role
			//the "basic" role can CRUD their own Accounts, Categories, Payees and Transactions
			$role=$this->_authManager->createRole("basic");
			
			$role->addChild("createUser");//to allow an anon person to create a new account
			
			$role->addChild("createAccount");
			$role->addChild("readAccount");
			$role->addChild("updateAccount");
			$role->addChild("deleteAccount");
			$role->addChild("adminAccount");
			$role->addChild("indexAccount");
			
			$role->addChild("createCategory");
			$role->addChild("readCategory");
			$role->addChild("updateCategory");
			$role->addChild("deleteCategory");
			$role->addChild("adminCategory");
			$role->addChild("indexCategory");
			
			$role->addChild("createPayee");
			$role->addChild("readPayee");
			$role->addChild("updatePayee");
			$role->addChild("deletePayee");
			$role->addChild("adminPayee");
			$role->addChild("indexPayee");
			
			$role->addChild("createTransaction");
			$role->addChild("readTransaction");
			$role->addChild("updateTransaction");
			$role->addChild("deleteTransaction");
			$role->addChild("adminTransaction");
			$role->addChild("indexTransaction");
			
			//create the "premium" user role and add the appropriate permissions (and reader role) as children to this role
			$role=$this->_authManager->createRole("premium");
			$role->addChild("basic");
			
			
			
			//create the administrator role and add the appropriate permissions (and reader+editor roles) as children to this role
			$role=$this->_authManager->createRole("administrator");
			$role->addChild("premium");
			
			//user management accessible only by the administrator
			$role->addChild("readUser");
			$role->addChild("updateUser");
			$role->addChild("deleteUser");
			$role->addChild("adminUser");
			$role->addChild("indexUser");

			
			//test the assignment of users 
			//$this->_authManager->assign('basic', 1);
			//$this->_authManager->assign('premium', 2);
			//$this->_authManager->assign('administrator', 3);
			
			
			//provide a message indicating success
			echo "Authorization hierarchy successfully generated.";
		}
	}
}

