<?php 
    //Get the session details to check if the user is inactive for a long time

    function createSessionData($adminuser_gid)
    {
        $date = date('Y-m-d H:i:s');
        $dbcon = new db();
        session_regenerate_id(true); // Regenerate session ID as the user has just logged in
        $__session_id   = session_id();
              $ins_session    = $dbcon->query('INSERT INTO tbl_session (session_id,session_created,session_active,admin_user_id) 
                                             VALUES (?,?,?,?)', $__session_id,$date,$date,$adminuser_gid);

    }

    // Function to determine if session ID needs regeneration
    function shouldRegenerateSessionId() {
        // Define your criteria for session ID regeneration here
        // For example, you might regenerate it after a user logs in or after a certain time interval

    }

    // Regenerate the session ID if necessary
    function regenerateSessionIdIfNeeded() {
        // Check if session ID needs regeneration
        if (shouldRegenerateSessionId()) {
            // Regenerate session ID
            session_regenerate_id(true); // Set to true to delete the old session data
        }
    }
    
    function regenerateSessionId() {    
        // Regenerate session ID for avoiding session fixation attack
        session_regenerate_id(true); // Set to true to delete the old session data
        $user_session = $_SESSION['SESS_USERLOGIN_ID'];
        $dbcon = new db();
        $date = date('Y-m-d H:i:s');
        $__session_id   = session_id();
        $upd_session    = $dbcon->query('UPDATE tbl_session SET session_id =?, session_active =? WHERE admin_user_id =?', 
                                        $__session_id,
                                        $date,
                                        $user_session);
    }

    function getSessionData($timezone)
    {
        
        $dbcon = new db();
        
        //Get the TIME DIFFERENCE BETWEEN LOGGED IN TIME AND LAST ACTIVE TIME
        // If idle for more than 30 minutes, kill session and redirect to home page with info.
        
        $__session_id = session_id();

         $arr_session = $dbcon->query('SELECT  TIMESTAMPDIFF( 
                            MINUTE, session_active, 
                            CONVERT_TZ( NOW(), ?,?) ) AS active_time
                        FROM tbl_session 
                        WHERE session_id = ?', $timezone,'+05:30',$__session_id)->fetchArray();
       
    
                     //   echo "<br>";
        $dbcon ->close();
      // echo  $arr_session;
        return $arr_session['active_time'];
    }

    function checkSessionExists()
    {
        $dbcon = new db();
        //Get the TIME DIFFERENCE BETWEEN LOGGED IN TIME AND LAST ACTIVE TIME
        // If idle for more than 30 minutes, kill session and redirect to home page with info.
        $count = 0;
        $__session_id   = session_id();
        $count = $dbcon->query('SELECT * FROM tbl_session WHERE session_id = ?  ', 
                                        $__session_id
                                    )->numRows();
        if($count > 0 )
        {
            if(isset($_SESSION['SESS_USERLOGIN_ID']))
            {
                $arr_session = $dbcon->query('SELECT * FROM tbl_session WHERE session_id = ? AND admin_user_id = ? ', 
                                                $__session_id,
                                                $_SESSION['SESS_USERLOGIN_ID']
                                            );
                $count  =$arr_session->numRows();
            }
            else
            {
                $count = 0;
            }
        }
        $dbcon ->close();
        return $count;

    }

    function updateSessionData()
    {
        $date = date('Y-m-d H:i:s');
        $dbcon = new db();
        $__session_id = session_id();
        $arr_session = $dbcon->query('UPDATE tbl_session SET session_active = ?  
                        WHERE session_id = ?', $date, $__session_id);
        $dbcon ->close();
    }


    function deleteSessionData()
    {
        $dbcon = new db();
        $__session_id   = session_id();
        $del_session    = $dbcon->query(' DELETE FROM tbl_session WHERE session_id = ?', $__session_id);
        
        $dbcon->close();
        session_regenerate_id(true);
    }

?>