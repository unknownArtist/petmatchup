<?php

class SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
        $SearchForm = new Application_Form_Search();
        $this->view->form = $SearchForm;

         $AppliedSearch = Zend_Db_Table::getDefaultAdapter();
        $selectDetails = new Zend_Db_Select($AppliedSearch);
        $getStates = new Application_Model_State(); 
        
           if ($this->getRequest()->isPost()) 
            {
            
            $formData = $this->getRequest()->getPost();

            if ($SearchForm->isValid($formData)) 
                {
                  $protype     = $SearchForm->getValue('profileType');
                  $whichAnimal = $SearchForm->getValue('kind');
                  $race        = $SearchForm->getValue('race');
                  $MaleFemale  = $SearchForm->getValue('sex');
                  $Country     = $SearchForm->getValue('Country');
                  $state       = $SearchForm->getValue('states');
                  $city        = $SearchForm->getValue('city');
                  $zip         = $SearchForm->getValue('zip');
                  $stateResult = $getStates->fetchAll("state_abbr = '$state'")->toArray();
                  foreach ($stateResult as $value) 
                  {
                      $stateRow = $value['state_id']; 
                  }


                 
                  $where = "type = '$protype'";
                  
                  if(!empty($race)) {
                  $where .= "AND race LIKE '$race%'";
                  } 

                   $where .= "AND state      = '$stateRow'";
                   $where .= "AND kind       = '$whichAnimal'";
                   $where .= "AND sex        = '$MaleFemale'";
                   $where .= "AND country    = '$Country'";
          
                  if(!empty($zip)) {
                  $where .= "AND zipcode    LIKE '$zip%'";
                  }
              
              
            
                $result = $selectDetails->from('profiles')->where($where);
               
                $searchResult = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($result));
                $Paginatedresult = $searchResult->setItemCountPerPage(250)
                     ->setCurrentPageNumber($this->_getParam('page',1));
                $this->view->searchResult = $Paginatedresult;
                }
                else
                {
                  $SearchForm->populate($formData);
                }
            }
    }

    public function searchProfileAction()
    {
        
        $AppliedSearch = Zend_Db_Table::getDefaultAdapter();
        $selectDetails = new Zend_Db_Select($AppliedSearch);
        $getStates = new Application_Model_State(); 
        
           $protype           = $_POST['profileType'];
           $whichAnimal       = $_POST['kind'];
           $race              = $_POST['race'];
           $MaleFemale        = $_POST['sex'];
           $Country           = $_POST['Country'];
           $state             = $_POST['states'];
           $city              = $_POST['city'];
           $zip               = $_POST['zip'];


        $stateResult = $getStates->fetchAll("state_abbr = '$state'")->toArray();
        foreach ($stateResult as $value) {
          $stateRow = $value['state_id'];
        }

          $where = 
          " type = '$protype'
           AND kind = '$whichAnimal' 
           AND sex = '$MaleFemale' 
           AND city = '$city'
           ";
          
           
        //AND zipcode LIKE  '$zip%'
        //AND state   =     '$stateRow'
        //  
        //AND race LIKE     '$race%'
        //AND country =     '$Country'
        

        $result = $selectDetails->from('profiles')->where($where);

        

        $searchResult = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($result));

        $Paginatedresult = $searchResult->setItemCountPerPage(9)
                     ->setCurrentPageNumber($this->_getParam('page',1));
 
        $this->view->searchResult = $Paginatedresult;

       //   $this->view->searchResult = $result;
          
       
      
    }

    public function getDetailsAction()
    {
        
      $id = $this->getRequest()->getParam('id');
      $getDetailsofPet = new Application_Model_Profile();
      $getPetPictures  = new Application_Model_UserPics();

      $where = "id = '$id'";
      $result = $getDetailsofPet->fetchAll($where)->toArray();
      $wherePIC = "profile_id = '$id'";
      $picresult = $getPetPictures->fetchAll($wherePIC)->toArray();
      
      $this->view->petDetails = $result;
      $this->view->petPics    = $picresult;   
      $captchaForm = new Application_Form_GetContact();
      $this->view->captchaForm = $captchaForm;  

      if ($this->getRequest()->isPost() && $this->view->captchaForm->isValid($this->_getAllParams()))
        
       {
         $this->view->trueVal =  "true value";
       } 
            
    }
}