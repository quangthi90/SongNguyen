<?php
class ControllerFaqFaq extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');

		$this->data['text_faq'] = $this->language->get('text_faq');
		$this->data['text_title'] = $this->language->get('text_faq');
				
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$this->load->model('faq/faq');
		$this->load->model('faq/faq_category');
		$this->language->load('information/faq');
		$this->data['base'] = $server;
		$this->data['lang'] = $this->language->get('code');
		$this->data['direction'] = $this->language->get('direction');
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');

		$this->load->model('faq/faq');
		$faq_categories_data = $this->model_faq_faq_category->getFaqCategories(array(
			'start' => 0,
			'limit' => 999,
			'filter_status' => 1,
			));

		$this->data['faq_categories'] = array();
		$active = false;
		if (!empty($faq_categories_data)) {
			foreach ($faq_categories_data as $category) {
				$faqs_data = $this->model_faq_faq->getFaqs(array(
					'start' => 0,
					'limit' => 999,
					'filter_status' => 1,
					'filter_faq_category_id' => $category['faq_category_id'],
					));

				$faqs = array();
				if (!empty($faqs_data)) {
					$this->data['faqs'][$category['faq_category_id']] = array();
					foreach ($faqs_data as $faq) {
						$faqs[] = array(
							'question' => $faq['question'],
							'answer' => $faq['answer'],
							);
					}
				}

				if (!$active) {
					$this->data['faq_categories'][] = array(
						'name' => $category['name'],
						'faq_category_id' => $category['faq_category_id'],
						'faqs' => $faqs,
						'active' => 1,
						);
					$active = true;
				}else {
					$this->data['faq_categories'][] = array(
						'name' => $category['name'],
						'faq_category_id' => $category['faq_category_id'],
						'faqs' => $faqs,
						'active' => 0,
						);
				}
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/faq/faq.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/faq/faq.tpl';
		} else {
			$this->template = 'default/template/faq/faq.tpl';
		}

		$this->children = array(
			'common/footer',
			'common/header'
		);
										
		$this->response->setOutput($this->render());
	}
}
?>