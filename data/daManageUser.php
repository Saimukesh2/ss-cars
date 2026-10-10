<?php 

function getAllUserGroups()
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM ss_trn_customer");
    $count = $sql->numRows();
    if($count > 0)
    {
        $result = $sql->fetchAll();
        return $result;
    }
    else
    {
        $result = array();
        return $result;
    }
    $dbcon->close();
}

function getAllUsers()
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT a.*, b.customer_name FROM 
                            ss_trn_employee a 
                            INNER JOIN ss_trn_customer b ON a.employee_id = b.employee_id
                            ORDER BY a.customer_id DESC");
    $count = $sql->numRows();
    if($count > 0)
    {
        $result = $sql->fetchAll();
        return $result;
    }
    else
    {
        $result = array();
        return $result;
    }
    $dbcon->close();
}


function checkUGExists($arrData)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM ss_trn_customer WHERE customer_name =? ", $arrData['customer_name']);
    $count = $sql->numRows();
    $dbcon->close();
    return $count;
}

function checkLoginIDExists($arrData)
{
    $login_id = strtoupper($arrData['user_id']);
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM ss_trn_employee WHERE UPPER(user_name) =? ", $user_id );
    $count = $sql->numRows();
    $dbcon->close();
    return $count;
}

// Check if the module code has got privilege to access this page.
function checkPagePrivilege($module_code)
{
    $user_group_gid = $_SESSION['SESS_EMPLOYEE_ID'];
    $user_login     = $_SESSION['SESS_USERID'];
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM gk_trn_tuserprivileges WHERE usergroup_gid =? AND menu_permission = 1 
                            AND module_code =? AND status = 'Active'",
                            $user_group_gid,
                            $module_code
                        );
    $count = $sql->numRows();
    $dbcon->close();
    return $count;
}

function getUserGroupById($usergroup_gid)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM gk_mst_tusergroup WHERE usergroup_gid =? LIMIT 1", $usergroup_gid);
    $arrUserGroup = $sql->fetchArray();
    $dbcon->close();
    return $arrUserGroup;
}
function getUserById($usergroup_gid)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM ss_trn_employee WHERE employee_id =? LIMIT 1", $employee_id);
    $arrUser = $sql->fetchArray();
    $dbcon->close();
    return $arrUser;
}

function loadPrivileges($usergroup_gid)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM gk_trn_tuserprivileges WHERE usergroup_gid =? AND menu_permission = 1", $usergroup_gid);
    $arrPrivileges = $sql->fetchAll();
    $dbcon->close();
    return $arrPrivileges;
}


function loadMainModule($module_code)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM gk_mst_tmodule WHERE module_code =? LIMIT 1", $module_code);
    $arrModule = $sql->fetchArray();
    $dbcon->close();
    return $arrModule;
    
}

function loadChildModule($parent_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM gk_mst_tmodule WHERE parent =? ORDER BY display_order", $parent_id);
    $arrModule = $sql->fetchAll();
    $dbcon->close();
    return $arrModule;  
}

function loadChildModuleByCode($parent_code)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM gk_mst_tmodule WHERE module_code LIKE '$parent_code-%' ORDER BY display_order");
    $arrModule = $sql->fetchAll();
    $dbcon->close();
    return $arrModule;
}

function getUserGroupPrivileges($usergroup_gid)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT module_code FROM gk_trn_tuserprivileges WHERE usergroup_gid =? AND menu_permission = 1", $usergroup_gid);
    $arrPrivileges = $sql->fetchAll();
    $dbcon->close();
    return $arrPrivileges;
}

function updateUserGroupPrivileges($usergroup_gid, $arrPostedPrivileges)
{
    $dbcon = new db();
    //Lets delelete all the existing privileges for this user group
    $main_module = $arrPostedPrivileges['main_module'];
    $sql = $dbcon->query("DELETE FROM gk_trn_tuserprivileges WHERE usergroup_gid =? AND module_code LIKE '$main_module%'", $usergroup_gid);
    //Now insert the new privileges
    $modified_date = date('Y-m-d H:i:s');
    $modified_by = getUserGID($_SESSION['SESS_USERLOGIN_ID']);

    foreach($arrPostedPrivileges as $key => $value)
    {
        {   
            if(($key!= 'hdnusergroup_gid') && ($key!='main_module'))
            {
                $sql = $dbcon->query("INSERT INTO gk_trn_tuserprivileges (usergroup_gid, module_code, menu_permission, `status`,modified_by,modified_date) 
                                        VALUES (?,?,?,?,?,?)", 
                                        $usergroup_gid, 
                                        $value, 
                                        1, 
                                        'Active',
                                        $modified_by,
                                        $modified_date
                                    );
            }
        }

    }
    $dbcon->close();
}



function insertUserGroup($arrData)
{
    $dbcon = new db();
    $created_by = getUserGID();
    $created_date = date('Y-m-d H:i:s');
    $sql = $dbcon->query("INSERT INTO gk_mst_tusergroup (`usergroup_name`, `usergroup_desc`, `created_by`, `created_date`)
                            VALUES (?,?,?,?)",
                            $arrData['usergroup_name'],
                            $arrData['usergroup_desc'],
                            $created_by,
                            $created_date
                        );
    $result = $sql->affectedRows();
    $dbcon->close();
    return $result;
}

function updateUser($arrData)
{
    $dbcon = new db();
    $modified_by = getUserGID();
    $modified_date = date('Y-m-d H:i:s');
    $sql = $dbcon->query("UPDATE ss_trn_employee SET  
                            employee_name =?,  
                            address =?, 
                            phone =?, 
                            e-mail =?, 
                            position =?, 
                            hire_date =?, 
                            gender =? 
                            WHERE employee_id =?",
                            $arrData['employee_name'],
                            $arrData['address'],
                            $arrData['phone'],
                            $arrData['e-mail'],
                            $arrData['position'],
                            $hire_date,
                            $gender,
                            $arrData['employee_id']
                        );
    $result = $sql->affectedRows();
    $dbcon->close();
    return $result;
}

function insertUser($arrData)
{
    $dbcon = new db();
    $created_by = getUserGID();
    $created_date = date('Y-m-d H:i:s');
    $enc_password = hash('sha256',$arrData['password']);
    $sql = $dbcon->query("INSERT INTO gk_mst_tuser (`user_name`, `employee_name`, `password`, `uemployee_id`, `e-mail`, `phone`, 
                            `created_by`, `created_date`)
                            VALUES (?,?,?,?,?,?,?,?,?)",
                            $arrData['user_id'],
                            $arrData['employee_name'],
                            $enc_password,
                            $arrData['employee_id'],
                            $arrData['e-mail'],
                            $arrData['phone'],
                            $hire_date,
                            $position
                        );
    $result = $sql->affectedRows();
    $dbcon->close();
    return $result; 
}
function  updateUserGroup($arrData)
{
    $dbcon = new db();
    $modified_by = getUserGID();
    $modified_date = date('Y-m-d H:i:s');
    $sql = $dbcon->query("UPDATE gk_mst_tusergroup SET  usergroup_desc =?, modified_by =?, `status` = ?, modified_date =? WHERE usergroup_gid =?",
                            $arrData['usergroup_desc'],
                            $modified_by,
                            $arrData['usergroup_status'],
                            $modified_date,
                            $arrData['usergroup_gid']
                        );
    $result = $sql->affectedRows();
    $dbcon->close();
    return $result;
}

function changeUserGroupStatus($usergroup_gid, $status)
{
    $dbcon = new db();
    $modified_by = getUserGID();
    $modified_date = date('Y-m-d H:i:s');
    $sql = $dbcon->query("UPDATE gk_mst_tusergroup SET `status` =?, modified_by =?, modified_date =? WHERE usergroup_gid =?",
                            $status,
                            $modified_by,
                            $modified_date,
                            $usergroup_gid
                        );
    $result = $sql->affectedRows();
    $dbcon->close();
    return $result;
}

function changeUserStatus($user_gid, $status)
{
    $dbcon = new db();
    $modified_by = getUserGID();
    $modified_date = date('Y-m-d H:i:s');
    $sql = $dbcon->query("UPDATE gk_mst_tuser SET `status` =?, modified_by =?, modified_date =? WHERE user_gid =?",
                            $status,
                            $modified_by,
                            $modified_date,
                            $user_gid
                        );
    $result = $sql->affectedRows();
    $dbcon->close();
    return $result;
}
?>
