<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/22 15:07
 */

namespace App\Utils;

use AlibabaCloud\Credentials\Credential\Config;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\Tea\Exception\TeaError;
use App\Exception\AliyunSmsException;
use App\Services\ConfigService;
use Hyperf\Utils\Traits\StaticInstance;

class AliyunSms
{

    use StaticInstance;

    protected function getConfig($key = false){
        $config = [
            'accessKeyId'       =>  ConfigService::instance()->getConfig('sms_al_appid'),
            'accessKeySecret'   =>  ConfigService::instance()->getConfig('sms_al_secret'),
            'signName'          =>  ConfigService::instance()->getConfig('sms_al_signname'),
            'templateId'        =>  ConfigService::instance()->getConfig('sms_al_templateid'),
        ];
        if ($key && (empty($config[$key]) or strlen($config[$key]) === 0)){
            throw new AliyunSmsException($key.'的配置不存在或为空');
        }
        return $key ? $config[$key] : $config;
    }

    protected function createClient(){
        $config = new Config([
            'accessKeyId'       =>  $this->getConfig('accessKeyId'),
            'accessKeySecret'   =>  $this->getConfig('accessKeySecret'),
        ]);
        // 访问的域名
        $config->endpoint = "dysmsapi.aliyuncs.com";
        return new Dysmsapi($config);
    }

    protected function send(SendSmsRequest $request){
        $errMsg = '';
        try {
            $response = $this->createClient()->sendSms($request);
            if ($response->body->code !== 'OK'){
                throw new \Exception($response->body->message);
            }
        }
        catch (\Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            $errMsg = $error->getMessage();
        }
        if ($errMsg){
            throw new AliyunSmsException($errMsg);
        }
        return true;
    }

    public function sendCode(string $phone, int $code){
        return $this->send(new SendSmsRequest([
            'signName'      =>  $this->getConfig('signName'),
            'templateCode'  =>  $this->getConfig('templateId'),
            'templateParam' =>  json_encode(['code'=>$code]),
            'phoneNumbers'  =>  $phone,
        ]));
    }
}