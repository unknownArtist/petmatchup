
<?php

class Application_Form_SignIn extends Zend_Form
{

    public function init()
    {
        
        $this->setAction('#');
        $this->setMethod('post');
        
        $email = new Zend_Form_Element_Text('email');
        $email->setRequired(TRUE)
                  ->setLabel('Email')
                  ->addValidator('EmailAddress')
                 ->setErrorMessages(array('email is Required'))
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
        
        $password = new Zend_Form_Element_Password('password');
        $password->setRequired(TRUE)
                 ->setLabel('Password')
                 ->setErrorMessages(array('Password is Required'))
                 ->setRequired(TRUE)
                 ->addFilter('StripTags')
                 //->setAttrib('autofocus', "password")
                 ->addFilter('StringTrim');
        
        
        $submit = new Zend_Form_Element_Submit('Login');
//         $submit->setAttrib('onSubmit', "window.location = 
// 'index/index/div/'+document.getElementById('#login-form').value; 
// return false;"); 
         //$submit->setAttrib('onSubmit','window.location ="#login-form";return true;');
        $submit->class = "register";
        $this->addElements(array(
            
            $email,
            $password,
            $submit
        ));
    }


}

