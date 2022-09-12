<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 15:37
 */

namespace App\Exception\BaseSupport;

class BaseSupportException extends \Exception
{
    /**
     * @var int
     */
    protected $httpStatusCode;

    /**
     * @var array
     */
    protected $exceptionData;

    public function __construct(string $errMsg, int $errCode = 5000, int $httpStatusCode = 200, array $data = [])
    {
        $this->httpStatusCode = $httpStatusCode;
        $this->exceptionData = $data;
        parent::__construct($errMsg, $errCode);
    }

    public function getHttpStatusCode() : int {
        return $this->httpStatusCode;
    }

    public function getExceptionData() : array {
        return $this->exceptionData;
    }
}