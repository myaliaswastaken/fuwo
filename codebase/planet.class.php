<?php
	include_once "codebase/planetXbuildings.class.php";	
	include_once "codebase/production.class.php";	

	class planet {
	
		private $iID;
		private $iUniverseID;
		private $iSystemID;
		private $iPos;
		private $iOwnerID;
		private $sName;
		private $iCoal;
		private $iOre;
		private $iWater;
		private $iOil;
		private $iNobleMetal;
		private $iUpdated ;	
		private $aPlanetBuildings;
		
		public function __construct($id)
		{
			// Füllen der Daten 
			if ($id > 0)
			{
				$oDB = new DB();
				$aResult = $oDB->query("SELECT * FROM planet where id = $id", 'numeric');
				if (empty($aResult))
				{
					$oDB->close();
					return false;
				}
				else
				{
					$this->iID = $aResult[0][0];
					$this->iUniverseID = $aResult[0][1];
					$this->iSystemID = $aResult[0][2];
					$this->iPos = $aResult[0][3];
					$this->iOwnerID = $aResult[0][4];
					$this->sName = $aResult[0][5];
					$this->iCoal = $aResult[0][6];
					$this->iOre = $aResult[0][7];
					$this->iWater = $aResult[0][8];
					$this->iOil = $aResult[0][9];
					$this->iNobleMetal = $aResult[0][10];
					$this->iUpdated = $aResult[0][11];
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
		
		public function getUniverseID()
		{
			return $this->iUniverseID;
		}
		
		public function getSystemID()
		{
			return $this->iSystemID;
		}
		
		public function getPos()
		{
			return $this->iPos;
		}
		
		public function getOwnerID()
		{
			return $this->iOwnerID;
		}
		
		public function getOwnerObject()
		{
			include_once "user.class.php";
			return new User($this->iOwnerID);
		}
		
		public function getName()
		{
			return $this->sName;
		}
	
		public function getCoal()
		{
			return $this->iCoal;
		}
	
		public function getOre()
		{
			return $this->iOre;
		}
	
		public function getWater()
		{
			return $this->iWater;
		}
	
		public function getOil()
		{
			return $this->iOil;
		}
	
		public function getNobleMetal()
		{
			return $this->iNobleMetal;
		}
	
		public function getUpdated()
		{
			return $this->iUpdated;
		}
	
		public function setUniverseID($Value)
		{
			$this->sUniverseID = $Value;
		}
		
		public function setSystemID($Value)
		{
			$this->iSystemID = $Value;
		}
		
		public function setPos($Value)
		{
			$this->iPos = $Value;
		}
		
		public function setOwnerID($Value)
		{
			$this->iOwnerID = $Value;
		}
	
		public function setName($Value)
		{
			$this->sName = $Value;
		}
		
		public function setCoal($Value)
		{
			$this->iCoal = $Value;
		}
	
		public function setOre($Value)
		{
			$this->iOre = $Value;
		}
	
		public function setWater($Value)
		{
			$this->iWater = $Value;
		}
	
		public function setOil($Value)
		{
			$this->iOil = $Value;
		}
	
		public function setNobleMetal($Value)
		{
			$this->iNobleMetal = $Value;
		}	
		
		public function setUpdated($Value)
		{
			$this->iUpdated = $Value;
		}	
		/*
		 * END get and set methodes
		 */

		 
		public function getPlanetCoords()
		{
			return $this->iUniverseID.':'.$this->iSystemID.':'.$this->iPos;
		}
		
		public function update()
		{		
// To Do: Res neu berechnung
			$this->iUpdated = time();
			$oDB = new DB();
			try
			{
				$oDB->query('	UPDATE planet 
								SET 
									universe_id = '.$this->iUniverseID.', 
									system_id = '.$this->iSystemID.', 
									pos = '.$this->iPos.', 
									owner_id = '.$this->iOwnerID.', 
									name = \''.$this->sName.'\', 
									coal = '.$this->iCoal.', 
									ore = '.$this->iOre.', 
									water = '.$this->iWater.', 
									oil = '.$this->iOil.',
									noble_metal = '.$this->iNobleMetal.',
									updated = '.$this->iUpdated.'
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
		 * key 		= building id
		 * value	= level
		 */
		public function getPlanetBuildings()
		{
			if (empty($this->aPlanetBuildings))
			{
				$oDB = new DB();
				$aRetData = array();
				try
				{
					$aPlanetData = $oDB->query("SELECT * FROM planetXbuildings where planet_id = ".$this->iID, 'numeric');
					if (!empty($aPlanetData))
					{
						foreach($aPlanetData as $fvValues)
						{
							$aRetData[$fvValues[1]] = $fvValues[2];
						}
					}
				}
				catch(Exception $e)
				{
					$oDB->rollback();
					echo $e->getMessage();
				};
				$oDB->close();
				return $aRetData;
			}
			else return $this->aPlanetBuildings;
		}
		
		/*
		 *	returns the level for the given building id
		 */
		public function getBuildingLevelForBuildingID($iBuildingID)
		{
			$aTmp = array();
			if (empty($this->aPlanetBuildings)) $aTmp = $this->getPlanetBuildings();
			else $aTmp = $this->aPlanetBuildings;
			
			if(isset($aTmp[$iBuildingID])) return $aTmp[$iBuildingID];
			else return 0;
		}
		
		/*
		 *	upgrades the building to the next level
		 *	returns true if success
		 */
		public function upgradeBuilding($iBuildingID)
		{
			$oPlanetXbuilding = new planetXbuildings($this->iID, $iBuildingID);
			$oPlanetXbuilding->setLevel($oPlanetXbuilding->getLevel() + 1);
			return $oPlanetXbuilding->update();
		}
		
		/*
		 *	update the resources from a planet
		 */
		public function updateResources()
		{
			$aPlanetBuildings = $this->getPlanetBuildings();

			$iTimeDif = time() - $this->getUpdated();
			for ($i = 2; $i < 7; $i++)
			{
				if (isset($aPlanetBuildings[$i]))
				{
					$iTmpProd = production::getProductionForBuilding($i,$aPlanetBuildings[$i]);
					switch($i)
					{
						case 2: 
							$iTmp = $this->getCoal();
							$this->setCoal($iTmp + ($iTmpProd * $iTimeDif));
							break;
						
						case 3: 
							$iTmp = $this->getOre();
							$this->setOre($iTmp + ($iTmpProd * $iTimeDif));
							break;
						
						case 4: 
							$iTmp = $this->getNobleMetal();
							$this->setNobleMetal($iTmp + ($iTmpProd * $iTimeDif));
							break;
						
						case 5: 
							$iTmp = $this->getWater();
							$this->setWater($iTmp + ($iTmpProd * $iTimeDif));
							break;
						
						case 6: 
							$iTmp = $this->getOil();
							$this->setOil($iTmp + ($iTmpProd * $iTimeDif));
							break;
							
					}
				}
			}
			$this->update();
		}
		
		static function getPlanetByCoords($iUniverseID = 1, $iSystemID, $iPosition)
		{			
			$oDB = new DB();
			$aResult = $oDB->query("SELECT id FROM planet where universe_id = $iUniverseID and system_id = $iSystemID and pos = $iPosition ", 'numeric');
			if (empty($aResult))
			{
				$oDB->close();
				return false;
			}
			else
			{
				$oDB->close();
				return new planet($aResult[0][0]);
			}
		}
	}
?>