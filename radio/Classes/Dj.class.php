<?php
	class Dj {
	    
        public static function create() {
            return new self();
        }
        
        	$this->request = Request::create();
        	$this->user = Autentification::create();

		public function handler() {
				$this->deleteDj();
			}
            if ($this->request->hasPostVar('dj') and $this->request->hasPostVar('djpass') and $user['admin'] == 1) {
				$this->insertDj();
			}

		public function getDjList() {
			return $this->db->getLines($query);

		public function getError() {
		    if (!empty($this->error)) {
			} else {

		public function insertDj() {
			$query = "SELECT * FROM `dj` ORDER BY `id`";
			foreach ($this->db->getLines($query) as $line) {
				if ($this->request->getPostVar('dj') == $line['dj']) {
					$this->error = "Такой пользователь уже есть";
				}
			}

			$admin = addslashes($this->request->getPostVar('admin'));
			$dj = addslashes($this->request->getPostVar('dj'));
			$password  = addslashes($this->request->getPostVar('djpass'));
			$description = addslashes($this->request->getPostVar('djdescription'));

			if (empty($this->error)) {
				$query="INSERT INTO `dj` ( `description` , `dj` , `password` ,`admin` )
					VALUES ('$description', '$dj','$password','$admin');";
				$this->db->queryNull($query);
			}

		public function deleteDj() {
			$query = "DELETE FROM `dj` WHERE `id` = ".$delete;
			$this->db->queryNull($query);
?>