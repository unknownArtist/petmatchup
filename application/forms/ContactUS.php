<?php

class Application_Form_ContactUS extends Zend_Form
{

    public function init()
    {
        
        $this->setAction('contactus');
        $this->setMethod('post');
        
        $submit = NULL;
        $name       = $this->addElement('text', 'name', 
                    array(
                        'label'  =>  'Name',
                        'required'   => true,
                        'filters'    => array('StringTrim'),
                         ));
        
        $email      = $this->addElement('text', 'email', array(
                            'label'      => 'Your email address:',
                            'required'   => true,
                            'filters'    => array('StringTrim'),
                            'validators' => array(
                                'EmailAddress',
                        )
                    ));
                    
        $phone      = $this->addElement('text', 'phone', array('label'  =>  'Phone'));
        
        $message = new Zend_Form_Element_Textarea('message');
        $message->setLabel('Message')
                    ->addFilter('StripTags')
                    ->addErrorMessage('Please write something to us')
                    ->addFilter('StringTrim')
                    ->setAttrib('cols',40) 
                    ->setAttrib('rows',12)
                    ->setRequired(TRUE)
                    ->addValidator('NotEmpty');
        $this->addElement($message);
        
        $recaptchaKeys = Zend_Registry::get('config.recaptcha');
        $recaptcha = new Zend_Service_ReCaptcha($recaptchaKeys['publickey'], $recaptchaKeys['privatekey'],
                NULL, array('theme' => 'clean'));

        $captcha = new Zend_Form_Element_Captcha('captcha',
            array(
                'label' => 'Type the characters you see in the picture below.',
                'captcha' =>  'ReCaptcha',
                'captchaOptions'        => array(
                    'captcha'   => 'ReCaptcha',
                    'service' => $recaptcha
                )
            )
        );
        
         

        $this->addElements(array($captcha, $submit));
        $submit = $this->addElement('submit','submit');
        
       
               
                     
    }


}

