<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common extends MY_Controller{
	function __construct(){
		parent::__construct();
		if(!empty(MODULE_NAME)){
			$this->load->model('common_model');
		}
	}
	
	/* State List by Country ID */
	public function getStateListByCountryID(){
		$country_id = $this->input->post('country_id');
		$state_list = $this->common_model->getStateListByCountryID($country_id);
		$html = '';
		$html .= '<option value="">-- Select --</option>';
		if(!empty($state_list)){
			foreach ($state_list as $s_list){
				$html .= '<option value="'.$s_list->state_id.'">'.$s_list->state_name.'</option>';
			}
		}
		echo $html;
	}

	/* State List by Country ID */
	public function getUnitWiseSubUnit(){
		$unit_id = $this->input->post('unit_id');
		$state_list = $this->common_model->getData('tbl_unit', array('parent_unit_id'=>$unit_id, 'unit_status'=>1), 'multi');
		$html = '';
		$html .= '<option value="">-- Select --</option>';
		if(!empty($state_list)){
			foreach ($state_list as $s_list){
				$html .= '<option value="'.$s_list->unit_id.'">'.$s_list->unit_name.'</option>';
			}
		}
		echo $html;
	}

	public function getCategoryWiseSubCategory(){
		$category_id = $this->input->post('category_id');
		$state_list = $this->common_model->getData('tbl_category', array('parent_category_id'=>$category_id, 'category_status'=>1), 'multi');
		$html = '';
		$html .= '<option value="">-- Select --</option>';
		if(!empty($state_list)){
			foreach ($state_list as $s_list){
				$html .= '<option value="'.$s_list->category_id.'">'.$s_list->category_name.'</option>';
			}
		}
		echo $html;
	}

	/* State List by Country ID */
	public function getEngeryResorWiseUnit(){
		$energy_resources_id = $this->input->post('energy_resources_id');
		$energy_resources_res = $this->common_model->getData('tbl_energy_resources', array('energy_resources_id'=>$energy_resources_id, 'energy_resources_status'=>1), 'single');
		if(!empty($energy_resources_res))
		{
			$unit_res = $this->common_model->getData('tbl_unit', array('unit_id'=>$energy_resources_res->unit_id, 'unit_status'=>1), 'single');
			$sub_unit_res = $this->common_model->getData('tbl_unit', array('unit_id'=>$energy_resources_res->sub_unit_id, 'unit_status'=>1), 'single');
			echo json_encode(array('success'=> true ,'unit_res' => $unit_res, 'sub_unit_res' => $sub_unit_res));
		}
		else
		{
			echo json_encode(array('success'=> false ));
		}
	}

	

}
?>