<?php
	include "codebase/user.class.php";
	$bLoginError = true;
	
	//Check, if password and username was enterend and not empty
	if (isset($aPostData['login']['name']) && $aPostData['login']['name'] != '' && isset($aPostData['login']['password']) && $aPostData['login']['password'] != '') 
	{
		if ($oTmp = user::getPlayerByLogin($aPostData['login']['name'], $aPostData['login']['password']))
		{
			$_SESSION['user']['playerID'] = $oTmp->getPlayerID();
			$_SESSION['user']['playerName'] = $oTmp->getName();
			$_SESSION['pageID'] = 1;
			$bLoginError = false;
			$iPage = 1;
		} else {
			echo "<br/>No user found!";
		}
	}
?>