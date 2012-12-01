<?php

class Application_Form_Search extends Zend_Form
{

    public function init()
    {

        $sex = array(
            'Male'   => 'Male',
            'Female' => 'Female'
            );
        $profileType = array(

            '1'     =>      'For Mating',
            '2'     =>      'For Sale',
            '3'     =>      'Adoption',
            '4'     =>      'Showcase',
            );
        $animal = array(
            '1'       =>  'Dog',
            '2'       =>  'Cats',
            '3'       =>  'Others'    
            );
       $selectCountry = array(
            '1'     =>      'America',
            '0'     =>      'Canada',
           );

       $Price         = array(

            '$100'    =>    '$100',
            '$200'    =>    '$200',
            '$400'    =>    '$400',
            '$500'    =>    'more than $500',

         );
       
       
       $statesofamerica = Zend_Registry::get('states');
        
 
        
        //////////////////////////////////////////////////////////////////
        
        $this->setMethod('post');
        // $this->setAction('search/search-Profile');
        $this->setAction('#');
        $protype = new Zend_Form_Element_Select('profileType');
                         $protype->setLabel('Profile Type')
                                     ->setRequired(true)
                                     ->addFilter('StripTags')
                                     ->addFilter('StringTrim')
                                     ->addMultiOptions($profileType);
                         
        $whichAnimal        = new Zend_Form_Element_Select('kind');
        $whichAnimal->setLabel('Search For')
                       ->addFilter('StripTags')
                       ->setRequired(true)
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty')
                       ->addMultiOptions($animal);
        
        $race        = new Zend_Dojo_Form_Element_TextBox('race');
        $race->setLabel('Race')
                        ->addFilter('StripTags')
                       // ->setRequired(true)
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty')
                        ->addValidator('regex', true, 
                                 array(
                                       'pattern'=>'/^[(a-zA-Z ]+$/', 
                                       'messages'=>array(
                                       'regexNotMatch'=>'Kindly Enter only Alphabets'
                                      )
                       ));
        
        $MaleFemail        = new Zend_Form_Element_Select('sex');
        $MaleFemail->setLabel('Sex')
        ->setRequired(true)
                      ->addFilter('StripTags')
                      ->addFilter('StringTrim')
                      ->addValidator('NotEmpty')
                      ->addMultiOptions($sex);
        $price        = new Zend_Form_Element_Select('price');
        $price->setLabel('Price')
        ->setRequired(true)
                      ->addFilter('StripTags')
                      ->addFilter('StringTrim')
                      ->addValidator('NotEmpty')
                      ->addMultiOptions($Price);
        $price->class = "price";
        $Country        = new Zend_Form_Element_Select('Country');
        $Country->setLabel('Select Country')
                       ->addFilter('StripTags')
                       ->setRequired(true)
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty')
                        ->addMultiOptions($selectCountry);

        $state        = new Zend_Form_Element_Select('states');
        $state->setLabel('Select State')
        ->setRequired(true)
                        ->addFilter('StripTags')
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty')
                        ->addMultiOptions($statesofamerica);

        $city         = new Zend_Form_Element_Text('city');
        $city->setLabel('City')
                        ->addFilter('StripTags')
                      //  ->setRequired(true)
                        ->addFilter('StringTrim')
                        ->addValidator('NotEmpty');
        $zip = new Zend_Form_Element_Text('zip');
        $zip->setLabel('Zip')
                       ->addFilter('StripTags')
                    //   ->setRequired(true)
                       ->addFilter('StringTrim')
                       ->addValidator('Digits')
                       ->addValidator('NotEmpty');
        
        
         $submit = new Zend_Form_Element_Submit('Search');
         
                         
        $this->addElements(array(
        
           $protype,
           //$price,
           $whichAnimal,
           $race,
           $MaleFemail,
           $Country,
           $state,
           //$city,
           $zip,
           $submit,


        ));
        
    }


}

