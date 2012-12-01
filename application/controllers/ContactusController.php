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
            'username'      =>      'nayatelorg@gmail.com',
            'password'      =>      'quickbrown123',
            'ssl'           =>      'ssl',
            'port'          =>       465
            
        );
        
        $smtpTransportObject = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $smtpConfigs);
        
        $mail = new Zend_Mail();
        
        
        
        
        $form = new Application_Form_ContactUS();
        $this->view->form = $form;
        
        

    if ($this->getRequest()->isPost() && $this->view->form->isValid($this->_getAllParams()))
        
       {
        $mail->addTo($_POST['email'], $_POST['name'])
             ->setFrom('rooott@gmail.com', "saqib")
             ->setSubject('its a test email')
             ->setBodyText($_POST['message']. '<br />'. $_POST['phone'])
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



