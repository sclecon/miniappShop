<?php

namespace App\Controller\Admin\Base;

use App\Controller\BaseSupport\BaseSupportController;
use App\Model\BaseSupport\BaseSupportModel;
use App\Model\ConfigModel;
use App\Traits\Admin\Curd;

class BaseCurd extends BaseSupportController
{
    /**
     * @var BaseSupportModel
     */
    protected $model;

    /**
     * @var array
     */
    protected $adminer;

    use Curd;

    public function __construct()
    {
        $this->adminer = $this->request->getAttribute('adminer', []);
        $this->model = new ConfigModel();
        parent::__construct();
    }
}