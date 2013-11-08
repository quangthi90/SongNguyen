<?php
class ControllerProgramProgram extends Controller {
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
		$this->data['text_title'] = 'Chương trình';//$this->language->get('text_program');
		$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		$this->data['base'] = $server;
		$this->data['left_image'] = $server . '/image/data/program.jpg';

		if (empty($this->request->get['page'])) {
			$page = 1;
		}else {
			$page = $this->request->get['page'];
		}

		$this->load->model('program/program');

		$data = array(
			'sort'            => 'n.date_added',
			'order'           => 'DESC',
			'start'           => ($page - 1) * $this->limit,
			'limit'           => $this->limit,
			'filter_status'	  => 1,
		);

		$program_total = $this->model_program_program->getTotalPrograms($data);
			
		$results = $this->model_program_program->getPrograms($data);
		
		$this->data['items'] =array();	    	
		foreach ($results as $result) {
      		$this->data['items'][] = array(
				'href' => $this->url->link('program/program/detail', 'program_id=' . $result['program_id']),
				'title'       => $result['title'] . ' (' . (new DateTime($result['date_added']))->format($this->language->get('date_format_short')) . ')',
			);
    	}

    	$num_links = 4;
    	$pagination_url = $this->url->link('program/program', 'page={page}');
    	$num_pages = ceil($program_total / $data['limit']);
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
		if (empty($this->request->get['program_id'])) {

		}else {
			$this->load->model('program/program');

			$program = $this->model_program_program->getProgram($this->request->get['program_id']);

			if (empty($program)) {

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
				if(file_exists(DIR_IMAGE . $program['image'])) {
					$image = $this->model_tool_image->resize($program['image'], 200, 124);
				}else {
					$image = $this->model_tool_image->resize('no_image.jpg', 200, 124);
				}

				$this->data['title'] = $program['title'];
				$this->data['content'] = html_entity_decode($program['content'], ENT_QUOTES, 'UTF-8');
				$this->data['date_added'] = (new DateTime($program['date_added']))->format($this->language->get('date_format_short'));
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