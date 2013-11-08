<?php  
class ControllerCommonFooter extends Controller {
	protected function index() {
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$this->data['urlImg'] = $server.'image/data/';
		$this->language->load('common/footer');		

		$this->data['text_sitemap'] = $this->language->get('text_sitemap');
		$this->data['text_newsletter'] = 'Đăng ký email nhận tin tức mới';//$this->language->get('text_newsletter');
		$this->data['text_ok'] = 'OK';//$this->language->get('text_ok');
		$this->data['text_enter_email'] = 'Nhập email đăng ký';//$this->language->get('text_enter_email');
		$this->data['text_invalid_email'] = 'Email không hợp lệ !';//$this->language->get('text_invalid_email');
		$this->data['text_copyright'] = 'Copyright 2013 - Tư Vấn Du Học Song Nguyễn. All rights reserved<br>Designed by <strong style="color: #000;">BommerDesign Team </strong>';// $this->language->get('text_copyright');

		$this->data['lang_url'] = $this->url->link('module/language');
		$this->data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));
		$this->data['subcriber'] = $this->url->link('subcriber/subcriber');

		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
			
			unset($this->request->get['route']);
			
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