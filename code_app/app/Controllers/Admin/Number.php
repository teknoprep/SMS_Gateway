<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CarrierModel;
use App\Models\LabelModel;
use App\Models\NumberModel;

class Number extends BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		$NumberModel = new NumberModel();
		$labelModel = new LabelModel();
		$numbers = $NumberModel->findAll();

		$labelData = $labelModel->where('is_active', 1)->findAll();

		$this->data['numbers'] = $numbers;
		$this->data['labels'] = $labelData;

		return view('admin/number_view', $this->data);
	}

	public function insert()
	{
		$NumberModel = new NumberModel();
		$labelModel = new LabelModel();
		$labels = $labelModel->where('is_active', 1)->findAll();

		$CarrierModel = new CarrierModel();
		$carriers = $CarrierModel->where('is_active', 1)->findAll();

		$this->data['labels'] = $labels;
		$this->data['carriers'] = $carriers;

		if ($this->request->getMethod() === 'post') {

			$fields = [
				'number' => 'required'
			];
			$validated = $this->validate($fields);
			if (!$validated) {
				return view('admin/number_add');
			}
			$number = $this->request->getVar('number');
			$number_label = $this->request->getVar('number_label');
			$carrier_id = $this->request->getVar('carrier_id');
			$ddlabel = $this->request->getVar('ddlabel');

			$numberExist = $NumberModel->where("number", $number)->first();
			if ($numberExist) {
				$_SESSION['msg_error'] = "Something went wrong while adding a number | NUMBERALREADYEXISTS";
				return view('admin/number_add', $this->data);
			}

			$labelData = '';
			if ($ddlabel) {
				foreach ($ddlabel as $labelRow) {
					$labelData .= $labelRow . ",";
				}
				$labelData = rtrim($labelData, ",");
			}
			$data = [
				'number' => $number,
				'number_label' => $number_label,
				'carrier_id' => $carrier_id,
				'label_id' => $labelData,
				'is_active' => 1
			];

			if ($NumberModel->save($data)) {

				$_SESSION['msg_success'] = "Number added successfully";

				return redirect()->to(base_url() . '/admin/number');
			} else {
				$_SESSION['msg_error'] = "Somethong went wrong while adding a number";
				return redirect()->to(base_url() . '/admin/number/insert')->withInput();
			}
		}

		return view('admin/number_add', $this->data);
	}

	public function update()
	{
		$NumberModel = new NumberModel();

		if ($this->request->getMethod() === 'post') {


			$number = $this->request->getVar('number');
			$number_label = $this->request->getVar('number_label');
			$carrier_id = $this->request->getVar('carrier_id');
			$ddlabel = $this->request->getVar('ddlabel');
			$number_id = $this->request->getVar('number_id');

			$labelData = '';
			if ($ddlabel) {
				foreach ($ddlabel as $labelRow) {
					$labelData .= $labelRow . ",";
				}
				$labelData = rtrim($labelData, ",");
			}
			$data = [
				'number_id' => $number_id,
				'carrier_id' => $carrier_id,
				'number' => $number,
				'number_label' => $number_label,
				'label_id' => $labelData,
			];

			if ($NumberModel->save($data)) {

				$_SESSION['msg_success'] = "Number update successfully";

				return redirect()->to(base_url() . '/admin/number');
			} else {
				$_SESSION['msg_error'] = "Somethong went wrong while updating a number";
				return redirect()->to(base_url() . '/admin/number/insert')->withInput();
			}
		}
		$labelModel = new LabelModel();
		$labels = $labelModel->where('is_active', 1)->findAll();
		$this->data['labels'] = $labels;

		$CarrierModel = new CarrierModel();
		$carriers = $CarrierModel->where('is_active', 1)->findAll();
		$this->data['carriers'] = $carriers;


		$uri = service('uri');
		$id = $uri->getSegment(4);

		$numberData = $NumberModel->where('md5(number_id::text)', $id)->first();
		$this->data['update'] = $numberData;

		return view('admin/number_update', $this->data);
	}

	public function delete()
	{
		$NumberModel = new NumberModel();

		$uri = service('uri');
		$id = $uri->getSegment(4);

		if ($NumberModel->where('md5(number_id::text)', $id)->delete()) {
			$_SESSION['msg_success'] = "Number deleted successfully";
			return redirect()->to(base_url() . '/admin/number');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while deleting a number";
			return redirect()->to(base_url() . '/admin/number');
		}
	}

	public function status()
	{
		$NumberModel = new NumberModel();
		$uri = service('uri');

		$id = $uri->getSegment(4);
		$status = $uri->getSegment(5);

		$update_data = [
			'is_active' => $status
		];

		$row = $NumberModel->where('md5(number_id::text)', $id)->first();
		if ($NumberModel->update($row['number_id'], $update_data)) {
			$_SESSION['msg_success'] = "Status changed successfully";
			return redirect()->to(base_url() . '/admin/number');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while updating status";
			return redirect()->to(base_url() . '/admin/number');
		}
	}
	//--------------------------------------------------------------------

}
