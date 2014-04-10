<?php

class AppController extends Controller 
{	
	// Käsittelemättömien tukipyyntöjen määrän näyttö
	function beforeFilter()
	{
		if( (strcmp($this->params['action'], "login")!=0) && (strcmp($this->params['action'], "register")!=0) && (strcmp($this->params['action'], "logout")!=0) )
		{
			if(($this->Auth->user('group_id'))==1)
			{
				$db = ConnectionManager::getInstance();
				$conn = $db->getDataSource('default');
				$uncompleteCount = $conn->query("SELECT count(*) AS count FROM requests WHERE complete=0");
					
				//echo ("<div class=\"notification_flash\">");
				//echo ($uncompleteCount['0']['0']['count'] . " " . __('käsittelemätöntä tukipyyntöä', true));
				//echo ("</div>");
				
				$this->set('requestNotification', "<div class=\"notification\">" . $uncompleteCount['0']['0']['count'] . " " . __('käsittelemätöntä tukipyyntöä', true) . "</div>");
				
				/*
					<div id="flashMessage" class="notification">
						3 käsittelemätöntä tukipyyntöä 
					</div>	
				*/
					
				//$this->Session->setFlash($uncompleteCount['0']['0']['count'] . ' ' . __('käsittelemätöntä tukipyyntöä', true), $element = 'notification_flash');
			}
		}
	}
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
        'RequestHandler'
    );

    public $helpers = array(
        'Html',
        'Js',
        'Session'
    );
}