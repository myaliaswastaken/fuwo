<?php
		
	class user {
		
		private $iPlayerID;
		private $sMail;
		private $sName;
		private $sPassword;
		
		public function __construct($id)
		{
			$this->iPlayerID = 0;
			$this->sMail = '';
			$this->sName = '';
			$this->sPassword = '';
			
			//Get user information from database
			//Mandatory informations is: id, email, name, password
			if ($id > 0)
			{
				$oDB = new DB();
				$aResult = $oDB->query("SELECT * FROM user where id = $id", 'assoc');
				if (empty($aResult)) return false;
				else
				{
					$this->iPlayerID = $aResult[0]['id'];
					$this->sMail = $aResult[0]['mail'];
					$this->sName = $aResult[0]['name'];
					$this->sPassword = $aResult[0]['password'];
				}
			}
		}
		
		static function getPlayerByLogin($sName, $sPassword)
		{			
			$oDB = new DB();
			$aResult = $oDB->query("SELECT id FROM user where name LIKE '$sName' and password = '$sPassword'", 'assoc');
			if (!empty($aResult) && count($aResult) == 1 && isset($aResult[0]))
			{
				foreach($aResult as $fvValue)
				{
					$oTmp = new user($fvValue['id']);
					$oDB->close();
					return $oTmp;
				}
			}
			return false;
		}
		
		public function getPlayerID()
		{
			return $this->iPlayerID;
		}
		
		public function getName()
		{
			return $this->sName;
		}
	
		public function setPlayerID($iID)
		{
			$this->iPlayerID = $iID;
		}
			
		public function setName($sName)
		{
			$this->sName = $sName;
		}
		
		/**
		 * 
		 * @param int $iPlanetID 		if an ID is set, only this planet will be returned
		 * @return array of objects		all planets from the player
		 */
		public function getPlayerPlanets($iPlanetID = 0)
		{
			$aRet = array();
			$oDB = new DB();
			$sPlantID = '';
			$iPlanetID > 0 ? $sPlantID = ' AND id = '.$iPlanetID : $sPlantID = '';
			$aResult = $oDB->query('SELECT id FROM planet where owner_id = '.$this->iPlayerID.' '.$sPlantID, 'numeric');
			if (!empty($aResult))
			{
				include_once "planet.class.php";
				foreach ($aResult as $fvValue)
				{
					$aRet[$fvValue[0]] = new planet($fvValue[0]);
				}
			}
			return $aRet;
		}
		
		static function getPlayerNameByID($iID)
		{			
			$sRet = '';
			if ($iID > 0)
			{
				$oDB = new DB();
				$aResult = $oDB->query("SELECT name FROM user where id = '$iID'", 'assoc');
				if (!empty($aResult)) $sRet = $aResult[0]['name'];
				$oDB->close();
			}
			return $sRet;
		}
	}
?>