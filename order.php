<?php
/**
 * Created by PhpStorm.
 * User: 890
 * Date: 2017/3/17
 * Time: 15:33
 */
include_once '/conf/config.php';
include_once '/lib/ApiClient.php';
$order = new ApiOrder();

$order_sn = '20170324150514216104';
$result = $order->queryTicketBySn($order_sn);
var_dump($result);