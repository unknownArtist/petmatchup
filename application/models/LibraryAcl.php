<?php

class Application_Model_LibraryAcl extends Zend_Acl
{
	public function __construct()
	{
		$this->add(new Zend_Acl_Resource('profile'));
		$this->add(new Zend_Acl_Resource('index'),'profile');

        
        /////////////////Roles///////////////////////////

        $this->addRole(new Zend_Acl_Role('member'));
        $this->addRole(new Zend_Acl_Role('admin'),'member');
	}
}

