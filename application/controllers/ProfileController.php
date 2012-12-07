<?php

class ProfileController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

     public function deleteAction()
    {
          if(Zend_Auth::getInstance()->hasIdentity())
        {
           $getProfiles = new Application_Model_Profile();
           $where = "id =".$this->_request->getParam('id');
           $userProfiles = $getProfiles->delete($where);
          
           $getPics = new Application_Model_UserPics();
           $where = "profile_id =".$this->_request->getParam('id');
           $data = array(
                  'status'=>'0'
                  );
           $getPics->update($data,$where);
           $this->_redirect('/profile/list');

}
    }

    public function editAction()
    {
         if(Zend_Auth::getInstance()->hasIdentity())
        {

        $form            = new Application_Form_Profile();
        $profile         = new Application_Model_Profile();
        $profilePicutres = new Application_Model_UserPics();
        $form->getElement('submit')->setLabel('Update Profile');
        $form->removeElement('pic_upload');
        $form->removeElement('pic_uploadSec');
        $form->removeElement('pic_uploadThird');
        $form->removeElement('pic_uploadFourth');
        $this->view->form = $form;
            if($this->getRequest()->isPost())
            {
                $formData = $this->getRequest()->getPost();
                     if ($form->isValid($formData)) 
                    {
                        $data = array();

                        $getStates = new Application_Model_State();
                        $state = $form->getValue('state');
                        $stateResult = $getStates->fetchAll("state_abbr = '$state'")->toArray();
                        $data = $form->getValues();
                        $data['state'] = $stateResult['0']['state_id'];
            
                        unset($data['pic_upload']);
                        unset($data['pic_uploadSec']);
                        unset($data['pic_uploadThird']);
                        unset($data['pic_uploadFourth']);
                       
                        $where = "id = ".$this->_request->getParam('id');
                        $profile->update($data,$where);
                    
                        $this->_redirect('profile/list');
                            
                        
                    }else
                    {
                        $form->populate($formData);
                    }
            }
            else
            {  
                $identity = $this->_request->getParam('id');
                if($identity > 0)
                {
                    $getProfileData = new Application_Model_Profile();
                    $whereIF = "id = ".$identity;
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
    }

    public function listAction()
    {
        if(Zend_Auth::getInstance()->hasIdentity())
        {
           /// sending profile details to list page../////
           $getProfiles = new Application_Model_Profile();
           $where = "user_id =".Zend_Auth::getInstance()->getIdentity()->id;
           $userProfiles = $getProfiles->fetchAll($where);
           $this->view->userProfiles = $userProfiles;
        }
        
    }


    public function addAction()
    {
        require_once('imagecrop/class.upload.php');
       if(Zend_Auth::getInstance()->hasIdentity())
        {

        $form            = new Application_Form_Profile();
        $profile         = new Application_Model_Profile();
        $profilePicutres = new Application_Model_UserPics();
        $form->getElement('submit')->setLabel('Add Profile');
        $this->view->form = $form;
            if($this->getRequest()->isPost())
            {
                $formData = $this->getRequest()->getPost();
                     if ($form->isValid($formData)) 
                    {
                        $data = array();

                        $getStates = new Application_Model_State();
                        $state = $form->getValue('state');
                        $stateResult = $getStates->fetchAll("state_abbr = '$state'")->toArray();
                        $data = $form->getValues();
                        $data['user_id'] =  Zend_Auth::getInstance()->getIdentity()->id;
                        $data['state'] = $stateResult['0']['state_id'];
            $picnumber =$data['picture'] = rand();

                        unset($data['pic_upload']);
                        unset($data['pic_uploadSec']);
                        unset($data['pic_uploadThird']);
                        unset($data['pic_uploadFourth']);
                       
                        if($profile->insert($data))
                        {
                          $where = "picture = ".$picnumber;
                          $profileID = $profile->fetchRow($where)->toArray();
                          $picData = array(
                            $form->getValue("pic_upload"),
                            $form->getValue("pic_uploadSec"),
                            $form->getValue("pic_uploadThird"),
                            $form->getValue("pic_uploadFourth"),
                            );

                          foreach ($picData as $value) {
                            if(isset($value))
                            {
                                $updatedImages = array(
                                    'picture'    => $value,
                                    'profile_id' => $profileID['id'],
                                    'status'     => '1'
                                    );                          
                               $profilePicutres->insert($updatedImages);
                            }
                            
                        }
                        
                        $this->_redirect('profile/list');
                        }
                                
                    }
               
                         
              }
      
          }
        }
            
            
    
    }

   








