<?php

class SignUpController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        
        $form = new Application_Form_SignUp();
        $pass =  $this->randGenAction();
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost())
            {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) 
                {
            
                 $data = array(
                 'f_name'             => $form->getValue('f_name'),
                 'l_name'             => $form->getValue('l_name'),
                 'email'              => $form->getValue('email'),
                 'password'           => $pass,
                 'friend1'            => $form->getValue('friend1')
                 );
                
                $emailAddress = $form->getValue('email');
                $CheckEmail = new Application_Model_SignUp();
                $where = "email = '$emailAddress'";
                $temp = $CheckEmail->fetchAll($where)->count();
                if($temp > 0)
                {
                   $this->view->errorMsg = "This email is already registered";
                   $form->populate($formData);
                  
                   
                }
                else
                {
         
                      $signupDB = new Application_Model_SignUp();
                     if($signupDB->insert($data))
                     {
                      $this->view->message = "your ID has been created. Plz activate you account <br /> an email is sent at " .
                      $form->getValue('email');
                      $this->view->signin = "Sign in";
                      $email = $form->getValue('email');
                      $form->reset();

                      $this->mailToContactAction($email,$pass);
                     }

                     // $this->_redirect('index');
                             else
                                 {
                                    $form->populate($formData);
                                 }
                }
              }
            }
        
            
    }

    public function mailToContactAction($email, $pass)
    {
       
      // $pass =  $this->randGenAction();
       $StoreRandString = new Application_Model_SignUp();

       
       //////////////////////////////////////////////////
       $smtpConfigs = array(
            
            'auth'          =>      'login',
            'username'      =>      'nayab.rajpoot',
            'password'      =>      'jeerry1979',
            'ssl'           =>      'ssl',
            'port'          =>       465
            
        );
        
        $smtpTransportObject = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $smtpConfigs);
        
        $mail = new Zend_Mail();
  
        $form = new Application_Form_ContactUS();
  
 
        $mail->addTo($email,"john evans")
             ->setFrom('nayatelorg@gmail.com', "nayatel")
             ->setSubject('Accounet Confirmation')
             ->setBodyText('your pin code is '. " " .$pass . " " .'After you logged in kindly set you desired password')
             ->send($smtpTransportObject);
        
           
           
          
       
       //////////////////////////////////////////////////
       
       
    }

    public function randGenAction()
    {
       $length=15;
       $strength=0;
       
        $vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
    }

    public function recoverPasswordAction()
    {
        $form = new Application_Form_RecoverPassword();
        $this->view->form = $form;

         if ($this->getRequest()->isPost())
            {

            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData))
                {
                  $getEmail = new Application_Model_SignUp();
                  $formEmail = $form->getValue('email');
                  $where = "email = '$formEmail'";
                  $email = $getEmail->fetchAll($where)->toArray();
                  if($email)
                  {

                      $data = array('password' => $randNumber = $this->randGenAction());
                      $getEmail->update($data, $where);
                      $this->mailToContactAction($formEmail,$randNumber);

                    $this->view->successMessage = "Your password is sent to this email"." ".$formEmail;

                  }
                  else
                  {
                        $this->view->ErrorMessage = "This is not Valid Email";
                  }

                }
            }



    }

    public function getapiAction()
    {
        
      require_once('aweber_api/aweber_api.php');

      // Put the consumer key and secret from your App on labs.aweber.com below.
      $consumerKey    = 'AkEwGDikDdONWQPkDT3I073n';
      $consumerSecret = 'Px3lt9PxCYKHiIuJARC6w9gesTTwraDZ9I9yo3OP';
      // $accessKey      = 'Agy6yV9IQJOY1gEOwq1ycNrh'; # put your credentials here
      // $accessSecret   = '1pSovJVQ77aBPNfBg5QgwcEYZn9YhpxAcxPBwc3z'; # put your credentials here
      // $account_id     = '668528'; # put the Account id here
      // $list_id        = '2431047';
      $aweber = new AWeberAPI($consumerKey, $consumerSecret);
      $callbackUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

      list($key, $secret) = $aweber->getRequestToken($callbackURL);

        // get the authorization URL
        $authorizationURL = $aweber->getAuthorizeUrl();

        // store the request token secret
        setcookie('secret', $secret);

        // redirect user to authorization URL
        header("Location: $authorizationURL");
        exit();





      //  $consumerKey    = 'AkJ0oW31TeNfdCiwGd3zdAA6';
      // $consumerSecret = 'p64w4AoPOOyLhgr9PU9zuzi667J9I5BxwRHzUilZ';

//       if (empty($_COOKIE['accessToken'])) {
//     if (empty($_GET['oauth_token'])) {
//         $callbackUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//         list($requestToken, $requestTokenSecret) = $aweber->getRequestToken($callbackUrl);
//         setcookie('requestTokenSecret', $requestTokenSecret);
//         setcookie('callbackUrl', $callbackUrl);
//         header("Location: {$aweber->getAuthorizeUrl()}");
//         exit();
//     }

//     $aweber->user->tokenSecret = $_COOKIE['requestTokenSecret'];
//     $aweber->user->requestToken = $_GET['oauth_token'];
//     $aweber->user->verifier = $_GET['oauth_verifier'];
//     list($accessToken, $accessTokenSecret) = $aweber->getAccessToken();
//     setcookie('accessToken', $accessToken);
//     setcookie('accessTokenSecret', $accessTokenSecret);
//     header('Location: '.$_COOKIE['callbackUrl']);
//     exit();
// }

// $aweber->adapter->debug = false;

 //$account = $aweber->getAccount($_COOKIE['accessToken'], $_COOKIE['accessTokenSecret']);

// print_r($account);

//       foreach($account->lists as $offset => $list)
//       {
//       echo "<h1>List:".$list->name."</h1>";
//       echo "<h3>".$list->id."</h3>";
//       }

//       try {
//     $account = $aweber->getAccount($accessKey, $accessSecret);
//     // $listURL = "/accounts/{$account_id}/lists/{$list_id}";
//     $listURL = "/accounts/{$account_id}/lists/{$list_id}/subscribers";
//      $list = $account->loadFromUrl($listURL);


//   $found_subscribers_collection = $list->find(array('email' => 'saqibbb.msn@hotmail.com'));
// print "<li>total size: " . $found_subscribers_collection->total_size . "<br>";

// foreach ($found_subscribers_collection as $subscriber) {
//     print " <li> " . $subscriber->email . "<br>";
// }
//     //  print_r($list);
    // foreach ($list as $value) {
      
    //      echo $value->id."<br />";
    //      // echo $value->name."<br />";
    //      echo $value->subscribed_at."<br />";
    //      echo $value->status."<br />";


    // }
    # create a subscriber
    // $params = array(
    //     'email' => 'saqib.msn@hotmail.com',
    //     'ip_address' => '127.0.0.1',
    //     'ad_tracking' => 'client_lib_example',
    //     'last_followup_message_number_sent' => 1,
    //     'misc_notes' => 'my cool app',
    //     'name' => 'saqib',
        
    // );
    // $subscribers = $list->subscribers;
    // $new_subscriber = $subscribers->create($params);

    // # success!
    // echo $new_subscriber->email."was added to the".$list->name." list!";
    // die();

// } catch(AWeberAPIException $exc) {
//     print "<h3>AWeberAPIException:</h3>";
//     print " <li> Type: $exc->type              <br>";
//     print " <li> Msg : $exc->message           <br>";
//     print " <li> Docs: $exc->documentation_url <br>";
//     print "<hr>";
//     exit(1);
// }


    }


}






