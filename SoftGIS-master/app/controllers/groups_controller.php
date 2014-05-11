<?php

class GroupsController extends AppController
{
	var $name = 'Groups';
	//  KÄYTTÄJÄHALLINTA

	//Ryhmälistaus
    public function index()
    {
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			$this->Group->recursive = 0;
			$this->set('groups', $this->paginate());
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Ryhmälista', true));
		}
    }


	//Sivutusryhmälistalle
	var $paginate = array(
        'limit' => 25,
    );
	
	//Uuden käyttäjän lisääminen käyttäjähallinnan kautta
	function add() {
		
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			if (!empty($this->data)) {
				$this->Group->create();
				if ($this->Group->save($this->data)) {
					$this->Session->setFlash(__('Uusi ryhmä lisätty', true));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('Uutta ryhmää ei voitu lisätä. Ole hyvä ja yritä uudestaan.', true));
				}
			}
			//$groups = $this->User->Group->find('list');
			//$this->set(compact('groups'));
			
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Lisää uusi ryhmä', true));
		}
	}
	
	//Käyttäjän muokkaaminen
	function edit($id = null) {
	
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Ryhmää ei löydy', true));
				$this->redirect(array('action' => 'index'));
			}
			if (!empty($this->data)) {
			
				// Id of authorized editor
				$editorId = $this->Auth->user('id');
				
				//Authorized user's password
				$AuthorizedPassword =  $this->Group->query("SELECT authors.password FROM authors WHERE authors.id=$editorId;");
				$AuthorizedPassword = $AuthorizedPassword['0']['authors']['password'];
			
				//Confirm password
				$confirmPassword = $this->Auth->password($this->data['Group']['confirmPassword']);
		
				// IF Authorized user's password == Confirm password
				if(strcmp($AuthorizedPassword, $confirmPassword)==0)
				{
			
					if ($this->Group->save($this->data)) {
						$this->Session->setFlash(__('Ryhmään tehdyt muutokset on tallennettu', true));
						$this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash(__('Muutoksia ei voitu tallentaa. Ryhmän nimi on jo käytössä.', true));
						$this->data['Group']['confirmPassword'] = '';
						$this->redirect(array('action' => 'edit', $id));
					}
				}
				else
				{
					//$this->data['confirmPassword'] = '';
					//$this->set('passwordWrong', true);
					//$this->Session->setFlash(__('Virheellinen salasana. Muutoksia ei tallennettu', true));
					//$this->redirect(array('action' => 'username', $id));
					
					$this->Session->setFlash(__('Virheellinen salasana.', true));
					$this->redirect(array('action' => 'edit', $id));
					
					//Tyhjennetään salasanakentät
					//$this->data['Author']['password']="";
					//$this->data['Author']['passwordRetyped']="";
					$this->data['Group']['confirmPassword'] = '';
				}
			}
			if (empty($this->data)) {
				$this->data = $this->Group->read(null, $id);
			}		
			
			//Asetetaan layout -> Navigointi näkyviin
			$this->layout = 'author';
			
			//Asetetaan sivun otsikko
			$this->set('title_for_layout', __(' - Muokkaa ryhmää', true));
		}
	}

	//Ryhmän poistaminen
	function delete($id = null) {
	
		if(($this->Auth->user('group_id'))!=1)
		{
			$this->Session->setFlash(__('Sinulla ei ole oikeutta käyttäjien hallintaan.', true));
			 $this->redirect(array('controller' => 'polls', 'action' => 'index'));
		}
		else
		{
			if (!$id) {
				$this->Session->setFlash(__('Ryhmää ei löytynyt.', true));
				$this->redirect(array('action'=>'index'));
			}
			if ($this->Group->delete($id)) {
				$this->Session->setFlash(__('Ryhmä poistettu.', true));
				$this->redirect(array('action'=>'index'));
			}
			$this->Session->setFlash(__('Ryhmää ei voitu poistaa.', true));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	
	//   / KÄYTTÄJÄHALLINTA
	
}