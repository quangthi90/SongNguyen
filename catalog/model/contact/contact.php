<?php
class ModelContactContact extends Model {
	public function addContact($data) {
		if (!isset($data['phone'])) {
			$data['phone'] = '';
		}
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "contact SET status = '1', email = '" . $this->db->escape($data['email']) . "', name = '" . $this->db->escape($data['name']) . "', content = '" . $this->db->escape($data['enquiry']) . "', phone = '" . $this->db->escape($data['phone']) . "', date_posted = NOW()");
	}	
	
	public function getContact($contact_id) {
		$sql = "SELECT c.id AS contact_id, c.email AS email, c.name AS name, c.phone AS phone, c.content AS content, c.date_posted AS date_posted, c.status AS status FROM " . DB_PREFIX . "contact c WHERE c.id ='" . (int)$contact_id . "'";
				
		return $this->db->query($sql)->row;
	}
}
?>
