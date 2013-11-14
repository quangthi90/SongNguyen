<?php
class ModelIntroIntro extends Model {
	public function getIntro() {
		$query = $this->db->query("SELECT DISTINCT i.id AS intro_id, i.name AS name, i.url AS url, i.status AS status FROM " . DB_PREFIX . "intro i WHERE i.status = '1'");
				
		return $query->row;
	}
}
?>
