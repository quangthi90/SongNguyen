<?php
class ControllerSubcriberSubcriber extends Controller {
	public function index() {
		$json = array();

		if (!empty($this->request->post['reg-email']) && $this->isValidateEmail($this->request->post['reg-email'])) {
			$this->load->model('subcriber/subcriber');

			$this->model_subcriber_subcriber->addSubcriber($this->request->post['reg-email']);


			$json['message'] = 'ok';
		}

		$this->response->setOutput(json_encode($json));
	}

	private function isValidateEmail($email) {
		if (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
			return false;
		}else {
			return true;
		}
	}
}
?>