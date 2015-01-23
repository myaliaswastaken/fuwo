<?php
		
	class systems {
		
		private $iID;
		private $iPosition;
		private $sName;
		private $iPlanets;
		
		public function __construct($id)
		{
			$this->iID = 0;
			$this->iPosition = 0;
			$this->sName = '';
			$this->iPlanets = 0;
			
			// Füllen der Daten 
			if ($id > 0)
			{
				$oDB = new DB();
				$aResult = $oDB->query("SELECT * FROM solar_system where id = $id", 'assoc');
				if (empty($aResult)) return false;
				else
				{
					$this->iID = $aResult[0]['id'];
					$this->iPosition = $aResult[0]['position'];
					$this->sName = $aResult[0]['name'];
					$this->iPlanets = $aResult[0]['planets'];
				}
			}
		}
		
		public function getID()
		{
			return $this->iID;
		}
		
		public function getPosition()
		{
			return $this->iPosition;
		}
		
		public function getName()
		{
			return $this->sName;
		}
	
		public function getPlanetsCount()
		{
			return $this->iPlanets;
		}
			
		public function setName($sName)
		{
			$this->sName = $sName;
		}
				
		public function update()
		{		
			$oDB = new DB();
			try
			{
				$oDB->query('	UPDATE solar_system 
								SET 
									name = \''.$this->sName.'\'
								WHERE id = '.$this->iID);
			}
			catch(Exception $e)
			{
				$oDB->rollback();
				echo $e->getMessage();
			};
			$oDB->close();
		}
		
		/*
		 *
		 */
		public function getPlanetsForSystem()
		{
			$aRet = array();
			if ($this->iID > 0)
			{
				$oDB = new DB();
				$aResult = $oDB->query('SELECT pos, owner_id, name FROM planet where system_id = '.$this->iID, 'numeric');
				if (!empty($aResult))
				{
					include_once "user.class.php";
					foreach ($aResult as $fvValue)
					{
						$aRet[$fvValue[0]] = array(user::getPlayerNameByID($fvValue[1]),$fvValue[2]);
					}
				}
			}
			return $aRet;
		}
		
		public function getPlanetObject($iPlanetPosition)
		{
			$oRet = null;
			if ($iPlanetPosition > 0)
			{
				include_once 'codebase/planet.class.php';
				$oRet = planet::getPlanetByCoords(1,$this->iPosition,$iPlanetPosition);
			}
			return $oRet;
		}
	}
?>