<?php 
class ControllerSubcriberSubcriber extends Controller { 
	private $error = array();
 
	public function index() {
		$this->language->load('subcriber/subcriber');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('subcriber/subcriber');
		 
		$this->getList();
	}

	public function insert() {
		$this->language->load('subcriber/subcriber');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('subcriber/subcriber');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_subcriber_subcriber->addSubcriber($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('subcriber/subcriber', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('subcriber/subcriber');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('subcriber/subcriber');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_subcriber_subcriber->editSubcriber($this->request->get['subcriber_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('subcriber/subcriber', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('subcriber/subcriber');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('subcriber/subcriber');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $subcriber_id) {
				$this->model_subcriber_subcriber->deleteSubcriber($subcriber_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('subcriber/subcriber', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getList();
	}

	public function email() {
		$this->language->load('subcriber/subcriber');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_all_newsletter'] = $this->language->get('text_all_newsletter');

		$this->data['button_send'] = $this->language->get('button_send');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['entry_to'] = $this->language->get('entry_to');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_subject'] = $this->language->get('entry_subject');
		$this->data['entry_message'] = $this->language->get('entry_message');
		
		$this->data['token'] = $this->session->data['token'];

		$this->data['cancel'] = $this->url->link('subcriber/subcriber', 'token=' . $this->session->data['token'], 'SSL');

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('subcriber/subcriber', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->template = 'subcriber/subcriber_email.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
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
			'href'      => $this->url->link('subcriber/subcriber', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->link('subcriber/subcriber/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('subcriber/subcriber/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['subcribers'] = array();
		
		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
				
		$subcriber_total = $this->model_subcriber_subcriber->getTotalSubcribers();
		
		$results = $this->model_subcriber_subcriber->getSubcribers($data);

		foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('subcriber/subcriber/update', 'token=' . $this->session->data['token'] . '&subcriber_id=' . $result['subcriber_id'] . $url, 'SSL')
			);

			$this->data['subcribers'][] = array(
				'subcriber_id' => $result['subcriber_id'],
				'email'        => $result['email'],
				'status'		=> ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'selected'    => isset($this->request->post['selected']) && in_array($result['subcriber_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
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
		$pagination->total = $subcriber_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('subcriber/subcriber', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'subcriber/subcriber_list.tpl';
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
		$this->data['entry_status'] = $this->language->get('entry_status');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	
 		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('subcriber/subcriber', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['subcriber_id'])) {
			$this->data['action'] = $this->url->link('subcriber/subcriber/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('subcriber/subcriber/update', 'token=' . $this->session->data['token'] . '&subcriber_id=' . $this->request->get['subcriber_id'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('subcriber/subcriber', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['subcriber_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$subcriber_info = $this->model_subcriber_subcriber->getSubcriber($this->request->get['subcriber_id']);
    	}
		
		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (!empty($subcriber_info)) {
			$this->data['email'] = $subcriber_info['email'];
		} else {
			$this->data['email'] = '';
		}
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($subcriber_info)) {
			$this->data['status'] = $subcriber_info['status'];
		} else {
			$this->data['status'] = 1;
		}
						
		$this->template = 'subcriber/subcriber_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'subcriber/subcriber')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if ((utf8_strlen($this->request->post['email']) < 2) || (utf8_strlen($this->request->post['email']) > 255)) {
			$this->error['email'] = $this->language->get('error_email');
		}elseif (preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'subcriber/subcriber')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
		
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_email'])) {
			$this->load->model('subcriber/subcriber');
			
			if (isset($this->request->get['filter_email'])) {
				$filter_email = $this->request->get['filter_email'];
			} else {
				$filter_email = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_email'  => $filter_email,
				'start'        => 0,
				'limit'        => $limit
			);
			
			$results = $this->model_subcriber_subcriber->getSubcribers($data);
			
			foreach ($results as $result) {
				$json[] = array(
					'subcriber_id' => $result['subcriber_id'],
					'email'       => strip_tags(html_entity_decode($result['email'], ENT_QUOTES, 'UTF-8')),	
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	public function getSubcribers() {
		$json = array();
		
		$this->load->model('subcriber/subcriber');	
						
		$data = array(
			'filter_status'  => 1,
		);
			
		$results = $this->model_subcriber_subcriber->getAllSubcribers($data);
			
		foreach ($results as $result) {
			$json[] = array(
				'subcriber_id' => $result['subcriber_id'],
				'email'       => strip_tags(html_entity_decode($result['email'], ENT_QUOTES, 'UTF-8')),	
			);	
		}

		$this->response->setOutput(json_encode($json));
	}

	public function send() {
		$mail_protocol 	= $this->config->get('config_mail_protocol');
		$mail_parameter = $this->config->get('config_mail_parameter');
		$mail_hostname 	= $this->config->get('config_smtp_host');
		$mail_username 	= $this->config->get('config_smtp_username');
		$mail_password 	= $this->config->get('config_smtp_password');
		$mail_port 		= $this->config->get('config_smtp_port');
		$mail_timeout 	= $this->config->get('config_smtp_timeout');	
		$mail_from 		= $this->config->get('config_email');
		$mail_sender 	= $this->language->get('config_name');

		$this->language->load('subcriber/subcriber');
		
		$json = array();
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', 'subcriber/subcriber')) {
				$json['error']['warning'] = $this->language->get('error_permission');
			}
					
			if (!$this->request->post['subject']) {
				$json['error']['subject'] = $this->language->get('error_subject');
			}
	
			if (!$this->request->post['message']) {
				$json['error']['message'] = $this->language->get('error_message');
			}
			
			if (!$json) {
				$this->load->model('subcriber/subcriber');
	
				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
				}
								
				$email_total = 0;
							
				$emails = array();
				
				switch ($this->request->post['to']) {
					case 'all-newsletter':
						/*$subcriber_data = array(
							'status' 			=> 1,
							'start'             => ($page - 1) * 10,
							'limit'             => 10,
						);
						
						$email_total = $this->model_subcriber_subcriber->getTotalSubcribers($subcriber_data);
							
						$results = $this->model_subcriber_subcriber->getSubcribers($subcriber_data);

						foreach ($results as $result) {
							$emails[$result['email']] = $result['email'];
						}*/

						if (!empty($this->request->post['subcriber_email'])) {					
							foreach ($this->request->post['subcriber_email'] as $email) {
								$emails[] = $email;
							}
						}
						break;
					case 'newsletter':
						if (!empty($this->request->post['subcriber_email'])) {					
							foreach ($this->request->post['subcriber_email'] as $email) {
								$emails[] = $email;
							}
						}
						break;	
				}
				
				if ($emails) {
					$start = ($page - 1) * 10;
					$end = $start + 10;
					
					if ($end < $email_total) {
						$json['success'] = sprintf($this->language->get('text_sent'), $start, $email_total);
					} else { 
						$json['success'] = $this->language->get('text_sent_success');
					}				
						
					if ($end < $email_total) {
						$json['next'] = str_replace('&amp;', '&', $this->url->link('subcriber/subcriber/send', 'token=' . $this->session->data['token'] . '&page=' . ($page + 1), 'SSL'));
					} else {
						$json['next'] = '';
					}
										
					$message  = '<html dir="ltr" lang="en">' . "\n";
					$message .= '  <head>' . "\n";
					$message .= '    <title>' . $this->request->post['subject'] . '</title>' . "\n";
					$message .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
					$message .= '  </head>' . "\n";
					$message .= '  <body>' . html_entity_decode($this->request->post['message'], ENT_QUOTES, 'UTF-8') . '</body>' . "\n";
					$message .= '</html>' . "\n";
					
					foreach ($emails as $email) {
						$mail = new Mail();	
						$mail->protocol = $mail_protocol;
						$mail->parameter = $mail_parameter;
						$mail->hostname = $mail_hostname;
						$mail->username = $mail_username;
						$mail->password = $mail_password;
						$mail->port = $mail_port;
						$mail->timeout = $mail_timeout;				
						$mail->setTo($email);
						$mail->setFrom($mail_from);
						$mail->setSender($mail_sender);
						$mail->setSubject(html_entity_decode($this->request->post['subject'], ENT_QUOTES, 'UTF-8'));					
						$mail->setHtml($message);
						$mail->send();
					}
				}
			}
		}
		
		$this->response->setOutput(json_encode($json));	
	}
}
?>