<?php

class Application_Form_GetContact extends Zend_Form
{

    public function init()
    {
    	$this->setAction('');
        $this->setMethod('post');
        $submit = NULL;
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

