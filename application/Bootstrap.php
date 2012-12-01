<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
 protected function _initStatesList()
    {
        if (!Zend_Registry::isRegistered('states')) {
            $dataFile = '../data/us-states.xml';
            $states = array();
            $data = simplexml_load_file($dataFile);

            foreach ($data->item as $item) {
                $states[(string) $item->value] = (string) $item->label;
            }
            
            Zend_Registry::set('states', $states);
        }
    }
    
    protected function _initAutoload()
    {
    $this->options = $this->getOptions();
    Zend_Registry::set('config.recaptcha', $this->options['recaptcha']);

   // $acl    = new Application_Model_LibraryAcl();
   // $auth   =  Zend_Auth::getInstance();

  //  $frontController = Zend_Controller_Front::getInstance();
  //  $frontController->registerPlugin(new Application_Plugin_Acl($acl, $auth));
    }
    
//    protected function _initViewHelpers() {
//         $this->bootstrap('layout');
//         $layout = $this->getResource('layout');
//         $view = $layout->getView();
//        Zend_Dojo::enableView($view);
//		$view->dojo()
//    		 ->addStyleSheetModule('dijit.themes.tundra')
//   			 ->setDjConfigOption('usePlainJson', true)
//   			 ->disable();
//		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
//		$viewRenderer->setView($view);
//        
//    }
   

}

