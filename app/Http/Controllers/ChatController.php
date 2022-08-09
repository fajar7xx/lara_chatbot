<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Aws\LexRuntimeService\LexRuntimeServiceClient;

class ChatController extends Controller
{
    private $botConfig;
    private $senderBotName;
    private $senderBotId;

    public function __construct()
    {
        $this->botConfig = [
            'region'   => env("AWS_DEFAULT_REGION"),
            'version'  => 'latest',
            'botName'  => 'LaravelChatbot', //required
            'botAlias' => 'beta',           //required
        ];
        $this->senderBotName = 'LexBot';
        $this->senderBotId = '1lexbot';
    }

    public function init(Request $request)
    {
        $lexRuntimeServiceClient = new LexRuntimeServiceClient($this->botConfig);

        $this->botConfig['userId'] = 'Client-' . \Auth::id();
        $newSessionData = $lexRuntimeServiceClient->putSession($this->botConfig);

        return [
            "dialogState" => $newSessionData["dialogState"],
            "messages"    => [
                Chat::create([
                    "session_id"  => $newSessionData["sessionId"],
                    'message'     => "Hi",
                    'sender_name' => $this->senderBotName,
                    'sender_id'   => $this->senderBotId,
                ])
            ],
            "slots" => $newSessionData["slots"],
        ];
    }

    public function send(Request $request)
    {
        $lexRuntimeServiceClient = new LexRuntimeServiceClient($this->botConfig);

        $newMessage = $this->botConfig;
        $newMessage['inputText'] = $request->message;
        $newMessage['userId'] = Auth::id();

        $returnMessage = $lexRuntimeServiceClient->postText($newMessage);

        // dd($returnMessage);

        $newMessage = [
            [
                'message'     => $request->message,
                'sender_id'   => Auth::id(),
                'sender_name' => Auth::user()->name,
                "session_id"  => $returnMessage['sessionId']
            ],
        ];

        if ($returnMessage["dialogState"] != "ReadyForFulfillment") {
            $newMessage[] =
                [
                    'message'     => $returnMessage["message"],
                    'sender_name' => $this->senderBotName,
                    'sender_id'   => $this->senderBotId,
                    "session_id"  => $returnMessage['sessionId']
                ];
        }

        $messsages = [];
        foreach ($newMessage as $key => $value) {
            $messsages[] = Chat::create([
                "session_id"  => $returnMessage["sessionId"],
                'message'     => $value["message"],
                'sender_id'   => $value["sender_id"],
                'sender_name' => $value["sender_name"],
            ]);
        }

        return [
            "dialogState" => $returnMessage["dialogState"],
            "slots"       => $returnMessage["slots"],
            "messages"    => $messsages
        ];
    }
}
