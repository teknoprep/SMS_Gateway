<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LabelModel;
use App\Models\CarrierModel;

class Carrier extends BaseController
{
	public function __construct()
	{
	}

	public function index()
	{
		$CarrierModel = new CarrierModel();
		$labelModel = new LabelModel();
		$numbers = $CarrierModel->findAll();

		$labelData = $labelModel->where('is_active', 1)->findAll();

		$this->data['numbers'] = $numbers;
		$this->data['labels'] = $labelData;

		return view('admin/carrier_view', $this->data);
	}

	public function insert()
	{
		if ($this->request->getMethod() === 'post') {

			$fields = [
				'name' => 'required'
			];
			$validated = $this->validate($fields);
			if (!$validated) {
				return view('admin/carrier_add');
			}
			$name = $this->request->getVar('name');
			$function = $this->request->getVar('function');
			$ddlabel = $this->request->getVar('ddlabel');

			$labelData = '';
			if ($ddlabel) {
				foreach ($ddlabel as $labelRow) {
					$labelData .= $labelRow . ",";
				}
				$labelData = rtrim($labelData, ",");
			}
			$data = [
				'name' => $name,
				'function' => $function,
				'label_id' => $labelData,
				'is_active' => 1
			];
			$CarrierModel = new CarrierModel();

			if ($CarrierModel->save($data)) {

				$_SESSION['msg_success'] = "Carrier added successfully";

				return redirect()->to(base_url() . '/admin/carrier');
			} else {
				$_SESSION['msg_error'] = "Somethong went wrong while adding a name";
				return redirect()->to(base_url() . '/admin/carrier/insert')->withInput();
			}
		}
		$labelModel = new LabelModel();
		$labels = $labelModel->where('is_active', 1)->findAll();

		$this->data['labels'] = $labels;


		return view('admin/carrier_add', $this->data);
	}

	public function update()
	{
		$CarrierModel = new CarrierModel();

		if ($this->request->getMethod() === 'post') {


			$name = $this->request->getVar('name');
			$function = $this->request->getVar('function');
			$ddlabel = $this->request->getVar('ddlabel');
			$carrier_id = $this->request->getVar('carrier_id');

			$labelData = '';
			if ($ddlabel) {
				foreach ($ddlabel as $labelRow) {
					$labelData .= $labelRow . ",";
				}
				$labelData = rtrim($labelData, ",");
			}
			$data = [
				'carrier_id' => $carrier_id,
				'function' => $function,
				'name' => $name,
				'label_id' => $labelData,
			];

			if ($CarrierModel->save($data)) {

				$_SESSION['msg_success'] = "Carrier update successfully";

				return redirect()->to(base_url() . '/admin/carrier');
			} else {
				$_SESSION['msg_error'] = "Somethong went wrong while updating a name";
				return redirect()->to(base_url() . '/admin/carrier/insert')->withInput();
			}
		}
		$labelModel = new LabelModel();
		$labels = $labelModel->where('is_active', 1)->findAll();
		$this->data['labels'] = $labels;


		$uri = service('uri');
		$id = $uri->getSegment(4);

		$numberData = $CarrierModel->where('md5(carrier_id::text)', $id)->first();
		$this->data['update'] = $numberData;

		return view('admin/carrier_update', $this->data);
	}

	public function delete()
	{
		$CarrierModel = new CarrierModel();

		$uri = service('uri');
		$id = $uri->getSegment(4);

		if ($CarrierModel->where('md5(carrier_id::text)', $id)->delete()) {
			$_SESSION['msg_success'] = "Carrier deleted successfully";
			return redirect()->to(base_url() . '/admin/carrier');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while deleting a name";
			return redirect()->to(base_url() . '/admin/carrier');
		}
	}

	public function status()
	{
		$CarrierModel = new CarrierModel();
		$uri = service('uri');

		$id = $uri->getSegment(4);
		$status = $uri->getSegment(5);

		$update_data = [
			'is_active' => $status
		];

		$row = $CarrierModel->where('md5(carrier_id::text)', $id)->first();
		if ($CarrierModel->update($row['carrier_id'], $update_data)) {
			$_SESSION['msg_success'] = "Status changed successfully";
			return redirect()->to(base_url() . '/admin/carrier');
		} else {
			$_SESSION['msg_error'] = "Something went wrong while updating status";
			return redirect()->to(base_url() . '/admin/carrier');
		}
	}
	//--------------------------------------------------------------------

}
