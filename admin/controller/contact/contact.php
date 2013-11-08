<?php 
class ControllerContactContact extends Controller { 
	private $error = array();
 
	public function index() {
		$this->language->load('contact/contact');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('contact/contact');
		 
		$this->getList();
	}

	public function view() {
		$this->language->load('contact/contact');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('contact/contact');
		 
		$this->getForm();
	}

	public function delete() {
		$this->language->load('contact/contact');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('contact/contact');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $contact_id) {
				$this->model_contact_contact->deleteContact($contact_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('contact/contact', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getList();
	}
	
	protected function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
						
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('contact/contact', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['delete'] = $this->url->link('contact/contact/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['contacts'] = array();
		
		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
				
		$contact_total = $this->model_contact_contact->getTotalContacts();
		
		$results = $this->model_contact_contact->getContacts($data);

		foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('contact/contact/view', 'token=' . $this->session->data['token'] . '&contact_id=' . $result['contact_id'] . $url, 'SSL')
			);

			$this->data['contacts'][] = array(
				'contact_id' => $result['contact_id'],
				'email'        => $result['email'],
				'name'        => $result['name'],
				'status'		=> ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'selected'    => isset($this->request->post['selected']) && in_array($result['contact_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$pagination = new Pagination();
		$pagination->total = $contact_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('contact/contact', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'contact/contact_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
	
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
				
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_phone'] = $this->language->get('entry_phone');
		$this->data['entry_content'] = $this->language->get('entry_content');
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_date_posted'] = $this->language->get('entry_date_posted');
		$this->data['entry_status'] = $this->language->get('entry_status');
		
		$this->data['button_cancel'] = $this->language->get('button_cancel');

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('contact/contact', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['cancel'] = $this->url->link('contact/contact', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['contact_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$contact_info = $this->model_contact_contact->getContact($this->request->get['contact_id']);
    	}

    	if (empty($contact_info)) {
    		$this->session->data['error_warning'] = $this->language->get('error_not_found');
    		$this->forward($this->data['cancel']);
    	}
		
		$this->data['token'] = $this->session->data['token'];

		$this->data['email'] = $contact_info['email'];
		$this->data['name'] = $contact_info['name'];
		$this->data['content'] = $contact_info['content'];
		$this->data['phone'] = $contact_info['phone'];
		$this->data['date_posted'] = $contact_info['date_posted'];
		$this->data['status'] = $contact_info['status'];
						
		$this->template = 'contact/contact_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'contact/contact')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}
?>