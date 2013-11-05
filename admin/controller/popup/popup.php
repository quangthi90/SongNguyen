<?php 
class ControllerPopupPopup extends Controller {
	private $error = array(); 
   
  	public function index() {
		$this->language->load('popup/popup');
    	
		$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('popup/popup');
		
		$this->getList();
  	}

  	public function insert() {
    	$this->language->load('popup/popup');

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('popup/popup');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_popup_popup->addPopup($this->request->post);
	  		
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
			
			$this->redirect($this->url->link('popup/popup', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
	
    	$this->getForm();
  	}
 
  	public function update() {
    	$this->language->load('popup/popup');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('popup/popup');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_popup_popup->editPopup($this->request->get['popup_id'], $this->request->post);
			
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
			
			$this->redirect($this->url->link('popup/popup', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	$this->language->load('popup/popup');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('popup/popup');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $popup_id) {
				$this->model_popup_popup->deletePopup($popup_id);
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
			
			$this->redirect($this->url->link('popup/popup', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}

  	public function active() {
    	$this->language->load('popup/popup');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('popup/popup');
		
		if (isset($this->request->get['popup_id']) && $this->validateDelete()) {
			$this->model_popup_popup->activePopup($this->request->get['popup_id']);

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
			
			$this->redirect($this->url->link('popup/popup', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}

  	public function deactive() {
    	$this->language->load('popup/popup');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('popup/popup');
		
		if (isset($this->request->get['popup_id']) && $this->validateDelete()) {
			$this->model_popup_popup->deactivePopup($this->request->get['popup_id']);

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
			
			$this->redirect($this->url->link('popup/popup', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getList();
  	}
	
  	protected function getList() {				
		if (isset($this->request->get['filter_title'])) {
			$filter_title = $this->request->get['filter_title'];
		} else {
			$filter_title = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ptd.title';
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
			'href'      => $this->url->link('popup/popup', 'token=' . $this->session->data['token'] . $url, 'SSL'),       		
      		'separator' => ' :: '
   		);
		
		$this->data['insert'] = $this->url->link('popup/popup/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('popup/popup/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
    	
		$this->data['popups'] = array();

		$data = array(
			'filter_title'	  => $filter_title, 
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'           => $this->config->get('config_admin_limit')
		);
		
		$popup_total = $this->model_popup_popup->getTotalPopups($data);
			
		$results = $this->model_popup_popup->getPopups($data);
				    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('popup/popup/update', 'token=' . $this->session->data['token'] . '&popup_id=' . $result['popup_id'] . $url, 'SSL')
			);

			if ($result['status']) {
				$action[] = array(
					'text' => $this->language->get('text_deactive'),
					'href' => $this->url->link('popup/popup/deactive', 'token=' . $this->session->data['token'] . '&popup_id=' . $result['popup_id'] . $url, 'SSL')
				);
			}else {
				$action[] = array(
					'text' => $this->language->get('text_active'),
					'href' => $this->url->link('popup/popup/active', 'token=' . $this->session->data['token'] . '&popup_id=' . $result['popup_id'] . $url, 'SSL')
				);
			}

			if ($result['type'] == 1) {
				$type = $this->language->get('text_video_popup');
			}elseif ($result['type'] == 2) {
				$type = $this->language->get('text_carousel_popup');
			}else {
				$type = $this->language->get('text_text_popup');
			}
	
      		$this->data['popups'][] = array(
				'popup_id' => $result['popup_id'],
				'title'       => $result['title'],
				'type'	=> $type,
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['popup_id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}
		
		$this->data['heading_title'] = $this->language->get('heading_title');		
				
		$this->data['text_enabled'] = $this->language->get('text_enabled');		
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');		
				
		$this->data['column_title'] = $this->language->get('column_title');	
		$this->data['column_type'] = $this->language->get('column_type');	
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
					
		$this->data['sort_title'] = $this->url->link('popup/popup_carousel', 'token=' . $this->session->data['token'] . '&sort=ptd.title' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('popup/popup_carousel', 'token=' . $this->session->data['token'] . '&sort=pt.status' . $url, 'SSL');
		$this->data['sort_order'] = $this->url->link('popup/popup_carousel', 'token=' . $this->session->data['token'] . '&sort=pt.sort_order' . $url, 'SSL');
		
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
				
		$pagination = new Pagination();
		$pagination->total = $popup_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('popup/popup', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
	
		$this->data['filter_title'] = $filter_title;
		$this->data['filter_status'] = $filter_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'popup/popup_list.tpl';
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
    	$this->data['text_video_popup'] = $this->language->get('text_video_popup');
    	$this->data['text_text_popup'] = $this->language->get('text_text_popup');
    	$this->data['text_carousel_popup'] = $this->language->get('text_carousel_popup');

		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_banner'] = $this->language->get('entry_banner');
		$this->data['entry_content'] = $this->language->get('entry_content');
		$this->data['entry_type'] = $this->language->get('entry_type');
		$this->data['entry_embbed'] = $this->language->get('entry_embbed');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');

    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
		
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
			'href'      => $this->url->link('popup/popup', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		if (!isset($this->request->get['popup_id'])) {
			$this->data['action'] = $this->url->link('popup/popup/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('popup/popup/update', 'token=' . $this->session->data['token'] . '&popup_id=' . $this->request->get['popup_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('popup/popup', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['popup_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$popup_info = $this->model_popup_popup->getPopup($this->request->get['popup_id']);
    	}

		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['popup_description'])) {
			$this->data['popup_description'] = $this->request->post['popup_description'];
		} elseif (isset($this->request->get['popup_id'])) {
			$this->data['popup_description'] = $this->model_popup_popup->getPopupDescriptions($this->request->get['popup_id']);
		} else {
			$this->data['popup_description'] = array();
		}
		
		if (isset($this->request->post['embbed'])) {
      		$this->data['embbed'] = $this->request->post['embbed'];
    	} elseif (!empty($popup_info)) {
      		$this->data['embbed'] = $popup_info['embbed'];
    	} else {
			$this->data['embbed'] = '';
		}
		
		if (isset($this->request->post['banner_id'])) {
      		$this->data['banner_id'] = $this->request->post['banner_id'];
    	} elseif (!empty($popup_info)) {
      		$this->data['banner_id'] = $popup_info['banner_id'];
    	} else {
			$this->data['banner_id'] = 0;
		}
		
		$this->load->model('design/banner');
		$banner_data = $this->model_design_banner->getBanner($this->data['banner_id']);
		if (!empty($banner_data)) {
			$this->data['banner'] = array(
				'banner_id' => $banner_data['banner_id'],
				'name' => $banner_data['name'],
				);
		}else {
			$this->data['banner'] = array(
				'banner_id' => 0,
				'name' => '',
				);
		}
		
		if (isset($this->request->post['type'])) {
      		$this->data['type'] = $this->request->post['type'];
    	} elseif (!empty($popup_info)) {
      		$this->data['type'] = $popup_info['type'];
    	} else {
			$this->data['type'] = 0;
		}
		
		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (!empty($popup_info)) {
      		$this->data['sort_order'] = $popup_info['sort_order'];
    	} else {
			$this->data['sort_order'] = 1;
		}
				
    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (!empty($popup_info)) {
			$this->data['status'] = $popup_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
										
		$this->template = 'popup/popup_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
  	} 
	
  	protected function validateForm() { 
    	if (!$this->user->hasPermission('modify', 'popup/popup')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	foreach ($this->request->post['popup_description'] as $language_id => $value) {
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
    	if (!$this->user->hasPermission('modify', 'popup/popup')) {
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
		
		if (isset($this->request->get['filter_title'])) {
			$this->load->model('popup/popup');
			
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
			
			$results = $this->model_popup_popup->getPopups($data);
			
			foreach ($results as $result) {
				$json[] = array(
					'popup_id' => $result['popup_id'],
					'title'       => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'))
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>