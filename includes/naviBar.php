<?php
	$aContent = array(
		'__NaviBarPlanetNameContent__' => $oPlanet->getPlanetCoords().' '.$oPlanet->getName(),
		'__NaviBarBuildingsContent__' => '<a href="?site=buildings&pID='.$oPlanet->getID().'">Geb&auml;ude</a>',
		'__NaviBarResearchContent__' => '<a href="?site=research&pID='.$oPlanet->getID().'">Forschung</a>',
		'__NaviBarShipyardContent__' => 'Schiffswerft',
		'__NaviBarTradeCenterContent__' => 'Handelszentrum',
		'__NaviBarRankingContent__' => 'Rangliste',
		'__NaviBarSystemContent__' =>  '<a href="?site=universe&sID='.$oPlanet->getSystemID().'">Zum System</a>',
		'__NaviBarUniverseContent__' => '<a href="?site=universe&sID=1">Zum Universum</a>',
		'__NaviBarUebersichtContent__' => '<a href="?site=1">zur&uuml;ck zur &Uuml;bersicht</a>'
	);
	
	$aMarkedLinks = array(
		'__NaviBarBuildings__',
		'__NaviBarResearch__',
		'__NaviBarShipyard__',
		'__NaviBarTradeCenter__',
		'__NaviBarRanking__',
		'__NaviBarSystem__',
		'__NaviBarUniverse__'
	);
	
	$sBody.= file_get_contents("templates/naviBar.html");
	
	//Markieren der aktuellen seite
	foreach ($aMarkedLinks as $fvKey)
	{
		if ($fvKey == $sActualSite) $sBody = str_replace($fvKey, 'border:1px solid black;', $sBody);
		else $sBody = str_replace($fvKey, '', $sBody);
	}
	foreach ($aContent as $fkKey => $fvValue) $sBody = str_replace($fkKey, $fvValue, $sBody);
	
?>