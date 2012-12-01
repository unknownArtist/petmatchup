<?php

class Application_Form_SignUp extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');
        $this->setAction('#');
        
        
        
        $FirstName = new Zend_Form_Element_Text('f_name');
        $FirstName->setRequired(TRUE)
                  ->setLabel('First Name')
                  ->addFilter('StripTags')
                  ->addFilter('StringTrim');
        
        $LastName = new Zend_Form_Element_Text('l_name');
        $LastName->setRequired(TRUE)
                 ->setLabel('Last Name')
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
        
        
        $Email = new Zend_Form_Element_Text('email');
        $Email->setRequired(TRUE)
              ->setLabel('Your Email Address')
              ->addValidator('EmailAddress')
              ->addFilter('StripTags')
              ->addFilter('StringTrim');
        
      /*  $Password = new Zend_Form_Element_Password('Password');
        $Password->setRequired(TRUE)
                 ->setLabel('Password')
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
        
        $ConfirmPassword = new Zend_Form_Element_Password('confirmPassword');
        $ConfirmPassword->setRequired(TRUE)
                 ->setLabel('Confirm Password')
                  ->addFilter('StripTags')
                  ->addValidator(new Zend_Validate_Identical('Password'))
                  ->setErrorMessages(array('pass' => 'Password do not match'))
                  ->addFilter('StringTrim');
                  */
        
        $FriendsEmailAddress = new Zend_Form_Element_Text('friend1');
        $FriendsEmailAddress->setLabel('Enter Alternate Email Address')
                            ->setRequired(TRUE)
                            ->addFilter('StripTags')
                            ->addValidator('EmailAddress')
                            ->addFilter('StringTrim');
        
        $submit = new Zend_Form_Element_Submit('submit');
        
        
        $this->addElements(array(
            
            $FirstName,
            $LastName,
            $Email,
           // $Password,
           // $ConfirmPassword,
            $FriendsEmailAddress,
            $submit
        ));
    }


}

