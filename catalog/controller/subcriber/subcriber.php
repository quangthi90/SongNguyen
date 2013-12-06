<?php
class ControllerSubcriberSubcriber extends Controller {
	public function index() {
		$json = array();

		if (!empty($this->request->post['reg-email']) && $this->isValidateEmail($this->request->post['reg-email'])) {
			$this->load->model('subcriber/subcriber');

			$this->model_subcriber_subcriber->addSubcriber($this->request->post['reg-email']);

			$this->send($this->request->post['reg-email']);

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

	private function send($email) {

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$logo = HTTP_SERVER . 'image/' . $this->config->get('config_logo');
		} else {
			$logo = '';
		}

		$mail_protocol 	= $this->config->get('config_mail_protocol');
		$mail_parameter = $this->config->get('config_mail_parameter');
		$mail_hostname 	= $this->config->get('config_smtp_host');
		$mail_username 	= $this->config->get('config_smtp_username');
		$mail_password 	= $this->config->get('config_smtp_password');
		$mail_port 		= $this->config->get('config_smtp_port');
		$mail_timeout 	= $this->config->get('config_smtp_timeout');	
		$mail_from 		= $this->config->get('config_email');
		$mail_sender 	= $this->config->get('config_name');

		$subject = 'Thank you for your Subscription!';
		$link_1 = HTTP_SERVER;
		$link_2 = HTTP_SERVER;
		$link_3 = HTTP_SERVER;
		$link_4 = HTTP_SERVER;
		$link_5 = HTTP_SERVER;
		$img_1_300x95 = $logo;
		$img_2_640x425 = HTTP_SERVER . 'image/data/thanks-subscribe-1.jpg';
		$img_3_22x22 = HTTP_SERVER . 'image/data/thanks-subscribe-logo-1.png';
		$img_4_22x22 = HTTP_SERVER . 'image/data/thanks-subscribe-logo-2.jpg';
		$img_5_22x22 = HTTP_SERVER . 'image/data/thanks-subscribe-logo-4.png';		
		$img_6_556x21 = HTTP_SERVER . 'image/data/thanks-subscribe-shadow.png';
		$message_1 = 'Thank you for subscribing to our e-newsletter service!';
		$message_2 = 'Cám ơn quý khách!';
		$message_3 = 'Xin chân thành cám ơn quý khách đã đăng ký tham gia cập nhật thông tin du học thường xuyên từ Công ty tư vấn du học Song Nguyên. Chúng tôi hy vọng sẽ mang đến cho quý khách các thông tin bổ ích về du học, cập nhật các lịch diễn ra hội thảo hoặc các chương trình học bổng. Chúng tôi rất mong quý khách chia sẻ với bạn bè và người thân của mình về dịch vụ của chúng tôi. Xin cảm ơn!<br/><br/>We rely on word of mouth referrals for much of our business. If you enjoyed your experience with us, please tell your friends by sharing this email on your social networks or forwarding to their email address. We appreciate your support!';
		$message_4 = 'SHARE';
		$message_5 = 'STAY CONNECTED';
		$message_6 = 'Song Nguyen Education Services * Contact us at (08) 5410 5770';
		$message_7 = 'Your gateway to world\'s renowned education institutions! ';
										
		$message  = '<html dir="ltr" lang="en">' . "\n";
		$message .= '  <head>' . "\n";
		$message .= '    <title>' . $subject . '</title>' . "\n";
		$message .= '    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
		$message .= '  </head>' . "\n";
		$message .= '  <body>' . "\n";
		$message .= '    <div style="width:640px;margin:0 auto;">' . "\n";
		$message .= '      <div style="width:640px;">' . "\n";
		$message .= '        <div style="width:470px;margin-left:170px;margin-top:34px;">' . "\n";
		$message .= '          <a href="' . $link_1 . '">' . "\n";
		$message .= '            <img src="' . $img_1_300x95 .'" width="300" height="95"/>' . "\n";
		$message .= '          </a>' . "\n";
		$message .= '        </div>' . "\n";
		$message .= '        <div style="width:640px;margin-top:28px;background:#cd0216;">' . "\n";
		$message .= '          <i style="color:#ffffff;font-family:Arial,Helvetica,sans-serif;font-size:14pt;line-height:44px;margin-left:20px;">' . $message_1 . '</i>' . "\n";
		$message .= '        </div>' . "\n";
		$message .= '        <div style="width:640px;margin-top:8px;margin-bottom:-3px;">' . "\n";
		$message .= '          <img src="' . $img_2_640x425 .'" width="640" height="425"/>' . "\n";
		$message .= '        </div>' . "\n";
		$message .= '      </div>' . "\n";
		$message .= '      <div style="width:638px;border-left:solid 1px gray;border-right:solid 1px gray;border-bottom:solid 1px gray;">' . "\n";
		$message .= '        <div style="width:638px;">' . "\n";
		$message .= '          <div style="width:528px;padding:28px 40px 0px 40px;">' . "\n";
		$message .= '            <b style="font-size:18pt;font-family:Arial,Helvetica,sans-serif;color:rgb(205,2,22);line-height:50px;">' . $message_2 . '</b>' . "\n";
		$message .= '          </div>' . "\n";
		$message .= '          <div style="width:558px;color:#767a7a;font-family:Arial,Helvetica,sans-serif;font-size:10pt;padding:8px 40px 8px 40px;">' . "\n";
		$message .= $message_3;
		$message .= '          </div>' . "\n";
		$message .= '        </div>' . "\n";
		$message .= '        <div style="width:638px;padding:8px 0 28px 0;">' . "\n";
		$message .= '        	<a href="' . $link_2 . '" style="padding:10px 39px 9px 40px;font-style:italic;color:#ffffff;font-family:Arial,Helvetica,sans-serif;font-weight:bold;text-decoration:none;font-size:12pt;">' . $message_4 . '</a>' . "\n";
		$message .= '        </div>' . "\n";
		$message .= '        <div style="width:638px;border-top:solid 5px #cd0216;padding:18px 0px 14px 0px;text-align:center;">' . "\n";
		$message .= '          <b style="color: #625467;font-family: Arial,Helvetica,sans-serif;font-size: 8pt;"><i>' . $message_5 . '</i></b><br/><br/>' . "\n";
		$message .= '          <a href="' . $link_3 . '"><img src="' . $img_3_22x22 . '" height="22" width="22" alt="" title=""></a>' . "\n";
		$message .= '          <a href="' . $link_4 . '"><img src="' . $img_4_22x22 . '" height="22" width="22" alt="" title=""></a>' . "\n";
		$message .= '          <a href="' . $link_5 . '"><img src="' . $img_5_22x22 . '" height="22" width="22" alt="View our profile on LinkedIn" title="View our profile on LinkedIn"></a>' . "\n";
		$message .= '        </div>' . "\n";
		$message .= '      </div>' . "\n";
		$message .= '      <div style="width:640px;">' . "\n";
		$message .= '        <div style="width:598px;margin-left:42px;">' . "\n";
		$message .= '          <img src="' . $img_6_556x21 . '" width="556" height="21"/>' . "\n";
		$message .= '        </div>' . "\n";
		$message .= '        <div style="width:640px;">' . "\n";
		$message .= '          <b style="color: #505050;font-family: Arial,Helvetica,sans-serif;font-size: 12pt;">' . $message_6 . '</b><br/>' . "\n";
		$message .= '          <i style="color: #505050;font-family: Arial,Helvetica,sans-serif;font-size: 8pt;">' . $message_7 . '</i><br/>' . "\n";
		$message .= '        </div>' . "\n";
		$message .= '      </div>' . "\n";
		$message .= '    </div>' . "\n";
		$message .= '  </body>' . "\n";
		$message .= '</html>' . "\n";
					
		$mail = new Mail();	
		$mail->protocol = $mail_protocol;
		$mail->parameter = $mail_parameter;
		$mail->hostname = $mail_hostname;
		$mail->username = $mail_username;
		$mail->password = $mail_password;
		$mail->port = $mail_port;
		$mail->timeout = $mail_timeout;				
		$mail->setTo($email);
		$mail->setFrom($mail_from);
		$mail->setSender($mail_sender);
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));	
		$mail->setHtml($message);
		$mail->send();
	}
}
?>