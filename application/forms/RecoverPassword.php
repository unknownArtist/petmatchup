<?php

class Application_Form_RecoverPassword extends Zend_Form
{

    public function init()
    {
        $this->setAction('');
        $this->setMethod('post');
		$this->setAttrib('id','recover-password');


          $email = new Zend_Form_Element_Text('email');
    	  $email->setRequired(TRUE)
		        ->setLabel('Enter Your Email')
		        ->addValidator('EmailAddress')
		        ->setErrorMessages(array('email is Required'))
		        ->addFilter('StripTags')
		        ->addFilter('StringTrim');
      

    $submit = new Zend_Form_Element_Submit('submit', 'Send');
    $submit->class = "submit";

    $this->addElements(array($email,$submit));

    }


}

