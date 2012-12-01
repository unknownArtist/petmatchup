<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */

    }

    public function indexAction()
    {
        $form = new Application_Form_AdminLogin();
        $this->view->AdminSignIn = $form;

             
        $authAdapter = $this->getAuthAdapter();
           
        if ($this->getRequest()->isPost()) 
            {
            
            $formData = $this->getRequest()->getPost();

            if ($form->isValid($formData)) 
                {
                    $admin    = $form->getValue('admin');
                    $password = $form->getValue('password');
                    
                         $authAdapter->setIdentity($admin)
                                     ->setCredential($password);
                
                    $auth = Zend_Auth::getInstance();
                    $result = $auth->authenticate($authAdapter);
	     
        
             if($result->isValid())
               {
                    $auth->getStorage()->write(
                         $authAdapter->getResultRowObject(array('adminid', 'admin_username', 'role'))
                        );
                    $this->_redirect('admin/home');
               }
               else
                    {
                        $form->populate($formData);
                        $this->view->SignUpError = "Invalid Username or Password";
                    }
                
                 } 
            
            else            
                {
                    $form->populate($formData);
                }
        }   
    }

    public function homeAction()
    {
        //$this->_helper->layout()->disableLayout();
        //$this->_helper->viewRenderer->setNoRender(true);
        $form = new Application_Form_Newletter();
        $this->view->form = $form;
        
    	
       

    	
    }

    private function getAuthAdapter()
    {
        $auth = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $auth->setTableName('adminlogin')
             ->setIdentityColumn('admin_username')
             ->setCredentialColumn('admin_password');
        
        return $auth;
    }

    public function newsLetterAction()
    {
        $this->view->form = new Application_Form_Newletter();
        $getConnect = Zend_Db_Table::getDefaultAdapter();
        $getDbTable = new Zend_Db_Select($getConnect);


        $getAllProfiles = $getDbTable->from('profiles');
        $getResult = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($getAllProfiles));

        $Paginatedresult = $getResult->setItemCountPerPage(10)
                                     ->setCurrentPageNumber($this->_getParam('page',1));
        $this->view->listProfiles = $Paginatedresult;
    }

    public function profilesAction()
    {
        echo "ehllo world";
    }


}


