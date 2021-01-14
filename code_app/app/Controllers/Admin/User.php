<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LabelModel;
use App\Models\NumberModel;
use App\Models\UserModel;
use App\Models\UserNumberModel;

class User extends BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		$UserModel = new UserModel();
		$labelModel = new LabelModel();

		$UserModel->where(['role_id' => 2]);
		$users = $UserModel->findAll();

		$labelData = $labelModel->where('is_active', 1)->findAll();

		$this->data['users'] = $users;
		$this->data['labels'] = $labelData;
		return view('admin/user_view', $this->data);
	}

	public function insert()
	{
		$UserModel = new UserModel();
		$labelModel = new LabelModel();
		$numberModel = new NumberModel();

		$labels = $labelModel->where('is_active', 1)->findAll();
		$numbers = $numberModel->where('is_active', 1)->findAll();


		$this->data['labels'] = $labels;
		$this->data['numbers'] = $numbers;


		if ($this->request->getMethod() === 'post') {

			$fields = [
				'fullname' => 'required',
				'email' => 'required',
			];
			$validated = $this->validate($fields);
			if (!$validated) {
				return view('admin/user_add', $this->data);
			}

			$fullname = $this->request->getVar('fullname');
			$email = $this->request->getVar('email');
			$numbers = $this->request->getVar('number_ids');
			$ddlabel = $this->request->getVar('ddlabel');

			$emailExist = $UserModel->where("email", $email)->first();
			if ($emailExist) {
				$_SESSION['msg_error'] = "Something went wrong while creating account | EMAILALREADYEXISTS";
				return view('admin/user_add', $this->data);
			}

			$labelData = '';
			if ($ddlabel) {
				foreach ($ddlabel as $labelRow) {
					$labelData .= $labelRow . ",";
				}
				$labelData = rtrim($labelData, ",");
			}
			$password = generateRandomString();
			$pwdPeppered = password_hash($password, PASSWORD_DEFAULT);

			$data = [
				'fullname' => $fullname,
				'email' => $email,
				'password' => $pwdPeppered,
				'label_id' => $labelData,
				'is_active' => 1,
				'role_id' => 2
			];



			if ($UserModel->save($data)) {
				$userId = $UserModel->insertID();

				$UserNumber = new UserNumberModel();

				foreach ($numbers as $row) {
					$data = [
						'user_id' => $userId,
						'number_id' => $row,
						'is_active' => 1,
					];

					$UserNumber->save($data);
				}

				$loginLink = base_url();
				$message = "Hello $fullname, <br> Your account has been created <br> User: $email <br> Password: $pwdPeppered <br> Login Link: $loginLink";

				send_email($email, "New Account Information", $message);

				$_SESSION['msg_success'] = "User added successfully";
				return redirect()->to(base_url() . '/admin/user');
			} else {
				$_SESSION['msg_error'] = "Somethong went wrong while adding a user";
				return redirect()->to(base_url() . '/admin/user/insert')->withInput();
			}
		}

		return view('admin/user_add', $this->data);
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
				return view('admin/user_update');
			}
			$fullname = $this->request->getVar('fullname');
			$email = $this->request->getVar('email');
			$ddlabel = $this->request->getVar('ddlabel');
			$user_id = $this->request->getVar('user_id');
			$password = $this->request->getVar('password');

			$labelData = '';
			if ($ddlabel) {
				foreach ($ddlabel as $labelRow) {
					$labelData .= $labelRow . ",";
				}
				$labelData = rtrim($labelData, ",");
			}
			$data = [
				'user_id' => $user_id,
				'fullname' => $fullname,
				'email' => $email,
				'label_id' => $labelData
			];

			if ($password != "" or $password != NULL) {

				$encryptPassword = password_hash($password, PASSWORD_DEFAULT);

				$data = [
					'user_id' => $user_id,
					'fullname' => $fullname,
					'email' => $email,
					'label_id' => $labelData,
					'password' => $encryptPassword
				];
			}

			if ($UserModel->save($data)) {

				$_SESSION['msg_success'] = "User update successfully";


				return redirect()->to(base_url() . '/admin/user');
			} else {
				$_SESSION['msg_error'] = "Somethong went wrong while updating a user";
				return redirect()->to(base_url() . '/admin/user/update')->withInput();
			}
		}


		$uri = service('uri');
		$id = $uri->getSegment(4);

		$labelModel = new LabelModel();
		$labels = $labelModel->where('is_active', 1)->findAll();


		$user = $UserModel->where('md5(user_id::text)', $id)->first();

		$this->data['update'] = $user;
		$this->data['labels'] = $labels;

		return view('admin/user_update', $this->data);
	}

	public function delete()
	{
		$UserModel = new UserModel();

		$uri = service('uri');
		$id = $uri->getSegment(4);

		if ($UserModel->where('md5(user_id::text)', $id)->delete()) {
			$_SESSION['msg_success'] = "User deleted successfully";
			return redirect()->to(base_url() . '/admin/user');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while deleting a user";
			return redirect()->to(base_url() . '/admin/user');
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
			return redirect()->to(base_url() . '/admin/user');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while updating status";
			return redirect()->to(base_url() . '/admin/user');
		}
	}

	public function update_number()
	{
		$UserModel = new UserModel();
		$userNumberModel = new UserNumberModel();
		$numberModel = new NumberModel();
		$labelModel = new LabelModel();

		$uri = service('uri');

		$id = $uri->getSegment(4);

		$userNumberModel->select("array_to_string(array_agg(number_id), ',') as number_ids");
		$userNumberArray = $userNumberModel->where('md5(user_id::text)', $id)->first();

		$numberIds = $userNumberArray['number_ids'];

		$numberData = $this->db->query("select tbl_numbers.number, tbl_user_numbers.*,tbl_numbers.label_id
		from tbl_user_numbers
		inner join tbl_numbers
		on tbl_user_numbers.number_id = tbl_numbers.number_id
		where md5(tbl_user_numbers.user_id::text) = '$id' and tbl_numbers.deleted_at IS NULL and tbl_user_numbers.deleted_at IS NULL");

		$labelData = $labelModel->where('is_active', 1)->findAll();

		$this->data['numbers'] = $numberData;
		$this->data['id'] = $id;
		$this->data['labels'] = $labelData;

		return view('admin/user_number_view', $this->data);
	}
	//--------------------------------------------------------------------

	public function numberstatus()
	{
		$userNumberModel = new UserNumberModel();
		$uri = service('uri');

		$id = $uri->getSegment(4);
		$status = $uri->getSegment(5);
		$userId = $uri->getSegment(6);

		$update_data = [
			'is_active' => $status
		];

		$row = $userNumberModel->where('md5(un_id::text)', $id)->first();

		if ($userNumberModel->update($row['un_id'], $update_data)) {

			$_SESSION['msg_success'] = "Status changed successfully";
			return redirect()->to(base_url() . '/admin/user');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while updating status";
			return redirect()->to(base_url() . '/admin/user');
		}
	}

	public function numberdelete()
	{
		$userNumberModel = new UserNumberModel();
		$uri = service('uri');
		$id = $uri->getSegment(4);

		if ($userNumberModel->where('md5(un_id::text)', $id)->delete()) {

			$_SESSION['msg_success'] = "Number delete successfully";
			return redirect()->to(base_url() . '/admin/user');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while deleting number";
			return redirect()->to(base_url() . '/admin/user');
		}
	}

	public function getNumbers()
	{

		$labelModel = new LabelModel();

		$uri = service('uri');
		$id = $uri->getSegment(4);

		$numberData = $this->db->query("select * from tbl_numbers where number_id NOT IN (select number_id from tbl_user_numbers where md5(user_id::text) = '$id' and tbl_user_numbers.deleted_at IS NULL) and tbl_numbers.deleted_at IS NULL");

		$labelData = $labelModel->where('is_active', 1)->findAll();

		$this->data['labels'] = $labelData;
		$this->data['numbers'] = $numberData;
		$this->data['id'] = $id;

		return view('admin/assign_number', $this->data);
	}

	public function assignNumber()
	{

		$userNumberModel = new UserNumberModel();
		$numberModel = new NumberModel();
		$userModel = new UserModel();

		$uri = service('uri');
		$numberId = $uri->getSegment(4);
		$userId = $uri->getSegment(5);


		$getNumberId = $numberModel->where('md5(number_id::text)', $numberId)->first()['number_id'];
		$getUserId = $userModel->where('md5(user_id::text)', $userId)->first()['user_id'];

		$data = [
			'user_id' => $getUserId,
			'number_id' => $getNumberId,
			'is_active' => 1,
		];

		if ($userNumberModel->save($data)) {
			$_SESSION['msg_success'] = "Number assigned successfully";
			return redirect()->to(base_url() . '/admin/user');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while assigning a new number";
			return redirect()->to(base_url() . '/admin/user');
		}
	}

	public function edit_profile()
	{
		$userModel = new UserModel();
		$user_id = $_SESSION['admin']['user_id'];

		$userModel->select("fullname,email");
		$user = $userModel->where('user_id', $user_id)->first();

		if ($this->request->getMethod() === 'post') {

			$user_id = $_SESSION['admin']['user_id'];
			$fullname = $this->request->getVar('fullname');
			$email = $this->request->getVar('email');
			$password = $this->request->getVar('password');

			$updateData = [
				"fullname" => $fullname,
				"email" => $email
			];


			if ($password != "" or $password != NULL) {

				$encryptPassword = password_hash($password, PASSWORD_DEFAULT);
				$updateData = [
					"fullname" => $fullname,
					"email" => $email,
					"password" => $encryptPassword
				];
			}

			if ($userModel->where("user_id", $user_id)->set($updateData)->update()) {
				$_SESSION['msg_success'] = "Account information update successfully";
				return redirect()->to(base_url() . '/admin/user/edit_profile');
			} else {
				$_SESSION['msg_success'] = "Something went wrong while updating account information";
				return redirect()->to(base_url() . '/admin/user/edit_profile');
			}
		}
		$this->data['update_data'] = $user;
		return view('admin/edit_profile', $this->data);
	}

	public function sendResetLink()
	{
		$uri = service('uri');
		$email = $uri->getSegment(4);

		if (!$email) {
			$_SESSION['msg_error'] = "Something went wrong";
			return redirect()->to(base_url() . '/admin/user');
		}

		$userModel = new UserModel();
		$userExists = $userModel->where('md5(email)', $email)->first();

		if ($userExists) {
			$resetLink = "<a href='" . base_url() . "/user/login/change_password?key=" . md5($userExists['email']) . "'>RESET PASSWORD LINK</a>";
			$message = "Hello, <br> Please click $resetLink to reset your password ";

			if (send_email($userExists['email'], "Reset Password Request", $message)) {
				$_SESSION['msg_success'] = "Password reset link send successfully";
				return redirect()->to(base_url() . '/admin/user');
			} else {
				$_SESSION['msg_error'] = "Something went wrong, while sending password reset link";
				return redirect()->to(base_url() . '/admin/user');
			}
		} else {
			$_SESSION['msg_error'] = "Something went wrong | USERNOTFOUND";
			return redirect()->to(base_url() . '/admin/user');
		}
	}
}
