<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\MessageModel;
use App\Models\MessageResponseModel;
use App\Models\NumberModel;
use App\Models\SenderModel;

require CONS_VENDOR;

class Twilio extends BaseController
{
    public function index()
    {
        return "test";
    }

    public function getMessage()
    {
        $messageResponse = new MessageResponseModel();
        $messageModal = new MessageModel();
        $numberModal = new NumberModel();
        $senderModal = new SenderModel();

        $responseData =
            [
                'response' => json_encode($_REQUEST)
            ];

        $messageResponse->save($responseData);

        $sender = ltrim($_REQUEST["From"], "+");
        $to = ltrim($_REQUEST["To"], "+");
        $message = $_REQUEST["Body"];

        $senderId = '';
        $newSender = "";
        $checkSender = $senderModal->where('number', $sender)->first();
        if ($checkSender == NULL) {
            $newSender = "1";
            $senderModal->save(['number' => $sender, 'is_active' => 1]);
            $senderId = $senderModal->insertID();
        } else {
            $newSender = "0";
            $senderId = $checkSender['sender_id'];
        }

        $checkReceiver = $numberModal->where('number', $to)->first();
        $receiverId = $checkReceiver['number_id'];

        $messageData = [
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $message,
            'status' => 0,
            'is_active' => 1
        ];

        if ($messageModal->save($messageData)) {
            $messageId = $messageModal->insertID;

            $messageData = $messageModal->where('sl_id', $messageId)->first();
            $messageDate = date('m-d-Y', strtotime($messageData['created_at']));

            $newMessageData = '';

            $newMessageData = array(
                'category' => 'newmessage',
                'id' => (int) $messageId,
                'sender_id'    => (int)  $senderId,
                'receiver_id'    => (int)  $receiverId,
                'message'    =>  $message,
                'status' => 0,
                'date' => $messageDate,
                'number' => $sender,
                'new' => $newSender
            );


            $context = new \ZMQContext();
            $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my pusher');
            $socket->connect("tcp://" . CONS_WEBSOCKET_DOMAIN_NAME_OR_IP . ":5555");
            $socket->send(json_encode($newMessageData));
        }
    }


    //--------------------------------------------------------------------

}
