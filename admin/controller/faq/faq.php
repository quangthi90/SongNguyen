<?php 
class ControllerFaqFaq extends Controller {
	private $error = array(); 
    
  	public function index() {
		$this->language->load('faq/faq');
    	
		$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('faq/faq');
		
		$this->getList();
  	}
  
  	public function insert() {
    	$this->language->load('faq/faq');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('faq/faq');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_faq_faq->addFaq($this->request->post);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
			
			if (isset($this->request->get['filter_category_name'])) {
				$url .= '&filter_category_name=' . urlencode(html_entity_decode($this->request->get['filter_category_name'], ENT_QUOTES, 'UTF-8'));
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
			
			$this->redirect($this->url->link('faq/faq', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}

  	public function update() {
    	$this->language->load('faq/faq');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('faq/faq');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_faq_faq->editFaq($this->request->get['faq_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_category_name'])) {
				$url .= '&filter_category_name=' . urlencode(html_entity_decode($this->request->get['filter_category_name'], ENT_QUOTES, 'UTF-8'));
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
			
			$this->redirect($this->url->link('faq/faq', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	$this->language->load('faq/faq');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('faq/faq');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $faq_id) {
				$this->model_faq_faq->deleteFaq($faq_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['filter_category_name'])) {
				$url .= '&filter_category_name=' . urlencode(html_entity_decode($this->request->get['filter_category_name'], ENT_QUOTES, 'UTF-8'));
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
			
			$this->redirect($this->url->link('faq/faq', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}

  	protected function getList() {				
		if (isset($this->request->get['filter_faq_category_name'])) {
			$filter_faq_category_name = $this->request->get['filter_faq_category_name'];
		} else {
			$filter_faq_category_name = null;
		}

		if (isset($this->request->get['filter_question'])) {
			$filter_question = $this->request->get['filter_question'];
		} else {
			$filter_question = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'f.date_added';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
						
		$url = '';
						
		if (isset($this->request->get['filter_faq_category_name'])) {
			$url .= '&filter_faq_category_name=' . urlencode(html_entity_decode($this->request->get['filter_faq_category_name'], ENT_QUOTES, 'UTF-8'));
		}	
						
		if (isset($this->request->get['filter_question'])) {
			$url .= '&filter_question=' . urlencode(html_entity_decode($this->request->get['filter_question'], ENT_QUOTES, 'UTF-8'));
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
			'href'      => $this->url->link('faq/faq', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('faq/faq/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$this->data['delete'] = $this->url->link('faq/faq/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
    	
		$this->data['faqs'] = array();

		$data = array(
			'filter_faq_category_name'	  => $filter_faq_category_name, 
			'filter_question'   => $filter_question,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);
		
		$faq_total = $this->model_faq_faq->getTotalFaqs($data);
			
		$results = $this->model_faq_faq->getFaqs($data);
				    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('faq/faq/update', 'token=' . $this->session->data['token'] . '&faq_id=' . $result['faq_id'] . $url, 'SSL')
			);
	
      		$this->data['faqs'][] = array(
				'faq_id' => $result['faq_id'],
				'question'       => $result['question'],
				//'answer'       => $result['answer'],
				'faq_category_name' => (!empty($result['faq_category_name'])) ? $result['faq_category_name'] : 'root',
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['faq_id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}
		
		$this->data['heading_title'] = $this->language->get('heading_title');		
				
		$this->data['text_enabled'] = $this->language->get('text_enabled');		
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');		
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');		
					
		$this->data['column_id'] = $this->language->get('column_id');	
		$this->data['column_category'] = $this->language->get('column_category');
		$this->data['column_question'] = $this->language->get('column_question');	
		$this->data['column_anwser'] = $this->language->get('column_anwser');			
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

		if (isset($this->request->get['filter_question'])) {
			$url .= '&filter_question=' . urlencode(html_entity_decode($this->request->get['filter_question'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_faq_category_name'])) {
			$url .= '&filter_faq_category_name=' . urlencode(html_entity_decode($this->request->get['filter_faq_category_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if ($order == 'DESC') {
			$url .= '&order=ASC';
		} else {
			$url .= '&order=DESC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
			
		$this->data['sort_question'] = $this->url->link('faq/faq', 'token=' . $this->session->data['token'] . '&sort=fd.question' . $url, 'SSL');
		$this->data['sort_faq_category_name'] = $this->url->link('faq/faq', 'token=' . $this->session->data['token'] . '&sort=fcd.name' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('faq/faq', 'token=' . $this->session->data['token'] . '&sort=f.status' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['filter_question'])) {
			$url .= '&filter_question=' . urlencode(html_entity_decode($this->request->get['filter_question'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_faq_category_name'])) {
			$url .= '&filter_faq_category_name=' . urlencode(html_entity_decode($this->request->get['filter_faq_category_name'], ENT_QUOTES, 'UTF-8'));
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
		$pagination->total = $faq_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('faq/faq', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_faq_category_name'] = $filter_faq_category_name;
		$this->data['filter_question'] = $filter_question;
		$this->data['filter_status'] = $filter_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'faq/faq_list.tpl';
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
		$this->data['text_option'] = $this->language->get('text_option');
		$this->data['text_option_value'] = $this->language->get('text_option_value');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');

		$this->data['entry_question'] = $this->language->get('entry_question');
		$this->data['entry_answer'] = $this->language->get('entry_answer');
    	$this->data['entry_faq_category'] = $this->language->get('entry_faq_category');
		$this->data['entry_text'] = $this->language->get('entry_text');
		$this->data['entry_required'] = $this->language->get('entry_required');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_priority'] = $this->language->get('entry_priority');

    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_remove'] = $this->language->get('button_remove');
		
    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');		
		$this->data['tab_links'] = $this->language->get('tab_links');
		 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['question'])) {
			$this->data['error_question'] = $this->error['question'];
		} else {
			$this->data['error_question'] = array();
		}

 		if (isset($this->error['answer'])) {
			$this->data['error_answer'] = $this->error['answer'];
		} else {
			$this->data['error_answer'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_question'])) {
			$url .= '&filter_question=' . urlencode(html_entity_decode($this->request->get['filter_question'], ENT_QUOTES, 'UTF-8'));
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
			'href'      => $this->url->link('faq/faq', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['faq_id'])) {
			$this->data['action'] = $this->url->link('faq/faq/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('faq/faq/update', 'token=' . $this->session->data['token'] . '&faq_id=' . $this->request->get['faq_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('faq/faq', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['faq_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$faq_info = $this->model_faq_faq->getFaq($this->request->get['faq_id']);
    	}

		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['faq_description'])) {
			$this->data['faq_description'] = $this->request->post['faq_description'];
		} elseif (isset($this->request->get['faq_id'])) {
			$this->data['faq_description'] = $this->model_faq_faq->getFaqDescriptions($this->request->get['faq_id']);
		} else {
			$this->data['faq_description'] = array();
		}
		
		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (!empty($faq_info)) {
      		$this->data['sort_order'] = $faq_info['sort_order'];
    	} else {
			$this->data['sort_order'] = 1;
		}
				
    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (!empty($faq_info)) {
			$this->data['status'] = $faq_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
		
		if (isset($this->request->post['faq_category_id'])) {
			$faq_category_id = $this->request->post['faq_category_id'];
		} elseif (isset($this->request->get['faq_id'])) {		
			$faq_category_id = $faq_info['faq_category_id'];
		} else {
			$faq_category_id = 0;
		}
		
		// Categories
		$this->load->model('faq/faq_category');
		
		if ($faq_category_id) {	
			$faq_category_infor = $this->model_faq_faq_category->getFaqCategory($faq_category_id);
		} 
		
		if ( !empty($faq_category_infor) ) {
			$this->data['faq_category'] = array(
				'faq_category_id' => $faq_category_infor['faq_category_id'],
				'name' => $faq_category_infor['name'],
				);
		}else {
			$this->data['faq_category'] = array(
				'faq_category_id' => 0,
				'name' => '',
				);
		}
										
		$this->template = 'faq/faq_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	} 
	
  	protected function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'faq/faq')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	foreach ($this->request->post['faq_description'] as $language_id => $value) {
      		if ((utf8_strlen($value['question']) < 1) || (utf8_strlen($value['question']) > 1000)) {
        		$this->error['question'][$language_id] = $this->language->get('error_question');
      		}

      		if ((utf8_strlen($value['answer']) < 1) || (utf8_strlen($value['answer']) > 1000)) {
        		$this->error['answer'][$language_id] = $this->language->get('error_answer');
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
    	if (!$this->user->hasPermission('modify', 'faq/faq')) {
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
		
		if (isset($this->request->get['filter_question']) || isset($this->request->get['filter_faq_category_id']) || isset($this->request->get['filter_category_name'])) {
			$this->load->model('faq/faq');

			if (isset($this->request->get['filter_category_name'])) {
				$filter_category_name = $this->request->get['filter_category_name'];
			} else {
				$filter_category_name = '';
			}
			
			if (isset($this->request->get['filter_question'])) {
				$filter_question = $this->request->get['filter_question'];
			} else {
				$filter_question = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'filter_question'  => $filter_question,
				'filter_category_name'  => $filter_category_name,
				'start'        => 0,
				'limit'        => $limit
			);
			
			$results = $this->model_faq_faq->getFaqs($data);
			
			foreach ($results as $result) {
				$json[] = array(
					'faq_id' => $result['faq_id'],
					'question'       => strip_tags(html_entity_decode($result['question'], ENT_QUOTES, 'UTF-8'))
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>