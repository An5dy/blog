<?php

namespace App\Http\Controllers\Hook;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GithubWebHookController extends Controller
{
    /**
     * web hook
     *
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $commands = ['cd /www/blog', 'git pull'];
        $signature = $request->header('X-hub-Signature');
        $payload = file_get_contents('php://input');
        if ($this->isFromGitHub($payload, $signature)) {
            foreach ($commands as $command) {
                shell_exec($command);
            }
            http_response_code(200);
        } else {
            abort(403);
        }
    }

    /**
     * 验证签名
     *
     * @param $payload
     * @param $signature
     * @return bool
     */
    private function isFromGitHub($payload, $signature)
    {
        return 'sha1=' . hash_hmac('sha1', $payload, config('api.webhook.token'), false) === $signature;
    }
}
