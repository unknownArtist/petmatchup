<?php 
class Application_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	private $_acl = null;
	private $_auth = null;

	public function __construct(Zend_Acl $acl, Zend_Auth $auth)
	{
		$this->_acl 	=   $acl;
		$this->_auth 	=   $auth;
	}

	public function preDispatch(Zend_Controller_Request_Abstract $request) 
	{
		$resources = $request->getControllerName();
		
		$action    = $request->getActionName();

		//$identity = $this->_auth->getStorage()->read();
		//$role 	  = $identity->role;
               // $role = 'user';
		if(!$this->_acl->isAllowed($role, $resources, $action))
		{
			$request->setControllerName('index')
					->setActionName('index');
		} 
	}
}