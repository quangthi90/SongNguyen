<?php 
class ControllerNewsNewsCategory extends Controller { 
	private $error = array();
 
	public function index() {
		$this->language->load('news/news_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news_category');
		 
		$this->getList();
	}

	public function insert() {
		$this->language->load('news/news_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news_category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_news_category->addNewsCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('news/news_category', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('news/news_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news_category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_news_category->editNewsCategory($this->request->get['news_category_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('news/news_category', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('news/news_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news_category');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_category_id) {
				$this->model_news_news_category->deleteNewsCategory($news_category_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('news/news_category', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getList();
	}
	
	protected function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
						
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('news/news_category', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->link('news/news_category/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('news/news_category/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['repair'] = $this->url->link('news/news_category/repair', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['news_categories'] = array();
		
		// limit config
		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => 10,//$this->config->get('config_admin_limit')
		);
				
		$news_category_total = $this->model_news_news_category->getTotalNewsCategories();
		
		$results = $this->model_news_news_category->getNewsCategories($data);

		foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('news/news_category/update', 'token=' . $this->session->data['token'] . '&news_category_id=' . $result['news_category_id'] . $url, 'SSL')
			);

			$this->data['news_categories'][] = array(
				'news_category_id' => $result['news_category_id'],
				'name'        => $result['name'],
				'parent_name' => ($result['parent_name']) ? $result['parent_name'] : 'root',
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['news_category_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['column_parent'] = $this->language->get('column_parent');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		// config limit
		$pagination = new Pagination();
		$pagination->total = $news_category_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('news/news_category', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'news/news_category_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
				
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_description'] = $this->language->get('entry_description');
    	$this->data['entry_primary_image'] = $this->language->get('entry_primary_image');
    	$this->data['entry_second_image'] = $this->language->get('entry_second_image');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_parent'] = $this->language->get('entry_parent');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_design'] = $this->language->get('tab_design');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	
 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('news/news_category', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['news_category_id'])) {
			$this->data['action'] = $this->url->link('news/news_category/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('news/news_category/update', 'token=' . $this->session->data['token'] . '&news_category_id=' . $this->request->get['news_category_id'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('news/news_category', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['news_category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$news_category_info = $this->model_news_news_category->getNewsCategory($this->request->get['news_category_id']);
    	}
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['news_category_description'])) {
			$this->data['news_category_description'] = $this->request->post['news_category_description'];
		} elseif (isset($this->request->get['news_category_id'])) {
			$this->data['news_category_description'] = $this->model_news_news_category->getNewsCategoryDescriptions($this->request->get['news_category_id']);
		} else {
			$this->data['news_category_description'] = array();
		}
		
		if (isset($this->request->post['primary_image'])) {
			$this->data['primary_image'] = $this->request->post['primary_image'];
		} elseif (!empty($news_category_info)) {
			$this->data['primary_image'] = $news_category_info['primary_image'];
		} else {
			$this->data['primary_image'] = '';
		}
		
		if (isset($this->request->post['second_image'])) {
			$this->data['second_image'] = $this->request->post['second_image'];
		} elseif (!empty($news_category_info)) {
			$this->data['second_image'] = $news_category_info['second_image'];
		} else {
			$this->data['second_image'] = '';
		}

		$this->load->model('tool/image');
		
		if (isset($this->request->post['primary_image']) && file_exists(DIR_IMAGE . $this->request->post['primary_image'])) {
			$this->data['primary_thumb'] = $this->model_tool_image->resize($this->request->post['primary_image'], 100, 100);
		} elseif (!empty($news_category_info) && $news_category_info['primary_image'] && file_exists(DIR_IMAGE . $news_category_info['primary_image'])) {
			$this->data['primary_thumb'] = $this->model_tool_image->resize($news_category_info['primary_image'], 100, 100);
		} else {
			$this->data['primary_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['second_image']) && file_exists(DIR_IMAGE . $this->request->post['second_image'])) {
			$this->data['second_thumb'] = $this->model_tool_image->resize($this->request->post['second_image'], 100, 100);
		} elseif (!empty($news_category_info) && $news_category_info['second_image'] && file_exists(DIR_IMAGE . $news_category_info['second_image'])) {
			$this->data['second_thumb'] = $this->model_tool_image->resize($news_category_info['second_image'], 100, 100);
		} else {
			$this->data['second_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		$this->data['path'] = '';
		if (isset($this->request->post['path'])) {
			$this->data['path'] = $this->request->post['path'];
		} elseif (!empty($news_category_info)) {
			$parent_descripntions = $this->model_news_news_category->getNewsCategoryDescriptions($news_category_info['parent_id']);
			if (!empty($parent_descripntions[$this->config->get('config_language_id')]['name'])) {
				$this->data['path'] = $parent_descripntions[$this->config->get('config_language_id')]['name'];
			}
		}
		
		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($news_category_info)) {
			$this->data['parent_id'] = $news_category_info['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}
				
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($news_category_info)) {
			$this->data['sort_order'] = $news_category_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}
				
    	if (isset($this->request->post['keyword'])) {
      		$this->data['keyword'] = $this->request->post['keyword'];
    	} elseif (!empty($news_category_info)) {
			$this->data['keyword'] = $news_category_info['keyword'];
		} else {
      		$this->data['keyword'] = '';
    	}
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($news_category_info)) {
			$this->data['status'] = $news_category_info['status'];
		} else {
			$this->data['status'] = 1;
		}
						
		$this->template = 'news/news_category_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'news/news_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['news_category_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'news/news_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
		
	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('news/news_category');
			
			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$results = $this->model_news_news_category->getNewsCategories($data);
				
			foreach ($results as $result) {
				$json[] = array(
					'news_category_id' => $result['news_category_id'], 
					'parent_name' => ($result['parent_name']) ? strip_tags(html_entity_decode($result['parent_name'], ENT_QUOTES, 'UTF-8')) : 'root', 
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}		
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}		
}
?>