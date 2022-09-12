<?php

namespace App\Exception\Handler;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use App\Utils\Response;
use Hyperf\Di\Annotation\Inject;

class AppErrorResponseHandler extends ExceptionHandler
{
    /**
     * @Inject
     * @var Response
     */
    protected $response;

    /**
     * @var string
     */
    protected $errorPre = '[错误] ';

    /**
     * @var bool
     */
    protected $errorStack = true;

    public function __construct(Response $response){
        $this->response = $response;
    }

    protected $outputException = [

    ];


    public function isValid(\Throwable $throwable): bool
    {
        return true;
        foreach ($this->outputException as $exception){
            if ($throwable instanceof $exception){
                return true;
            }
        }
        return false;
    }

    public function handle(\Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        $stackData = $this->errorStack ? [
            'file'    =>  $throwable->getFile(),
            'line'    =>  $throwable->getLine(),
        ] : [];

        in_array('getExceptionData', get_class_methods($throwable)) && $this->errorStack && $throwable->getExceptionData() && $stackData['data'] = $throwable->getExceptionData();
        $httpStatus = (int) (isset($throwable->httpStatus) ? $throwable->httpStatus : 200);
        return $this->response->error($this->errorPre.$throwable->getMessage(), (int) $throwable->getCode(), $stackData, [], $httpStatus);
    }
}