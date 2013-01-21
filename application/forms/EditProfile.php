<?php

class Application_Form_EditProfile extends Zend_Form
{

    public function init()
    {
    	$this->setMethod('post');
        $this->setAction('#');
		$this->setAttrib('id','set-edit-profile');

        $FirstName = new Zend_Form_Element_Text('f_name');
        $FirstName->setRequired(TRUE)
                  ->setLabel('First Name')
                  ->addFilter('StripTags')
                  ->addFilter('StringTrim')
                  ->addValidator('regex', true, 
                                 array(
                                       'pattern'=>'/^[(a-zA-Z ]+$/', 
                                       'messages'=>array(
                                       'regexNotMatch'=>'Kindly Enter only Alphabets'
                                      )
                       ));
        
        $LastName = new Zend_Form_Element_Text('l_name');
        $LastName->setRequired(TRUE)
                 ->setLabel('Last Name')
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->addValidator('regex', true, 
                                 array(
                                       'pattern'=>'/^[(a-zA-Z ]+$/', 
                                       'messages'=>array(
                                       'regexNotMatch'=>'Kindly Enter only Alphabets'
                                      )
                       ));

        $Password = new Zend_Form_Element_Password('Password');
        $Password->setRequired(TRUE)
                 ->setLabel('Password')
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
        
        $ConfirmPassword = new Zend_Form_Element_Password('confirmPassword');
        $ConfirmPassword->setRequired(TRUE)
                 ->setLabel('Confirm Password')
                  ->addFilter('StripTags')
                  ->addValidator(new Zend_Validate_Identical('Password'))
                  ->addValidator(new Zend_Validate_StringLength(
                    array(
                      'min' => 8, 
                      'max' => 12,
                      )))
                  ->setErrorMessages(array('pass' => 'Password do not match and atleast 6 characters'))
                  ->addFilter('StringTrim');


        $FriendsEmailAddress = new Zend_Form_Element_Text('friend1');
        $FriendsEmailAddress->setLabel('Enter Alternate Email Address')
                            ->setRequired(TRUE)
                            ->addFilter('StripTags')
                            ->addFilter('StringTrim')
                            ->addValidator('EmailAddress')
                            ->addErrorMessage('Valid Email is required');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->class = "register";


        $this->addElements(array(
            
            $FirstName,
            $LastName,
            $Password,
            $ConfirmPassword,
            $FriendsEmailAddress,
            $submit
            ));
    }


}

