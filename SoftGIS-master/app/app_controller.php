<?php

class AppController extends Controller 
{	
	function beforeFilter()
	{
	
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
		
		
		
		// Käsittelemättömien tukipyyntöjen määrän näyttö
		if( (strcmp($this->params['action'], "login")!=0) && (strcmp($this->params['action'], "register")!=0) && (strcmp($this->params['action'], "logout")!=0) )
		{
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
					$this->set('requestNotification', "<div class=\"notification\">" . $uncompleteCount . " " . __('käsittelemätöntä tukipyyntöä', true) . "</div>");
				}
				else
				{
					$this->set('requestNotification', "");
				}
				
				/*
					<div id="flashMessage" class="notification">
						3 käsittelemätöntä tukipyyntöä 
					</div>	
				*/
					
				//$this->Session->setFlash($uncompleteCount['0']['0']['count'] . ' ' . __('käsittelemätöntä tukipyyntöä', true), $element = 'notification_flash');
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
            'authError' => 'Kirjaudu sisään',
            'loginError' => 'Sisäänkirjautuminen epäonnistui. 
                Tarkista käyttäjänimi ja salasana'
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