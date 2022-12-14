<?php

namespace App\Model\BaseSupport;

use App\Traits\Model\AddAll;
use App\Traits\Model\Utils;
use Hyperf\Database\Model\Model;

class BaseSupportModel extends Model
{

    /**
     * @var string
     */
    const CREATED_AT = 'created_time';

    const UPDATED_AT = null;

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $casts = ['created_time'=>'timestamp'];

    /**
     * @var string
     */
    protected $dateFormat = 'U';

    use Utils;

    use AddAll;
}