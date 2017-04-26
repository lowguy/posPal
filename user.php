<?php
/**
 * Created by PhpStorm.
 * User: 890
 * Date: 2017/3/17
 * Time: 15:33
 */
include_once '/conf/config.php';
include_once '/lib/ApiClient.php';
$user = new ApiUser();
//create user
//$info = array(
//    "categoryName"=>"金卡",
//    "number"=>"BL0000000087",
//    "name"=>"u634MCTE6231",
//    "point"=>0,
//    "discount"=>60,
//    "balance"=>0,
//    "phone"=>"",
//    "onAccount"=>0,
//    "enable"=>1,
//    "password"=>"96e79218965eb72c92a549dd5a330112"
//);
//$result = $user->addUser($info);
//var_dump($result);

//query user by phone
//$phone = '17759205640';
//$result = $user->getUserByPhone($phone);
//var_dump($result);



//query user by uid
//$uid = "225616758819911087";
//$result = $user->getUserByUid($uid);
//var_dump($result);

//$info['postBackParameter'] = array(
//    'parameterType'=>'LAST_RESULT_MAX_ID',
//    'parameterValue'=>'7700056'
//);
//query user by number
$number = "00001798";
$result = $user->getByNum($number);
var_dump($result);
//$result = $user->queryCustomerPages($info);
//var_dump($result);
//$customerUid = "225616758819911087";
//$info = array(
//    'customerUid'=>$customerUid,
//    'balanceIncrement'=>-200
//);
//$result = $user->editUserIncrement($info);
//var_dump($result);