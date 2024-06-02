<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;

class OssController extends BaseController
{
    /**生成阿里云oss token**/
    public function token()
    {
        $disk = Storage::disk('oss');

        $config = $disk->signatureConfig($prefix = '/', $callBackUrl = '', $customData = [], $expire = 300);
        $config = json_decode($config, true);

        return $this->response->array($config);
    }
}
