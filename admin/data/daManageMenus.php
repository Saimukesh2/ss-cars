<?php 
//Need to change this function later to load menus depending on the user logged in privilege
function loadMenus($menu_type,$menu_parent = 0)
{
	$usergroup_gid = $_SESSION['SESS_USERGROUP_GID'];
	$dbcon = new db();
	$rs_menus = $dbcon->query('SELECT a.menu_gid,a.menu_name, a.menu_link, a.menu_icon, a.menu_code 
								FROM gk_mst_tmenus a 
								INNER JOIN gk_mst_tmodule b ON a.menu_code = b.module_code 
								INNER JOIN gk_trn_tuserprivileges c ON b.module_code = c.module_code 
								WHERE a.menu_type = ? 
								AND a.menu_parent = ?  
								AND c.usergroup_gid = ?  
								AND c.menu_permission = ? 
								ORDER BY a.menu_order',
							   $menu_type,
							   $menu_parent,
							   $usergroup_gid,
							   '1'
							);
	
	$arr_menus = $rs_menus->fetchAll();
	$dbcon->close();
	return $arr_menus;
}




function loadMenuPrivilege($sessID)
{
	 $dbcon = new db();
    $rs_getAllPrivileges = $dbcon->query('SELECT * FROM gk_mst_tusergroup
                                     		WHERE login_name = ? and parent_id = 0' ,
                                     		$sessID
										); 
    $arrAllPrivileges = $rs_getAllPrivileges->fetchAll();
   // echo print_r($arrAllallotedSlots);
    $dbcon->close();
   return $arrAllPrivileges;

}

function loadSideMainMenus($sessID)
{
	$dbcon = new db();
	$menu='side';
	
	 $rs_sidemenus =  $dbcon->query('SELECT * FROM mbr_mst_tusergroup a,mbr_mst_tmenus b 
where a.login_name = ? and a.menu_gid=b.menu_gid and  b.menu_type = ? and a.parent_id=0  order by b.menu_parent asc,b.menu_order',$sessID,$menu);
		
	$arr_sidemenus = $rs_sidemenus->fetchAll();

	

	$dbcon->close();
	return $arr_sidemenus;
}

/*function loadSideMainMenus($sessID)
{
	$dbcon = new db();
	$menu='parent';
	 $rs_sidemenus =  $dbcon->query('SELECT * FROM mbr_mst_tusergroup a,mbr_mst_tmenus b 
where a.login_name = ? and a.menu_gid=b.menu_gid and  b.menu_type = ? and a.parent_id=0 order by b.menu_parent asc,b.menu_order',$sessID,$menu);
		
	$arr_sidemenus = $rs_sidemenus->fetchAll();

	

	$dbcon->close();
	return $arr_sidemenus;
}*/

function HideUnprivTopMenus($menuname1,$menuname2,$sessID)
{
		$dbcon = new db();
		
		 $rs_hidetopmenus =  $dbcon->query('SELECT * FROM mbr_mst_tmenus a,mbr_mst_tusergroup b 
		 						WHERE b.login_name = ? 
								AND (a.menu_parent =(select menu_gid from mbr_mst_tmenus where menu_name=?)
								or a.menu_parent =(select menu_gid from mbr_mst_tmenus where menu_name=?))
 								AND a.menu_gid=b.menu_gid',$sessID,$menuname1,$menuname2);
			
		$count_hidetopmenus = $rs_hidetopmenus->numRows();

		

		$dbcon->close();
		return $count_hidetopmenus;
}
function HideUnprivMenus($menugid,$sessID)
{
		$dbcon = new db();
		$menu='side';
		
		
		 $rs_hidesidemenus =  $dbcon->query('SELECT * FROM mbr_mst_tmenus a,mbr_mst_tusergroup b 
			where b.login_name = ? and a.menu_parent = ? and a.menu_gid=b.menu_gid',$sessID,$menugid);
			
		$count_hidesidemenus = $rs_hidesidemenus->numRows();

		

		$dbcon->close();
		return $count_hidesidemenus;
}

function loadSideSubMenusPriv($sessID,$mainmenuID)
{
	$dbcon = new db();
	$menu='side';
	$rs_sidesubmenusPriv =  $dbcon->query('SELECT * FROM mbr_mst_tusergroup a,mbr_mst_tmenus b 
where a.login_name = ? and a.menu_gid=b.menu_gid and b.menu_parent= ? and  b.menu_type = ? and a.parent_id=1 order by b.menu_parent asc,b.menu_order',$sessID,$mainmenuID,$menu);

	
	$arr_sidsubemenusPriv = $rs_sidesubmenusPriv->fetchAll();

	$dbcon->close();
	return $arr_sidsubemenusPriv;
}



function loadSideChildMenus($sessID,$SubMenuID)
{
	$dbcon = new db();
	$menu='side';
	$rs_sidechildmenus =  $dbcon->query('SELECT * FROM mbr_mst_tusergroup a,mbr_mst_tmenus b 
where a.login_name = ? and a.menu_gid=b.menu_gid and b.menu_parent= ? and  b.menu_type = ? and a.parent_id=2 order by b.menu_parent asc,b.menu_order',$sessID,$SubMenuID,$menu);

	
	$arr_sidechildmenus = $rs_sidechildmenus->fetchAll();

	$dbcon->close();
	return $arr_sidechildmenus;
}

//Get menu_gid from the menu name

function getTopMenuID($menu_name,$mainname)
{
	$dbcon = new db();
	//$menu_type = 'top';
	
	$rs_menus = $dbcon->query('SELECT a.menu_gid as chmenu,b.menu_gid as subpmenu
								 FROM mbr_mst_tmenus a, mbr_mst_tmenus b
								  WHERE a.menu_name = ? and a.menu_parent=b.menu_gid  
								  and b.menu_name= ?',$menu_name,$mainname);

	$arrMenuID = $rs_menus->fetchArray();
	$dbcon->close();
	return $arrMenuID;
}

?>