<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      x={
 *          "logo": {
 *              "url": "https://theme.zdassets.com/theme_assets/9115960/ef5800cc529889d180b05b57e40dd50e5c7adb73.png"
 *          }
 *      },
 *      title="WEROAD",
 *      description="Api documentation",
 *      @OA\Contact(
 *          email="peramkat@gmail.com"
 *      ),
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

}
