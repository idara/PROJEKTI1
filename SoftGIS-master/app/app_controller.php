<?php

class AppController extends Controller 
{	
	function beforeFilter()
	{
		// Set Default timezone
		// http://php.net/manual/en/function.date-default-timezone-set.php
		// http://www.php.net/manual/en/timezones.php
		// http://www.php.net/manual/en/timezones.others.php
		// http://www.php.net/manual/en/timezones.europe.php
		
		date_default_timezone_set('Europe/Helsinki');
		//date_default_timezone_set('UTC');
		//date_default_timezone_set('GMT');
		
	
		// Localization
		// http://nuts-and-bolts-of-cakephp.com/tag/cakephp-localization/
		// http://stackoverflow.com/questions/13645509/cakephp-let-the-users-choose-the-language
		if ($this->Cookie->read('lang') && !$this->Session->check('Config.language'))
		{
            $this->Session->write('Config.language', $this->Cookie->read('lang'));
			Configure::write('Config.language', $this->Cookie->read('lang'));
        }
        else if (isset($this->params['language']) && ($this->params['language'] !=  $this->Session->read('Config.language')))
		{
            $this->Session->write('Config.language', $this->params['language']);
            $this->Cookie->write('lang', $this->params['language'], false, '20 days');
			Configure::write('Config.language', $this->params['language']);
		}
		else
		{
			Configure::write('Config.language', $this->Cookie->read('lang'));
		}
		
		// / Localization
		
		//      Onko käyttäjällä oikeutta käyttäjähallintaan?
		//		Tulostetaanko käyttäjähallintalinkki tiedostossa Views->Layouts->Author.ctp
		
			if($this->Auth->user('group_id')==1)
			{
				$this->set('accessToUserControl', 1);
			}
			else
			{
				$this->set('accessToUserControl', 0);
			}
		
		//    / Onko käyttäjällä oikeutta käyttäjähallintaan?
		
		// Käsittelemättömien tukipyyntöjen määrän näyttö ja Sähköpostiosoitteen syöttämisen muistutus
		if( (strcmp($this->params['action'], "login")!=0) && (strcmp($this->params['action'], "register")!=0) && (strcmp($this->params['action'], "logout")!=0) )
		{
			$notificationCount = 0;
		
			//Käsittelemättömien tukipyyntöjen määrä
			if(($this->Auth->user('group_id'))==1)
			{
				$db = ConnectionManager::getInstance();
				$conn = $db->getDataSource('default');
				$uncompleteCount = $conn->query("SELECT count(*) AS count FROM requests WHERE complete=0");
				
				$uncompleteCount = $uncompleteCount['0']['0']['count'];
					
				//echo ("<div class=\"notification_flash\">");
				//echo ($uncompleteCount['0']['0']['count'] . " " . __('käsittelemätöntä tukipyyntöä', true));
				//echo ("</div>");
				
				if($uncompleteCount!=0)
				{
					if($uncompleteCount==1)
					{
						if(!isset($notification))
						{
							$notification = "";
						}
						
						$notification = $notification . $uncompleteCount . " " . __('käsittelemätön tukipyyntö', true);
					}
					else
					{
						if(!isset($notification))
						{
							$notification = "";
						}
						
						$notification = $notification . $uncompleteCount . " " . __('käsittelemätöntä tukipyyntöä', true);
					}
					$notificationCount++;
				}
			}
			
			// Sähköpostiosoitteen syöttämisen muistutus
			if(strlen($this->Auth->user('email'))==0)
			{
				if($notificationCount==0)
				{
					if(!isset($notification))
					{
						$notification = "";
					}
						
					$notification = $notification . __('Muistathan lisätä sähköpostiosoitteen käyttäjätietoihisi.', true);
				}
				else
				{
					if(!isset($notification))
					{
						$notification = "";
					}
					
					$notification = $notification . "<br>" . __('Muistathan lisätä sähköpostiosoitteen käyttäjätietoihisi.', true);
				}
				$notificationCount++;
			}
			
			if(isset($notification))
			{
				$notification = "<div class=\"notification\">" . $notification . "</div>";
				$this->set('userNotification', $notification);
			}
		}
	}
	
	//http://nuts-and-bolts-of-cakephp.com/tag/cakephp-localization/
	/*function _setLanguage()
	{
        if ($this->Cookie->read('lang') && !$this->Session->check('Config.language'))
		{
            $this->Session->write('Config.language', $this->Cookie->read('lang'));
        }
        else if (isset($this->params['language']) && ($this->params['language'] !=  $this->Session->read('Config.language')))
		{
            $this->Session->write('Config.language', $this->params['language']);
            $this->Cookie->write('lang', $this->params['language'], false, '20 days');
        }
    }
	*/
	
	
	//===========



    public $components = array(
        'Auth' => array(
            // 'authorize' => 'actions',
            'userModel' => 'Author',
            'loginAction' => array(
                'controller' => 'authors',
                'action' => 'login'
            ),
            'loginRedirect' => array(
                'controller' => 'polls',
                'action' => 'index'
            ),
            'authError' => __('Kirjaudu sisään'),
            'loginError' => __('Sisäänkirjautuminen epäonnistui. 
                Tarkista käyttäjänimi ja salasana')
        ),
        'Session',
        'RequestHandler',
		'Cookie'
    );

    public $helpers = array(
        'Html',
        'Js',
        'Session'
    );
}