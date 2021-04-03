<?php

    namespace App\Models;

use App\Controllers\P;
use CodeIgniter\Database\ConnectionInterface;

	class view_paste
	{
		function __construct(ConnectionInterface &$db)
        {
            $this->db = &$db;
        }

		public function isLarge($link)
		{
			$query = $this->db->query("SELECT `large` FROM `pastes` WHERE `link`='$link'");
			$result = $query->getResultArray();
			if($result[0]['large'] == 1)
				return true;
			return false;
		}

		public function hasPassword($link)
		{
			$query = $this->db->query("SELECT `password` FROM `pastes` WHERE `link`='$link' AND `password` IS NOT NULL");
			if($query->getNumRows() <= 0)
				return false;
			return true;
		}

		public function verifyPassword($link, $password)
		{
			$query = $this->db->query("SELECT `password` FROM `pastes` WHERE `link`='$link'");
			if($query->getNumRows() <= 0)
				return false;
			$result = $query->getResultArray();
			if(password_verify($password, $result[0]['password']))
				return true;
			return false;
		}

		public function getPaste($link)
		{
			$query = $this->db->query("SELECT `paste` FROM `pastes` WHERE `link`='$link'");
			if($query->getNumRows() <= 0)
				return false;
			$result = $query->getResultArray();
			return $result[0]['paste'];
		}

		public function getTitle($link)
		{
			$query = $this->db->query("SELECT `title` FROM `pastes` WHERE `link`='$link'");
			if($query->getNumRows() <= 0)
				return false;
			$result = $query->getResultArray();
			return $result[0]['title'];
		}

		public function getViews($link)
		{
			$query = $this->db->query("SELECT `views` FROM `pastes` WHERE `link`='$link'");
			$result = $query->getResultArray();
			return $result[0]['views'];
		}

		public function updateViews($link)
		{
			$sql = "UPDATE `pastes` SET `views`=views+1 WHERE link='$link'";
			if($this->db->query($sql))
				return true;
			else
				return false;
		}

		public function getAuthor($link)
		{
			$query = $this->db->query("SELECT `uid` FROM `pastes` WHERE `link`='$link'");
			$result = $query->getResultArray();
			if($result[0]['uid'] == 0)
				return "Anonymous";
			$query = $this->db->query("SELECT `username` FROM `auth` WHERE `uid`=$result[0]['uid']");
			$result = $query->getResultArray();
			return $result[0]['username'];
		}
	}