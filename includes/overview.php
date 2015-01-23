<?php

	$sBody.= file_get_contents('templates/overview.html');
	$sPlanetOverview = '';
	foreach ($oUser->getPlayerPlanets() as $fvPlanetObject)
	{
		$sTmp = file_get_contents("templates/overview_planets.html");
		$sTmp = str_replace('__coords__', '<a href="?site=buildings&pID='.$fvPlanetObject->getID().'">'.$fvPlanetObject->getPlanetCoords().'</a>', $sTmp);
		$sTmp = str_replace('__name__', '<span onclick="setShow(\'PlanetNameChange'.$fvPlanetObject->getID().'\'); setHide(\'PlanetName'.$fvPlanetObject->getID().'\')">'.$fvPlanetObject->getName().'</span>', $sTmp);
		$sTmp = str_replace('__inputName__', $fvPlanetObject->getName(), $sTmp);
		$sTmp = str_replace('__divName__', $fvPlanetObject->getID(), $sTmp);
		$sTmp = str_replace('__coal__', $fvPlanetObject->getCoal(), $sTmp);
		$sTmp = str_replace('__ore__', $fvPlanetObject->getOre(), $sTmp);
		$sTmp = str_replace('__nobleMetal__', $fvPlanetObject->getNobleMetal(), $sTmp);
		$sTmp = str_replace('__oil__', $fvPlanetObject->getOil(), $sTmp);
		$sTmp = str_replace('__water__', $fvPlanetObject->getWater(), $sTmp);
		$sTmp = str_replace('__buildings__', '<a href="?site=buildings&pID='.$fvPlanetObject->getID().'">Kein Auftrag</a>', $sTmp);
		$sTmp = str_replace('__shipyard__', 'Kein Auftrag', $sTmp);
		$sPlanetOverview.= $sTmp;
	}
	$sBody = str_replace('__planets__', $sPlanetOverview, $sBody);
	
?>