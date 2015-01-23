<?php
	
	if ($aPostData['hiddenPlanetID'] > 0 && $aPostData['newName'] != '') 
	{
		include_once "codebase/planet.class.php";
		$oPlanet = new Planet($aPostData['hiddenPlanetID']);
		$oPlanet->setName($aPostData['newName']);
		$oPlanet->update();
	}
?>