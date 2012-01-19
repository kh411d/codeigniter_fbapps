<?php 
require_once 'Zend/Auth/Adapter/Interface.php';
class AuthAdapter implements Zend_Auth_Adapter_Interface
{
 
    protected $user;
    protected $password = "";
    protected $identity = "";       
    protected $CI;
 
    public function __construct($params)
    {
	    $this->CI = get_instance();
	   
        $this->identity = $params['identity'];
        $this->password = $params['password'];
        $this->CI->load->model('customer_model'); 
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
			$auth_data = $result;
            return $this->createResult(Zend_Auth_Result::SUCCESS,$auth_data,self::message($e->getMessage()));
        }catch (Exception $e){
                return $this->createResult($e->getMessage(),NULL,self::message($e->getMessage()));
        } 

		return $this->createResult(Zend_Auth_Result::SUCCESS);
    }
	
	public static function message($const)
	{
		 switch($const){
			case 0  : return lang('auth_failure'); break;
			case -1 : return lang('auth_failure_identity_not_found'); break;
			case -2 : return lang('auth_failure_identity_ambiguous'); break;
			case -3 : return lang('auth_failure_credential_invalid'); break;
			case -4 : return lang('auth_failure_uncategorized'); break;
			case 1  : return lang('auth_success'); break;
			default : return lang('auth_failure'); break;
		 }
	}
 
    private function createResult($code,$identities = NULL, $messages = array())
    {
        return new Zend_Auth_Result($code, $identities,$messages );
    }
	
	function fetchData($identity, $password)
    {
        $r['key'] = 'email';
		$r['value'] = $identity;
        $data = $this->CI->customer_model->retrieve(array($r['key']=>$r['value']));
		
        if (!$data) {
			throw new Exception(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND);
                    return false;
		}

        if ($this->verifyPassword(trim($password, "\r\n"),trim($data['password'], "\r\n"),'phpass')) {
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
		
		case "phpass" :
		   return $this->verify_PHPass($password1,$password2);

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
		return ($newHash == $hash) ? TRUE : FALSE;
	}
	
	function verify_PHPass($plaintext,$hash)
	{
	 $this->CI->load->library('passwordhash',array('iteration'=>8,'portable'=>TRUE));
	 $check = $this->CI->passwordhash->CheckPassword($plaintext, $hash);
	 return $check;
	}

}