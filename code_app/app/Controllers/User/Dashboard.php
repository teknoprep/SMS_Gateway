<?php

namespace App\Controllers\User;

use App\Models\NumberModel;
use App\Models\MessageModel;
use App\Models\UserNumberModel;
use App\Controllers\BaseController;
use App\Models\CarrierModel;
use App\Models\MessageResponseModel;
use App\Models\SenderModel;

include_once CONS_VENDOR;


class Dashboard extends BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		$db = \Config\Database::connect();
		$userId = $_SESSION['user']['user_id'];

		$query = $db->query("select tbl_numbers.number, tbl_numbers.number_label ,tbl_user_numbers.number_id
		from tbl_numbers
		inner join tbl_user_numbers
		on tbl_numbers.number_id = tbl_user_numbers.number_id
		where tbl_user_numbers.user_id = $userId and tbl_numbers.deleted_at IS NULL and tbl_user_numbers.deleted_at IS NULL");
		$userNumberLists = $query->getResult();

		$this->data['user_numbers'] = $userNumberLists;
		return view('user/dashboard', $this->data);
	}

	public function getAllContacts()
	{
		$sms_number = $this->request->getVar('sms_number');
		$userId = $_SESSION['user']['user_id'];

		$userNumberModel = new UserNumberModel();
		$verifyRequest = $userNumberModel->where(['number_id' => $sms_number, 'user_id' => $_SESSION['user']['user_id']])->first();
		if ($verifyRequest == null) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die();
		}

		$query = $this->db->query("select * from tbl_senders");
		$senderNumberList = $query->getResult();

		$list = [];
		foreach ($senderNumberList as $contact) {

			$user = [
				'id'       => (int) $contact->sender_id,
				'name'     => $contact->number,
				'number'   => $contact->number,
				'tempName' => ($contact->alias) ? $contact->alias : "Unknown",
				'pic'      => '../assets/images/placeholder.png',
				'lastSeen' => date('m-d-Y h:i:s a', time())
			];
			array_push($list, $user);
		}

		$userQuery = $this->db->query("select tbl_numbers.number_id, tbl_users.fullname, tbl_numbers.number from tbl_users
		inner join tbl_user_numbers
		on tbl_users.user_id = tbl_user_numbers.user_id
		inner join tbl_numbers
		on tbl_user_numbers.number_id = tbl_numbers.number_id
		where tbl_user_numbers.number_id = $sms_number")->getRow();

		$user2 = [
			'id'       => (int) $userQuery->number_id,
			'name'     => $userQuery->number,
			'number'   => $userQuery->number,
			'pic'      => '../assets/images/placeholder.png',
			'lastSeen' => date('m-d-Y h:i:s a', time())
		];
		array_push($list, $user2);

		echo json_encode($list);
	}

	public function getUserById()
	{

		$userId = $_SESSION['user']['user_id'];
		$sms_number = $this->request->getVar('sms_number');

		$userNumberModel = new UserNumberModel();
		$verifyRequest = $userNumberModel->where(['number_id' => $sms_number, 'user_id' => $_SESSION['user']['user_id']])->first();
		if ($verifyRequest == null) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die();
		}

		$query = $this->db->query("select tbl_numbers.number_id, tbl_users.fullname, tbl_numbers.number from tbl_users
		inner join tbl_user_numbers
		on tbl_users.user_id = tbl_user_numbers.user_id
		inner join tbl_numbers
		on tbl_user_numbers.number_id = tbl_numbers.number_id
		where tbl_user_numbers.number_id = $sms_number")->getRow();

		$user = [
			'id'     => (int) $query->number_id,
			'name'   => $_SESSION['user']['fullname'],
			'number' => $query->number,
			'pic'    => '../assets/images/placeholder.png',
		];
		header('Content-Type: application/json');
		echo json_encode($user);
	}

	public function getAllMessages()
	{
		$sms_number = $this->request->getVar('sms_number');

		$userNumberModel = new UserNumberModel();
		$verifyRequest = $userNumberModel->where(['number_id' => $sms_number, 'user_id' => $_SESSION['user']['user_id']])->first();
		if ($verifyRequest == null) {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			die();
		}

		$query  = $this->db->query("select * from tbl_sms_logs where (sender_id = $sms_number or receiver_id = $sms_number) and is_active = 1 and deleted_at IS NULL order by sl_id ASC");


		$allMessages = $query->getResult();

		$thread = [];
		foreach ($allMessages as $message) {
			$chat = [
				'id' 		  => (int) $message->sl_id,
				'sender' 	  => (int) $message->sender_id,
				'recvId'      => (int) $message->receiver_id,
				'body' 		  => $message->message,
				'status' 	  => $message->status,
				'recvIsGroup' => false,
				'time' 		  => date('m-d-Y H:i:s', strtotime($message->created_at)),
			];
			array_push($thread, $chat);
		}

		header('Content-Type: application/json');
		echo json_encode($thread);
	}

	public function sendMessage()
	{

		$response = $this->request->getVar('response');


		$messageModel = new MessageModel();
		$numberModel = new NumberModel();
		$senderModel = new SenderModel();
		$carrierModel = new CarrierModel();

		$recvId = $response['recvId'];
		$senderId = $response['sender'];
		$senderNumber = $numberModel->where('number_id', $senderId)->first();

		$receiverNumber = $senderModel->where('sender_id', $recvId)->first()['number'];

		$mobile = "+" . $receiverNumber;
		$message = $response['body'];
		$from = "+" . $senderNumber['number'];

		$carrierId = $senderNumber['carrier_id'];
		if ($carrierId == "") {
			echo "404";
		}
		$func = $carrierModel->where('carrier_id', $carrierId)->first()['function'];

		if ($func($mobile, $message, $from)) {

			$messageData = [
				'sender_id' => (int) $response['sender'],
				'receiver_id' => (int) $response['recvId'],
				'message' => $response['body'],
				'status' => (int) 2,
				'is_active' => 1,
				'user_id' => $_SESSION['user']['user_id'],
			];

			if ($messageModel->save($messageData)) {

				$newMessageId = $messageModel->insertID();
				$messageDataDb = $messageModel->where('sl_id', $newMessageId)->first();
				$messageDate = date('m-d-Y H:i:s', strtotime($messageDataDb['created_at']));

				$newMessageData = '';

				$newMessageData = array(
					'category' => 'newmessagesend',
					'id' 		  => (int) $newMessageId,
					'sender' 	  => (int) $response['sender'],
					'recvId'      => (int) $response['recvId'],
					'body' 		  => $response['body'],
					'status' 	  => (int) 2,
					'recvIsGroup' => false,
					'time' 		  => $messageDate,
				);

				$context = new \ZMQContext();
				$socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my pusher');
				$socket->connect("tcp://" . CONS_WEBSOCKET_DOMAIN_NAME_OR_IP . ":5555");
				$socket->send(json_encode($newMessageData));

				echo "1";
			} else {
				echo "0";
			};
		} else {
			echo "00";
		}
	}

	public function updateMessageStatus()
	{
		$messageModel = new MessageModel();
		$response = $this->request->getVar('response');

		$updateData = [
			"status" => 2
		];

		if ($messageModel->where('sender_id', $response)->set('status', 2)->update()) {
			echo "1";
		} else {
			echo "0";
		}
	}

	public function sendNewMessageLogic()
	{
		$receiverModel = new SenderModel();
		$numberModel = new NumberModel();
		$messageModel = new MessageModel();

		$number = $_REQUEST['number'];
		$message = $_REQUEST['message'];
		$senderId = $_REQUEST['senderId'];

		$date = date('m-d-Y H:i:s');

		$receiverId = '';
		$newReceiver = '';

		$checkReceiver = $receiverModel->where('number', $number)->first();
		if ($checkReceiver == NULL) {
			$newReceiver = "1";
			$receiverModel->save(['number' => $number, 'is_active' => 1]);
			$receiverId = $receiverModel->insertID();
		} else {
			$newReceiver = "0";
			$receiverId = $checkReceiver['sender_id'];
		}

		$senderNumber = $numberModel->where('number_id', $senderId)->first();

		$mobile = "+" . $number;
		$from = "+" . $senderNumber['number'];

		$carrierId = $senderNumber['carrier_id'];
		if ($carrierId == "") {
			echo "404";
		}
		$carrierModel = new CarrierModel();
		$func = $carrierModel->where('carrier_id', $carrierId)->first()['function'];

		if ($func($mobile, $message, $from)) {
			$messageData = [
				'sender_id' => $senderId,
				'receiver_id' => $receiverId,
				'message' => $message,
				'status' => 2,
				'is_active' => 1,
				'user_id' => $_SESSION['user']['user_id']
			];

			if ($messageModel->save($messageData)) {
				$messageId = $messageModel->insertID;

				$newMessageData = [
					'id' => (int) $messageId,
					'sender_id' => (int) $senderId,
					'receiver_id' => (int) $receiverId,
					'message' => $message,
					'status' => (int) 2,
					'is_active' => 1,
					'new' => $newReceiver,
					'date' => $date,
					'number' => $number
				];

				echo json_encode($newMessageData);
			} else {
				echo "0";
			};
		} else {
			echo "00";
		}
	}

	public function fetchName()
	{
		$number = $this->request->getVar('number');

		$senderModel = new SenderModel();
		$senderModel->select('alias');
		$data = $senderModel->where('number', $number)->first();

		$jsonData = [
			'code' => 200,
			'message' => 'success',
			'data' => $data
		];
		echo json_encode($jsonData);
	}

	public function assignName()
	{
		$name = $this->request->getVar('txtName');
		$number = $this->request->getVar('number');

		$senderModel = new SenderModel();

		$data = $senderModel->where('number', $number)->set(['alias' => $name])->update();

		$jsonData = [
			'code' => 200,
			'message' => 'success'
		];
		echo json_encode($jsonData);
	}

	public function deleteConversation()
	{
		$messageModel = new MessageModel();
		$key = $this->request->getVar('key');
		$secret = $this->request->getVar('secret');

		$messageModel->where(['sender_id' => $secret, 'receiver_id' => $key])->delete();
		$messageModel->where(['sender_id' => $key, 'receiver_id' => $secret])->delete();

		$jsonData = [
			'code' => 200,
			'message' => 'success'
		];
		echo json_encode($jsonData);
	}
}
