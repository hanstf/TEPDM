<?php
require 'config.php';

function connectDB (){
    try {
        $connectDB = new PDO('mysql:host='.HOST_NAME.';dbname='.DATABASE_NAME, USER_NAME, DB_PASSWORD);
        $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    return $connectDB;
}
function connectDB2 (){
    try {
        $connectDB = new PDO('mysql:host='.HOST_NAME2.';dbname='.DATABASE_NAME2, USER_NAME2, DB_PASSWORD2);
        $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    return $connectDB;
}

function verifyUser($username, $password){
    
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT * FROM  user WHERE user_name = :username');
    $records->bindParam(':username', $username);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    
    if(count($results) > 0) {
        if (password_verify($password, $results['user_pass'])){    
            return $results['user_id'];
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function getUserDetails($param) {
    $connectDB = connectDB();
    $records = $connectDB->prepare('SELECT * FROM  user WHERE user_id = :userid');
    $records->bindParam(':userid', $_SESSION['user']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    
    if(count($results) > 0) {
        return $results[$param];    
    }else{
        return false;    
    }
}
function getDistinctPBBId (){
    $connectDB = connectDB2();
    $records = $connectDB->prepare('SELECT DISTINCT `pbb_id` FROM `matchtrx` WHERE `match_tagging` IS NULL ORDER BY RAND()');
    $records->execute();
    $results = $records->fetchAll();
	
    return $results;
}

function getDistinctNAPIC ($pbbID){
    $connectDB = connectDB2();
    $records = $connectDB->prepare('SELECT DISTINCT a.napic_id FROM matchtrx a, tp_consortium b, tp_analytica c WHERE pbb_id = :id and b.id = a.pbb_id and c.id = a.napic_id order by c.area, STR_TO_DATE(c.contract_date, \'%m-%d-%Y\') desc LIMIT 20');
    $records->bindParam(':id', $pbbID);
    $records->execute();
    $results = $records->fetchAll();
    return $results;
}
function getAllNAPIC ($pbbID){
    $connectDB = connectDB2();
    $records = $connectDB->prepare('SELECT DISTINCT `napic_id` FROM `matchtrx` WHERE `pbb_id` = :id');
    $records->bindParam(':id', $pbbID);
    $records->execute();
    $results = $records->fetchAll();
    return $results;
}
function getPBBDetails ($pbbID){
    $connectDB = connectDB2();
    $records = $connectDB->prepare('SELECT `collecteral_id`, `state`, `town`, `property_type`, `value_date`, CONCAT(`address1`, " - ",  `address2`, ", ", `address3`, ", ", `address4`) as `address`, `project_name`, `land_area`, `build_up_area`, `napic_prop_type`, `address3`, `dollar_value`, `build_up_area_unit`, `land_area_unit`, `storey` FROM `tp_consortium` WHERE `id` = :id');
    $records->bindParam(':id', $pbbID);
    $records->execute();
    $results = $records->fetchAll();
    return $results;
}
function getPBBIDWithParam ($paramArray){
    
    
    $connectDB = connectDB2();
    $query="";
    if(empty($paramArray)== false){
        $whereOptions = "";
        foreach($paramArray as $key => $value){
            
            $paramsKeyVal = " " . $key . ' = ' . $value . " AND";     
            $whereOptions .=  $paramsKeyVal;
        }
        $whereOptions = substr($whereOptions, 0, -3);
       
        $query = 'SELECT `id` FROM `tp_consortium` WHERE '. $whereOptions; 
        
    }else{
        $query = 'SELECT `id` FROM `tp_consortium`';    
    }
    
    $records = $connectDB->prepare($query);
    
   
    $records->execute();
    $results = $records->fetchAll();
    return $results;
}
function getNAPICDetails ($napicID){
    $connectDB = connectDB2();
    $records = $connectDB->prepare('SELECT `id`, `state`, `sector`, `property_type`, `price`, `address`, `lot_area_sqm`, `pbb_prop_type`, `mukim`, `area`, `residential`, STR_TO_DATE(`contract_date`, \'%m-%d-%Y\'),`lot_build_sqm` FROM `tp_analytica` WHERE `id` = :id order by area asc, STR_TO_DATE(`contract_date`, \'%m-%d-%Y\') desc');
    $records->bindParam(':id', $napicID);
    $records->execute();
    $results = $records->fetchAll();
    return $results;
}
function updateSelection($selection, $id, $userid, $status, $pbbID){
    $connectDB = connectDB2();
    $records = $connectDB->prepare('UPDATE `matchtrx` SET `match_tagging` = :tagging, `updated_by` = :userid, `updated_time` = NOW(), `status` = :status  WHERE `napic_id`= :id and `pbb_id`= :pbbId ');
    $records->bindParam(':tagging', $selection);
    $records->bindParam(':userid', $userid);
    $records->bindParam(':status', $status);
	$records->bindParam(':id', $id);
	$records->bindParam(':pbbId', $pbbID);
    
	if ($records->execute()){
        return true;
    }else{
        return false;
    }
}

?>