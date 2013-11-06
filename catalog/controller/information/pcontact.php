<?php  
class ControllerInformationPcontact extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));		
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$this->data['categoryImgUrl'] = $server . 'image/data/category';
		$this->data['contactus'] = $this->url->link('information/contact');
		$this->language->load('information/pcontact');
		$this->data["heading_title"] = $this->language->get('text_heading');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/pcontact.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/pcontact.tpl';
		} else {
			$this->template = 'default/template/information/pcontact.tpl';
		}
		
		$this->children = array(
			'common/footer',
			'common/header'
		);
										
		$this->response->setOutput($this->render());
	}
}
?>