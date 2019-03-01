<?php

/**
 * @param $data
 * @param bool $isError
 * @param string $msg
 * @param int $code
 * @return \think\response\Json
 */
function showJson($data, $isError = false, $code = 200, $msg = '')
{
    $result = [
        'isError' => $isError,
        'code' => $code,
        'msg' => $msg | '操作成功',
        'data' => $data,
    ];

    return json($result);
}