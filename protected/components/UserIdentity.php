<?php
/**
* UserIdentity represents the data needed to identity a user.
* It contains the authentication method that checks if the provided
* data can identify the user.
*/
class UserIdentity extends CUserIdentity
{
	private $_id;
	/**
	* Authenticates a user using the User data model.
	* @return boolean whether authentication succeeds.
	*/
	public function authenticate()
	{
		$user=User::model()->findByAttributes(array('email'=>$this->username));
		if($user===null)
		{
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		else
		{
			if($user->password!==$user->encrypt($this->password))
			
			{
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}
			else
			{
				$this->_id = $user->id;
				if(null===$user->last_login_time)
				{
					$lastLogin = time();
				}
				else
				{
					$lastLogin = strtotime($user->last_login_time);
				}
				$this->setState('lastLoginTime', $lastLogin); 
				$this->errorCode=self::ERROR_NONE;
			}
		}
		// If the errorCode is set to a non-zero integer i.e. there is an error
		// then the following statement returns false. If the errorCode is 0 i.e. no errors 
		// then the following statement returns true.
		return !$this->errorCode;
	}
	public function getId()
	{
		return $this->_id;
	}
}

