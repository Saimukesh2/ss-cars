<?php
function insertCategory($arrData)
{
    //Unpack the array arrData
    $category_name = $arrData['category_name'];
    $category_desc = $arrData['category_desc'];
    $category_status = $arrData['category_status'];
    $category_image = $arrData['category_image'];

    //Open the db connection
    $dbcon = new db();
    $sql = $dbcon->query("  INSERT INTO `ss_mst_category` 
                            (   `category_name`, 
                                `category_desc`, 
                                `category_status`,
                                `category_image`
                            ) 
                            VALUES (?, ?, ?, ?) ",
                            $category_name, 
                            $category_desc, 
                            $category_status,
                            $category_image
                        );
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
}

function updateCategory($arrData)
{
    $category_desc = $arrData['category_desc'];
    $category_status = $arrData['category_status'];
    $category_id = $arrData['category_id'];
    //Open the db connection
    $dbcon = new db();
    if (!empty($arrData['category_image'])) {
        $category_image = $arrData['category_image'];
        $sql = $dbcon->query(" UPDATE `ss_mst_category` SET `category_desc` = ?, `category_status` = ?, `category_image` = ? WHERE `category_id` = ?",
                             $category_desc,
                             $category_status,
                             $category_image,
                             $category_id
                             );
    } else {
        $sql = $dbcon->query(" UPDATE `ss_mst_category` SET `category_desc` = ?, `category_status` = ? WHERE `category_id` = ?",
                             $category_desc,
                             $category_status,
                             $category_id
                             );
    }
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
}

function updateModels($arrData)
{
    //$model_id = $arrData['model_id'];
    $model_status= $arrData['model_status'];
    $model_desc = $arrData['model_desc'];
    $model_id = $arrData['model_id'];
    //open the db connection
    $dbcon = new db();
    if (!empty($arrData['model_image'])) {
        $model_image = $arrData['model_image'];
        $sql = $dbcon->query("UPDATE `ss_mst_models` SET `model_status` = ?, `model_desc` = ?, `model_image` = ? WHERE `model_id` = ?",
                              $model_status,
                              $model_desc,
                              $model_image,
                              $model_id
                            );
    } else {
        $sql = $dbcon->query("UPDATE `ss_mst_models` SET `model_status` = ?, `model_desc` = ? WHERE `model_id` = ?",
                              $model_status,
                              $model_desc,
                              $model_id
                            );
    }
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
}

function updateCar($arrData)
{
    //$car_id = $arrData['car_id'];
    //$car_name = $arrData['car_name'];
    //$model_id = $arrData['model_id'];
    $year = $arrData['year'];
    $color_available = implode(',', $arrData['color_available']);;
    $price = $arrData['price'];
    $features = $arrData['features'];
    $mieleage = $arrData['mieleage'];
    $status = $arrData['status'];
    $car_id = $arrData['car_id'];
    $car_image = isset($arrData['car_image']) ? $arrData['car_image'] : '';
    //open the db connection
    $dbcon = new db();
    if ($car_image != '') {
        $sql = $dbcon->query("UPDATE `ss_mst_car` SET `year` =?,
                                                      `color_available` =?,
                                                      `price` =?,
                                                      `features` =?,
                                                      `mieleage` =?,
                                                      `status` =?,
                                                      `car_image` =?
                                                    WHERE `car_id` =?",
                                                    $year,
                                                    $color_available,
                                                    $price,
                                                    $features,
                                                    $mieleage,
                                                    $status,
                                                    $car_image,
                                                    $car_id
                            );
    } else {
        $sql = $dbcon->query("UPDATE `ss_mst_car` SET `year` =?,
                                                      `color_available` =?,
                                                      `price` =?,
                                                      `features` =?,
                                                      `mieleage` =?,
                                                      `status` =?
                                                    WHERE `car_id` =?",
                                                    $year,
                                                    $color_available,
                                                    $price,
                                                    $features,
                                                    $mieleage,
                                                    $status,
                                                    $car_id
                            );
    }
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;   
}

function checkCategoryExists($categoryName_upper)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM `ss_mst_category` WHERE UPPER(`category_name`) = ?", $categoryName_upper);
    $count = $sql->numRows();
    $dbcon->close();
    return $count;
}
function checkModelsExists($modelName_upper)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM `ss_mst_models` WHERE UPPER(`model_name`) = ?", $modelName_upper);
    $count = $sql->numRows();
    $dbcon->close();
    return $count;
}
function checkCarExists($carName_upper)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM `ss_mst_car` WHERE UPPER(`car_name`) = ?", $carName_upper);
    $count = $sql->numRows();
    $dbcon->close();
    return $count;
}
function insertModels($arrData)
{
    //Unpack the array arrData
    $category_id = $arrData['category_id'];
    $model_name = $arrData['model_name'];
    $model_desc = $arrData['model_desc'];
    $model_status = $arrData['model_status'];
    $model_image = $arrData['model_image'];
    
    //open the db connection
    $dbcon = new db();  
    $sql  = $dbcon->query(" INSERT INTO `ss_mst_models`
                                    (    `model_name`,
                                         `model_desc`,
                                         `model_status`,
                                         `category_id`,
                                         `model_image`
                                     )   
                                     VALUES (?, ?, ?, ?, ?)",
                                     $model_name,
                                     $model_desc,
                                     $model_status,
                                     $category_id,
                                     $model_image
                        );
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;

}
function insertCar($arrData)
{
    //Unpack the array arrData
    $car_name = $arrData['car_name'];
    $modelName = $arrData['model_name'];
    $year = $arrData['year'];
    $color_available= $arrData['color_available'];
    $price = $arrData['price'];
    $features = $arrData['features'];
    $mieleage = $arrData['mieleage'];
    $status = $arrData['status'];
    $car_image = isset($arrData['car_image']) ? $arrData['car_image'] : '';
    //print_r($arrData);
    //exit;
    //open the db connection
    $dbcon = new db();
    $sql = $dbcon->query(" INSERT INTO `ss_mst_car`
                            (    `car_name`,
                                 `year`,
                                 `color_available`,
                                 `price`,
                                 `features`,
                                 `mieleage`,
                                 `status`,
                                 `model_id`,
                                 `car_image`
                            )
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                            $car_name,
                            $year,
                            $color_available,
                            $price,
                            $features,
                            $mieleage,
                            $status,
                            $modelName,
                            $car_image
                        );
    $affectedRows = $sql->affectedRows();
    $dbcon->close();
    return $affectedRows;
}



function getAllActiveCategory()
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT `category_id`, `category_name` FROM `ss_mst_category` WHERE category_status = 'Active'");
    $arrCategories = $sql->fetchAll();
    $dbcon->close();
    return $arrCategories;
}

function getAllActiveModels()
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT `model_id`, `model_name` FROM `ss_mst_models` WHERE model_status = 'Active'");
    $arrModels = $sql->fetchAll();
    $dbcon->close();
    return $arrModels;
}
function getAllActiveCars()
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT `car_id`, `car_name` FROM `ss_mst_car` WHERE status = 'Active'");
    $arrCars = $sql->fetchAll();
    $dbcon->close();
    return $arrCars;
}

function getAllCategory()
{
    $dbcon = new db();
    $sql = $dbcon->query('SELECT * FROM ss_mst_category ');
    $arrProductCat = $sql->fetchAll();
    $dbcon->close();
    return $arrProductCat;
}

function getAllModels()
{
    $dbcon = new db();
    $sql = $dbcon->query('SELECT m.model_id,
                                 c.category_name,             
                                 m.model_name,
                                 m.model_desc,
                                 m.model_status,
                                 m.model_image
                          FROM ss_mst_models m
                          INNER JOIN ss_mst_category c
                          ON m.category_id = c.category_id');
    $arrModels = $sql->fetchAll();
    $dbcon->close();
    return $arrModels;
}
function getAllCars()
{
    $dbcon = new db();
    $sql = $dbcon->query('SELECT a.car_id,a.color_available,
                                 c.category_name,
                                 m.model_name,
                                 a.car_name,
                                 a.year,
                                 a.price,
                                 a.features,
                                 a.mieleage,
                                 a.status,
                                 a.car_image
                          FROM ss_mst_car a
                          INNER JOIN ss_mst_models m
                          ON a.model_id=m.model_id
                          INNER JOIN ss_mst_category c
                          ON m.category_id=c.category_id ORDER BY a.car_id ');
    $arrCars = $sql->fetchAll();
    $dbcon->close();
    return $arrCars;
}

function getCarById($car_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT a.car_id,b.model_id,c.category_name,b.model_name,
                            a.color_available,
                            a.car_name,a.year,a.color_available,a.price,a.features,a.mieleage,a.status,a.car_image
                          FROM ss_mst_car a
                          INNER JOIN ss_mst_models b
                          ON a.model_id=b.model_id
                          INNER JOIN ss_mst_category c
                          ON b.category_id=c.category_id
                          WHERE a.car_id = ? LIMIT 1", $car_id);
    $arrCar = $sql->fetchArray();
    $dbcon->close();
    return $arrCar;
}

function deleteCat($category_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("DELETE FROM ss_mst_category WHERE category_id = ?",$category_id);
    $count = $sql->affectedRows();
    $dbcon->close();
    return $count;
}

function getCategoryById($category_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM ss_mst_category WHERE category_id = ? LIMIT 1", $category_id);
    $arrCategory = $sql->fetchArray();
    $dbcon->close();
    return $arrCategory;
}
function getModelsById($model_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT b.model_id,a.category_id,a.category_name,b.model_name,b.model_desc,b.model_status,b.model_image
                          FROM ss_mst_models b
                          INNER JOIN ss_mst_category a
                          ON b.category_id=a.category_id
                          WHERE b.model_id = ? LIMIT 1", $model_id);
    $arrModels = $sql->fetchArray();
    $dbcon->close();
    return $arrModels;
}
function deleteModel($model_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("DELETE FROM ss_mst_models WHERE model_id = ?",$model_id);
    $count = $sql->affectedRows();
    $dbcon->close();
    return $count;
}
function deleteCar($car_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("DELETE FROM ss_mst_car WHERE car_id = ?",$car_id);
    $count = $sql->affectedRows();
    $dbcon->close();
    return $count;
}
function checkCategoryExistsinModels($category_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM ss_mst_models WHERE category_id = ?", $category_id);
    $count = $sql->numRows();
    $dbcon->close();
    return $count;
}
function checkModelsExistsinCars($model_id)
{
    $dbcon = new db();
    $sql = $dbcon->query("SELECT * FROM ss_mst_car WHERE model_id = ?",$model_id);
    $count = $sql->numRows();
    $dbcon->close();
    return $count;
}
?>