<?php
		
	class production {
		
		private $iBuildingID;
		private $iLevel;
		private $iProduction;
		
		public function __construct($iBuildingID, $iLevel)
		{
			// Füllen der Daten 
			if ($iBuildingID > 0 && $iLevel > 0)
			{
				$oDB = new DB();
				$aResult = $oDB->query("SELECT * FROM production where building_id = $iBuildingID and level = $iLevel ", 'numeric');
				$oDB->close();
				if (empty($aResult)) return false;
				else
				{
					$this->iBuildingID = $aResult[0][0];
					$this->iLevel = $aResult[0][1];
					$this->iProduction = $aResult[0][2];
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
		
		public function getProduction()
		{
			return $this->iProduction;
		}
		/*
		 * END get and set methodes
		 */
		 
		static function getProductionForBuilding($iBuildingID, $iLevel)
		{
			if ($iBuildingID > 0 && $iLevel > 0)
			{
				$oDB = new DB();
				$aResult = $oDB->query("SELECT per_second FROM production where building_id = $iBuildingID and level = $iLevel ", 'numeric');
				$oDB->close();
				if (empty($aResult)) return false;
				else
				{
					return $aResult[0][0];
				}		
			}
		}
		 
	}
?>