<?php
		
	class building_costs {
		
		private $iBuildingID;
		private $iLevel;
		private $iCoal;
		private $iOre;
		private $iOil;
		private $iWater;
		private $iNobleMetal;
		private $iBuildingTime;
		
		public function __construct($iBuildingID, $iLevel)
		{
			// Füllen der Daten 
			if ($iBuildingID > 0 && $iLevel > 0)
			{
				$oDB = new DB();
				$aResult = $oDB->query("SELECT * FROM building_costs where building_id = $iBuildingID and level = $iLevel ", 'numeric');
				$oDB->close();
				if (empty($aResult)) return false;
				else
				{
					$this->iBuildingID = $aResult[0][0];
					$this->iLevel = $aResult[0][1];
					$this->iCoal = $aResult[0][2];
					$this->iOre = $aResult[0][3];
					$this->iOil = $aResult[0][4];
					$this->iWater = $aResult[0][5];
					$this->iNobleMetal = $aResult[0][6];
					$this->iBuildingTime = $aResult[0][7];
				}		
			}
		}
			

		/*
		 * START get and set methodes
		 */
		public function getBuildingID()
		{
			return $this->iBuildingID;
		}
		
		public function getLevel()
		{
			return $this->iLevel;
		}
		
		public function getCoal()
		{
			return $this->iCoal;
		}
		
		public function getOre()
		{
			return $this->iOre;
		}
		
		public function getOil()
		{
			return $this->iOil;
		}
		
		public function getWater()
		{
			return $this->iWater;
		}
		
		public function getNobleMetal()
		{
			return $this->iNobleMetal;
		}
		
		public function getBuildingTime()
		{
			return $this->iBuildingTime;
		}
		
		/*
		 * END get and set methodes
		 */
		 
		 
	}
?>