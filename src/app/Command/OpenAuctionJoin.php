<?php

namespace App\Command;

use App\Services\AuctionJoinService;
use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as BaseCommand;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\Inject;

/**
 * @Command()
 */
class OpenAuctionJoin extends BaseCommand
{

    /**
     * @Inject()
     * @var StdoutLoggerInterface
     */
    protected $logger;

    public function __construct()
    {
        parent::__construct('auction:openJoin');
        $this->setDescription('参与竞拍开奖');
    }

    public function handle()
    {
        $this->msg('开始开奖');
        AuctionJoinService::instance()->openJoin(function(string $msg) {
            $this->msg($msg);
        });
        $this->msg('开奖结束');
    }

    protected function msg(string $msg, $error = false){
        $msg = '['.date('Y-m-d H:i:s').'] '.$msg;
        $error ? $this->output->error($msg) : $this->output->note($msg);
    }
}