<?php  
class ControllerCommonFooter extends Controller {
	protected function index() {
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$this->data['urlImg'] = $server.'image/data/';
		$this->data['base'] = $server;
		$this->language->load('common/footer');	
		$this->language->load('common/header');		

		$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_ok'] = $this->language->get('text_ok');
		$this->data['text_enter_email'] = $this->language->get('text_enter_email');
		$this->data['text_invalid_email'] = $this->language->get('text_invalid_email');
		$this->data['text_success'] = $this->language->get('text_success');
		$this->data['text_copyright'] = $this->language->get('text_copyright');
		$this->data['text_contact_inf'] = $this->language->get('text_contact_inf');
		$this->data['text_send_email'] = $this->language->get('text_send_email');
		$this->data['text_support_onl'] = $this->language->get('text_support_onl');

		$this->data['lang_url'] = $this->url->link('module/language');
		$this->data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));
		$this->data['subcriber'] = $this->url->link('subcriber/subcriber');

		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
			
			unset($this->request->get['route']);
			unset($this->request->get['_route_']);
			
			$url = '';
						
			if ($this->request->get) {
				$url .= http_build_query($this->request->get);
			}
			
			$this->data['redirect'] = $this->url->link($route, $url);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		}
		
		$this->render();
	}
}
?>