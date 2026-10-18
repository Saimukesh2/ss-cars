<?php

	if(isset($_SESSION['SESS_USERLOGIN_ID']))
	{
		$employee_gid = $_SESSION['SESS_USERLOGIN_ID'];
		 $count_session = checkSessionExists();
		if($count_session > 0)
		{
			$session_diff_minutes= getSessionData(MYSQL_TZ);
			if($session_diff_minutes > SESSION_TIMEOUT)
			{
			    //echo "session time out";
			    deleteSessionData();
			   header("Location:index.php?msg=ERR02");
			    
			}
			else
			{
			    //Update the session_active column to latest time stamp and redirect to dashboard.php
			    updateSessionData();
			}
		}
		else {
			header("Location:index.php?msg=ERR02");
		}
	}
	else
	{
		header("Location:index.php?msg=ERR02");
	}

?>