<?php
namespace app\api\controller\exception;
use think\exception\Handle;

class ApiHandleException extends Handle 
{
    public function render(\Exception $e)
    {
        $result = [
            'isError' => true,
            'data' => [],
            'errorMsg' => $e->getMessage(),
        ];
        return json($result);
    }
}