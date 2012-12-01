<?php

class Application_Form_Newletter extends Zend_Form
{

    public function init()
    {
        $this->setAction('send-News-Letters');
        $this->setMethod('post');

        $subject = new Zend_Form_Element_Text('subject');
        $subject->setRequired(TRUE)
                  ->setLabel('Subject')
                  ->addFilter('StripTags')
                  ->addFilter('StringTrim')
                  ->addValidator('regex', true, 
                                 array(
                                       'pattern'=>'/^[(a-zA-Z ]+$/', 
                                       'messages'=>array(
                                       'regexNotMatch'=>'Kindly Enter only Alphabets'
                                      )
                       ));

        $Body = new Zend_Form_Element_Textarea('Body');
        $Body->setLabel('Description')
                    ->addFilter('StripTags')
                    ->addErrorMessage('Please Write some Message')
                    ->addFilter('StringTrim')
                    ->setAttrib('cols',40) 
                    ->setAttrib('rows',12)
                    ->addValidator('NotEmpty');

         $submit = new Zend_Form_Element_Submit('submit');

         $this->addElements(array(
          $subject,
          $Body,
          $submit,
          ));


    }


}

