<?php  
class ControllerCommonFooter extends Controller {
	static $count = 0;

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

		//Contact information:
		$this->data['text_company_name'] = $this->language->get('text_company_name');
		$this->data['text_company_main_location'] = $this->language->get('text_company_main_location');
		$this->data['text_company_main_address'] = $this->language->get('text_company_main_address');
		$this->data['text_company_main_fone'] = $this->language->get('text_company_main_fone');
		$this->data['text_company_main_fax'] = $this->language->get('text_company_main_fax');
		$this->data['text_company_main_email'] = $this->language->get('text_company_main_email');
		$this->data['text_company_main_website'] = $this->language->get('text_company_main_website');
		$this->data['text_company_behalf_location'] = $this->language->get('text_company_behalf_location');
		$this->data['text_company_behalf_address'] = $this->language->get('text_company_behalf_address');
		$this->data['text_company_behalf_fone'] = $this->language->get('text_company_behalf_fone');
		$this->data['text_company_behalf_fax'] = $this->language->get('text_company_behalf_fax');
		$this->data['text_company_behalf_email'] = $this->language->get('text_company_behalf_email');
		$this->data['text_company_behalf_website'] = $this->language->get('text_company_behalf_website');
		$this->data['text_company_behalf_fanpage'] = $this->language->get('text_company_behalf_fanpage');

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

		$this->data['text_sitemap'] = 'Sơ đồ Website';
		$this->data['sitemap']['items'] = $this->getSitemap(0, 1, 3);

		// faqs
		$this->data['sitemap']['items'][] = array(
			'href' => $this->url->link('faq/faq'),
			'text' => $this->language->get('text_faq'),
			'class' => 'link-popup iframe',
			);

		// contact
		$contact_childs = array();
		$contact_childs[] = array(
			'href' => '#contact-address',
			'text' => $this->language->get('text_contact_inf'),
			'class' => 'link-popup contact',
			);
		$contact_childs[] = array(
			'href' => $this->url->link('contact/contact/email'),
			'text' => $this->language->get('text_send_email'),
			'class' => 'link-popup iframe',
			);
		$contact_childs[] = array(
			'href' => '#contact-online-support',
			'text' => $this->language->get('text_support_onl'),
			'class' => 'link-popup inline',
			);
		$this->data['sitemap']['items'][] = array(
			'href' => $this->url->link('contact/contact'),
			'text' => $this->language->get('text_contact'),
			'class' => '',
			'items' => $contact_childs,
			);

		$this->data['count'] = $this->count + 4;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		}
		
		$this->render();
	}

	private function getSitemap($news_category_id, $current_lv, $max_lv) {
		$this->load->model('news/news_category');
		$this->load->model('news/news');

		$categories = $this->model_news_news_category->getNewsCategories(array(
			'start' => 0,
			'limit' => 999,
			'filter_parent_id' => $news_category_id,
			'status' => 1,
			));

		$result = array();
		if ($categories) {
			foreach ($categories as $category) {
				if ($current_lv < $max_lv) {
					$current_lv++;
					$childs = $this->getSitemap($category['news_category_id'], $current_lv, $max_lv);
				
					$result[] = array(
						'href' => (!empty($category['link'])) ? $category['link'] :$this->url->link('news/news_category', 'news_category_id=' . $category['news_category_id']),
						'text' => $category['name'],
						'items' => $childs,
						'class' => ($category['have_popup'])? 'link-popup iframe' : '',
						);
				}else {
					$result[] = array(
						'href' => (!empty($category['link'])) ? $category['link'] :$this->url->link('news/news_category', 'news_category_id=' . $category['news_category_id']),
						'text' => $category['name'],
						'class' => ($category['have_popup'])? 'link-popup iframe' : '',
						);
				}
			}
		}else {
			$newses = $this->model_news_news->getNewses(array(
				'start' => 0,
				'limit' => 999,
				'sort'	=> 'n.sort_order',
				'filter_news_category_id' => $news_category_id,
				'status' => 1,
				));
			if ($newses) {
				foreach ($newses as $news) {
					$result[] = array(
					'href' => $this->url->link('news/news', 'news_id=' . $news['news_id']),
					'text' => $news['title'],
					'class' => 'link-popup iframe',
					);
				}
			}
		}

		$this->count += count($result);
		return $result;
	}
}
?>