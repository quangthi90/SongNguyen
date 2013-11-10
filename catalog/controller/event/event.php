<?php
class ControllerEventEvent extends Controller {
	private $limit = 10;

	public function index() {
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');


		$this->data['direction'] = $this->language->get('direction');
		$this->data['text_title'] = $this->language->get('text_event_news');
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		$this->data['base'] = $server;
		$this->data['left_image'] = $server . '/image/data/event.jpg';

		if (empty($this->request->get['page'])) {
			$page = 1;
		}else {
			$page = $this->request->get['page'];
		}

		$this->load->model('event/event');

		$data = array(
			'sort'            => 'n.date_added',
			'order'           => 'DESC',
			'start'           => ($page - 1) * $this->limit,
			'limit'           => $this->limit,
			'filter_status'	  => 1,
		);

		$event_total = $this->model_event_event->getTotalEvents($data);
			
		$results = $this->model_event_event->getEvents($data);
		
		$this->data['items'] =array();	    	
		foreach ($results as $result) {
			$date_added = new DateTime($result['date_added']);
      		$this->data['items'][] = array(
				'href' => $this->url->link('event/event/detail', 'event_id=' . $result['event_id']),
				'title'       => $result['title'] . ' (' . $date_added->format($this->language->get('date_format_short')) . ')',
			);
    	}

    	$num_links = 4;
    	$pagination_url = $this->url->link('event/event', 'page={page}');
    	$num_pages = ceil($event_total / $data['limit']);
		$this->data['pagination'] = '';
		if ($num_pages >= 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);
			
				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}
						
				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}

			for ($i = $start; $i <= $end; $i++) {
				if ($start != $i) {
					$this->data['pagination'] .= ' | ';
				}
				if ($page == $i) {
					$this->data['pagination'] .= ' <a href="' . str_replace('{page}', $i, $pagination_url) . '" class="active">' . $i . '</a> ';
				} else {
					$this->data['pagination'] .= ' <a href="' . str_replace('{page}', $i, $pagination_url) . '">' . $i . '</a> ';
				}	
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/event/event_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/event/event_list.tpl';
		} else {
			$this->template = 'default/template/event/event_list.tpl';
		}
										
		$this->response->setOutput($this->render());
	}

	public function detail() {
		if (empty($this->request->get['event_id'])) {

		}else {
			$this->load->model('event/event');

			$event = $this->model_event_event->getEvent($this->request->get['event_id']);

			if (empty($event)) {

			}else {
				if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
					$server = $this->config->get('config_ssl');
				} else {
					$server = $this->config->get('config_url');
				}

				$this->document->setTitle($this->config->get('config_title'));
				$this->document->setDescription($this->config->get('config_meta_description'));

				$this->data['heading_title'] = $this->config->get('config_title');

				$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');

				$this->data['base'] = $server;

				$this->load->model('tool/image');
				if(file_exists(DIR_IMAGE . $event['image'])) {
					$image = $this->model_tool_image->resize($event['image'], 200, 124);
				}else {
					$image = $this->model_tool_image->resize('no_image.jpg', 200, 124);
				}

				$this->data['title'] = $event['title'];
				$this->data['content'] = html_entity_decode($event['content'], ENT_QUOTES, 'UTF-8');
				$date_added = new DateTime($event['date_added']);
				$this->data['date_added'] = $date_added->format($this->language->get('date_format_short'));
				$this->data['image'] = $image;


				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/event/event_detail.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/event/event_detail.tpl';
				} else {
					$this->template = 'default/template/event/event_detail.tpl';
				}
												
				$this->response->setOutput($this->render());
			}
		}
	}
}
?>