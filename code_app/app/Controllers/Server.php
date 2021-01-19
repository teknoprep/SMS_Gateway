<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Pusher;


require CONS_VENDOR;

class Server extends BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		$loop   = \React\EventLoop\Factory::create();
		$pusher = new Pusher;

		$context = new \React\ZMQ\Context($loop);
		$pull = $context->getSocket(\ZMQ::SOCKET_PULL);
		$pull->bind('tcp://0.0.0.0:5555');

		$pull->on('message', array($pusher, 'onNewMessage'));


		$webSock = new \React\Socket\Server('0.0.0.0', $loop);
		$webServer = new \Ratchet\Server\IoServer(
			new \Ratchet\Http\HttpServer(
				new \Ratchet\WebSocket\WsServer(
					new \Ratchet\Wamp\WampServer(
						$pusher
					)
				)
			),
			$webSock
		);

		$loop->run();
	}
}
