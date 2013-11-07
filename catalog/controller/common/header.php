<?php   
class ControllerCommonHeader extends Controller {
	protected function index() {
		$this->data['title'] = $this->document->getTitle();
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
        
        if (isset($this->session->data['error']) && !empty($this->session->data['error'])) {
            $this->data['error'] = $this->session->data['error'];            
            unset($this->session->data['error']);
        } else {
            $this->data['error'] = '';
        }
		$this->data['base'] = $server;
		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();	 
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		$this->data['name'] = $this->config->get('config_name');
		
		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$this->data['icon'] = '';
		}
		
		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}		
		
		$this->language->load('common/header');		
		$this->data['text_home'] = $this->language->get('text_home');				
		$this->data['home'] = $this->url->link('common/home');
		$this->data['faq'] = $this->url->link('information/faq');
		$this->data['contactus'] = $this->url->link('information/contact');
		$this->data['pcontact'] = $this->url->link('information/pcontact');
		$this->data['news_list'] = $this->url->link('news/list');
		$this->data['news_detail'] = $this->url->link('news/detail');

		// menu render
		$this->load->model('news/news_category');
		$this->load->model('news/news');
		$news_categories = $this->model_news_news_category->getNewsCategories(array(
			'start' => 0,
			'limit' => 5,
			'filter_parent_id' => 0,
			'status' => 1,
			));

		$this->data['menu'] = array();
		foreach ($news_categories as $inc => $news_category) {
			if ($inc == 3) {
				$this->data['menu'][] = array(
					'href' => $this->url->link('program/program', ''),
					'label' => $this->language->get('text_program'),
					'popup' => '0',
					'childs' => array(),
					);
			}

			if ($inc == 4) {
				$this->data['menu'][] = array(
					'href' => $this->url->link('event/event', ''),
					'label' => $this->language->get('text_event'),
					'popup' => '1',
					'childs' => array(),
					);
			}

			$child_categories = $this->model_news_news_category->getNewsCategories(array(
				'start' => 0,
				'limit' => 5,
				'filter_parent_id' => $news_category['news_category_id'],
				'status' => 1,
				));

			$childs = array();
			if (empty($child_categories)) {
				$newses = $this->model_news_news->getNewses(array(
					'start' => 0,
					'limit' => 5,
					'sort'	=> 'n.sort_order',
					'filter_news_category_id' => $news_category['news_category_id'],
					'status' => 1,
					));

				if (!empty($news)) {
					foreach ($newses as $news) {
						$childs[] = array(
							'href' => $this->url->link('news/news', 'news_id=' . $news['news_id']),
							'label' => $news['title'],
							'popup' => '1',
							);
					}
				}
			}else {
				foreach ($child_categories as $key => $child_category) {
					$childs[] = array(
						'href' => $this->url->link('news/news_category', 'news_category_id=' . $child_category['news_category_id']),
						'label' => $child_category['name'],
						'popup' => '0',
						);
				}
			}
			
			$this->data['menu'][] = array(
				'href' => $this->url->link('news/news_category', 'news_category_id=' . $news_category['news_category_id']),
				'label' => $news_category['name'],
				'popup' => '0',
				'childs' => $childs,
				);
		}

		$this->data['menu'][] = array(
			'href' => $this->url->link('faq/faq', ''),
			'label' => $this->language->get('text_faq'),
			'popup' => '1',
			'childs' => array(),
			);

		$contact_childs = array();
		$contact_childs[] = array(
			'href' => '#',
			'label' => $this->language->get('text_contact_inf'),
			'popup' => '1',
			'childs' => array(),
			);
		$contact_childs[] = array(
			'href' => '#',
			'label' => $this->language->get('text_send_email'),
			'popup' => '1',
			'childs' => array(),
			);
		$contact_childs[] = array(
			'href' => '#',
			'label' => $this->language->get('text_support_onl'),
			'popup' => '1',
			'childs' => array(),
			);
		$this->data['menu'][] = array(
			'href' => '#',
			'label' => $this->language->get('text_contact'),
			'popup' => '0',
			'childs' => $contact_childs,
			);
		
		// Daniel's robot detector
		$status = true;		
		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", trim($this->config->get('config_robots')));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;
					break;
				}
			}
		}
		
		$this->children = array(
			'module/language'
		);
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/header.tpl';
		} else {
			$this->template = 'default/template/common/header.tpl';
		}
		
    	$this->render();
	} 	
}
?>
