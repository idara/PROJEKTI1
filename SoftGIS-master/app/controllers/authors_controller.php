<?php

class AuthorsController extends AppController
{
	
	var $name = 'Authors';	
	
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('register', 'login');
    }

    public function index()
    {
        $id = $this->Author->id = $this->Auth->user('id');
        $me = $this->Author->read();
        // debug($me);die;
        $this->set('me', $me);
    }

    public function login()
    {
        
    }
	
    public function register()
    {
        $secret = 'kalapuikko';

        if (!empty($this->data)) {
            if ($this->data['secret'] == $secret) {
			
				$lowestGroup = $this->Author->query("SELECT groups.id FROM groups ORDER BY id DESC LIMIT 1;");
		
				$this->data['Author']['group_id'] = $lowestGroup['0']['groups']['id'];
				
				if( (isset($this->data['Author']['pw'])) AND (strlen($this->data['Author']['pw'])!=0) )
				{
					$this->data['Author']['password'] = $this->Auth->password($this->data['Author']['pw']);
					
					// Tarkistetaan salasanojen oikeinkirjoitus
					if(strcmp($this->data['Author']['password'], $this->Auth->password($this->data['Author']['passwordRetyped']))==0)
					{
						if ($this->Author->save($this->data)) {
							$this->Session->setFlash(__('Rekisteröinti onnistui<br>Voit nyt kirjautua sisään', true));
							//$this->Session->setFlash(__('Rekisteröinti onnistui'));
							//$this->Session->setFlash(__('Voit nyt kirjautua sisään'));
							$this->redirect(array('action' => 'login'));
						} else {
							$this->data['Author']['password'] = '';
						}
					}
					else
					{
						//$this->Session->setFlash(__('Salasanat eivät täsmää.', true) . " " . __('Käyttäjää ei luotu.', true));
						//$this->redirect(array('action' => 'add
						
						$this->Session->setFlash(__('Rekisteröinti ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
						$this->Author->invalidate( 'passwordRetyped', __('Salasanat eivät täsmää.', true) );
						
						//Tyhjennetään salasanakentät
						$this->data['Author']['password']="";
						$this->data['Author']['passwordRetyped']="";
					}
				}
				else
				{
					$this->Session->setFlash(__('Rekisteröinti ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
					$this->Author->invalidate( 'pw', __('Salasana on pakollinen.', true) );
				}
            } else {
                $this->data['Author']['password'] = '';
                $this->set('secretWrong', true);
            }
        }
    }

    public function logout()
    {
        $this->redirect($this->Auth->logout());
    }
	
	//KÄYTTÄJÄHALLINTA
	
	//Kaikkien käyttäjien listaus
	public function view() {
	
		//$tuloste = "Kirjautunut käyttäjä: " . $this->Auth->user('id');
		//$this->set('tuloste', $tuloste);
		$this->set('authorizedUserId', $this->Auth->user('id'));
	
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{		
			//Sivutuskäyttäjälistalle
			$this->paginate = array(
				'limit' => 25,
				'order' => array(
					'Author.id' => 'asc'
				)
			);
		
			//Käyttäjälista
			$this->Author->recursive = 0;
			$this->set('authors', $this->paginate());
			
			//Kyselyiden määrä
			$this->set('pollsCount', $this->Author->query("SELECT authors.id, COUNT(polls.author_id) as lkm FROM authors INNER JOIN polls ON authors.id=polls.author_id GROUP BY authors.id;"));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Käyttäjälista', true));
			
			//Ryhmät
			$this->set('groups', $this->Author->query("SELECT groups.id, groups.groupname FROM groups;"));
		}
	}
	
	//Uuden käyttäjän lisääminen käyttäjähallinnan kautta
	function add() {
		
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			if (!empty($this->data)) {
				$this->Author->create();
				
				if( (isset($this->data['Author']['pw'])) AND (strlen($this->data['Author']['pw'])!=0) )
				{
					$this->data['Author']['password'] = $this->Auth->password($this->data['Author']['pw']);
				
					/*	$this->Session->setFlash(
							"Tunnus: " . $this->data['Author']['username'] . 
							"<br><br>Salasana: " . $this->data['Author']['password'] . 
							"<br>Varmistus: " . $this->Auth->password($this->data['Author']['passwordRetyped']) . 
							"<br><br>Email: " . $this->data['Author']['email'] . 
							"<br>Varmistus: " . $this->data['Author']['emailRetyped']);
					*/	
					// Tarkistetaan salasanojen oikeinkirjoitus
					if(strcmp($this->data['Author']['password'], $this->Auth->password($this->data['Author']['passwordRetyped']))==0)
					{
						// Tarkistetaan sähköpostiosoitteiden oikeinkirjoitus
						if(strcmp($this->data['Author']['email'], $this->data['Author']['emailRetyped'])==0)
						{
							if ($this->Author->save($this->data)) {
								$this->Session->setFlash(__('Uusi käyttäjä lisätty', true));
								$this->redirect(array('action' => 'view'));
							} else {
								$this->Session->setFlash(__('Uutta käyttäjää ei voitu lisätä. Ole hyvä ja yritä uudestaan.', true));
								//Tyhjennetään salasanakentät
								$this->data['Author']['password']="";
								$this->data['Author']['passwordRetyped']="";
							}
						}
						else
						{
						//$this->Session->setFlash(__('Sähköpostiosoitteet eivät täsmää.', true) . " " . __('Käyttäjää ei luotu.', true));
						//$this->redirect(array('action' => 'add'));
						
						$this->Session->setFlash(__('Uutta käyttäjää ei voitu lisätä. Ole hyvä ja yritä uudestaan.', true));
						$this->Author->invalidate( 'emailRetyped', __('Sähköpostiosoitteet eivät täsmää.', true) );
						
						//Tyhjennetään salasanakentät
						$this->data['Author']['password']="";
						$this->data['Author']['passwordRetyped']="";
						}
					}
					else
					{
						//$this->Session->setFlash(__('Salasanat eivät täsmää.', true) . " " . __('Käyttäjää ei luotu.', true));
						//$this->redirect(array('action' => 'add
						
						$this->Session->setFlash(__('Uutta käyttäjää ei voitu lisätä. Ole hyvä ja yritä uudestaan.', true));
						$this->Author->invalidate( 'passwordRetyped', __('Salasanat eivät täsmää.', true) );
						
						//Tyhjennetään salasanakentät
						$this->data['Author']['password']="";
						$this->data['Author']['passwordRetyped']="";
					}
				}
				else
				{
					$this->Session->setFlash(__('Rekisteröinti ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
					$this->Author->invalidate( 'pw', __('Salasana on pakollinen.', true) );
				}
			}
			//$groups = $this->User->Group->find('list');
			//$this->set(compact('groups'));
			
			//Ryhmien nimet ja id:t ja nimet lomakkeen select-elementille
			$groups = $this->Author->Group->find('all');
			$this->set(compact('groups'));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Lisää uusi käyttäjä', true));
		}
	}
	
	//Käyttäjän käyttäjänimen muokkaaminen
	/*
	function username($id = null) {
	
		if(($this->Auth->user('group_id'))==1)
		{
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'view'));
			}
			if (!empty($this->data)) {

				// Id of authorized editor
				$editorId = $this->Auth->user('id');
				
				//Authorized user's password
				$AuthorizedPassword =  $this->Author->query("SELECT authors.password FROM authors WHERE authors.id=$editorId;");
				$AuthorizedPassword = $AuthorizedPassword['0']['authors']['password'];
			
				//Confirm password
				$confirmPassword = $this->Auth->password($this->data['Author']['confirmPassword']);
		
				// IF Authorized user's password == Confirm password
				if(strcmp($AuthorizedPassword, $confirmPassword)==0)
				{
					if ($this->Author->save($this->data)) {
						$this->Session->setFlash(__('Käyttäjän käyttäjänimeen tehdyt muutokset on tallennettu', true));
						$this->redirect(array('action' => 'view'));
					} else {
						$this->Session->setFlash(__('Muutoksia ei voitu tallentaa. Käyttäjätunnus on jo käytössä.', true));
						$this->data['Author']['confirmPassword'] = '';
						$this->redirect(array('action' => 'username', $id));
					}
				}
				else
				{					
					$this->Session->setFlash(__('Virheellinen salasana.', true));
					
					//Tyhjennetään salasanakentät
					//$this->data['Author']['password']="";
					//$this->data['Author']['passwordRetyped']="";
					$this->data['Author']['confirmPassword'] = '';
					
					$this->redirect(array('action' => 'username', $id));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Author->read(null, $id);
			}
			
			//Käyttäjän tiedot näkymälle tulostettavaksi
			$this->set('user', $this->Author->read(null, $id));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Muokkaa käyttäjän käyttäjänimeä', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			$this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	*/
	
	//Käyttäjän salasanan muokkaaminen
	function password($id = null) {
	
		if(($this->Auth->user('group_id'))==1)
		{
			if(isset($_GET["source"]))
			{
				$this->set('source', $_GET["source"]);
			}
			else
			{
				$this->set('source', "");
			}
			
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'view'));
			}
			if (!empty($this->data)) {
			
				// Id of authorized editor
				$editorId = $this->Auth->user('id');
				
				//Authorized user's password
				$AuthorizedPassword =  $this->Author->query("SELECT authors.password FROM authors WHERE authors.id=$editorId;");
				$AuthorizedPassword = $AuthorizedPassword['0']['authors']['password'];
			
				//Confirm password
				$confirmPassword = $this->Auth->password($this->data['Author']['confirmPassword']);
		
				// IF Authorized user's password == Confirm password
				if(strcmp($AuthorizedPassword, $confirmPassword)==0)
				{
					if(strcmp($this->data['Author']['pwd'], $this->data['Author']['retypedPassword'])==0)
					{
						$pw = $this->Auth->password($this->data['Author']['pwd']);
	 
						if($this->Author->query("UPDATE authors SET password = '$pw'  WHERE id = $id;"))
						{
							$this->Session->setFlash(__('Käyttäjän salasanaan tehdyt muutokset on tallennettu', true));
							$this->redirect(array('action' => 'view'));
						} else {
							$this->Session->setFlash(__('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
							$this->data['Author']['confirmPassword'] = '';
							$this->data['Author']['pwd'] = "";
							$this->data['Author']['retypedPassword'] = "";
							$this->redirect(array('action' => 'password', $id));
						}
					}
					else
					{
						$this->Session->setFlash(__('Salasanat eivät täsmää. Muutoksia ei tallennettu.', true));
						$this->redirect(array('action' => 'password', $id));
					}
				}
				else
				{
					//$this->data['confirmPassword'] = '';
					//$this->set('passwordWrong', true);
					$this->Session->setFlash(__('Virheellinen salasanavarmistus. Muutoksia ei tallennettu.', true));
					$this->data['Author']['confirmPassword'] = '';
					$this->data['Author']['pwd'] = "";
					$this->data['Author']['retypedPassword'] = "";
					$this->redirect(array('action' => 'password', $id));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Author->read(null, $id);
			}
			
			//Käyttäjän tiedot näkymälle tulostettavaksi
			$this->set('user', $this->Author->read(null, $id));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Muokkaa käyttäjän salasanaa', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	//Käyttäjän sähköpostiosoitteen muokkaaminen
	function email($id = null) {
	
		if(($this->Auth->user('group_id'))==1)
		{
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'view'));
			}
			if (!empty($this->data)) {

				// Id of authorized editor
				$editorId = $this->Auth->user('id');
				
				//Authorized user's password
				$AuthorizedPassword =  $this->Author->query("SELECT authors.password FROM authors WHERE authors.id=$editorId;");
				$AuthorizedPassword = $AuthorizedPassword['0']['authors']['password'];
			
				//Confirm password
				$confirmPassword = $this->Auth->password($this->data['Author']['confirmPassword']);
		
				// IF Authorized user's password == Confirm password
				if(strcmp($AuthorizedPassword, $confirmPassword)==0)
				{
					$this->data['Author']['id'] = $id;
					
					if(strcmp($this->data['Author']['email'], $this->data['Author']['emailRetyped'])==0)
					{
						if ($this->Author->save($this->data)) {
							$this->Session->setFlash(__('Käyttäjän sähköpostiosoitteeseen tehdyt muutokset on tallennettu', true));
							$this->redirect(array('action' => 'view'));
						} else {
							$this->Session->setFlash(__('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
							$this->data['Author']['confirmPassword'] = '';
							$this->redirect(array('action' => 'email', $id));
						}
					}
					else
					{
						$this->Session->setFlash(__('Sähköpostiosoitteet eivät täsmää.', true));
						$this->redirect(array('action' => 'email', $id));
					}
				}
				else
				{
					//$this->data['confirmPassword'] = '';
					//$this->set('passwordWrong', true);
					$this->Session->setFlash(__('Virheellinen salasana.', true));
					
					//Tyhjennetään salasanakentät
					//$this->data['Author']['password']="";
					//$this->data['Author']['passwordRetyped']="";
					$this->data['Author']['confirmPassword'] = '';
					
					$this->redirect(array('action' => 'email', $id));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Author->read(null, $id);
			}
			
			//Käyttäjän tiedot näkymälle tulostettavaksi
			$this->set('user', $this->Author->read(null, $id));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Muokkaa käyttäjän sähköpostiosoitetta', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	//Käyttäjän poistaminen
	function delete($id = null) {
		/*
		$conditions = array("Post.title" => "This is a post");
		//Example usage with a model:
		$this->Post->find('first', array('conditions' => $conditions));
		
		deleteAll(mixed $conditions, $cascade = true, $callbacks = false)
		*/
	
		if(($this->Auth->user('group_id'))==1)
		{
			if (!$id) {
				$this->Session->setFlash(__('Käyttäjää ei löytynyt.', true));
				$this->redirect(array('action'=>'view'));
			}
			
			// Id of authorized editor
			$editorId = $this->Auth->user('id');
			
			//Authorized user's password
			$AuthorizedPassword =  $this->Author->query("SELECT authors.password FROM authors WHERE authors.id=$editorId;");
			$AuthorizedPassword = $AuthorizedPassword['0']['authors']['password'];
		
			//Confirm password
			$confirmPassword = $this->Auth->password($_POST['confirmPassword']);
	
			// IF Authorized user's password == Confirm password
			if(strcmp($AuthorizedPassword, $confirmPassword)==0)
			{
				//$conditions = array("Post.title" => "This is a post");
				//Example usage with a model:
				//$this->Post->find('first', array('conditions' => $conditions));
				
				$conditions = array("Author.id" => $id);

				if ($this->Author->deleteAll($conditions, $cascade = true)) {
				
					if($id==$this->Auth->user('id'))
					{
						$this->Session->setFlash(__('Poistit oman käyttäjätunnuksesi', true));
						$this->redirect(array('action' => 'logout'));
					}
					else
					{
						$this->Session->setFlash(__('Käyttäjä poistettu.', true));
						$this->redirect(array('action'=>'view'));
					}
				}
				$this->Session->setFlash(__('Käyttäjää ei voitu poistaa.', true));
				$this->redirect(array('action' => 'view'));
			}
			else
			{
				$this->data['confirmPassword'] = '';
				$this->Session->setFlash(__('Virheellinen salasana', true));
				$this->redirect(array('action'=>'view'));
			}
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	
	//Ryhmän vaihtaminen
	function group($id = null) {
	
		if(($this->Auth->user('group_id'))==1)
		{			
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'view'));
			}
			if (!empty($this->data)) {
			
				// Id of authorized editor
				$editorId = $this->Auth->user('id');
				
				//Authorized user's password
				$AuthorizedPassword =  $this->Author->query("SELECT authors.password FROM authors WHERE authors.id=$editorId;");
				$AuthorizedPassword = $AuthorizedPassword['0']['authors']['password'];
			
				//Confirm password
				$confirmPassword = $this->Auth->password($this->data['Author']['confirmPassword']);
		
				// IF Authorized user's password == Confirm password
				if(strcmp($AuthorizedPassword, $confirmPassword)==0)
				{
					$this->data['Author']['id'] = $id;
					
					if ($this->Author->save($this->data)) {
						$this->Session->setFlash(__('Käyttäjään tehdyt muutokset on tallennettu', true));
						$this->redirect(array('action' => 'view'));
					} else {
						$this->Session->setFlash(__('Muutoksia ei voitu tallentaa. Ryhmän nimi on jo käytössä.', true));
						$this->data['Author']['confirmPassword'] = '';
						$this->redirect(array('action' => 'group', $id));
					}
				}
				else
				{
					$this->Session->setFlash(__('Virheellinen salasana.', true));
					
					//Tyhjennetään salasanakentät
					//$this->data['Author']['password']="";
					//$this->data['Author']['passwordRetyped']="";
					$this->data['Author']['confirmPassword'] = '';
					
					$this->redirect(array('action' => 'group', $id));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Author->read(null, $id);
			}
			
			//Käyttäjän tiedot näkymälle tulostettavaksi
			$this->set('user', $this->Author->read(null, $id));
			
			//Ryhmien nimet ja id:t lomakkeen select-elementille
			$groups = $this->Author->Group->find('all');
			$this->set(compact('groups'));
			
			//Ryhmä, johon muokattava käyttäjä kuuluu
			$modifyGroup = $this->Author->find('first', array('conditions' => array('Author.id' => $id), 'fields' => array('Author.group_id')));
			$this->set('modifyGroup', $modifyGroup['Author']['group_id']);
			
			// Muokkaajan id
			$this->set('editorsId', $this->Auth->user('id'));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Vaihda ryhmää', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	//Omien tietojen hallinta
	
	//Profiili - Etusivu
	function profile() {
	
		//Käyttäjän id
		$id = $this->Auth->user('id');
	
		//Käyttäjän tiedot
		$this->set('author', $this->Author->query("SELECT authors.id, authors.username, authors.password, authors.email, authors.group_id FROM authors WHERE authors.id=$id;"));
		
		// Sähköpostin pituus
		//$this->set('emailLengt', strlen($this->Auth->user('email')));
		//$emailLengt = $this->Author->query("SELECT authors.email FROM authors WHERE authors.id=$id;");
		//$this->set('emailLengt', strlen($emailLengt['0']['authors']['email']));
		
		//Kyselyiden määrä
		$this->set('pollsCount', $this->Author->query("SELECT authors.id, COUNT(polls.author_id) as lkm FROM authors INNER JOIN polls ON authors.id=polls.author_id GROUP BY authors.id;"));
		
		//Kyselyiden määrä
		$this->set('pollsCount', $this->Author->query("SELECT author_id, COUNT(author_id) as lkm FROM polls WHERE author_id=$id;"));
		
		//Julkisten kyselyiden määrä
		$this->set('publicPollsCount', $this->Author->query("SELECT author_id, COUNT(author_id) as lkm FROM polls WHERE author_id=$id AND public='1';"));
		
		//Avoimien kyselyiden määrä
		$now = date("Y-m-d");
		$this->set('openPollsCount', $this->Author->query("SELECT author_id, COUNT(author_id) as lkm FROM polls WHERE author_id=$id AND ('$now' BETWEEN `launch` AND `end`);"));
		
		//Asetetaan layout -> Navigointi näkyviin
		$this->layout = 'author';
		
		//Asetetaan sivun otsikko
		$this->set('title_for_layout', __(' - Omien tietojen hallinta', true));
		
		//Ryhmät
		$this->set('groups', $this->Author->query("SELECT groups.id, groups.groupname FROM groups;"));
	}
	
	//Profiili - Käyttäjänimen muokkaaminen
	/*
	function profile_username() {
	
		$id = $this->Auth->user('id');
	
		if(($this->Auth->user('id'))==$id)
		{
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'profile'));
			}
			if (!empty($this->data)) {
				if ($this->Author->save($this->data)) {
					$this->Session->setFlash(__('Käyttäjän käyttäjänimeen tehdyt muutokset on tallennettu', true));
					$this->redirect(array('action' => 'profile'));
				} else {
					$this->Session->setFlash(__('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Author->read(null, $id);
			}
			
			//Käyttäjän tiedot näkymälle tulostettavaksi
			$this->set('user', $this->Author->read(null, $id));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Muokkaa omaa käyttäjätunnusta', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	*/
	
	//Käyttäjän salasanan muokkaaminen
	function profile_password() {
	
		$id = $this->Auth->user('id');
	
		if(($this->Auth->user('id'))==$id)
		{			
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'profile'));
			}
			if (!empty($this->data)) {
			
				// Id of authorized editor
				$editorId = $this->Auth->user('id');
				
				//Authorized user's password
				$AuthorizedPassword =  $this->Author->query("SELECT authors.password FROM authors WHERE authors.id=$editorId;");
				$AuthorizedPassword = $AuthorizedPassword['0']['authors']['password'];
			
				//Confirm password
				$confirmPassword = $this->Auth->password($this->data['Author']['confirmPassword']);
		
				// IF Authorized user's password == Confirm password
				if(strcmp($AuthorizedPassword, $confirmPassword)==0)
				{
					if(strcmp($this->data['Author']['pwd'], $this->data['Author']['retypedPassword'])==0)
					{
						$pw = $this->Auth->password($this->data['Author']['pwd']);
	 
						if($this->Author->query("UPDATE authors SET password = '$pw'  WHERE id = $id;"))
						{
							$this->Session->setFlash(__('Käyttäjän salasanaan tehdyt muutokset on tallennettu', true));
							$this->redirect(array('action' => 'profile'));
						} else {
							$this->Session->setFlash(__('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
							$this->data['Author']['confirmPassword'] = '';
							$this->data['Author']['pwd'] = "";
							$this->data['Author']['retypedPassword'] = "";
							$this->redirect(array('action' => 'profile_password', $id));
						}
					}
					else
					{
						$this->Session->setFlash(__('Salasanat eivät täsmää. Muutoksia ei tallennettu.', true));
						$this->redirect(array('action' => 'profile_password', $id));
					}
				}
				else
				{
					//$this->data['confirmPassword'] = '';
					//$this->set('passwordWrong', true);
					$this->Session->setFlash(__('Virheellinen salasanavarmistus. Muutoksia ei tallennettu.', true));
					$this->data['Author']['confirmPassword'] = '';
					$this->data['Author']['pwd'] = "";
					$this->data['Author']['retypedPassword'] = "";
					$this->redirect(array('action' => 'profile_password', $id));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Author->read(null, $id);
			}
			
			//Käyttäjän tiedot näkymälle tulostettavaksi
			$this->set('user', $this->Author->read(null, $id));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Muokkaa omaa salasanaa', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	//Käyttäjän poistaminen
	/*
	function profile_delete() {
	
		$id = $this->Auth->user('id');
	
		if(($this->Auth->user('id'))==$id)
		{
		
			if (!$id) {
				$this->Session->setFlash(__('Käyttäjää ei löytynyt.', true));
				$this->redirect(array('action'=>'profile'));
			}
			
			//$conditions = array("Post.title" => "This is a post");
			//Example usage with a model:
			//$this->Post->find('first', array('conditions' => $conditions));
			
			$conditions = array("Author.id" => $id);

			if ($this->Author->deleteAll($conditions, $cascade = true)) {
			
				if($id==$this->Auth->user('id'))
				{
					$this->Session->setFlash(__('Poistit oman käyttäjätunnuksesi', true));
					$this->redirect(array('action' => 'logout'));
				}
				else
				{
					$this->Session->setFlash(__('Käyttäjä poistettu.', true));
					$this->redirect(array('action'=>'profile'));
				}
			}
			$this->Session->setFlash(__('Käyttäjää ei voitu poistaa.', true));
			$this->redirect(array('action' => 'profile'));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	*/
	
	//Profiili - Sähköpostiosoitteen muokkaaminen
	function profile_email() {
	
		$id = $this->Auth->user('id');
	
		if(($this->Auth->user('id'))==$id)
		{
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'profile'));
			}
			if (!empty($this->data)) {
			
				//Authorized user's password
				$AuthorizedPassword =  $this->Author->query("SELECT authors.password FROM authors WHERE authors.id=$id;");
				$AuthorizedPassword = $AuthorizedPassword['0']['authors']['password'];
			
				//Confirm password
				$confirmPassword = $this->Auth->password($this->data['Author']['confirmPassword']);
		
				// IF Authorized user's password == Confirm password
				if(strcmp($AuthorizedPassword, $confirmPassword)==0)
				{
					$this->data['Author']['id'] = $id;
					
					if ($this->Author->save($this->data)) {
						$this->Session->setFlash(__('Käyttäjän sähköpostiosoitteeseen tehdyt muutokset on tallennettu', true));
						$this->redirect(array('action' => 'profile'));
					} else {
						$this->Session->setFlash(__('Sähköpostiosoite on jo käytössä', true) . '<br>' . __('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
					}
				}
				else
				{
					//$this->data['confirmPassword'] = '';
					//$this->set('passwordWrong', true);
					$this->Session->setFlash(__('Virheellinen salasanavarmistus. Muutoksia ei tallennettu.', true));
					$this->data['Author']['confirmPassword'] = '';
					//$this->data['Author']['pwd'] = "";
					//$this->data['Author']['retypedPassword'] = "";
					$this->redirect(array('action' => 'profile_email', $id));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Author->read(null, $id);
			}
			
			//Käyttäjän tiedot näkymälle tulostettavaksi
			$this->set('user', $this->Author->read(null, $id));
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Muokkaa omaa sähköpostiosoitettasi', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	
	//Ryhmän vaihtaminen
	/*
	function profile_group() {
	
		$id = $this->Auth->user('id');
	
		if(($this->Auth->user('id'))==$id)
		{			
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Käyttäjää ei löydy', true));
				$this->redirect(array('action' => 'profile'));
			}
			if (!empty($this->data)) {
				if ($this->Author->save($this->data)) {
					$this->Session->setFlash(__('Käyttäjään tehdyt muutokset on tallennettu', true));
					$this->redirect(array('action' => 'profile'));
				} else {
					$this->Session->setFlash(__('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Author->read(null, $id);
			}
			
			//Käyttäjän tiedot näkymälle tulostettavaksi
			$this->set('user', $this->Author->read(null, $id));
			
			//Ryhmien nimet ja id:t ja nimet lomakkeen select-elementille
			$groups = $this->Author->Group->find('all');
			$this->set(compact('groups'));
			
			//Ryhmä, johon muokattava käyttäjä kuuluu
			$modifyGroup = $this->Author->find('first', array('conditions' => array('Author.id' => $id), 'fields' => array('Author.group_id')));
			$this->set('modifyGroup', $modifyGroup['Author']['group_id']);
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Vaihda ryhmää', true));
		}
		else
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			$this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
	}
	*/
	
	//  /Omien tietojen hallinta
	
	//   / KÄYTTÄJÄHALLINTA
	
	//  VARMUUSKOPIOINTI
	
	//Alkusivu - Listaa varmuuskopiot
	public function backup()
    {	
        //Asetetaan layout -> Navigointi näkyviin
		$this->layout = 'author';
		
		//Asetetaan sivun otsikko
		$this->set('title_for_layout', __(' - Varmuuskopiointi', true));
    }
	
	// Luo uusi varmuuskopio
	public function backup_exec()
    {
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjienhallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{	
			//Varmuuskopiotiedoston tiedostonimi
			$backupFilename = 'soft-gis_backup_' . date('Y-m-d_H-i-s') . '.sql';
			
			//Suoritettava komento
			$command = 'mysqldump -u projekti_1 -pprojekti_1_salasana projekti_1 > ' . WWW_ROOT . 'backups' . DIRECTORY_SEPARATOR . $backupFilename;
			
			//Suoritetaan komento järjestelmässä |  $retval = paluuarvo
			system($command, $retval);
			
			//Reagoidaan paluuarvon perusteella
			if($retval==0)
			{
			/*
			// Tarvittaessa voidaan asettaa luodulle tiedostolle oikeudet
				if(chmod(WWW_ROOT . 'backups' . DIRECTORY_SEPARATOR . $backupFilename, 0666))
				{
					$this->Session->setFlash(__('Varmuuskopiointi onnistui', true) . '<br>' . __('Viimeistelläksesi varmuuskopioinnin, lataa varmuuskopiotiedosto palvelimelta omalle koneellesi tai siirrettävälle tietovälineelle. Muista myös huolehtia varmuuskopion riittävästä tietoturvasta.', true));
				}
				else
				{
					$this->Session->setFlash(__('Luodun tiedoston oikeuksia ei voitu muuttaa', true));
				}
			*/
				// Kommentoi alla oleva, jos poistat kommentoinnin ylläolevasta
				$this->Session->setFlash(__('Varmuuskopiointi onnistui', true) . '<br>' . __('Viimeistelläksesi varmuuskopioinnin, lataa varmuuskopiotiedosto palvelimelta omalle koneellesi tai siirrettävälle tietovälineelle. Muista myös huolehtia varmuuskopion riittävästä tietoturvasta.', true));
			}
			else
			{
				$this->Session->setFlash(__('Varmuuskopiointi epäonnistui', true) . '<br>' . __('Mysqldump virhekoodi:', true) . ' ' . $retval);
			}
			
			//Ohjataan käyttäjä takaisin varmuuskopioinninaloitussivulle
			$this->redirect(array('controller' => 'authors', 'action' => 'backup'));
		}
		
		//Asetetaan layout -> Navigointi näkyviin
		$this->layout = 'author';
		
		//Asetetaan sivun otsikko
		$this->set('title_for_layout', __(' - Varmuuskopiointi', true));
    }
	
	// Poista varmuuskopio palvelimelta
	public function backup_delete($fileName = null)
    {	
		$file = $path = WWW_ROOT . "backups" . DIRECTORY_SEPARATOR . $fileName;
/*	
//FOR DEBUG
		$this->Session->setFlash(
			"fileName: " . $file . "<br>" .
			"file_exists: " . file_exists($file) . "<br>" .
			"is_file: " . is_file($file) . "<br>" .
			"is_executable: " . is_executable($file) . "<br>" .
			"is_readable: " . is_readable($file) . "<br>" .
			"is_writable: " . is_writable($file) . "<br>" .
			"fileperms: " . fileperms($file)
		);
*/		
		if(is_readable($file))
		{
			if(unlink($file))
			{
				$this->Session->setFlash(__('Varmuuskopion poistaminen onnistui', true));
			}
			else
			{
				$this->Session->setFlash(__('Varmuuskopion poistaminen epäonnistui', true));
			}
		}
		else
		{
			$this->Session->setFlash(__('Tiedostoa ei voitu lukea', true));
		}
		
		//Ohjataan käyttäjä takaisin varmuuskopioinninaloitussivulle
		$this->redirect(array('controller' => 'authors', 'action' => 'backup'));
    }
	
	//  / VARMUUSKOPIOINTI
}