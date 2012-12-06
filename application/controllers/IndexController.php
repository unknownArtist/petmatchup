<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        //$this->_redirect('search');
    }

    public function indexAction()
    {      
        $form = new Application_Form_SignIn();
        $this->view->SignIn = $form;
        
        $authAdapter = $this->getAuthAdapter();
           
        if ($this->getRequest()->isPost()) 
            {
            
            $formData = $this->getRequest()->getPost();
            

            if ($form->isValid($formData)) 
                {
                $email    = $form->getValue('email');
                $password = sha1($form->getValue('password')); echo $password; die();
                $authAdapter->setIdentity($email)
                            ->setCredential($password);
                
             $auth = Zend_Auth::getInstance();
        
             $result = $auth->authenticate($authAdapter);
	     
        
             if($result->isValid())
               {
                    $auth->getStorage()->write($authAdapter->getResultRowObject(array('id', 'f_name','level')));
                    $this->_redirect('index');
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

    

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('index');
    }

    public function editProfileAction()
    {

       $CurrentLoggedInUserID = Zend_Auth::getInstance()->getIdentity()->id;
       $form = new Application_Form_EditProfile();
       //$form = new Application_Form_Profile();
       $this->view->form = $form;

       if($this->getRequest()->isPost())
       {
           $formData = $this->getRequest()->getPost();


           if($form->isValid($formData))
           {
               $UpdateformData = array(

                  'f_name'               =>   $form->getValue('f_name'),
                  'l_name'               =>   $form->getValue('l_name'),
                  'password'             =>   $form->getValue('Password'),
                  'friend1'              =>   $form->getValue('friend1')

                  );
            $updateFormData = new Application_Model_SignUp();
            $updateFormData->update($UpdateformData,'id = '.$CurrentLoggedInUserID);
            
            }
           else
           {
             $form->populate($formData);
           }
         }
         else
        {
          if($CurrentLoggedInUserID > 0)
          {
            $updateFormDataLoggedIn = new Application_Model_SignUp();
            $where = "id = '$CurrentLoggedInUserID'"; 
            $editAbleData = $updateFormDataLoggedIn->fetchRow($where)->toArray();
            $form->populate($editAbleData);
          }  
        
    }
      
    }

    private function getAuthAdapter()
    {
        $auth = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $auth->setTableName('users')
             ->setIdentityColumn('email')
             ->setCredentialColumn('password');
        
        return $auth;
    }

    public function forgetPasswordAction()
    {
        echo "forgetPassword";
    }


}




