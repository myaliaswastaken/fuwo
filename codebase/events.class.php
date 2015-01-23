<?php
		
	class events {
		
		private $iID;
		private $iPlanet_ID;
		private $iPrio;
		private $iTime;
		private $eType;
		private $iCount;
		
		public function __construct($id)
		{
			// Füllen der Daten 
			if ($id > 0)
			{
				$oDB = new DB();
				$aResult = $oDB->query("SELECT * FROM events where id = $id", 'numeric');
				if (empty($aResult))
				{
					$oDB->close();
					return false;
				}
				else
				{
					$this->iID = $aResult[0][0];
					$this->iPlanet_ID = $aResult[0][1];
					$this->iPrio = $aResult[0][2];
					$this->iTime = $aResult[0][3];
					$this->eType = $aResult[0][4];
					$this->iCount = $aResult[0][5];
				}
				$oDB->close();
			}
		}
			

		/*
		 * START get and set methodes
		 */
		public function getID()
		{
			return $this->iID;
		}
		
		public function getPlanetID()
		{
			return $this->iPlanet_ID;
		}
	
		public function getPrio()
		{
			return $this->iPrio;
		}
		
		public function getTime()
		{
			return $this->iTime;
		}
		
		public function getType()
		{
			return $this->eType;
		}
		
		public function getCount()
		{
			return $this->iCount;
		}
		
		public function sePlanetID($Value)
		{
			$this->iPlanet_ID = $Value;
		}
		
		public function setPrio($Value)
		{
			$this->iPrio = $Value;
		}
	
		public function setTime($Value)
		{
			$this->iTime = $Value;
		}
		
		public function setType($Value)
		{
			$this->eType = $Value;
		}
	
		public function setCount($Value)
		{
			$this->iCount = $Value;
		}	
		/*
		 * END get and set methodes
		 */

		
	}
?>