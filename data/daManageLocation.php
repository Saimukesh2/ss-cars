<?php 
/*************************************************************************
 * File Name: daManageLocation.php
 * Author: Karthi
 * Date: 2022-03-07
 * Desc: This file contains the functions for managing the locations.
 ************************************************************************/

 function getAllLocation()
 {
    $dbcon = new db();
     $sql = $dbcon->query('SELECT a.*,b.countryname FROM gk_mst_tlocation a INNER JOIN tbl_countries b ON a.country_code = b.countrycode');
     $arrLocation = $sql->fetchAll();
     $dbcon->close();
     return $arrLocation;
 }

 function checkLocationNameExists($arrLocation)
 {
     $dbcon = new db();
     $location_name = strtoupper($arrLocation['location_name']);
     $sql = $dbcon->query('SELECT * FROM gk_mst_tlocation WHERE UPPER(location_name) =?', $location_name );
     $count = $sql->numRows();
     $dbcon->close();
     return $count;
 }

 function insertLocation($arrLocation)
 {
    $dbcon = new db();
     $created_by = getUserGID();
     $created_date =  date('Y-m-d H:i:s');
     $sql = $dbcon->query('INSERT INTO gk_mst_tlocation
                                                (   location_name,
                                                    country_code,
                                                    address1,
                                                    address2,
                                                    city,
                                                    `state`,
                                                    zipcode,
                                                    location_type,
                                                    contact_person,
                                                    contact_email,
                                                    contact_number,
                                                    currency,
                                                    notes,
                                                    `status`,
                                                    created_by,
                                                    created_date
                                                )
                                                VALUES (
                                                    ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
                                                )',
                                                $arrLocation['location_name'],
                                                $arrLocation['country_code'],
                                                $arrLocation['address1'],
                                                $arrLocation['address2'],
                                                $arrLocation['city'],
                                                $arrLocation['state'],
                                                $arrLocation['zipcode'],
                                                $arrLocation['location_type'],
                                                $arrLocation['contact_person'],
                                                $arrLocation['contact_email'],
                                                $arrLocation['contact_number'],
                                                $arrLocation['currency'],
                                                $arrLocation['notes'],
                                                $arrLocation['location_status'],
                                                $created_by,
                                                $created_date
                                            );
     $dbcon->close();
     return $sql->affectedRows();
 }


 function updateLocation($arrLocation,$location_id)
{
    $dbcon = new db();
    $modified_by = getUserGID();
    $modified_date = date('Y-m-d H:i:s');
    $sql = $dbcon->query('UPDATE gk_mst_tlocation
                            SET 
                                address1 = ?,
                                address2 = ?,
                                city = ?,
                                `state` = ?,
                                zipcode = ?,
                                location_type = ?,
                                contact_person = ?,
                                contact_email = ?,
                                contact_number = ?,
                                currency = ?,
                                notes = ?,
                                `status` = ?,
                                modified_by = ?,
                                modified_date = ?
                            WHERE location_gid = ?',
                            
                            $arrLocation['address1'],
                            $arrLocation['address2'],
                            $arrLocation['city'],
                            $arrLocation['state'],
                            $arrLocation['zipcode'],
                            $arrLocation['location_type'],
                            $arrLocation['contact_person'],
                            $arrLocation['contact_email'],
                            $arrLocation['contact_number'],
                            $arrLocation['currency'],
                            $arrLocation['notes'],
                            $arrLocation['location_status'],
                            $modified_by,
                            $modified_date,
                            $location_id
                        );
    $dbcon->close();
    return $sql->affectedRows();
}

function getLocationDetailsById($location_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM gk_mst_tlocation WHERE location_gid = ?", $location_id);
    $locationDetails = $sql->fetchArray();
    $dbcon->close();
    return $locationDetails;
}

function getStores($country_code)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM gk_mst_tlocation WHERE country_code = ?", $country_code);
    $arrStores = $sql->fetchAll();
    $dbcon->close();
    return $arrStores;
}

function changeLocationStatus($location_id, $status)
{
    $dbcon = new db();
    $sql = $dbcon->query('UPDATE gk_mst_tlocation SET `status` = ? WHERE location_gid = ?', $status, $location_id);
    $dbcon->close();
    return $sql->affectedRows();
}

  function getAllCountriesFromLocation()
  {
    $dbcon = new db();
    $sql = $dbcon->query('SELECT DISTINCT(country_code) as country_code, b.countryname  
                            FROM  gk_mst_tlocation a 
                            INNER JOIN tbl_countries b ON a.country_code = b.countrycode 
                            ORDER BY country_code ', 
);
    $arrCountries = $sql->fetchAll();
    $dbcon->close();
    return $arrCountries;
  }

function getLocationByIDs($location_gids)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM gk_mst_tlocation WHERE location_gid IN (". $location_gids. ") ORDER BY location_gid");
    $arrLocations = $sql->fetchAll();
    $dbcon->close();
    return $arrLocations;
}
?>