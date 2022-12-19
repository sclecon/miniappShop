<?php
use Hyperf\Crontab\Crontab;

return [
    'enable' => true,
    // 通过配置文件定义的定时任务
    'crontab' => [
        // Command类型定时任务
        (new Crontab())->setType('command')->setName('竞拍开奖')->setRule('* * * * *')->setCallback([
            'command' => 'auction:openJoin',
        ]),
    ],
];