<?php  
class ControllerCommonHome extends Controller {
	public function index() {
		$this->load->model('popup/popup');
		$popup_data = $this->model_popup_popup->getPopup();

		$popup = array();
		if (!empty($popup_data)) {
			$banners = array();
			if (!empty($popup_data['banner_id']) && $popup_data['type'] == 2) {
				$this->load->model('design/banner');
				$this->load->model('tool/image');
				$banner_data = $this->model_design_banner->getBanner($popup_data['banner_id']);
				$banners = array();
				if (!empty($banner_data)) {
					foreach ($banner_data as $banner) {
						if (file_exists(DIR_IMAGE . $banner['image'])) {
							$banner_image = $this->model_tool_image->resize($banner['image'], 850, 338);
						}else {
							$banner_image = $this->model_tool_image->resize('no_image.jpg', 850, 338);
						}

						$banners[] = array(
							'title' => $banner['title'],
							'image' => $banner_image,
							'href' => $banner['link'],
							);
					}
				}
			}

			$popup = array(
				'type' => $popup_data['type'],
				'title' => $popup_data['title'],
				'description' => $popup_data['description'],
				'content' => html_entity_decode($popup_data['content'], ENT_QUOTES, 'UTF-8'),
				'embbed' => html_entity_decode($popup_data['embbed'], ENT_QUOTES, 'UTF-8'),
				'banners' => $banners,
				);
		}

		$this->session->data['popup'] = $popup;

		header("Location: " . HTTP_SERVER . 'studying-abroad');

		exit();

		$this->document->setTitle($this->config->get('config_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));

		$this->data['heading_title'] = $this->config->get('config_title');
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$this->data['categoryImgUrl'] = $server . 'image/data/category';
		$this->data['introImgUrl'] = $server . 'image/data/intro';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
		} else {
			$this->template = 'default/template/common/home.tpl';
		}
		
		$this->children = array(
			'common/footer',
			'common/header'
		);
										
		$this->response->setOutput($this->render());
	}
}
?>