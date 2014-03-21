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
				if ($this->Group->save($this->data)) {
					$this->Session->setFlash(__('Ryhmään tehdyt muutokset on tallennettu', true));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('Muutosten tallentaminen ei onnistunut. Ole hyvä ja yritä uudestaan.', true));
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