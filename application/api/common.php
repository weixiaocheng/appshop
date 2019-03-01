<?php

/**
 * @param $data
 * @param bool $isError
 * @param string $msg
 * @param int $code
 * @return \think\response\Json
 */
function showJson($data, $isError = false, $code = 200, $msg = '操作成功')
{
    $result = [
        'isError' => $isError,
        'code' => $code,
        'msg' => $msg ,
        'data' => $data,
    ];
    return json($result);
}