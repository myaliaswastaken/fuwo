<?php

	include_once 'codebase/research.class.php';
	
	$sBody.= file_get_contents('templates/content.html');
	$sBody = str_replace('__content_title__', 'Forschungs &Uuml;bersicht', $sBody);
	
	$aAllBuildings = research::getAllResearch();
	
	$sTmp = '<div style="width:740px; margin: 5px 5px 5px 15px;">';
	$i = 0;
	foreach ($aAllBuildings as $fkID => $fvValues)
	{		
		if ($i == 3)
		{
			$sTmp.= '<div style="width:740px; margin: 5px 5px 5px 15px;">';
			$i = 1;
		}
		else $i++;
		
//		echo "<br/>$fkID | ".$fvValues[0]. ' | '.$fvValues[1]. ' | '.$fvValues[2]. ' | '.$i;
		$sTmp.= file_get_contents('templates/content_box.html');
		$sTmp = str_replace('__title__', $fvValues[0], $sTmp);
		if(empty($fvValues[2]))
		{
			$sTmp = str_replace('__image__', 'templates/pictures/no_image.jpg', $sTmp);
			$sTmp = str_replace('__image_alt__', 'no_image', $sTmp);
		}
		else
		{
			$sTmp = str_replace('__image__', $fvValues[2], $sTmp);
			$sTmp = str_replace('__image_alt__', 'Test', $sTmp);
		}
		$sTmp = str_replace('__description__', $fvValues[1], $sTmp);
		$sTmp = str_replace('__upgradeButton__', 'erforschen', $sTmp);
		
		if ($i == 3) $sTmp.= '<div style="clear: both; font-size:0px; line-height:0px; height:0px;"></div></div>';
	}
	if ($i != 3) $sTmp.= '<div style="clear: both; font-size:0px; line-height:0px; height:0px;"></div></div>';
	
	
	$sBody = str_replace('__content_body__', $sTmp, $sBody);
	
?>