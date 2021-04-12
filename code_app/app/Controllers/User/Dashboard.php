<?php

namespace App\Controllers\User;

use App\Models\NumberModel;
use App\Models\MessageModel;
use App\Models\UserNumberModel;
use App\Controllers\BaseController;
use App\Models\CarrierModel;
use App\Models\MessageResponseModel;
use App\Models\SenderModel;
use App\Models\UserImportContactModel;

use App\Models\UserModel;
use App\Models\UserNumberNameModel;

include_once CONS_VENDOR;
use \TheNetworg\OAuth2\Client\Provider\Azure;

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
		$userNameModel = new UserNumberNameModel();
		
		$number = $_REQUEST['number'];
		$message = $_REQUEST['message'];
		$senderId = $_REQUEST['senderId'];
		$contactName = isset($_REQUEST['contactName']) ? $_REQUEST['contactName'] : "Unknown";
		$userId = $_SESSION['user']['user_id'];


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

		$checkUserNameExists = $userNameModel->where(['user_id' => $userId, 'number_id' => $receiverId, 'deleted_at' => null])->first();

		if (!$checkUserNameExists) {
			$userNameData = [
				"number_id" => $receiverId,
				"user_id" => $_SESSION['user']['user_id'],
				"alias" => $contactName,
			];
			$userNameModel->save($userNameData);
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
					'number' => $number,
					'name' => $contactName
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
		$userId = $_SESSION['user']['user_id'];
		$senderModel = new SenderModel();
		$senderModel->select('sender_id');
		$numberId = $senderModel->where('number', $number)->first()['sender_id'];

		$userNameModel = new UserNumberNameModel();
		$userNameModel->select('alias');
		$checkUserNameExists = $userNameModel->where(['user_id' => $userId, 'number_id' => $numberId, 'deleted_at' => null])->first();

		if ($checkUserNameExists) {
		$jsonData = [
			'code' => 200,
			'message' => 'success',
			'data' => $checkUserNameExists
		];
		echo json_encode($jsonData);
	} else {

		$nameData = [
			"user_id" => $userId,
			"number_id" => $numberId,
			"is_active" => 1,
			"alias" => "Unknown"
		];

		if ($userNameModel->save($nameData)) {
			$newId = $userNameModel->insertID();
			$userNameModel->select('alias');
			$userNameExists = $userNameModel->where('uni_id', $newId)->first();

			$jsonData = [
				'code' => 200,
				'message' => 'success',
				'data' => $userNameExists
			];
			echo json_encode($jsonData);
		}
	}
}

public function getAll365Contacts()
{

	$userImportModel = new UserImportContactModel();
	$userId = $_SESSION['user']['user_id'];

	$userImportModel->select('uic,name,mobile_number,business_number,home_number');
	$getAllContacts = $userImportModel->where('user_id', $userId)->findAll();

	$jsonData = [
		'code' => 200,
		'message' => 'success',
		'data' => $getAllContacts
	];
	echo json_encode($jsonData);
}


public function get365ConctactDetails()
{

	$userImportModel = new UserImportContactModel();
	$userId = $_SESSION['user']['user_id'];
	$number = $this->request->getVar('number');

	$userImportModel->select('uic,name,mobile_number,business_number,home_number');
	$getContact = $userImportModel->where(['user_id' => $userId, 'uic' => $number])->first();

	if ($getContact) {
		$jsonData = [
			'code' => 200,
			'message' => 'success',
			'data' => $getContact
		];
		echo json_encode($jsonData);
	} else {
		$jsonData = [
			'code' => 404,
			'message' => 'Contact details not found',
		];
		echo json_encode($jsonData);
	}
}

public function assignName()
{
	$name = $this->request->getVar('txtName');
	$number = $this->request->getVar('number');
	$userId = $_SESSION['user']['user_id'];

	$senderModel = new SenderModel();
	$userNameModel = new UserNumberNameModel();

	$senderModel->select('sender_id');
	$numberId = $senderModel->where('number', $number)->first()['sender_id'];

	$data = $userNameModel->where(['number_id' => $numberId, 'user_id' => $userId])->set(['alias' => $name])->update();

	$jsonData = [
		'code' => 200,
		'message' => 'success'
	];
	echo json_encode($jsonData);
}

	public function deleteConversation()
	{
		$messageModel = new MessageModel();
		$userNameModel = new UserNumberNameModel();

		$key = $this->request->getVar('key');
		$secret = $this->request->getVar('secret');

		$messageModel->where(['sender_id' => $secret, 'receiver_id' => $key])->delete();
		$messageModel->where(['sender_id' => $key, 'receiver_id' => $secret])->delete();
		$userNameModel->where(['number_id' => $key, 'user_id' => $_SESSION['user']['user_id']])->delete();

		$jsonData = [
			'code' => 200,
			'message' => 'success'
		];
		echo json_encode($jsonData);
	}

	public function edit_profile()
	{

		$userModel = new UserModel();
		$user_id = $_SESSION['user']['user_id'];

		$userModel->select("fullname");
		$user = $userModel->where('user_id', $user_id)->first();

		if ($this->request->getMethod() === 'post') {

			$user_id = $_SESSION['user']['user_id'];
			$fullname = $this->request->getVar('fullname');
			$password = $this->request->getVar('password');

			$updateData = [
				"fullname" => $fullname,
			];


			if ($password != "" or $password != NULL) {

				$encryptPassword = password_hash($password, PASSWORD_DEFAULT);
				$updateData = [
					"fullname" => $fullname,
					"password" => $encryptPassword
				];
			}

			if ($userModel->where("user_id", $user_id)->set($updateData)->update()) {
				$_SESSION['user']['fullname'] = $fullname;
				$_SESSION['msg_success'] = "Account information update successfully";
				return redirect()->to(base_url() . '/user/dashboard');
			} else {
				$_SESSION['msg_success'] = "Something went wrong while updating account information";
				return redirect()->to(base_url() . '/user/dashboard');
			}
		}

		echo json_encode($user);
	}
	
	public function loginAndGetContact()
	{

		$userImportModel = new UserImportContactModel();
		$userId = $_SESSION['user']['user_id'];

		$importData = '';

		$provider = new \TheNetworg\OAuth2\Client\Provider\Azure([
			'clientId'          => o365_CLIENT_ID,
			'clientSecret'      => o365_SECRET,
			'redirectUri'       =>  base_url() . '/user/dashboard/loginAndGetContact',
			//Optional
			'scopes'            => ['openid'],
			//Optional
			'defaultEndPointVersion' => '2.0'
		]);

		$provider->defaultEndPointVersion = \TheNetworg\OAuth2\Client\Provider\Azure::ENDPOINT_VERSION_2_0;

		$baseGraphUri = $provider->getRootMicrosoftGraphUri(null);
		$provider->scope = 'openid profile email offline_access ' . $baseGraphUri . '/User.Read ' . $baseGraphUri . '/Contacts.Read';

		if (isset($_GET['code']) && isset($_SESSION['OAuth2.state']) && isset($_GET['state'])) {

			if ($_GET['state'] == $_SESSION['OAuth2.state']) {
				unset($_SESSION['OAuth2.state']);

				/** @var AccessToken $token */
				$token = $provider->getAccessToken('authorization_code', [
					'scope' => $provider->scope,
					'code' => $_GET['code'],
				]);

				$loop = 1;
				$totalContactFound = 0;
				$totalImportCount = 0;

				for ($i = 0; $i < 10; $i++) {

					if ($loop < 10) :
						$optional = "top=1000";
						$otherFilter = '&skip=' . $i * 1000;

						$fetchContacts = $provider->get($provider->getRootMicrosoftGraphUri($token) . '/v1.0/me/contacts?' . $optional . $otherFilter, $token);
						$totalContact = 0;

						foreach ($fetchContacts as $contactRow) :
							$totalContact++;
							$totalContactFound++;

							$importName = '';
							$importMobileNumber = '';
							$importBusinessNumber = null;
							$importHomeNumber = null;

							$numberExist = $userImportModel->where([
								'mobile_number' => $contactRow['mobilePhone'],
								'user_id' => $userId,
							])->first();
							if (!$numberExist) {
								$totalImportCount++;
								echo $totalImportCount . ": " . $contactRow['displayName'] . "Import" . "<br>";
								$importName = $contactRow['displayName'];
								$importMobileNumber = $contactRow['mobilePhone'];

								if (count($contactRow['businessPhones']) > 0) {
									$importBusinessNumber = $contactRow['businessPhones'][0];
								}

								if (count($contactRow['homePhones']) > 0) {
									$importHomeNumber = $contactRow['homePhones'][0];
								}

								$importData = [
									'name' => $importName,
									'mobile_number' => $importMobileNumber,
									'business_number' => $importBusinessNumber,
									'home_number' => $importHomeNumber,
									'user_id' => $userId,
									'is_active' => 1
								];

								if ($userImportModel->save($importData)) {
									$importName = '';
									$importMobileNumber = '';
									$importBusinessNumber = null;
									$importHomeNumber = null;
								}
							} else {
								echo "NumberExist";
							}
						endforeach;

						if ($totalContact > 998) {
							$loop++;
						} else {
							$loop = 100;
						}
					endif;
				} // end for loop


				echo "<script>alert('Total Contact Found: $totalContactFound | Total Contact Sync: $totalImportCount')</script>";
				echo "<script>window.close()</script>";
			} else {
				echo 'Invalid state';

				return null;
			}
		} else {

			$authorizationUrl = $provider->getAuthorizationUrl(['scope' => $provider->scope]);
			$_SESSION['OAuth2.state'] = $provider->getState();
			header('Location: ' . $authorizationUrl);
			exit;
			//return $token->getToken();
		}
	}
}
