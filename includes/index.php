<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');	
	
	session_start();
	include "codebase/DB.class.php";
	include "codebase/EventSystem.class.php";
	$aPostData = $_POST;
	$aGetData = $_GET;


	
/*

	$oDB = new DB();
	$oDB->startTransaction();
	
	try
	{
		$aResult = $oDB->query('SELECT id FROM planet where owner_id = 1 ', 'numeric');
		var_dump($aResult);
	}
	catch(Exception $e)
	{
		$oDB->rollback();
		echo $e->getMessage();
	};
	$oDB->close();
	
	
	try
	{
		$all_user_data = $oDB->query("SELECT * FROM user", 'assoc');
		if (!empty($all_user_data))
		{
			foreach($all_user_data as $dataset)
			{
				echo 'ID:'.$dataset['id'].' | ';
				echo 'NICKNAME:'.$dataset['mail'].' | ';
				echo 'NICKNAME:'.$dataset['name'].' | ';
				echo 'PASSWORD:'.$dataset['password'].'<br/>';
			}
		}
		/*
		$next_id = count($all_user_data) + 1;
		$oDB->query("INSERT INTO user (id, mail, name, password) VALUES (".$next_id.", 'test@test.de', 'Testuser', 'test123')");
		$oDB->query("UPDATE user SET password = 'sCv54!j' WHERE id = ".$next_id);
		$oDB->commit();	
	
	}
	catch(Exception $e)
	{
		$oDB->rollback();
		echo $e->getMessage();
	};
	$oDB->close();
	

	foreach ($_SESSION as $fkKey => $fvValue)
	{
		echo "<br/>$fkKey => $fvValue";
		foreach ($fvValue as $fkKey1 => $fvValue2)
		{
			echo "<br/> --- $fkKey1 => $fvValue2";
		}
	}
*/


	$iPage = 0;
	if (isset($_SESSION['pageID'])) $iPage = $_SESSION['pageID'];
	if (isset($aGetData['site']))
	{
		switch ($aGetData['site'])
		{
			case 'buildings':
				if (isset($aGetData['pID']))
				{
					include_once "codebase/planet.class.php";
					$oPlanet = new Planet($aGetData['pID']);
					if ($oPlanet->getOwnerID() == $_SESSION['user']['playerID']) $iPage = 3;
					else echo '<h1><span style="color:#FF0000">Dir gehört der Planet nicht</span></h1>';
				}
				else echo '<h1><span style="color:#FF0000">Kein Planet ausgewählt</span></h1>';
				break;
			case 'research':
				$iPage = 4;
				break;
			
		}
	}
	
	// Daten zum einloggen wurden gesendet
	if (isset($aPostData['hiddenFormID']) && $aPostData['hiddenFormID'] == 1) include "includes/login.php";
	
	// User ist bereits eingelogt
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
	else if ($iPage > 0 && !isset($_SESSION['user']['playerID']))
	{
		$iPage = 5;
	}
	
	
	/*
	 * 1: 		main page
	 * 2: 		logout
	 * 3:		buildings
	 * 4: 		research
	 * 5:		Logout wegen Session timeout
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
		<link rel="stylesheet" type="text/css" href="scripts/styles.css">
		<script type="text/javascript" src="scripts/javascript_functions.js"></script>
	</head>
	<body>
		<div style="width:960px; border:1px solid green; margin: 5px" >
			<?php echo $sBody ?>
		</div>
	</body>
</html>


