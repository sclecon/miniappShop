<?php

namespace App\Controller\Port;

use App\Controller\BaseSupport\BaseSupportController;
use App\Services\UcService;
use Hyperf\Contract\ConfigInterface;
use App\Annotation\ApiRouter;
use Hyperf\Di\Annotation\Inject;

/**
 * @ApiRouter(router="/uc", method="get", intro="UC接口")
 */
class Uc extends BaseSupportController
{

    /**
     * @var ConfigInterface
     * @Inject()
     */
    protected $config;

    /**
     * @ApiRouter(router="/api/uc.php", method="get", intro="UC接口入口")
     */
    public function api(){
        $time = (string) $this->request->input('time', '');
        $code = (string) $this->request->input('code', '');
        $response = UcService::instance()->api($code, $time);
        return $this->success('处理完成', is_array($response) ? $response : ['response'=>$response]);
    }
}