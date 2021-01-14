<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Setup extends BaseController
{
	public function index()
	{
		$password  = password_hash("admin", PASSWORD_DEFAULT);

		$data = [
			"fullname" => "", // Your Name
			"email" => "", // Your Email
			"password" => $password,
			"role_id" => 1,
			"is_active" => 1
		];

		$userModel = new UserModel();
		$userModel->save($data);
	}


	//--------------------------------------------------------------------

}
