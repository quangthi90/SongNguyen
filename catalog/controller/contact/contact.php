<?php
class ControllerContactContact extends Controller {
	private $error = array();

	public function index() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->language->load('common/header');	
		$this->data['heading_title'] = $this->language->get('config_title');
		$this->data['title'] = $this->language->get('text_contact');
				
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$this->data['items'][] = array(
			'name' => $this->language->get('text_send_email'),
			'image' => $server . 'image/data/contact/'.$this->language->get('email_form_img'),
			'href' => $this->url->link('contact/contact/email'),
			'class' => 'link-popup iframe',
			);
		$this->data['items'][] = array(
			'name' => $this->language->get('text_contact_inf'),
			'image' => $server . 'image/data/contact/'.$this->language->get('contact_info_img'),
			'href' => '#contact-address',
			'class' => 'link-popup contact',
			);
		$this->data['items'][] = array(
			'name' => $this->language->get('text_support_onl'),
			'image' => $server . 'image/data/contact/'.$this->language->get('online_support_img'),
			'href' => '#contact-online-support',
			'class' => 'link-popup inline',
			);

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contact/contact.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/contact/contact.tpl';
		} else {
			$this->template = 'default/template/contact/contact.tpl';
		}

		$this->children = array(
			'common/footer',
			'common/header'
		);
										
		$this->response->setOutput($this->render());
	}

	public function email() {
		$this->language->load('information/contact');		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$this->data['base'] = $server;
    	$this->data['action'] = $this->url->link('contact/contact/email');
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
	 
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('contact/contact');	
			$this->model_contact_contact->addContact($this->request->post);
			/*$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');				
			$mail->setTo($this->config->get('config_email'));
	  		$mail->setFrom($this->request->post['email']);
	  		$mail->setSender($this->request->post['name']);
	  		$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
	  		$mail->setText(strip_tags(html_entity_decode($this->request->post['enquiry'], ENT_QUOTES, 'UTF-8')));
      		$mail->send();*/
	  		$this->redirect($this->url->link('information/contact/success'));
    	}

      	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_error_enquiry'] = $this->language->get('text_error_enquiry');
    	$this->data['text_error_name'] = $this->language->get('text_error_name');
    	$this->data['text_error_email'] = $this->language->get('text_error_email');
    	$this->data['text_error_phone'] = $this->language->get('text_error_phone');
    	$this->data['text_success_enquiry'] = $this->language->get('text_success_enquiry');
    	$this->data['text_success_name'] = $this->language->get('text_success_name');
    	$this->data['text_success_email'] = $this->language->get('text_success_email');
    	$this->data['text_success_phone'] = $this->language->get('text_success_phone');

    	$this->data['entry_name'] = $this->language->get('entry_name');
    	$this->data['entry_phone'] = $this->language->get('entry_phone');
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_enquiry'] = $this->language->get('entry_enquiry');

		if (isset($this->error['name'])) {
    		$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}
		
		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}		
		
		if (isset($this->error['enquiry'])) {
			$this->data['error_enquiry'] = $this->error['enquiry'];
		} else {
			$this->data['error_enquiry'] = '';
		}		

    	$this->data['button_continue'] = $this->language->get('button_continue');
    
		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['phone'])) {
			$this->data['phone'] = $this->request->post['phone'];
		} else {
			$this->data['phone'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}
		
		if (isset($this->request->post['enquiry'])) {
			$this->data['enquiry'] = $this->request->post['enquiry'];
		} else {
			$this->data['enquiry'] = '';
		}
		

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/contact/email.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/contact/email.tpl';
		} else {
			$this->template = 'default/template/contact/email.tpl';
		}
			
 		$this->response->setOutput($this->render());		
  	}

  	public function success() {
		$this->language->load('information/contact');

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$this->data['base'] = $server;
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');		
    	$this->data['heading_title'] = $this->language->get('heading_title');
    	$this->data['text_message'] = $this->language->get('text_message');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}
 		$this->response->setOutput($this->render()); 
	}
	
  	protected function validate() {
    	if ((utf8_strlen(trim($this->request->post['name'])) < 3) || (utf8_strlen(trim($this->request->post['name'])) > 32)) {
      		$this->error['name'] = $this->language->get('error_name');
    	}

    	if (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', trim($this->request->post['email']))) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if ((utf8_strlen(trim($this->request->post['enquiry'])) < 10) || (utf8_strlen(trim($this->request->post['enquiry'])) > 3000)) {
      		$this->error['enquiry'] = $this->language->get('error_enquiry');
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}  	  
  	}

	public function captcha() {
		$this->load->library('captcha');
		
		$captcha = new Captcha();
		
		$this->session->data['captcha'] = $captcha->getCode();
		
		$captcha->showImage();
	}
}
?>