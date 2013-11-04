<?php 
class ControllerNewsNews extends Controller {
	private $error = array(); 
    
  	public function index() {
		$this->language->load('news/news');
    	
		$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('news/news');
		$this->load->model('news/news_category');
		
		$this->getList();
  	}
  
  	public function insert() {
    	$this->language->load('news/news');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('news/news');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_news->addNews($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
			
			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function update() {
    	$this->language->load('news/news');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_news_news->editNews($this->request->get['news_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	$this->language->load('news/news');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('news/news');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$this->model_news_news->deleteNews($news_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_title'])) {
				$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
	
  	protected function getList() {				
		if (isset($this->request->get['filter_title'])) {
			$filter_title = $this->request->get['filter_title'];
		} else {
			$filter_title = null;
		}

		if (isset($this->request->get['filter_news_category_name'])) {
			$filter_news_category_name = $this->request->get['filter_news_category_name'];
		} else {
			$filter_news_category_name = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'n.date_modified';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
						
		$url = '';
						
		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
		}	
						
		if (isset($this->request->get['filter_news_category_name'])) {
			$url .= '&filter_news_category_name=' . urlencode(html_entity_decode($this->request->get['filter_news_category_name'], ENT_QUOTES, 'UTF-8'));
		}	

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
						
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
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
			'href'      => $this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('news/news/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('news/news/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
    	
		$this->data['newses'] = array();

		$data = array(
			'filter_title'	  => $filter_title, 
			'filter_news_category_name'	  => $filter_news_category_name, 
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);
		
		$this->load->model('tool/image');
		
		$news_total = $this->model_news_news->getTotalNewses($data);
			
		$results = $this->model_news_news->getNewses($data);
				    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('news/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $result['news_id'] . $url, 'SSL')
			);
			
			if ($result['primary_image'] && file_exists(DIR_IMAGE . $result['primary_image'])) {
				$image = $this->model_tool_image->resize($result['primary_image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
	
      		$this->data['newses'][] = array(
				'news_id' => $result['news_id'],
				'title'       => $result['title'],
				'image'      => $image,
				'news_category_name' => $result['news_category_name'],
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['news_id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}
		
		$this->data['heading_title'] = $this->language->get('heading_title');		
				
		$this->data['text_enabled'] = $this->language->get('text_enabled');		
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');		
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');		
			
		$this->data['column_image'] = $this->language->get('column_image');		
		$this->data['column_title'] = $this->language->get('column_title');		
		$this->data['column_news_category_name'] = $this->language->get('column_news_category_name');			
		$this->data['column_status'] = $this->language->get('column_status');		
		$this->data['column_action'] = $this->language->get('column_action');		
					
		$this->data['button_insert'] = $this->language->get('button_insert');		
		$this->data['button_delete'] = $this->language->get('button_delete');		
		$this->data['button_filter'] = $this->language->get('button_filter');
		 
 		$this->data['token'] = $this->session->data['token'];
		
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

		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_news_category_name'])) {
			$url .= '&filter_news_category_name=' . urlencode(html_entity_decode($this->request->get['filter_news_category_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$this->data['sort_title'] = $this->url->link('news/news', 'token=' . $this->session->data['token'] . '&sort=nd.title' . $url, 'SSL');
		$this->data['sort_news_category_name'] = $this->url->link('news/news', 'token=' . $this->session->data['token'] . '&sort=ncd.name' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('news/news', 'token=' . $this->session->data['token'] . '&sort=n.status' . $url, 'SSL');
		$this->data['sort_order'] = $this->url->link('news/news', 'token=' . $this->session->data['token'] . '&sort=n.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_news_category_name'])) {
			$url .= '&filter_news_category_name=' . urlencode(html_entity_decode($this->request->get['filter_news_category_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $news_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('news/news', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_title'] = $filter_title;
		$this->data['filter_news_category_name'] = $filter_news_category_name;
		$this->data['filter_status'] = $filter_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'news/news_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	}

  	protected function getForm() {
    	$this->data['heading_title'] = $this->language->get('heading_title');
 
    	$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
    	$this->data['text_none'] = $this->language->get('text_none');
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_plus'] = $this->language->get('text_plus');
		$this->data['text_minus'] = $this->language->get('text_minus');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_option'] = $this->language->get('text_option');
		$this->data['text_option_value'] = $this->language->get('text_option_value');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_format_one'] = $this->language->get('text_format_one');
		$this->data['text_format_two'] = $this->language->get('text_format_two');

		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_content'] = $this->language->get('entry_content');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
    	$this->data['entry_primary_image'] = $this->language->get('entry_primary_image');
    	$this->data['entry_second_image'] = $this->language->get('entry_second_image');
    	$this->data['entry_news_category'] = $this->language->get('entry_news_category');
		$this->data['entry_text'] = $this->language->get('entry_text');
		$this->data['entry_required'] = $this->language->get('entry_required');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_format'] = $this->language->get('entry_format');

    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->data['button_add_option'] = $this->language->get('button_add_option');
		
    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');	
		 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_title'])) {
			$url .= '&filter_title=' . urlencode(html_entity_decode($this->request->get['filter_title'], ENT_QUOTES, 'UTF-8'));
		}	
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
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
			'href'      => $this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['news_id'])) {
			$this->data['action'] = $this->url->link('news/news/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('news/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $this->request->get['news_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('news/news', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['news_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$news_info = $this->model_news_news->getNews($this->request->get['news_id']);
    	}

		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['news_description'])) {
			$this->data['news_description'] = $this->request->post['news_description'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_description'] = $this->model_news_news->getNewsDescriptions($this->request->get['news_id']);
		} else {
			$this->data['news_description'] = array();
		}
		
		if (isset($this->request->post['primary_image'])) {
			$this->data['primary_image'] = $this->request->post['primary_image'];
		} elseif (!empty($news_info)) {
			$this->data['primary_image'] = $news_info['primary_image'];
		} else {
			$this->data['primary_image'] = '';
		}
		
		if (isset($this->request->post['second_image'])) {
			$this->data['second_image'] = $this->request->post['second_image'];
		} elseif (!empty($news_info)) {
			$this->data['second_image'] = $news_info['second_image'];
		} else {
			$this->data['second_image'] = '';
		}
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['primary_image']) && file_exists(DIR_IMAGE . $this->request->post['primary_image'])) {
			$this->data['primary_thumb'] = $this->model_tool_image->resize($this->request->post['primary_image'], 100, 100);
		} elseif (!empty($news_info) && $news_info['primary_image'] && file_exists(DIR_IMAGE . $news_info['primary_image'])) {
			$this->data['primary_thumb'] = $this->model_tool_image->resize($news_info['primary_image'], 100, 100);
		} else {
			$this->data['primary_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		if (isset($this->request->post['second_image']) && file_exists(DIR_IMAGE . $this->request->post['second_image'])) {
			$this->data['second_thumb'] = $this->model_tool_image->resize($this->request->post['second_image'], 100, 100);
		} elseif (!empty($news_info) && $news_info['second_image'] && file_exists(DIR_IMAGE . $news_info['second_image'])) {
			$this->data['second_thumb'] = $this->model_tool_image->resize($news_info['second_image'], 100, 100);
		} else {
			$this->data['second_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (!empty($news_info)) {
      		$this->data['sort_order'] = $news_info['sort_order'];
    	} else {
			$this->data['sort_order'] = 1;
		}
				
    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (!empty($news_info)) {
			$this->data['status'] = $news_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
				
    	if (isset($this->request->post['format'])) {
      		$this->data['format'] = $this->request->post['format'];
    	} elseif (!empty($news_info)) {
			$this->data['format'] = $news_info['format'];
		} else {
      		$this->data['format'] = 1;
    	}

		if (isset($this->request->post['news_category_id'])) {
			$news_category_id = $this->request->post['news_category_id'];
		} elseif (isset($this->request->get['news_id'])) {		
			$news_category_id = $news_info['news_category_id'];
		} else {
			$news_category_id = 0;
		}
		
		// Categories
		$this->load->model('news/news_category');

		if ($news_category_id) {
			$news_category_info = $this->model_news_news_category->getNewsCategory($news_category_id);
		}

		if (!empty($news_category_info)) {		
			$this->data['news_category'] = array(
					'news_category_id' => $news_category_info['news_category_id'],
					'name'        => $news_category_info['name']
				);
		} else {
			$this->data['news_category'] = array(
				'name' => '',
				'news_category_id' => 0,
				);
		}
										
		$this->template = 'news/news_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	} 
	
  	protected function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'news/news')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	foreach ($this->request->post['news_description'] as $language_id => $value) {
      		if ((utf8_strlen($value['title']) < 1) || (utf8_strlen($value['title']) > 255)) {
        		$this->error['title'][$language_id] = $this->language->get('error_title');
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
    	if (!$this->user->hasPermission('modify', 'news/news')) {
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
		
		if (isset($this->request->get['filter_title']) || isset($this->request->get['filter_news_category_id'])) {
			$this->load->model('news/news');
			
			if (isset($this->request->get['filter_title'])) {
				$filter_title = $this->request->get['filter_title'];
			} else {
				$filter_title = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_title'  => $filter_title,
				'start'        => 0,
				'limit'        => $limit
			);
			
			if (isset($this->request->get['filter_news_category_id']) && $this->request->get['filter_news_category_id']) {
				$data['filter_news_category_id'] = $this->request->get['filter_news_category_id'];
			}
			
			$results = $this->model_news_news->getNewses($data);
			
			foreach ($results as $result) {
				$json[] = array(
					'news_id' => $result['news_id'],
					'title'       => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'))
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>