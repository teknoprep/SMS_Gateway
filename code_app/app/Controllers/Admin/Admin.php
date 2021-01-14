<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;


class Admin extends BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		$UserModel = new UserModel();

		$UserModel->where(['role_id' => 1]);
		$users = $UserModel->findAll();


		$this->data['users'] = $users;
		return view('admin/admin_view', $this->data);
	}

	public function insert()
	{
		$UserModel = new UserModel();

		if ($this->request->getMethod() === 'post') {

			$fields = [
				'fullname' => 'required',
				'email' => 'required',
			];
			$validated = $this->validate($fields);
			if (!$validated) {
				return view('admin/admin_add', $this->data);
			}

			$fullname = $this->request->getVar('fullname');
			$email = $this->request->getVar('email');

			$emailExist = $UserModel->where("email", $email)->first();
			if ($emailExist) {
				$_SESSION['msg_error'] = "Something went wrong while creating account | EMAILALREADYEXISTS";

				return view('admin/admin_add', $this->data);
			}

			$password = generateRandomString();
			$pwdPeppered = password_hash($password, PASSWORD_DEFAULT);

			$data = [
				'fullname' => $fullname,
				'email' => $email,
				'password' => $pwdPeppered,
				'is_active' => 1,
				'role_id' => 1
			];

			if ($UserModel->save($data)) {
				$userId = $UserModel->insertID();

				$loginLink = base_url() . "/admin/login";
				$message = "Hello $fullname, <br> Your account has been created <br> User: $email <br> Password: $pwdPeppered <br> Login Link: $loginLink";

				$emailConfig = \Config\Services::email();

				$emailConfig->setTo($email);
				$emailConfig->setFrom('sms@blueuc.com', 'SMS BLUEUC');
				$emailConfig->setSubject("BLUEUC | New Account Information");
				$emailConfig->setMessage($message);
				$emailConfig->send();

				$_SESSION['msg_success'] = "Admin added successfully";
				return redirect()->to(base_url() . '/admin/admin');
			} else {
				$_SESSION['msg_error'] = "Somethong went wrong while adding a admin";
				return redirect()->to(base_url() . '/admin/admin/insert')->withInput();
			}
		}

		return view('admin/admin_add');
	}

	public function update()
	{
		$UserModel = new UserModel();

		if ($this->request->getMethod() === 'post') {

			$fields = [
				'fullname' => 'required',
				'email' => 'required',
			];
			$validated = $this->validate($fields);
			if (!$validated) {
				return view('admin/admin_update');
			}
			$fullname = $this->request->getVar('fullname');
			$email = $this->request->getVar('email');
			$user_id = $this->request->getVar('user_id');
			$password = $this->request->getVar('password');

			$data = [
				'user_id' => $user_id,
				'fullname' => $fullname,
				'email' => $email
			];

			if ($password != "" or $password != NULL) {

				$encryptPassword = password_hash($password, PASSWORD_DEFAULT);

				$data = [
					'user_id' => $user_id,
					'fullname' => $fullname,
					'email' => $email,
					'password' => $encryptPassword
				];
			}

			if ($UserModel->save($data)) {

				$_SESSION['msg_success'] = "Admin update successfully";


				return redirect()->to(base_url() . '/admin/admin');
			} else {
				$_SESSION['msg_error'] = "Somethong went wrong while updating a admin";
				return redirect()->to(base_url() . '/admin/admin/update')->withInput();
			}
		}


		$uri = service('uri');
		$id = $uri->getSegment(4);

		$user = $UserModel->where('md5(user_id::text)', $id)->first();

		$this->data['update'] = $user;

		return view('admin/admin_update', $this->data);
	}

	public function delete()
	{
		$UserModel = new UserModel();

		$uri = service('uri');
		$id = $uri->getSegment(4);

		if ($UserModel->where('md5(user_id::text)', $id)->delete()) {
			$_SESSION['msg_success'] = "Admin deleted successfully";
			return redirect()->to(base_url() . '/admin/admin');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while deleting a admin";
			return redirect()->to(base_url() . '/admin/admin');
		}
	}

	public function status()
	{
		$UserModel = new UserModel();
		$uri = service('uri');

		$id = $uri->getSegment(4);
		$status = $uri->getSegment(5);

		$update_data = [
			'is_active' => $status
		];

		$row = $UserModel->where('md5(user_id::text)', $id)->first();
		if ($UserModel->update($row['user_id'], $update_data)) {
			$_SESSION['msg_success'] = "Status changed successfully";
			return redirect()->to(base_url() . '/admin/admin');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while updating status";
			return redirect()->to(base_url() . '/admin/admin');
		}
	}

	public function sendResetLink()
	{

		$uri = service('uri');
		$email = $uri->getSegment(4);

		if (!$email) {
			$_SESSION['msg_error'] = "Something went wrong";
			return redirect()->to(base_url() . '/admin/admin');
		}

		$userModel = new UserModel();
		$userExists = $userModel->where('md5(email)', $email)->first();

		if ($userExists) {
			$resetLink = "<a href='" . base_url() . "/admin/login/change_password?key=" . md5($userExists['email']) . "'>RESET PASSWORD LINK</a>";
			$message = "Hello, <br> Please click $resetLink to reset your password ";

			if (send_email($userExists['email'], "Reset Password Request", $message)) {
				$_SESSION['msg_success'] = "Password reset link send successfully";
				return redirect()->to(base_url() . '/admin/admin');
			} else {
				$_SESSION['msg_error'] = "Something went wrong, while sending password reset link";
				return redirect()->to(base_url() . '/admin/admin');
			}
		} else {
			$_SESSION['msg_error'] = "Something went wrong | USERNOTFOUND";
			return redirect()->to(base_url() . '/admin/admin');
		}
	}
}
