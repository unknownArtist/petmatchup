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

        $values=$this->getRequest()->getParams();

        
        // if (!empty($values['profileType'])) {
        
        $formData = $values;
            // if($SearchForm->isValid($formData))
            // {
          
        $protype      = $this->getRequest()->getParam('profileType');
        $whichAnimal  = $this->getRequest()->getParam('kind');
        $race         = $this->getRequest()->getParam('race');
        $MaleFemale   = $this->getRequest()->getParam('sex');
        $Country      = $this->getRequest()->getParam('Country');
        $stateRow     = $this->getRequest()->getParam('state');
        $zip          = $this->getRequest()->getParam('zip');
        $stateResult  = $getStates->fetchAll("state_abbr = '$stateRow'")->toArray();

        $stateRow = $stateResult[0]['state_id'];

        $z = $this
        ->getDefaultAdapter()
        ->query("SELECT * FROM profiles")
        ->fetchAll();
        print_r($z);
        die();
    //     $selectDetails = $selectDetails->from('profiles');
    // if(!empty($zip))
    // {
        
    //     if (!empty($protype)) {

    //         $selectDetails = $selectDetails->where('type =?',$protype);

    //     }

    //     if (!empty($whichAnimal)) {

    //         $selectDetails = $selectDetails->where('kind =?',$whichAnimal);

    //     }
    //     if (!empty($MaleFemale)) {

    //         $selectDetails = $selectDetails->where('sex=?',$MaleFemale);

    //     }
        
    //     if (!empty($Country)) {

    //         $selectDetails = $selectDetails->where('country=?',$Country);

    //     }
    //     if (!empty($race)) {

    //         $selectDetails = $selectDetails->where('race LIKE ?',"$race%");

    //     }
    //      if (!empty($stateRow)) {
             
    //         $selectDetails = $selectDetails->where('state =?',$stateRow);

    //     }

    // }else
    // {
    //     if (!empty($zip)) {

    //         $selectDetails = $selectDetails->where('zipcode LIKE ?',"$zip%");

    //     }
    //      if (!empty($protype)) {

    //         $selectDetails = $selectDetails->where('type =?',$protype);

    //     }
    //       if (!empty($whichAnimal)) {

    //         $selectDetails = $selectDetails->where('kind =?',$whichAnimal);

    //     }
    //     if (!empty($MaleFemale)) {

    //         $selectDetails = $selectDetails->where('sex=?',$MaleFemale);

    //     }
    // }
    //   var_dump($selectDetails);
    //   die();
    //       $result=$selectDetails;
    //             $searchResult = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($result));
                
    //             $Paginatedresult = $searchResult->setItemCountPerPage(250)->
    //                 setCurrentPageNumber($this->_getParam('page', 1));
     
    //     if ( count($Paginatedresult) ) {
    //       $this->view->searchResult = $Paginatedresult;
    //     }  
              
    //         } else {
    //             $SearchForm->populate($formData);
    //         }
    //      }
    }


    public function searchProfileAction()
    {
        $SearchForm = new Application_Form_Search();
        $db = $AppliedSearch = Zend_Db_Table::getDefaultAdapter();
        $selectDetails = new Zend_Db_Select($AppliedSearch);
        $getStates = new Application_Model_State();

        $values = $SearchForm->getValues();


        $protype = $values['profileType'];
        $whichAnimal = $values['kind'];
        $race = $values['race'];
        $MaleFemale = $values['sex'];
        $Country = $values['Country'];
        $state = $values['states'];
        $city = $values['city'];
        $zip = $values['zip'];
        
        //           $protype           = $_POST['profileType'];
        //           $whichAnimal       = $_POST['kind'];
        //           $race              = $_POST['race'];
        //           $MaleFemale        = $_POST['sex'];
        //           $Country           = $_POST['Country'];
        //           $state             = $_POST['states'];
        //           $city              = $_POST['city'];
        //           $zip               = $_POST['zip'];
        //

        $stateResult = $getStates->fetchAll("state_abbr = '$state'")->toArray();
        foreach ($stateResult as $value) {
            $stateRow = $value['state_id'];
        }

        $where = " type = '$protype'
           AND kind = '$whichAnimal' 
           AND sex = '$MaleFemale' 
           AND city = '$city'
           ";


        //AND zipcode LIKE  '$zip%'
        //AND state   =     '$stateRow'
        //  
        //AND race LIKE     '$race%'
        //AND country =     '$Country'

        $selectDetails = $selectDetails->from('profiles');


        if (!empty($protype)) {

            $selectDetails = $selectDetails->from('type =?',$protype);

        }

        if (!empty($whichAnimal)) {

            $selectDetails = $selectDetails->from('kind =?',$whichAnimal);

        }
        if (!empty($MaleFemale)) {

            $selectDetails = $selectDetails->from('sex=?',$MaleFemale);

        }
        if (!empty($city)) {

            $selectDetails = $selectDetails->from('city=?',$city);

        }
        
        if (!empty($Country)) {

            $selectDetails = $selectDetails->from('country=?'.$Country);

        }
        if (!empty($race)) {

            $selectDetails = $selectDetails->from('race LIKE ?',"$race%");

        }


        if (!empty($state)) {

            $selectDetails = $selectDetails->from('state IN ('.implode(',',$stateRow).")");

        }
        if (!empty($zip)) {

            $selectDetails = $selectDetails->from('zip LIKE ?',"$zip%");

        }
//echo $selectDetails;
//
//die ("ok");
        $searchResult = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($result));
        
    

        $Paginatedresult = $searchResult->setItemCountPerPage(9)->setCurrentPageNumber($this->
            _getParam('page', 1));
          
          
          echo count($Paginatedresult);  
            
        die ("g");    

        $this->view->searchResult = $Paginatedresult;

        //   $this->view->searchResult = $result;


    }


    public function getDetailsAction()
    {

        $id = $this->getRequest()->getParam('id');
        $getDetailsofPet = new Application_Model_Profile();
        $getPetPictures = new Application_Model_UserPics();

        $where = "id = '$id'";
        $result = $getDetailsofPet->fetchAll($where)->toArray();
        $wherePIC = "profile_id = '$id'";
        $picresult = $getPetPictures->fetchAll($wherePIC)->toArray();

        $this->view->petDetails = $result;
        $this->view->petPics = $picresult;
        $captchaForm = new Application_Form_GetContact();
        $this->view->captchaForm = $captchaForm;


        if ($this->getRequest()->isPost() && $this->view->captchaForm->isValid($this->
            _getAllParams())) {
            $this->view->trueVal = "true value";
        }

    }
}