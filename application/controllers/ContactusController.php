<?php

class ContactusController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $smtpConfigs = array(
            
            'auth'          =>      'login',
            'username'      =>      'contact@petmatchup.com',
            'password'      =>      'pl3d35m@',
            'ssl'           =>      'ssl',
            'port'          =>       465
            
        );
        
        $smtpTransportObject = new Zend_Mail_Transport_Smtp('server1.ingeniousdigital.com', $smtpConfigs);
        
        $mail = new Zend_Mail();
        
        
        
        
        $form = new Application_Form_ContactUS();
        $this->view->form = $form;
        
        

    if ($this->getRequest()->isPost() && $this->view->form->isValid($this->_getAllParams()))
        
       {
        $mail->addTo('contact@petmatchup.com', "petmatchup")
             ->setFrom($_POST['email'], $_POST['name'])
             ->setSubject('its a test email')
             ->setBodyHtml($_POST['message']. '<br />'.'<br />'. 'Tel # ' .$_POST['phone'])
             ->send($smtpTransportObject);
           $this->_redirect('contactus');
           
           $this->view->message = "your email has been sent";
        } 
       
    }

    public function sentAction()
    {
        // action body
    }


}



