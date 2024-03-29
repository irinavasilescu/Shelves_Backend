<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */

	private $_id;
	public $username;

	public function authenticate()
	{
        $record = Users::model()->findByAttributes(['username' => $this->username]);

        if ($record === null) {
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        } elseif ($record->validatePassword($this->password)) {
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        } else {
            $this->errorCode=self::ERROR_NONE;
            $this->_id = $record->id;
            $this->username = $record->username;
        }
        return !$this->errorCode;
	}

	public function getId() {
	    return $this->_id;
    }
}