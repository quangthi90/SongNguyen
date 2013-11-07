<?php
class ControllerNewsNewsCategory extends Controller {
	public function index() {
		if (empty($this->request->get['news_category_id'])) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
		}else {
			$this->load->model('news/news_category');

			$category_data = $this->model_news_news_category->getNewsCategory($this->request->get['news_category_id']);

			if (empty($category_data)) {
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

				//$this->data['categoryImgUrl'] = $server . 'image/data/category';
				//$this->data['introImgUrl'] = $server . 'image/data/intro';
				$category_child = $this->model_news_news_category->getNewsCategories(array(
					'start' => 0,
					'limit' => 20,
					'filter_parent_id' => $category_data['news_category_id'],
					'status' => 1,
					));
				$childs = array();
				$this->load->model('tool/image');
				if (!empty($category_child)) {
					foreach ($category_child as $child) {
						$child = $this->model_news_news_category->getNewsCategory($child['news_category_id']);
						if (!empty($child)) {
							if (file_exists(DIR_IMAGE . $child['primary_image'])) {
								$primary_image = $this->model_tool_image->resize($child['primary_image'], 190, 129);
							}else {
								$primary_image = $this->model_tool_image->resize('no_image.jpg', 190, 129);
							}

							if (file_exists(DIR_IMAGE . $child['second_image'])) {
								$second_image = $this->model_tool_image->resize($child['second_image'], 190, 129);
							}else {
								$second_image = $this->model_tool_image->resize('no_image.jpg', 190, 129);
							}

							$childs[] = array(
								'name' => $child['name'],
								'primary_image' => $primary_image,
								'second_image' => $second_image,
								'href' => $this->url->link('news/news_category', 'news_category_id=' . $child['news_category_id']),
								);
						}
					}
				}

				$this->load->model('popup/popup');
				$this->load->model('design/banner');
				$popup_data = $this->model_popup_popup->getPopup($category_data['popup_id']);

				$popup = array();
				if (!empty($popup_data)) {
					$banners = array();
					if (!empty($popup_data['banner_id'])) {
						$banner_data = $this->model_design_banner->getBanner($popup_data['banner_id']);
						if (!empty($banner_data)) {
							foreach ($banner_data as $banner) {
								if (file_exists($banner['image'])) {
									$banner_image = $this->model_tool_image->resize($banner['image'], 850, 338);
								}else {
									$banner_image = $this->model_tool_image->resize('no_image.jpg', 850, 338);
								}

								$banners = array(
									'title' => $banner['title'],
									'image' => $banner_image,
									);
							}
						}
					}

					$popup = array(
						'type' => $popup_data['type'],
						'title' => $popup_data['title'],
						'description' => $popup_data['description'],
						'content' => $popup_data['content'],
						'embbed' => $popup_data['embbed'],
						'banners' => $banners,
						);
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
			}
		}
		$this->children = array(
			'common/footer',
			'common/header'
		);
										
		$this->response->setOutput($this->render());

	}
}
?>