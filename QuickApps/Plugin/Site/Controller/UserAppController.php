<?php
/**
 * UserApp Controller
 *
 * PHP version 5
 *
 * @package	 QuickApps.Plugin.UserApp.Controller
 * @version	 1.0
 * @author	 Pronexo by DevTeam manber Jingle
 * @link	 
 */
class UserAppController extends AppController {
	public $name = 'UserApp';
	public $uses = array('User.User');
	public $components = array('User.Mailer');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->QuickApps->disableSecurity();
	}

	public function admin_index() {
		if (isset($this->data['User']['update'])) {
			if (isset($this->data['Items']['id'])) {
				$update = ($this->data['User']['update'] != 'delete');

				foreach ($this->data['Items']['id'] as $key => $id) {
					if ($id === 1) {
						continue; // admin protected
					}

					if ($update) {
						// update User
						switch ($this->data['User']['update']) {
							case 'block':
								$this->requestAction('/admin/site/userApp/list/block/' . $id);
							break;

							case 'unblock':
								$this->requestAction('/admin/site/userApp/list/activate/' . $id);
							break;
						}
					} else {
						// delete User
						$this->requestAction('/admin/site/userApp/delete/' . $id);
					}
				}
			}

			$this->redirect($this->referer());
		}

		$paginationScope = array();
	
		
		
		if (isset($this->data['User']['filter']) || $this->Session->check('User.filter')) {
			if (isset($this->data['User']['filter']) && empty($this->data['User']['filter'])) {
				$this->Session->delete('User.filter');
			} else {
				$filter = isset($this->data['User']['filter']) ? $this->data['User']['filter'] : $this->Session->read('User.filter');

				foreach ($filter as $field => $value) {
					if ($value !== '') {
						$paginationScope[str_replace('|', '.', $field)] = strpos($field, 'LIKE') !== false ? "%{$value}%" : $value;
					}
				}

				$this->Session->write('User.filter', $filter);
			}
		}
		
		
		$results = $this->paginate('User', $paginationScope);
		
		foreach($results as $ind => $result):
			
			if($result['Role'][0]['id'] != 6 ):
			
				unset($results[$ind]);
			
			endif;
		
		endforeach;
		$this->set('results', $results);
		$this->setCrumb('/admin/site/userApp/');
		$this->title(__t('Users'));
	}

	public function admin_delete($id) {
		$del = false;

		if ($id != 1) {
			$user = $this->User->findById($id) or $this->redirect($this->referer());
			$notify = $this->Variable->findByName('user_mail_canceled_notify');
			$del = $this->User->delete($id);

			if ($del && $notify) {
				$this->Mailer->send($user, 'canceled');
			}
		}

		if (isset($this->request->params['requested'])) {
			return $del;
		} else {
			$this->redirect($this->referer());
		}
	}

	public function admin_block($id) {
		$data = array();
		$data = array(
			'User' => array(
				'status' => 0,
				'id' => $id
			)
		);

		$save = $this->User->save($data, false);
		$notify = $this->Variable->findByName('user_mail_blocked_notify');

		if ($save && $notify) {
			$this->Mailer->send($this->User->id, 'blocked');
		}

		return $save;
	}

	public function admin_activate($id) {
		$data = array();
		$data = array(
			'User' => array(
				'status' => 1,
				'id' => $id
			)
		);

		$save = $this->User->save($data, false);
		$notify = $this->Variable->findByName('user_mail_activation_notify');

		if ($save && $notify) {
			$this->Mailer->send($this->User->id, 'activation');
		}

		return $save;
	}

	public function admin_add() {
		$this->__setLangs();

		if (isset($this->data['User'])) {
			if ($this->User->save($this->data)) {
				$this->Mailer->send($this->User->id, 'welcome');
				$this->flashMsg(__t('User has been saved'), 'success');
				$this->redirect('/admin/site/userApp');
			} else {
				$this->flashMsg(__t('User could not be saved. Please, try again.'), 'error');
			}
		}

		$this->set('fields', $this->User->fieldInstances());
		
		$this->title(__t('Add User'));
		$this->setCrumb(
			'/admin/site/userApp/',
			array(__t('Add new user'))
		);
	}

	public function admin_edit($id) {
		$user = $this->User->findById($id) or $this->redirect('/admin/site/userApp');

		if (isset($this->data['User']['id']) && $this->data['User']['id'] == $id) {
			if ($this->User->save($this->data)) {

				/*****************/
				/* Email sending */
				/*****************/
				// Send "activated" mail
				if ($user['User']['status'] == 0 && $this->data['User']['status'] == 1) {
					$notify = $this->Variable->findByName('user_mail_activation_notify');

					if ($notify['Variable']['value']) {
						$this->Mailer->send($id, 'activation');
					}
				}

				// Send "blocked" mail
				if ($user['User']['status'] == 1 && $this->data['User']['status'] == 0) {
					$notify = $this->Variable->findByName('user_mail_blocked_notify_notify');

					if ($notify['Variable']['value']) {
						$this->Mailer->send($id, 'blocked');
					}
				}

				$this->flashMsg(__t('User has been saved'), 'success');
				$this->redirect($this->referer());
			} else {
				$this->flashMsg(__t('User could not be saved. Please, try again.'), 'error');
			}
		}

		unset($user['User']['password']);

		$this->data = $user;

		$this->__setLangs();
		
		$this->title(__t('Editing User'));
		$this->setCrumb(
			'/admin/site/userApp/',
			array(__t('Editing user'))
		);
	}

	private function __setLangs() {
		$languages = array();

		foreach (Configure::read('Variable.languages') as $l) {
			$languages[$l['Language']['code']] = $l['Language']['native'];
		}

		$this->set('languages', $languages);
	}
}
