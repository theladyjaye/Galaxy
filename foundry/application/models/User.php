<?php
class User
{
	public  $verified = false;
	private $_password;
	private $_email;
	private $_id;
	
	// this could be an expensive operation 
	// with all the json encoding/decoding taking place
	public static function verifyWithKey($key)
	{
		$status       = false;
		$db           = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseVerification);
		$key          = RenegadeConstants::kTypeVerification.':'.$key;
		$verification = null;
		$verification = $db->get($key);
		
		if($verification)
		{
			// hold all of the verification data in case something goes wrong
			$verification     = json_decode($verification, true);
			$verification_key = $key;
			
			$db->delete($verification_key);
			
			// Changing DB's
			$db       = null;
			$db       = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseUsers);
			$key      = RenegadeConstants::kTypeUser.':'.$verification['user'];
			
			$user     = $db->get($key);
			
			if($user)
			{
				$user             = json_decode($user, true);
				$user['verified'] = true;
				$status           = true;
				
				$db->set($key, json_encode($user));
			}
			else
			{
				// the user didn't exist but the verification did for some reason
				// restore the verification
				
				// Changing DB's
				$db = null;
				$db = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseVerification);
				$db->set($verification_key, json_encode($verification));
			}
		}
		
		return $status;
	}
	
	
	public function generateVerificationForUserWithKey(User $user, $key)
	{
		$key   = RenegadeConstants::kTypeVerification.':'.$key;
		$db    = Renegade::database(RenegadeConstants::kDatabaseRedis, RenegadeConstants::kDatabaseVerification);
		$value = array('user'=>$user->_id, 'timestamp'=>time());
		
		// our tokens should be sufficienly random enough so as never to conflict,
		// but just in case the issue ever comes up, look into setnx
		
		$db->set($key, json_encode($value));
	}
	
	public function __set($key, $value)
	{
		switch($key)
		{
			case 'id':
				$this->_id = strtolower($value);
				break;
				
			case 'email':
				$this->_email = strtolower($value);
				break;
			
			case 'password':
				$this->_password = renegade_security_hash($value);
				break;
		}
	}
	
	public function __get($key)
	{
		$value = null;
		switch($key)
		{
			// user:{id}    = json (string) $this
			// user:{email} = json {id}
			/*
				array('user:username'     => (string) $this,
				      'user:email'        => json_encode($this->_id)
				)
			*/
			case 'array':
				$prefix = RenegadeConstants::kTypeUser;
				$value  = array($prefix.':'.$this->_id    => (string) $this,
				                $prefix.':'.$this->_email => json_encode($this->_id)
				               );
		}
		
		return $value;
	}
	
	public function __toString()
	{
		return json_encode(array('email'    => $this->_email,
		                         'password' => $this->_password,
		                         'verified' => $this->verified,
		                         'type'     => RenegadeConstants::kTypeUser
		                  ));
	}
}
?>