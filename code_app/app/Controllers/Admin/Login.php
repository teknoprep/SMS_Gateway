<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoginModel;

class Login extends BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		return view('admin/login');
	}

	public function signin()
	{
		if ($this->request->getMethod() === 'post') {

			$fields = [
				'email' => 'required',
				'password' => 'required'
			];
			$validated = $this->validate($fields);
			if (!$validated) {
				return view('admin/login');
			}
			$email = $this->request->getVar('email');
			$password = $this->request->getVar('password');

			$LoginModel = new LoginModel();

			$loginData = $LoginModel->where(['email' => $email, 'role_id' => 1, 'is_active' => 1])->findAll();

			if ($loginData) {


				$loginData = $loginData[0];


				if (password_verify($password, $loginData['password'])) {

					$_SESSION['msg_success'] = "Login Successful";
					$this->session->set('admin', $loginData);
					return redirect()->to(base_url() . '/admin/user');
				} else {
					$_SESSION['msg_error'] = "Invalid email or password";
					return redirect()->to(base_url() . '/admin/login');
				}
			} else {
				$_SESSION['msg_error'] = "Invalid email or password";
				return redirect()->to(base_url() . '/admin/login');
			}
		}
		throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	}

	public function logout()
	{
		unset($_SESSION['admin']);
		return redirect()->to(base_url() . '/admin/login');
	}

	public function change_password()
	{
		if ($this->request->getMethod() === 'post') {

			$fields = [
				'password' => 'required'
			];

			$password = $this->request->getVar('password');
			$key = $this->request->getVar('key');

			$LoginModel = new LoginModel();
			$userExists = $LoginModel->where('md5(email)', $key)->first();
			if ($userExists) {

				$pwdPeppered = password_hash($password, PASSWORD_DEFAULT);

				$updateData = [
					"password" => $pwdPeppered
				];

				if ($LoginModel->update($userExists['user_id'], $updateData)) {
					$_SESSION['msg_success'] = "Password Changed Successfully";
					return redirect()->to(base_url() . '/admin/login');
				} else {
					$_SESSION['msg_error'] = "Something went wrong";
					return redirect()->to(base_url() . '/admin/login');
				}
			} else {
				$_SESSION['msg_error'] = "User not found";
				return redirect()->to(base_url() . '/admin/login/reset_password');
			}
		}
		return view('admin/change_password');
	}

	public function reset_password()
	{
		if ($this->request->getMethod() === 'post') {

			$fields = [
				'email' => 'required'
			];

			$email = $this->request->getVar('email');

			$LoginModel = new LoginModel();
			$userExists = $LoginModel->where('email', $email)->first();

			if ($userExists) {
				$resetLink = "<a href='" . base_url() . "/admin/login/change_password?key=" . md5($userExists['email']) . "'>RESET PASSWORD LINK</a>";
				$message = "Hello, <br> Please click $resetLink to reset your password ";

				if (send_email($userExists['email'], "Reset Password Request", $message)) {
					$_SESSION['msg_success'] = "Kindly check your email to reset password";
					return redirect()->to(base_url() . '/admin/login');
				} else {
					$_SESSION['msg_error'] = "Something went wrong while sending email";
					return redirect()->to(base_url() . '/admin/login/reset_password');
				}
			} else {
				$_SESSION['msg_error'] = "User not found";
				return redirect()->to(base_url() . '/admin/login/reset_password');
			}
		}
		return view('admin/reset_password');
	}

	//--------------------------------------------------------------------

}
