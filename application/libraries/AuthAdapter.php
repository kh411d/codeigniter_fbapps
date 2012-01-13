<?php 
require_once 'Zend/Auth/Adapter/Interface.php';
class AuthAdapter implements Zend_Auth_Adapter_Interface
{
    const NOT_FOUND_MSG = "Account not found";
    const BAD_PW_MSG = "Password is invalid";           
 
    protected $user;
    protected $password = "";
    protected $username = "";       
 
    public function __construct($params)
    {
        $this->username = $params['username'];
        $this->password = $params['password'];
 
        $this->user = $params;
 
    }
 
    /**
     * Performs an authentication attempt
     *
     * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        /* try
        {
            $this->user->authenticate($this->username, $this->password);
            return $this->createResult(Zend_Auth_Result::SUCCESS);
        }catch (Exception $e){
            if($e->getMessage() == User::WRONG_PW)
                return $this->createResult(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, array(self::BAD_PW_MSG));
            if($e->getMessage() == User::NOT_FOUND)
                return $this->createResult(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, array(self::NOT_FOUND_MSG));
        } */
		//$this->user->authenticate($this->username, $this->password);
		return $this->createResult(Zend_Auth_Result::SUCCESS);
    }
 
    private function createResult($code, $messages = array())
    {
        return new Zend_Auth_Result($code, $this->user,$messages );
    }
}