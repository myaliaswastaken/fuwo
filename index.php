<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');	
	
	session_start();
	include_once "codebase/DB.class.php";
	include_once "codebase/EventSystem.class.php";
	$aPostData = $_POST;
	$aGetData = $_GET;

//var_dump($aPostData);
	$iPage = 0;
	if (isset($_SESSION['pageID'])) $iPage = $_SESSION['pageID'];
	if (isset($aGetData['pID']))
	{
		include_once "codebase/planet.class.php";
		$oPlanet = new Planet($aGetData['pID']);
		$oPlanet->updateResources();
	}
	if (isset($aGetData['site']))
	{
		switch ($aGetData['site'])
		{
			case 'buildings':
				if (isset($aGetData['pID']))
				{
					if ($oPlanet->getOwnerID() == $_SESSION['user']['playerID']) $iPage = 3;
					else echo '<h1><span style="color:#FF0000">Dir gehört der Planet nicht</span></h1>';
				}
				else echo '<h1><span style="color:#FF0000">Kein Planet ausgewählt</span></h1>';
				break;
			case 'research':
				$iPage = 4;
				break;
			case 'universe':
				$iPage = 6;
				break;
		}
	}
	
	/* 
	 * 1: New login
	 * 2: New planet
	 */
	if (isset($aPostData['hiddenFormID']) && $aPostData['hiddenFormID'] == 1) include "includes/login.php";
	elseif (isset($aPostData['hiddenFormID']) && $aPostData['hiddenFormID'] == 2) include "includes/newPlanetName.php";
	elseif (isset($aPostData['upgrade']) && $aPostData['upgrade'] == 'buildings') include "includes/building_upgrade.php";
	
	// Erstelle user object
	if (isset($_SESSION['user']['playerID']))
	{
		include_once "codebase/user.class.php";
		$oUser = new user($_SESSION['user']['playerID']);
	}
	
	// Ausloggen
	if (isset($aGetData['logout']) && $aGetData['logout'] == 1)
	{
		session_destroy();
		session_start();
		$iPage = 2;
	}
	// Session ist abgelaufen
	else if (($iPage > 0 || isset($aGetData['site'])) && !isset($_SESSION['user']['playerID']))
	{
		$iPage = 5;
	}
	
	
	/*
	 * 1: 		main page
	 * 2: 		logout
	 * 3:		buildings
	 * 4: 		research
	 * 5:		Logout wegen Session timeout
	 * 6:		Universum
	 * default:	Startpage
	 */
	switch ($iPage)
	{
		case 1:
			$sActualSite = '';
			include "includes/ressBar.php";
			//include "includes/naviBar.php";
			include "includes/overview.php";
			break;
		case 2:	
			$sBody = file_get_contents("templates/logout.html");
			break;
		case 3:	
			$sActualSite = '__NaviBarBuildings__';
			include "includes/ressBar.php";
			include "includes/naviBar.php";
			include "includes/buildings.php";
			break;
		case 4:	
			$sActualSite = '__NaviBarResearch__';
			include "includes/ressBar.php";
			include "includes/naviBar.php";
			include "includes/research.php";
			break;
		case 5:	
			$sBody = file_get_contents("templates/timeout_logout.html");
			break;
		case 6:	
			$sActualSite = '';
			include "includes/ressBar.php";
			//include "includes/naviBar.php";
			include "includes/universe.php";
			break;
		default:
			$sBody = file_get_contents("templates/startpage.html");
			if (isset($bLoginError) && $bLoginError) $sBody = str_replace('__LogInError__', 'Fehler beim einloggen', $sBody);
			else $sBody = str_replace('__LogInError__', '', $sBody);
			
	}	
		

?>


<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="author" content="Christian Walter">
		<title>YOLO Game</title>
		<script type="text/javascript" src="scripts/javascript_functions.js"></script>
		<link type="text/css" href="scripts/css/styles.css" rel="stylesheet" >
		<link type="text/css" href="scripts/css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="Stylesheet">
		<script type="text/javascript" src="scripts/js/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="scripts/js/jquery-ui-1.7.2.custom.min.js"></script>
	</head>
	<body>
		<div style="width:960px; border:1px solid green; margin: 5px" >
			<?php echo $sBody ?>
		</div>
	</body>
</html>


