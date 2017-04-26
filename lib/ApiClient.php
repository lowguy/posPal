<?php
/**
 * Created by PhpStorm.
 * User: 890
 * Date: 2017/3/21
 * Time: 14:03
 */

/**
 * pos接口
 * Class ApiPos
 */
class ApiPos{
    protected $appId;
    protected $appKey;
    protected $url_prefix;
    protected $sendData = array();
    protected $msg = array('status'=>'error','messages'=>'参数错误');

    public function __construct($appId = null,$appKey = null,$url_prefix = 'https://service.pospal.cn:443/')
    {
        if(empty($appId)){
            return $this->msg;
            exit();
        }
        $this->appId = $appId;
        $this->appKey = $appKey;
        $this->url_prefix = $url_prefix;
    }

    public function httpRequestData($url){
        $this->sendData['appId'] = $this->appId;
        $jsonData = json_encode($this->sendData);
        $signature = strtoupper(md5($this->appKey.$jsonData));
        return Request::httpsRequest($this->url_prefix.$url,$jsonData,$signature);
    }
}
/**
 * 会员接口
 * Class ApiUser
 */
class ApiUser extends ApiPos
{
    private $base_url = '/pospal-api2/openapi/v1/customerOpenApi/';

    /**
     * 根据用户number查询
     * @param $number
     * @return mixed
     */
    public function getByNum($number){
        if(empty($number)){
            return $this->msg;
        }
        $this->sendData['customerNum'] = $number;
        return $this->httpRequestData($this->base_url."queryByNumber");
    }

    /**
     * 根据用户手机号查询
     * @param $phone
     * @return mixed
     */
    public function getUserByPhone($phone){
        if(empty($phone)){
            return $this->msg;
        }
        $this->sendData['customerTel'] = $phone;
        return $this->httpRequestData($this->base_url."queryBytel");
    }

    /**
     * 根据用户uid查询
     * @param $uid
     * @return mixed
     */
    public function getUserByUid($uid){
        if(empty($uid)){
            return $this->msg;
        }
        $this->sendData['customerUid'] = $uid;
        return $this->httpRequestData($this->base_url."queryByUid");
    }

    /**
     * 新增用户
     * @param $info
     * @return mixed
     */
    public function addUser($info)
    {
        if(empty($info['categoryName'])||empty($info['number'])||empty($info['password'])||empty($info['enable'])){
            return $this->msg;
        }
        $this->sendData['customerInfo'] = $info;
        return $this->httpRequestData($this->base_url."add");
    }

    /**
     * 修改会员基本信息
     * @param $info
     * @return mixed
     */
    public function editUserBaseInfo($info){
        if(empty($info['customerUid'])){
            return $this->msg;
        }
        $this->sendData['customerInfo'] = $info;
        return $this->httpRequestData($this->base_url."updateBaseInfo");
    }

    /**
     * 修改会员余额积分
     * @param $info
     * @return array|mixed
     */
    public function editUserIncrement($info){
        if(empty($info['customerUid'])){
            return $this->msg;
        }
        $info['dataChangeTime'] = date('Y-m-d H:i:s');
        $this->sendData = array_merge($this->sendData,$info);
        return $this->httpRequestData($this->base_url."updateBalancePointByIncrement");
    }

    /**
     * 分页查询会员
     * @param $info
     * @return mixed
     */
    public function queryCustomerPages($info){
        if($info){
            $this->sendData = array_merge($this->sendData,$info);
        }
        return $this->httpRequestData($this->base_url."queryCustomerPages");
    }
}

/**
 * 产品类接口
 * Class ApiProduct
 */
class ApiProduct extends ApiPos
{
    private $base_url = '/pospal-api2/openapi/v1/productOpenApi/';

    /**
     * 修改商品信息
     * @param $info
     * @return mixed
     */
    public function updateProductInfo($info){
        $this->sendData = array_merge($this->sendData,$info);
        return $this->httpRequestData($this->base_url."updateProductInfo");
    }

    /**
     * 分页查询商品图片
     * @param $info
     * @return mixed
     */
    public function queryProductImagePages($info){
        $this->sendData = array_merge($this->sendData,$info);
        return $this->httpRequestData($this->base_url."queryProductImagePages");
    }

    /**
     * 分页查询全部商品信息
     * @param $info
     * @return mixed
     */
    public function queryProductPages($info){
        if($info){
            $this->sendData = array_merge($this->sendData,$info);
        }
        return $this->httpRequestData($this->base_url."queryProductPages");
    }

    /**
     * 根据唯一标识查询商品信息
     * @param $productUid
     * @return array|mixed
     */
    public function queryProductByUid($productUid){
        if(empty($productUid)){
            return $this->msg;
        }
        $this->sendData['productUid'] = $productUid;
        return $this->httpRequestData($this->base_url."queryProductByUid");
    }

}

class ApiOrder extends ApiPos
{
    private $base_url = '/pospal-api2/openapi/v1/orderOpenApi/';


    /**
     * 新增订单
     * @param $order
     * @return array
     */
    public function addOnLineOrder($order){
        if(!in_array($order['payMethod'],array('Cash','CustomerBalance','customerNumber'))){
            return $this->msg;
        }
        if(empty($order['customerNumber'])){
            return $this->msg;
        }
        $order['orderDateTime'] = date('Y-m-d h:i:s');
        $this->sendData = array_merge($this->sendData,$order);
        return $this->httpRequestData($this->base_url."addOnLineOrder");
    }

    /**
     * 订单发货
     * @param $orderNo
     * @return array|mixed
     */
    public function shipOrder($orderNo){
        if(empty($orderNo)){
            return $this->msg;
        }
        $this->sendData['orderNo'] = $orderNo;
        return $this->httpRequestData($this->base_url."shipOrder");
    }

    /**
     * 完成订单
     * @param $orderNo
     * @return array|mixed
     */
    public function completeOrder($orderNo){
        if(empty($orderNo)){
            return $this->msg;
        }
        $this->sendData['orderNo'] = $orderNo;
        $this->sendData['shouldAddTicket'] = true;
        return $this->httpRequestData($this->base_url."completeOrder");
    }

    /**
     * 取消订单
     * @param $orderNum
     * @return mixed
     */
    public function cancleOrder($orderNum){
        if(empty($orderNum)){
            return $this->msg;
        }
        $this->sendData['orderNo'] = $orderNum;
        return $this->httpRequestData($this->base_url."cancleOrder");
    }
}

class ApiSale extends ApiPos {

    private $base_url = '/pospal-api2/openapi/v1/ticketOpenApi/';

    /**
     * 分页查询所有单据
     * @param $info
     * @return mixed
     */
    public function queryTicketPages($info){
        if($info){
            $this->sendData = array_merge($this->sendData,$info);
        }
        return $this->httpRequestData($this->base_url."queryTicketPages");
    }
}

/**
 * 数据请求
 * Class Request
 */
class Request
{
    // 模拟提交数据函数
    static public function httpsRequest($url, $data,$signature)
    {
        $time = time();
        $curl = curl_init();// 启动一个CURL会话
        // 设置HTTP头
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "User-Agent: openApi",
            "Content-Type: application/json; charset=utf-8",
            "accept-encoding: gzip,deflate",
            "time-stamp: ".$time,
            "data-signature: ".$signature
        ));
        curl_setopt($curl, CURLOPT_URL, $url);         // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);		// Post提交的数据包
//        curl_setopt($curl, CURLOPT_PROXY,'127.0.0.1:8888');//设置代理服务器,此处用的是fiddler，可以抓包分析发送与接收的数据
        curl_setopt($curl, CURLOPT_POST, 1);		// 发送一个常规的Post请求

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 获取的信息以文件流的形式返回
        $output = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话

        return $output; // 返回数据
    }
}
