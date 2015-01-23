<?php
		
	class research {
		
		private $iID;
		private $sName;
		private $sDescription;
		private $sImage;
		
		public function __construct($id)
		{
			// Füllen der Daten 
			if ($id > 0)
			{
				$oDB = new DB();
				$aResult = $oDB->query("SELECT * FROM research where id = $id", 'numeric');
				if (empty($aResult))
				{
					$oDB->close();
					return false;
				}
				else
				{
					$this->iID = $aResult[0][0];
					$this->sName = $aResult[0][1];
					$this->sImage = $aResult[0][2];
					$this->sDescription = $aResult[0][3];
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
		
		public function getName()
		{
			return $this->sName;
		}
	
		public function getImage()
		{
			return $this->sImage;
		}
		
		public function getDescription()
		{
			return $this->sDescription;
		}
		
		public function setName($Value)
		{
			$this->sName = $Value;
		}
		
		public function setImage($Value)
		{
			$this->sImage = $Value;
		}
	
		public function setDescription($Value)
		{
			$this->sDescription = $Value;
		}
		/*
		 * END get and set methodes
		 */

		static function getAllResearch()
		{			
			$oDB = new DB();
			$aRetData = array();
			try
			{
				$aResearcData = $oDB->query("SELECT * FROM research where 1", 'numeric');
				if (!empty($aResearcData))
				{
					foreach($aResearcData as $fvValues)
					{
						$aRetData[$fvValues[0]] = array($fvValues[1], $fvValues[2], $fvValues[3]);
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
	}
?>