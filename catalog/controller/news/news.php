<?php  
class ControllerNewsNews extends Controller {
	public function index() {
		if (empty($this->request->get['news_id'])) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
		}else {
			$this->load->model('news/news');

			$news = $this->model_news_news->getNews($this->request->get['news_id']);

			if (empty($news)) {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
				} else {
					$this->template = 'default/template/error/not_found.tpl';
				}
			}else {
				$this->document->setTitle($this->config->get('config_title'));
				$this->document->setDescription($this->config->get('config_meta_description'));

				$this->data['heading_title'] = $this->config->get('config_title');
				
				if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
					$server = $this->config->get('config_ssl');
				} else {
					$server = $this->config->get('config_url');
				}

				$this->language->load('news/detail');
				$this->data['lang'] = $this->language->get('code');
				$this->data['direction'] = $this->language->get('direction');
				$this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');

				$this->data['base'] = $server;
				
				$this->load->model('tool/image');
				if (file_exists(DIR_IMAGE . $news['primary_image'])) {
					$primary_image = $this->model_tool_image->resize($news['primary_image'], 190, 129);
				}else {
					$primary_image = $this->model_tool_image->resize('no_image.jpg', 190, 129);
				}

				$date_added = new DateTime($news['date_added']);
				
				$this->data['news'] = array(
					'title' => $news['title'],
					'image' => $primary_image,
					'content' => html_entity_decode($news['content'], ENT_QUOTES, 'UTF-8'),
					'date_added' => $date_added->format($this->language->get('date_format_short')),
					'href' => $this->url->link('news/news', 'news_id=' . $news['news_id']),
					);

				if ($news['format']) {
					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/news_detail0.tpl')) {
						$this->template = $this->config->get('config_template') . '/template/news/news_detail0.tpl';
					} else {
						$this->template = 'default/template/news/news_detail0.tpl';
					}
				}else {
					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/news_detail1.tpl')) {
						$this->template = $this->config->get('config_template') . '/template/news/news_detail1.tpl';
					} else {
						$this->template = 'default/template/news/news_detail.tpl';
					}
				}
				
				$this->children = array(
					'common/footer',
					'common/header'
				);
												
				$this->response->setOutput($this->render());
			}
		}
	}
}
?>