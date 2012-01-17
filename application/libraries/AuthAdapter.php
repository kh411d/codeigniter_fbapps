<?php 
require_once 'Zend/Auth/Adapter/Interface.php';
class AuthAdapter implements Zend_Auth_Adapter_Interface
{
    const NOT_FOUND_MSG = "Account not found";
    const BAD_PW_MSG = "Password is invalid";           
 
    protected $user;
    protected $password = "";
    protected $identity = "";       
 
    public function __construct($params)
    {
        $this->identity = $params['identity'];
        $this->password = $params['password'];
        $this->load->model('customer_model');

 
    }
 
    /**
     * Performs an authentication attempt
     *
     * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        try
        {
            $result = $this->fetchData($this->identity, $this->password);
            return $this->createResult(Zend_Auth_Result::SUCCESS);
        }catch (Exception $e){
            if($e->getMessage() == User::WRONG_PW)
                return $this->createResult(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, array(self::BAD_PW_MSG));
        } 
		
		
		
		return $this->createResult(Zend_Auth_Result::SUCCESS);
    }
 
    private function createResult($code,$identities, $messages = array())
    {
        return new Zend_Auth_Result($code, $identities,$messages );
    }
	
	function fetchData($identity, $password)
    {
        
        $data = $this->customer_model->retrieve(array('key'=>'email','value'=>$identity));
		
        if (!$data) {
			throw new Exception(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND);
                    return false;
		}

        if ($this->verifyPassword(trim($password, "\r\n"),trim($res['password'], "\r\n"),'md5')) {
            return $data;
        }
		
		throw new Exception(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID);
        return false;
    }
	
	/**
     * Crypt and verfiy the entered password
     *
     * @param  string Entered password
     * @param  string Password from the data container (usually this password
     *                is already encrypted.
     * @param  string Type of algorithm with which the password from
     *                the container has been crypted. (md5, crypt etc.)
     *                Defaults to "md5".
     * @return bool   True, if the passwords match
     */
    function verifyPassword($password1, $password2, $cryptType = "md5")
    {
    	
        switch ($cryptType) {
        case "crypt" :
            return (($password2 == "**" . $password1) ||
                    (crypt($password1, $password2) == $password2)
                    );
            break;

        case "none" :
            return ($password1 == $password2);
            break;

        case "md5" :
        	return (md5($password1) == $password2);
            break;

        default :
            if (function_exists($cryptType)) {
                return ($cryptType($password1) == $password2);
            }
            else if (method_exists($this,$cryptType)) { 
                return ($this->$cryptType($password1) == $password2);
            } else {
                return false;
            }
            break;
        }
    }
	
	function generate_SHA1($plainText, $salt = null)
	{
		if ($salt === null)
		{
			$salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
		}
		else
		{
			$salt = substr($salt, 0, SALT_LENGTH);
		}

		return $salt . sha1($salt . $plainText);
	}
	
	function verify_SHA1($plaintext,$hash,$password_salt)
	{
		$newHash = $this->generate_SHA1($plaintext,$password_salt);
		return if($newHash == $hash) ? TRUE : FALSE;
	}
	
	function verify_PHPass($plaintext,$hash)
	{
	 $this->load->library('passwordhash',array('iteration'=>8,'portable'=>TRUE));
	 $check = $this->passwordhash->CheckPassword($plaintext, $hash);
	 return $check;
	}

}