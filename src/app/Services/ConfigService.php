<?php

namespace App\Services;

use App\Exception\Service\ConfigServiceException;
use App\Model\ConfigModel;
use App\Services\BaseSupport\BaseSupportService;

class ConfigService extends BaseSupportService
{
    protected $model = ConfigModel::class;

    public function getNotice() : string {
        return $this->getConfig('notice', '暂未配置');
    }

    public function getWechatConfig() : array {
        $appid = $this->getConfig('wx_appid', false);
        $secret = $this->getConfig('wx_secret', false);
        $token = $this->getConfig('wx_token', false);
        if (!$appid){
            throw new ConfigServiceException('公众号APPID错误');
        } elseif (!$secret){
            throw new ConfigServiceException('公众号密钥错误');
        } elseif (!$token){
            throw new ConfigServiceException('公众号token错误');
        }
        return [
            'app_id'        =>      $appid,
            'secret'        =>      $secret,
            'token'         =>      $token
        ];
    }

    public function getWechatPayConfig() : array {
        $appid = $this->getConfig('wx_appid', false);
        $mid = $this->getConfig('wx_pay_mid', false);
        $secret = $this->getConfig('wx_pay_secret', false);

        if (!$appid){
            throw new ConfigServiceException('公众号APPID错误');
        } elseif (!$mid){
            throw new ConfigServiceException('微信支付商户ID错误');
        } elseif (!$secret){
            throw new ConfigServiceException('微信支付商户密钥错误');
        }

        $certDir = str_replace('/app/Services', '', __DIR__).'/cert/';
        return [
            'app_id'    =>  $appid,
            'mch_id'    =>  $mid,
            'key'       =>  $secret,
            'cert_client' =>  $certDir.'apiclient_cert.pem',
            'cert_key' =>  $certDir.'apiclient_key.pem',
            'log' => [ // optional
                'file' => './logs/wechat.log',
                'level' => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
                'type' => 'single', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                'timeout' => 5.0,
                'connect_timeout' => 5.0,
            ],
            'notify_url'    =>  UserPayService::instance()->getNotifyUrl(),
        ];
    }

    public function getSystemTel() : int {
        $tel = (int) $this->getConfig('system_tel', false);
        if (!$tel){
            throw new ConfigServiceException('暂无平台客服联系电话');
        }
        return $tel;
    }

    public function getAliyunSmsConfig() : array {
        $appid = $this->getConfig('sms_al_appid', false);
        $secret = $this->getConfig('sms_al_secret', false);
        $templateid = $this->getConfig('sms_al_templateid', false);
        $signname = $this->getConfig('sms_al_signname', false);
        if (!$appid){
            throw new ConfigServiceException('未设置短信APPID');
        } elseif (!$secret){
            throw new ConfigServiceException('未设置短信密钥');
        } elseif (!$templateid){
            throw new ConfigServiceException('未设置短信模版ID');
        } elseif (!$signname){
            throw new ConfigServiceException('未设置短信签名');
        }
        return [
            'appid'         =>  $appid,
            'secret'        =>  $secret,
            'templateid'    =>  $templateid,
            'signname'      =>  $signname,
        ];
    }


    public function getConfig(string $key, $default = null){
        $value = $this->getModel()
            ->where('uuid', $key)
            ->value('value');
        return is_null($value) ? $default : $value;
    }
}