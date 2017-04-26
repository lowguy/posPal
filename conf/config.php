<?php
/**
 * Created by PhpStorm.
 * User: 890
 * Date: 2017/3/17
 * Time: 15:00
 */
define("URL_PREFIX", "https://service.pospal.cn:443/");

define("APP_ID", "***************************");
define("APP_KEY", "*******************8");

//查询商品图片url的接口地址
define("QUERY_PRODUCT_IMAGE_PAGES_URL", URL_PREFIX."/pospal-api2/openapi/v1/productOpenApi/queryProductImagePages");
//查询商品单据的接口地址
define("QUERY_TICKET_PAGES_URL", URL_PREFIX."/pospal-api2/openapi/v1/ticketOpenApi/queryTicketPages");
//查询所有支付方式的接口地址
define("QUERY_ALL_PAY_METHOD_URL", URL_PREFIX."/pospal-api2/openapi/v1/ticketOpenApi/queryAllPayMethod");
//用户
define("USER_BASE_URL", URL_PREFIX."/pospal-api2/openapi/v1/customerOpenApi/");
//产品
define("PRODUCT_BASE_URL", URL_PREFIX."/pospal-api2/openapi/v1/productOpenApi/");
//订单
define("ORDER_BASE_URL", URL_PREFIX."/pospal-api2/openapi/v1/orderOpenApi/");
define("ORDER_TICKET_BASE_URL", URL_PREFIX."/pospal-api2/openapi/v1/ticketOpenApi/");
