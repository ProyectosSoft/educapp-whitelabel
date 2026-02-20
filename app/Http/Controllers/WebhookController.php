<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\GithubWebhook;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function github(Request $request)
    {
        $payload = $request->getContent();
        $signature = 'sha1=' . hash_hmac('sha1', $payload, 'DesarrolloGrupoEffi77+');


        if ($request->header('X-Hub-Signature') != $signature) {
            abort(403, 'Invalid signature');
        }
        GithubWebhook::dispatch();
        return response('webhook received', 200);
    }
}
