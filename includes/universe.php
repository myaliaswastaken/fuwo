<?php
	include_once 'codebase/systems.class.php';
	
	//$sBody.= file_get_contents("templates/universe.html");
	$sBody.= file_get_contents("templates/universe_planet.html");
	$oTmpSystem = new systems($aGetData['sID']);
	$aSystemPlanets = $oTmpSystem->getPlanetsForSystem();
	
	if ($aGetData['sID'] > 1) $sBody = str_replace('__SystemBack__', '<a href="?site=universe&sID='.($aGetData['sID']-1).'"><<</a>', $sBody);
	else $sBody = str_replace('__SystemBack__', '&nbsp;', $sBody);
	$sBody = str_replace('__SystemNummer__', $aGetData['sID'].' '.$oTmpSystem->getName(), $sBody);
	if ($aGetData['sID'] < 50) $sBody = str_replace('__SystemForward__', '<a href="?site=universe&sID='.($aGetData['sID']+1).'">>></a>', $sBody);
	else $sBody = str_replace('__SystemForward__', '&nbsp;', $sBody);
	
	$sSystemPlanets = '';
	for ($i = 1; $i <= $oTmpSystem->getPlanetsCount(); $i++)
	{
		$sTmp = file_get_contents("templates/universe_planet.html");
		$sTmp = str_replace('__PlanetenNr__', $i, $sTmp);
		if (isset($aSystemPlanets[$i]))
		{	
			if ($_SESSION['user']['playerName'] == $aSystemPlanets[$i][0]) $sTmp = str_replace('__PlanetenName__', '<a href="?site=buildings&pID='.$oTmpSystem->getPlanetObject($i)->getID().'">'.$aSystemPlanets[$i][1].'</a>', $sTmp);
			else $sTmp = str_replace('__PlanetenName__', $aSystemPlanets[$i][1], $sTmp);
			$sTmp = str_replace('__PlanetenBesitzer__', $aSystemPlanets[$i][0], $sTmp);
		}
		else
		{
			$sTmp = str_replace('__PlanetenName__', '&nbsp;', $sTmp);
			$sTmp = str_replace('__PlanetenBesitzer__', '&nbsp;', $sTmp);
		}
		$sSystemPlanets.= $sTmp;
	}
	$sBody = str_replace('__planets__', $sSystemPlanets, $sBody);
?>