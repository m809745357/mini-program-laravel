<?php

namespace M809745357\MiniProgram\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use M809745357\MiniProgram\Models\User;

class UserController extends Controller
{
    /**
     * register miniprogram user
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function register(Request $request)
    {
        $data = $this->getUserInfo($request);

        $user = User::firstOrNew([
            'openid' => $data['openid'],
        ]);

        $user->save();

        return $user;
    }

    /**
     * update miniprogram user
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update(Request $request)
    {
        $user = \Auth::user();
        $user->update([
            'nickname' => $request->nickname,
            'gender' => $request->gender,
            'avatar' => $request->avatar
        ]);
        return $user;
    }

    /**
     * get miniprogram user info
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    private function getUserInfo($request)
    {
        $appid = config('miniprogram.program.appid');
        $secret = config('miniprogram.program.appsecret');
        $code = $request->code;

        # 使用 appid secret code 获取用户信息
        $client = new \GuzzleHttp\Client();
        $url = "https://api.weixin.qq.com/sns/jscode2session"
             . "?appid={$appid}"
             . "&secret={$secret}"
             . "&js_code={$code}"
             . "&grant_type=authorization_code";

        $res = $client->request('GET', $url);
        $data = json_decode($res->getBody(), true);

        if (isset($data['errcode'])) {
            return \Response::json(array(
                'info' => array(
                    $data['errmsg']
                )
            ));
        }

        return $data;
    }
}
