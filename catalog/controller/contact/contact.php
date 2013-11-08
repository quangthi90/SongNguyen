<?php
class ControllerContactContact extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->language->load('common/header');	

		$this->data['heading_title'] = $this->config->get('config_title');

		$this->data['title'] = $this->config->get('text_contact_inf');
				
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$this->data['items'][] = array(
			'name' => $this->language->get('text_send_email'),
			'image' => $server . 'image/data/category/banner-formemail.jpg',
			'href' => $this->url->link('contact/contact/email'),
			'class' => 'link-popup iframe',
			);
		$this->data['items'][] = array(
			'name' => $this->language->get('text_contact_inf'),
			'image' => $server . 'image/data/category/banner-thongtinlienhe.jpg',
			'href' => '#contact-address',
			'class' => 'link-popup contact',
			);
		$this->data['items'][] = array(
			'name' => $this->language->get('text_support_onl'),
			'image' => $server . 'image/data/category/banner-hotrotructuyen.jpg',
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
		
	}
}
?>