<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LabelModel;

class Label extends BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		$LabelModel = new LabelModel();
		$labels = $LabelModel->findAll();
		$this->data['labels'] = $labels;
		return view('admin/label_view', $this->data);
	}

	public function insert()
	{
		if ($this->request->getMethod() === 'post') {

			$fields = [
				'label_name' => 'required'
			];
			$validated = $this->validate($fields);
			if (!$validated) {
				return view('admin/label_add');
			}
			$label = $this->request->getVar('label_name');

			$data = [
				'label_name' => $label,
				'is_active' => 1
			];
			$LabelModel = new LabelModel();

			if ($LabelModel->save($data)) {

				$_SESSION['msg_success'] = "Label added successfully";

				return redirect()->to(base_url() . '/admin/label');
			} else {
				$_SESSION['msg_error'] = "Somethong went wrong while adding a label";
				return redirect()->to(base_url() . '/admin/label/insert')->withInput();
			}
		}

		return view('admin/label_add');
	}

	public function update()
	{
		$LabelModel = new LabelModel();
		$uri = service('uri');
		$id = $uri->getSegment(4);

		if ($this->request->getMethod() === 'post') {

			$fields = [
				'label_name' => 'required'
			];
			$validated = $this->validate($fields);
			if (!$validated) {
				return view('admin/label_add');
			}
			$label_id = $this->request->getVar('label_id');
			$label = $this->request->getVar('label_name');

			$data = [
				'label_id' => $label_id,
				'label_name' => $label,
				'is_active' => 1
			];

			if ($LabelModel->save($data)) {

				$_SESSION['msg_success'] = "Label updated successfully";

				return redirect()->to(base_url() . '/admin/label');
			} else {
				$_SESSION['msg_error'] = "Somethong went wrong while updating a label";
				return redirect()->to(base_url() . '/admin/label/update')->withInput();
			}
		}

		$labelData = $LabelModel->where('md5(label_id::text)', $id)->first();
		$this->data['update'] = $labelData;

		return view('admin/label_update', $this->data);
	}

	public function delete()
	{
		$LabelModel = new LabelModel();

		$uri = service('uri');
		$id = $uri->getSegment(4);

		if ($LabelModel->where('md5(label_id::text)', $id)->delete()) {
			$_SESSION['msg_success'] = "Label deleted successfully";
			return redirect()->to(base_url() . '/admin/label');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while deleting a label";
			return redirect()->to(base_url() . '/admin/label');
		}
	}

	public function status()
	{
		$LabelModel = new LabelModel();
		$uri = service('uri');

		$id = $uri->getSegment(4);
		$status = $uri->getSegment(5);

		$update_data = [
			'is_active' => $status
		];

		$row = $LabelModel->where('md5(label_id::text)', $id)->first();
		if ($LabelModel->update($row['label_id'], $update_data)) {
			$_SESSION['msg_success'] = "Status changed successfully";
			return redirect()->to(base_url() . '/admin/label');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while updating status";
			return redirect()->to(base_url() . '/admin/label');
		}
	}
	//--------------------------------------------------------------------

}
