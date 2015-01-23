<?php
	$sBody = file_get_contents("templates/resBar.html");

	// Keine Ress anzeige weil kein planet ausgewählt ist
	if ($sActualSite == '')
	{
		$sBody = str_replace('__coal__', '&nbsp;', $sBody);
		$sBody = str_replace('__ore__', '&nbsp;', $sBody);
		$sBody = str_replace('__nobleMetall__', '&nbsp;', $sBody);
		$sBody = str_replace('__oil__', '&nbsp;', $sBody);
		$sBody = str_replace('__water__', '&nbsp;', $sBody);
	}
	else 
	{
		$sBody = str_replace('__coal__', 'Kohle: '.$oPlanet->getCoal(), $sBody);
		$sBody = str_replace('__ore__', 'Erze: '.$oPlanet->getOre(), $sBody);
		$sBody = str_replace('__nobleMetall__', 'Edelmetalle: '.$oPlanet->getNobleMetal(), $sBody);
		$sBody = str_replace('__oil__', '&Ouml;l: '.$oPlanet->getOil(), $sBody);
		$sBody = str_replace('__water__', 'Wasser: '.$oPlanet->getWater(), $sBody);
	}
?>