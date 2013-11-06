<?php 
class ControllerNewsList extends Controller {
	public function index() {  

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$this->language->load('news/list');
		$this->data['base'] = $server;
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');

    	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/news/list.tpl';
		} else {
			$this->template = 'default/template/news/list.tpl';
		}
					
  		$this->response->setOutput($this->render());
  	}	
}
?>