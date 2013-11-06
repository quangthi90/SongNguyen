<?php  
class ControllerCommonWelcome extends Controller {
	public function index() {
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$this->data['base'] = $server;
		$this->data['home'] = $this->url->link('common/home');
		$this->data['lang_url'] = $this->url->link('module/language');
		$this->data['description'] = $this->config->get('config_meta_description');
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		
		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$this->data['icon'] = '';
		}		
		if (file_exists(DIR_IMAGE . 'flash/intro.swf')) {
			$this->data['flash'] = $server . 'image/flash/intro.swf';
		} else {
			$this->data['flash'] = '';
		}		
		
		$this->language->load('common/welcome');
		$this->data['title'] = $this->language->get('text_welcome_title');
		$this->data['language_vn'] = $this->language->get('text_vietnam');
		$this->data['language_eng'] = $this->language->get('text_english');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/welcome.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/welcome.tpl';
		} else {
			$this->template = 'default/template/common/welcome.tpl';
		}

		$this->children = array(
			'common/footer'
		);
										
		$this->response->setOutput($this->render());
	}
}
?>