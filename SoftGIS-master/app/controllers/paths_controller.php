<?php

class PathsController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->layout = 'author';
    }

    public function index()
    {
        $this->Path->recursive = 1;
        $paths = $this->Path->findAllByAuthorId($this->Auth->user('id'), array('id','name','modified'), array('id'));
        $this->set('paths', $paths);
        /*$othersPaths = $this->Path->find('all', array(
            'conditions' => array('NOT' => array('Path.author_id' => $this->Auth->user('id'))), 
            'recursive' => -1,
            'fields' => array('id','name'),
            'order' => array('id')
            ));
        $this->set('others_paths', $othersPaths);*/ //Muiden käyttäjien tiedot poistettu käytöstä mahdollisten aineistojen lisenssiongelmien vuoksi
    }

    public function view($id = null)
    {
        if ($id != null) { // read data from db
            $this->Path->recursive = -1;
            $this->Path->id = $id;
            $this->data = $this->Path->read();

            $this->data['Path']['coordinates'] = stripslashes(
                $this->data['Path']['coordinates']
            );

            $this->set('author', $this->Auth->user('id'));
        } else {
            $this->Session->setFlash(__('Aineistoa ei löytynyt', true));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function import()
    {
        if (!empty($this->data)) {
            //save the data to session and reload it at modify
            $this->Session->write('path_temp', $this->data);
            $this->redirect(array('action' => 'edit'));
        }
    }

    public function edit($id = null)
    {
        if (empty($this->data)) { //load data

            if ($this->Session->check('path_temp')) { //if there is saved data in the session read it
                $this->data = $this->Session->read('path_temp');
                $this->Session->delete('path_temp');
            } else if ($id != null) { // read data from db
                $this->Path->recursive = -1;
                $this->Path->id = $id;
                $this->data = $this->Path->read();
                if ($this->data['Path']['author_id'] != $this->Auth->user('id')) { //vain omia aineistoja voi muokata
                    $this->Session->setFlash(__('Voit muokata vain omia aineistoja', true));
                    $this->redirect(array('action' => 'index'));
                }

                $this->data['Path']['coordinates'] = stripslashes(
                    $this->data['Path']['coordinates']
                );
            } else { //create a new data
                //$this->Session->setFlash('Aineistoa ei löytynyt');
                //$this->redirect(array('action' => 'index'));
            }

        } else { //Save data
            if ($id == null) { //create new
                $this->Path->create();
                $this->data['Path']['author_id'] = $this->Auth->user('id');
            } else { //update existing
                $this->data['Path']['id'] = $id;
                $author = $this->Path->find('first', array( 'conditions' => array('Path.id' => $id), 'recursive' => -1, 'fields' => array('author_id')));
                $this->data['Path']['author_id'] = $author['Path']['author_id'];
            }

            $this->data['Path']['coordinates'] = addslashes(
                $this->data['Path']['coordinates']
            );
            $this->data['Path']['modified'] = date('Y-m-d');
            
            //debug($this->data); die;
            if ($this->data['Path']['author_id'] == $this->Auth->user('id') && $this->Path->save($this->data)) {
                $this->Session->setFlash(__('Aineisto tallennettu', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Tallentaminen epäonnistui', true));
                //$this->redirect(array('action' => 'index'));

                $this->data['Path']['coordinates'] = stripslashes(
                    $this->data['Path']['coordinates']
                );
                $errors = $this->Path->validationErrors;
                foreach ($errors as $err) {
                    $this->Session->setFlash($err);
                }
            }
        }
    }

    public function copy($id = null)
    {
        if (!empty($id)) {
            $this->Path->recursive = -1;
            $this->Path->id = $id;
            $this->data = $this->Path->read();
            $this->data['Path']['id'] = null;
            $this->data['Path']['author_id'] = $this->Auth->user('id');
            //debug($this->data); die;

            //save the data to session and reload it at modify
            $this->Session->write('path_temp', $this->data);
            $this->redirect(array('action' => 'edit'));
        } else {
            $this->Session->setFlash(__('Aineistoa ei löytynyt', true));
            $this->redirect(array('action' => 'index'));
        }

    }

    public function delete($id = null)
    {
        if (!empty($id)) {
            $this->Path->id = $id;
            $this->data = $this->Path->find('first', array( 'conditions' => array('Path.id' => $id), 'recursive' => -1, 'fields' => array('author_id')));


            if (empty($this->data) || $this->data['Path']['author_id'] != $this->Auth->user('id')) {
                $this->Session->setFlash(__('Poistaminen ei onnistunut', true));
            } else { //poistetaan
                //debug($this->data); die;

                $this->Path->delete($id, false);

                $this->Session->setFlash(__('Aineisto poistettu', true));
            }
        } else {
            $this->Session->setFlash(__('Aineistoa ei löytynyt', true));
        }

        $this->redirect(array('action' => 'index'));

    }

    public function search()
    {
        if (!empty($this->params['url']['q'])) {
            $q = $this->params['url']['q'];
            $paths = $this->Path->find(
                'list',
                array(
                    'conditions' => array(
                        'Path.name LIKE' => '%' . $q . '%'
                    )
                )
            );
        } else {
            $paths = array();
        }

        $this->set('paths', $paths);
    }


/* SHAPEFILE */

	/*
	// EI KÄYTÖSSÄ
	//		Call to undefined function dbase_open ()
	//		Ei löydetty täysin varmasti kaikissa järjestelmissä toimivaa tapaa dbase -laajennoksen lisäämiseen php:hen
	// 		http://fi1.php.net/manual/en/dbase.installation.php
	
	public function import_shapefile()
    {
		//App::import('Lib', 'ShapeFile');
		App::import('Vendor', 'shapefile');

		
		if(isset($_POST['clicked']))
		{
			$abort = 0;
			
			// the maximum filesize from php.ini
			$ini_max = str_replace('M', '', ini_get('upload_max_filesize'));
			$upload_max = $ini_max * 1024 * 1024;
		
			// an array to hold error messages
			$errorMessages = array();
			
			$uploadErrors = array ( // http://www.php.net/manual/en/features.file-upload.errors.php
				'1' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
				'2' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
				'3' => 'The uploaded file was only partially uploaded.',
				'4' => 'No file was uploaded.',
				'6' => 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.',
				'7' => 'Failed to write file to disk. Introduced in PHP 5.1.0.',
				'8' => 'Unknown error.'
			
			);
		
			for($k=0; $k< count($_FILES['file']['error']); $k++)
			{
				if($_FILES['file']['error'][$k]!=0)
				{
					$errorMessages[] = $_FILES['file']['name'][$k] . ": " . $uploadErrors[$_FILES['file']['error'][$k]];
					
					$abort = 1; // Virheitä löytyi -> ei ladata tiedostoja palvelimelle
				}
				elseif($_FILES['file']['size'][$k] > $upload_max)
				{
					$errorMessages[] = $_FILES['file']['name'][$k] . ": File size exceeds php.ini size limit";
					
					$abort = 1; // Virheitä löytyi -> ei ladata tiedostoja palvelimelle
				}
			}
			
			if($abort) // Jos virheitä löytyi, näytetään virheviestit
			{
				$printableMessage = "";
				
				foreach($errorMessages as $errorMessage)
				{
					$printableMessage = $printableMessage . $errorMessage . "<br>";
				}
				
				$this->Session->setFlash($printableMessage);
			}
			else // Jos kaikki ok, jatketaan hommaa
			{				
				//debug($_FILES);
				
			//	Example of array structure
			//	$_FILES
			//	(
			//		[file] => Array
			//		(
			//			[name] => Array
			//			(
			//				[0] => world_countries_boundary_file_world_2002.dbf
			//				[1] => world_countries_boundary_file_world_2002.shp
			//			)
			//
			//			[type] => Array
			//			(
			//				[0] => application/octet-stream
			//				[1] => application/octet-stream
			//			)
			//
			//			[tmp_name] => Array
			//			(
			//				[0] => C:\wamp\tmp\php2F.tmp
			//				[1] => C:\wamp\tmp\php30.tmp
			//			)
			//
			//			[error] => Array
			//			(
			//				[0] => 0
			//				[1] => 0
			//			)
			//
			//			[size] => Array
			//			(
			//				[0] => 152452
			//				[1] => 1537592
			//			)
			//		)
			//	)
				
				$uniqFileID = uniqid('shapefile_');
				$upload_dir = WWW_ROOT . "shapefileuploads\\";
			
				for($i=0; $i< count($_FILES['file']['name']); $i++)
				{
					$fileExt = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
					
					if(strcmp($fileExt, "shp")==0)
					{
						$indexFile = $_FILES['file']['name'][$i];
					}
					
					$uniqFilename = $uniqFileID . "." . $fileExt;
				
			//		echo ($fileExt);
			//		echo("<br>");
			//		echo($_FILES['file']['name'][$i]);
			//		echo("<br>");
			//		echo($_FILES['file']['tmp_name'][$i]);
			//		echo("<br>");
			//		echo($_FILES['file']['size'][$i] . " / " . $upload_max);
			//		echo("<br>");
			//		echo ("Filename: " . $uniqFilename);
			//		echo("<br>");
			//		echo ("Upload dir: " . $upload_dir);
			//		echo("<br>");
			//		echo("<br>");
				
				
				
					// copy the file to the specified dir 
					if(copy($_FILES['file']['tmp_name'][$i], $upload_dir . $_FILES['file']['name'][$i]))
					{
						//echo ("Tiedosto kopioitu: " . $upload_dir . $uniqFilename);
					}
					else
					{
						//echo ("Tiedostoa ei kopioitu");
					}
					//echo("<br>");
					//echo("<br>");
					//echo("<br>");
				}
				
				$shp = new ShapeFile($upload_dir . $indexFile, array('noparts' => false)); // along this file the class will use file.shx and file.dbf

				debug($shp);
				
				$j = 0;
				while ($record = $shp->getNext() and $j<5) {
					$dbf_data = $record->getDbfData();
					$shp_data = $record->getShpData();
					//Dump the information
					var_dump($dbf_data);
					var_dump($shp_data);
					$j++;
				}
				
				
			
				// Let's see all the records:
			//	foreach($shp->records as $record){
			//		 echo "<pre>"; // just to format
			//		 print_r($record->shp_data);   // All the data related to the poligon
			//		 print_r($record->dbf_data);   // The alphanumeric information related to the figure
			//		 echo "</pre>";
			//	}
			
			}
		}
    }
	*/
	
	public function edit_shapefile($id = null)
    {
        if (empty($this->data)) { //load data

            if ($this->Session->check('path_temp')) { //if there is saved data in the session read it
                $this->data = $this->Session->read('path_temp');
                $this->Session->delete('path_temp');
            } else if ($id != null) { // read data from db
                $this->Path->recursive = -1;
                $this->Path->id = $id;
                $this->data = $this->Path->read();
                if ($this->data['Path']['author_id'] != $this->Auth->user('id')) { //vain omia aineistoja voi muokata
                    $this->Session->setFlash(__('Voit muokata vain omia aineistoja', true));
                    $this->redirect(array('action' => 'index'));
                }

                $this->data['Path']['coordinates'] = stripslashes(
                    $this->data['Path']['coordinates']
                );
            } else { //create a new data
                //$this->Session->setFlash('Aineistoa ei löytynyt');
                //$this->redirect(array('action' => 'index'));
            }

        } else { //Save data
            if ($id == null) { //create new
                $this->Path->create();
                $this->data['Path']['author_id'] = $this->Auth->user('id');
            } else { //update existing
                $this->data['Path']['id'] = $id;
                $author = $this->Path->find('first', array( 'conditions' => array('Path.id' => $id), 'recursive' => -1, 'fields' => array('author_id')));
                $this->data['Path']['author_id'] = $author['Path']['author_id'];
            }

            $this->data['Path']['coordinates'] = addslashes(
                $this->data['Path']['coordinates']
            );
            $this->data['Path']['modified'] = date('Y-m-d');
            
            //debug($this->data); die;
            if ($this->data['Path']['author_id'] == $this->Auth->user('id') && $this->Path->save($this->data)) {
                $this->Session->setFlash(__('Aineisto tallennettu', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Tallentaminen epäonnistui', true));
                //$this->redirect(array('action' => 'index'));

                $this->data['Path']['coordinates'] = stripslashes(
                    $this->data['Path']['coordinates']
                );
                $errors = $this->Path->validationErrors;
                foreach ($errors as $err) {
                    $this->Session->setFlash($err);
                }
            }
        }
    }
	
/* /SHAPEFILE */

}