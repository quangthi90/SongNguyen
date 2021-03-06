<?php
class ControllerNewsNewsCategory extends Controller {
	private $limit = 10;

	public function index() {
		if (empty($this->request->get['news_category_id'])) {
			// redirect to error page
			exit();
		}else {
			$this->load->model('news/news_category');
			$this->load->model('news/news');

			$category_data = $this->model_news_news_category->getNewsCategory($this->request->get['news_category_id']);

			if (empty($category_data)) {
				// redirect to error page
				exit();
			}else {
                if ($category_data['link']) {
                    header("Location: " . $category_data['link']);
                    exit();
                }

                $this->data['parent_id'] = $category_data['parent_id'];

                $this->document->setTitle($this->config->get('config_title'));
                $this->document->setDescription($this->config->get('config_meta_description'));

                $this->data['heading_title'] = $this->config->get('config_title');

                if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
                    $server = $this->config->get('config_ssl');
                } else {
                    $server = $this->config->get('config_url');
                }

                $this->data['direction'] = $this->language->get('direction');
                $this->data['text_title'] = $category_data['name'];
                $this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
                $this->data['base'] = $server;
                $this->data['lang'] = $this->language->get('code');

                $this->load->model('tool/image');

                if ($category_data['have_popup']) {
                    if (isset($this->request->get['popup']) && $this->request->get['popup']) {
                        if (file_exists(DIR_IMAGE . $category_data['primary_image'])) {
                            $this->data['left_image'] = $this->model_tool_image->resize($category_data['primary_image'], 200, 136);
                        }else {
                            $this->data['left_image'] = $this->model_tool_image->resize('no_image.jpg', 200, 136);
                        }

                        if (empty($this->request->get['page'])) {
                            $page = 1;
                        }else {
                            $page = $this->request->get['page'];
                        }

                        $this->session->data['back_link']['href'] = $this->url->link('news/news_category', 'news_category_id=' . $this->request->get['news_category_id'] . '&page=' . $page);
                        $this->session->data['back_link']['popup'] = $category_data['have_popup'];

                        $data = array(
                            'sort'            => 'nc.date_added',
                            'order'           => 'DESC',
                            'start'           => ($page - 1) * $this->limit,
                            'limit'           => $this->limit,
                            'filter_status'	  => 1,
                            'filter_parent_id'=> $category_data['news_category_id'],
                        );


                        $total = $this->model_news_news->getTotalNewses(array(
                            'filter_status'	  => 1,
                            'filter_news_category_id'=> $category_data['news_category_id'],
                        ));
                        $results = $this->model_news_news->getNewses(array(
                            'sort'            => 'n.date_added',
                            'order'           => 'DESC',
                            'start'           => ($page - 1) * $this->limit,
                            'limit'           => $this->limit,
                            'filter_status'	  => 1,
                            'filter_news_category_id'=> $category_data['news_category_id'],
                        ));

                        $this->data['items'] =array();
                        if ($results) {
                            foreach ($results as $result) {
                                $date_added = new DateTime($result['date_added']);
                                $this->data['items'][] = array(
                                    'href' => $this->url->link('news/news', 'news_id=' . $result['news_id'] . '&popup=1'),
                                    'title'       => $result['title'] . ' (' . $date_added->format($this->language->get('date_format_short')) . ')',
                                    'popup' => 1,
                                );
                            }
                        }else {
                            $total = $this->model_news_news_category->getTotalNewsCategories($data);

                            $results = $this->model_news_news_category->getNewsCategories($data);

                            foreach ($results as $result) {
                                $date_added = new DateTime($result['date_added']);
                                $this->data['items'][] = array(
                                    'href' => $this->url->link('news/news_category', 'news_category_id=' . $result['news_category_id'] . ($result['have_popup']) ? '&popup=1':''),
                                    'title'       => $result['name'] . ' (' . $date_added->format($this->language->get('date_format_short')) . ')',
                                    'popup' => $result['have_popup'],
                                );
                            }
                        }


                        $num_links = 4;
                        $pagination_url = $this->url->link('news/news_category', 'page={page}' . '&news_category_id=' . $category_data['news_category_id']);
                        $num_pages = ceil($total / $this->limit);
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

                        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/news_category_popup.tpl')) {
                            $this->template = $this->config->get('config_template') . '/template/news/news_category_popup.tpl';
                        } else {
                            $this->template = 'default/template/news/news_category_popup.tpl';
                        }
                    }else {
                        // Get full url
                        $popup_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                        if (strpos($popup_url, 'popup')) {
                            // Set the $_GET['popup'] = 1
                            $popup_url = str_replace('popup=0', 'popup=1',$popup_url);
                        }else {
                            if (strpos($popup_url, '?')) {
                                $popup_url .= '&popup=1';
                            }else {
                                $popup_url .= '?popup=1';
                            }
                        }
                        // Save to session
                        $this->session->data['popup_url'] = $popup_url;
                        // Redirect to studying-aboard
                        header("Location: " . HTTP_SERVER . 'studying-abroad');
                        exit();
                    }
                }else {
                    $this->session->data['back_link']['href'] = $this->url->link('news/news_category', 'news_category_id=' . $this->request->get['news_category_id']);
                    $this->session->data['back_link']['popup'] = $category_data['have_popup'];

                    $category_child = $this->model_news_news_category->getNewsCategories(array(
                        'start' => 0,
                        'limit' => 999,
                        'filter_parent_id' => $category_data['news_category_id'],
                        'filter_status' => 1,
                    ));
                    $childs = array();

                    if ($category_data['parent_id'] == 0) {
                        $img_width = 275;
                        $img_height = 187;
                    }else {
                        $img_width = 190;
                        $img_height = 129;
                    }

                    if (!empty($category_child)) {
                        foreach ($category_child as $child) {
                            $child = $this->model_news_news_category->getNewsCategory($child['news_category_id']);
                            if (!empty($child)) {
                                if (file_exists(DIR_IMAGE . $child['primary_image'])) {
                                    $primary_image = $this->model_tool_image->resize($child['primary_image'], $img_width, $img_height);
                                }else {
                                    $primary_image = $this->model_tool_image->resize('no_image.jpg', $img_width, $img_height);
                                }

                                if (file_exists(DIR_IMAGE . $child['second_image'])) {
                                    $second_image = $this->model_tool_image->resize($child['second_image'], $img_width, $img_height);
                                }else {
                                    $second_image = $this->model_tool_image->resize('no_image.jpg', $img_width, $img_height);
                                }

                                $childs[] = array(
                                    'name' => $child['name'],
                                    'primary_image' => $primary_image,
                                    'second_image' => $second_image,
                                    'sort_order' => $child['sort_order'],
                                    'href' => $this->url->link('news/news_category', 'news_category_id=' . $child['news_category_id'] . (($child['have_popup'])? '&popup=1' : '')),
                                    'class' => ($child['have_popup'])? 'link-popup iframe' : '',
                                );
                            }
                        }
                    }

                    $newses = $this->model_news_news->getNewses(array(
                        'start' => 0,
                        'limit' => 999,
                        'filter_news_category_id' => $category_data['news_category_id'],
                        'filter_status' => 1,
                    ));
                    if (!empty($newses)) {
                        foreach ($newses as $news) {
                            if (file_exists(DIR_IMAGE . $news['primary_image'])) {
                                $primary_image = $this->model_tool_image->resize($news['primary_image'], $img_width, $img_height);
                            }else {
                                $primary_image = $this->model_tool_image->resize('no_image.jpg', $img_width, $img_height);
                            }

                            if (file_exists(DIR_IMAGE . $news['second_image'])) {
                                $second_image = $this->model_tool_image->resize($news['second_image'], $img_width, $img_height);
                            }else {
                                $second_image = $this->model_tool_image->resize('no_image.jpg', $img_width, $img_height);
                            }

                            $childs[] = array(
                                'name' => $news['title'],
                                'primary_image' => $primary_image,
                                'second_image' => $second_image,
                                'sort_order' => $news['sort_order'],
                                'href' => $this->url->link('news/news', 'news_id=' . $news['news_id'] . '&popup=1'),
                                'class' => 'link-popup iframe',
                            );
                        }
                    }

                    // Comparison function
                    function cmp($a, $b) {
                        if ($a['sort_order'] == $b['sort_order']) {
                            return 0;
                        }
                        return ($a['sort_order'] < $b['sort_order']) ? -1 : 1;
                    }

                    // Sort and print the resulting array
                    uasort($childs, 'cmp');

                    $popup = array();
                    if (!empty($this->session->data['popup'])) {
                        $popup = $this->session->data['popup'];
                        unset($this->session->data['popup']);
                    }

                    $this->data['category'] = array(
                        'name' => $category_data['name'],
                        'childs' => $childs,
                        'popup' => $popup,
                    );

                    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/news/news_category.tpl')) {
                        $this->template = $this->config->get('config_template') . '/template/news/news_category.tpl';
                    } else {
                        $this->template = 'default/template/news/news_category.tpl';
                    }

                    $this->children = array(
                        'common/footer',
                        'common/header'
                    );
                }

                $this->response->setOutput($this->render());
			}
		}
	}
}
?>