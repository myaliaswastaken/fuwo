<?php
	include_once 'codebase/buildings.class.php';
	
	$sBody.= file_get_contents('templates/content.html');
	$sBody = str_replace('__content_title__', 'Geb&auml;ude &Uuml;bersicht', $sBody);
	$sBody = str_replace('__form_name__', 'buildingsForm', $sBody); 
	$sBody = str_replace('__hidden_form_value__', 'buildings', $sBody);
	$aAllBuildings = buildings::getAllBuildings();
	$sTmpBody = '';
	$i = 0;
	
	foreach ($aAllBuildings as $fkID => $fvValues)
	{	
		/*
		 *	Zählen der Elemente in einer Zeile
		 */
		if ($i == 3 || $i == 0)
		{
			$sTmpBody.= '<div style="width:740px; margin: 5px 5px 5px 15px;">';
			$i = 1;
		}
		else $i++;
		
		$sTmpBody.= file_get_contents('templates/content_box.html');
		
		/*
		 *	Titel
		 */
		$sTmpBody = str_replace('__title__', $fvValues[0].' Stufe: '.$oPlanet->getBuildingLevelForBuildingID($fkID) , $sTmpBody);
		
		/*
		 *	Bild
		 */
		if(empty($fvValues[1]))
		{
			$sTmpBody = str_replace('__image__', 'templates/pictures/no_image.jpg', $sTmpBody);
			$sTmpBody = str_replace('__image_alt__', 'Test', $sTmpBody);
		}
		else
		{
			$sTmpBody = str_replace('__image__', $fvValues[1], $sTmpBody);
			$sTmpBody = str_replace('__image_alt__', 'Test', $sTmpBody);
		}
		
		/*
		 *	Beschreibung
		 */
		$sTmpBody = str_replace('__description__', $fvValues[2], $sTmpBody);
		
		/*
		 *	Upgrade	
		 */
		$sTmp = '<input type="submit" value="'; 
		if ($oPlanet->getBuildingLevelForBuildingID($fkID) == 0) $sTmp.= 'bauen';
		else $sTmp.= 'ausbauen';
		$sTmp.= '" name=buildingID['.$fkID.']">';
		$sTmpBody = str_replace('__upgradeButton__', $sTmp, $sTmpBody);
		
		/*
		 * Zeilenende beim 3. Element
		 */
		if ($i == 3) $sTmpBody.= '<div style="clear: both; font-size:0px; line-height:0px; height:0px;"></div></div>';
	}
	
	/*
	 *	Wenn nicht 3 Elemente in der Zeile sind sind, Zeile abschließen
	 */
	if ($i != 3) $sTmpBody.= '<div style="clear: both; font-size:0px; line-height:0px; height:0px;"></div></div>';
	
	
	$sBody = str_replace('__content_body__', $sTmpBody, $sBody);
	
	
	
?>