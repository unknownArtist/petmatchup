<?php

class ProfileController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        if(Zend_Auth::getInstance()->hasIdentity())
        {
        $form = new Application_Form_Profile();
        $this->view->form = $form;

        if($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();
                 if ($form->isValid($formData)) 
                {
                  
        $data = array(

                    'name'              =>  $form->getValue('name'), 
                    'country'           =>  $form->getValue('country'),
                    
                    'state'             =>  $form->getValue('state'),
                    'city'              =>  $form->getValue('city'),
                    
                    'zipcode'           =>  $form->getValue('zipcode'),
                    'sex'               =>  $form->getValue('kind'),
                    
                    'race'              =>  $form->getValue('race'),
                    'kind'              =>  $form->getValue('sex'),
              
                    'pure_bread'        =>  $form->getValue('pure_bread'),
                    'papers'            =>  $form->getValue('papers'),
                    
                    'type'              =>  $form->getValue('type'),
                    'amount'            =>  $form->getValue('amount'),
                    
                    'negotiable'        =>  $form->getValue('negotiable'),
                    'details'           =>  $form->getValue('details'),
                     
                    'email'             =>  $form->getValue('email'),
                    'phone'             =>  $form->getValue('phone'),

                    'Latitude'          =>  $form->getValue('latitude'),
                    'Longitude'         =>  $form->getValue('longitude'),
                    'user_id'           =>  Zend_Auth::getInstance()->getIdentity()->id
                
                     );
                 
                 $InsertProfileData = new Application_Model_Profile();
                 $id = Zend_Auth::getInstance()->getIdentity()->id;
                 $where = "user_id = '$id'";

                 $checkIfData = $InsertProfileData->fetchRow($where);
                 if($checkIfData)
                 {
                    $InsertProfileData->update($data ,$where);
                 }
                 else
                 {
                 $InsertProfileData->insert($data);
                 }
                 
                
             //  $InsertProfileData->fetchRow($where)->toArray();
                
/////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// PIC upload Section////////////////////////////////////////
                $uploadPics = new Application_Model_UserPics();
                      
                 if($form->pic_upload->receive())
                {
                    $picData = array (
                    
                    'profile_id'            => $where,
                    'picture'               => $form->pic_upload->getFileName(),
                    //'date'                  => date('Y,m,d')
                   );
                    
                    

                }
                
                $uploadPics->insert($picData);

                if($form->pic_uploadSec->receive())
                {
                    $picDataSec = array (
                    
                    'profile_id'            => $where,
                    'picture'      => $form->pic_uploadSec->getFileName(),
                    //'date'              => date('Y,m,d')
                   );
                    
                    

                }
                
                $uploadPics->insert($picDataSec);

                if($form->pic_uploadThird->receive())
                {
                    $picDataThird = array (
                    
                    'profile_id'       => $where,
                    'picture'          => $form->pic_uploadThird->getFileName(),
                    //'date'                  => date('Y,m,d')
                   );
                    
                    

                }
                
                $uploadPics->insert($picDataThird);

                if($form->pic_uploadFourth->receive())
                {
                    $picDataFourth = array (
                    
                    'profile_id'            => $where,
                    'picture'      => $form->pic_uploadFourth->getFileName(),
                    //'date'              => date('Y,m,d')
                   );
                    
                    

                }
                
                $uploadPics->insert($picDataFourth);
/////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// PIC upload Section End////////////////////////////////////////
                }
                 else
               {
                $form->populate($formData);
               }
           }
           
           else
           {  
             $identity = Zend_Auth::getInstance()->getIdentity()->id; 
             if($identity > 0)

             {
                $getProfileData = new Application_Model_Profile();
                $whereIF = "user_id = ".$identity;

                if($getProfileData->fetchRow($whereIF))
                {
                $profileData = $getProfileData->fetchRow($whereIF)->toArray();
                $form->populate($profileData);
                }
                else
                {
                    $this->view->form = $form;
                }
             }               
           }
          
        

        
        }
        else 
            {
               $this->_redirect('index');
            }
    }

    public function addprofileAction()
    {
        
              //   $form = new Application_Form_Profile();
                // $this->view->form = $form;

               
                
        }
       
                
                
        
        
    


}



