<?php  
class ControllerNewsNews extends Controller {
	public function index() {
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$this->data['base'] = $server;

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
                // break when not exist $_GET['popup']
                if (isset($_GET['popup']) && $_GET['popup']) {
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
                    if (isset($this->session->data['back_link'])) {
                        $this->data['back_link']['href'] = $this->session->data['back_link']['href'];
                        $this->data['back_link']['popup'] = $this->session->data['back_link']['popup'];
                        unset($this->session->data['back_link']);
                    }else {
                        $this->data['back_link']['href'] = $this->url->link('common/home');
                        $this->data['back_link']['popup'] = 0;
                    }

                    $this->data['base'] = $server;

                    $this->data['text_go_back'] = $this->language->get('text_go_back');
                    $this->data['text_older_post'] = $this->language->get('text_older_post');

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

                    $results = $this->model_news_news->getNewses(array(
                        'start' => 0,
                        'limit' => 5,
                        // 'filter_older' => $news['date_added'],
                        'filter_status'	  => 1,
                        'filter_news_category_id' => $news['news_category_id'],
                    ));
                    $this->data['older'] = array();
                    foreach ($results as $key => $result) {
                        $date_added = new DateTime($result['date_added']);
                        $this->data['older'][] = array(
                            'title' => $result['title'],
                            'date_added' => $date_added->format($this->language->get('date_format_short')),
                            'href' => $this->url->link('news/news', 'news_id=' . $result['news_id'] . '&popup=1'),
                        );
                    }

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
                            $this->template = 'default/template/news/news_detail1.tpl';
                        }
                    }

                    $this->children = array(
                        'common/footer',
                        'common/header'
                    );

                    $this->response->setOutput($this->render());
                // Excute when popup not set or false
                }else {
                    // Get full url
                    $popup_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    if (strpos($popup_url, 'popup')) {
                        // Set the $_GET['popup'] = 1
                        $popup_url = str_replace('popup=0', 'popup=1',$popup_url);
                    }else {
                        $popup_url .= '&popup=1';
                    }
                    // Save to session
                    $this->session->data['popup_url'] = $popup_url;
                    // Redirect to studying-aboard
                    header("Location: " . HTTP_SERVER . 'studying-abroad');
                }
			}
		}
	}
}
?>