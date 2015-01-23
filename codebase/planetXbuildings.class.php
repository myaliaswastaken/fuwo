<?php
		
	class planetXbuildings {
		
		private $iPlanetID;
		private $iBuildingID;
		private $iLevel;
		
		public function __construct($iPlanetId, $iBuildingID, $iLevel = 0)
		{
			// Füllen der Daten 
			if ($iPlanetId > 0 && $iBuildingID > 0)
			{
				$oDB = new DB();
				$aResult = $oDB->query("SELECT * FROM planetXbuildings where planet_id = $iPlanetId and building_id = $iBuildingID ", 'numeric');
				if (empty($aResult))
				{
					$oDB->query("INSERT INTO planetXbuildings (planet_id, building_id, level) values ($iPlanetId, $iBuildingID, $iLevel) ");
					$this->iPlanetID = $iPlanetId;
					$this->iBuildingID = $iBuildingID;
					$this->iLevel = $iLevel;
				}
				else
				{
					$this->iPlanetID = $aResult[0][0];
					$this->iBuildingID = $aResult[0][1];
					$this->iLevel = $aResult[0][2];
				}
				$oDB->close();
			}
		}
			

		/*
		 * START get and set methodes
		 */
		public function getPlanetID()
		{
			return $this->iPlanetID;
		}
		
		public function getBuildingID()
		{
			return $this->iBuildingID;
		}
	
		public function getLevel()
		{
			return $this->iLevel;
		}
		
		public function setLevel($Value)
		{
			$this->iLevel = $Value;
		}
		/*
		 * END get and set methodes
		 */

		public function update()
		{
			$bRet = true;
			$oDB = new DB();
			try
			{
				$oDB->query('	UPDATE planetXbuildings 
								SET 
										level = '.$this->iLevel.' 
								WHERE 	planet_id = '.$this->iPlanetID.' 
									AND	building_id = '.$this->iBuildingID);
			}
			catch(Exception $e)
			{
				$oDB->rollback();
				echo $e->getMessage();
				$bRet = false;
			};
			$oDB->close();
			return $bRet;
		}
	}
?>