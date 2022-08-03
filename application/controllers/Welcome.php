<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
// ------------------------------------------
	public function ci()
	{
		$this->load->view('welcome_message');
	}
// ------------------------------------------
public function home_fc(){
	// var_dump($this->session->userdata());
	if($this->session->userdata('logged_in') != '1'){redirect('login');}

	$user_id = $this->session->userdata('user_id');
	$table_name = 'users';
	$known_value = $user_id;
	$col_name_of_known_value = 'user_id';
	
	$col_name_of_op_value = 'email_verified';
	$email_verified = $this->get_model->get_any_field_fm($table_name,$known_value,$col_name_of_known_value,$col_name_of_op_value);
	if($email_verified != '1'){redirect('please-verify-your-email');}

	$col_name_of_op_value = 'level_2';
	$level_2 = $this->get_model->get_any_field_fm($table_name,$known_value,$col_name_of_known_value,$col_name_of_op_value);
	if($level_2 != '1'){redirect('search-by-place');}

	$col_name_of_op_value = 'level_3';
	$level_3 = $this->get_model->get_any_field_fm($table_name,$known_value,$col_name_of_known_value,$col_name_of_op_value);
	if(!$level_3){redirect('community-details');}

	$col_name_of_op_value = 'level_4';
	$level_4 = $this->get_model->get_any_field_fm($table_name,$known_value,$col_name_of_known_value,$col_name_of_op_value);
	if(!$level_4){redirect('education-details');}

	$col_name_of_op_value = 'level_5';
	$level_5 = $this->get_model->get_any_field_fm($table_name,$known_value,$col_name_of_known_value,$col_name_of_op_value);
	if(!$level_5){redirect('family-details');}

	$col_name_of_op_value = 'level_6';
	$level_6 = $this->get_model->get_any_field_fm($table_name,$known_value,$col_name_of_known_value,$col_name_of_op_value);
	if(!$level_6){redirect('add-height');}

	$col_name_of_op_value = 'level_7';
	$level_7 = $this->get_model->get_any_field_fm($table_name,$known_value,$col_name_of_known_value,$col_name_of_op_value);
	if(!$level_7){redirect('image-uploader');}

	$data['matches'] = $this->search_model->home_page_results_fm();
	$this->load->view('templates/head/header');
	$this->load->view('home/home',$data);
	$this->load->view('templates/foot/footer');

}
// ------------------------------------------
	public function landing_fc(){
		$this->load->view('templates/head/header');
		// $this->load->view('templates/login_header/login_header');
		
		$this->load->view('landing/landing');
		$this->load->view('templates/foot/footer');

	}
// ------------------------------------------
	public function register_1st_page(){
if($this->session->userdata('level_1') == '1'){redirect('home');}

		$this->form_validation->set_rules('created_by','Profile created by','required');
		$this->form_validation->set_rules('gender','Gender','required');
		$this->form_validation->set_rules('marital_status','Marital Status','required');
		$this->form_validation->set_rules('name_b_g','Name','required');
		$this->form_validation->set_rules('dob','Date of Birth','required');
		$this->form_validation->set_rules('phone_no','Phone No','required');
		$this->form_validation->set_rules('email','Email','required|callback_check_email_exists_fc');
		$this->form_validation->set_rules('password','Password','required');
		$this->form_validation->set_rules('confirm_password','Confirm Password','required');

		if($this->form_validation->run() === false){
				$created_by = $this->input->post('created_by');
			$this->session->set_userdata('created_by', $created_by);
				$gender = $this->input->post('gender');
			$this->session->set_userdata('gender', $gender);
				$marital_status = $this->input->post('marital_status');
			$this->session->set_userdata('marital_status', $marital_status);
					$name_b_g = $this->input->post('name_b_g');
			$this->session->set_userdata('name_b_g', $name_b_g);
					$dob = $this->input->post('dob');
			$this->session->set_userdata('dob', $dob);
					$phone_no = $this->input->post('phone_no');
			$this->session->set_userdata('phone_no', $phone_no);
					$email = $this->input->post('email');
			$this->session->set_userdata('email', $email);


		$this->load->view('templates/head/header');
		$this->load->view('register/register_1st_page');
		$this->load->view('templates/foot/footer');
		}else{
			$created_by = $this->input->post('created_by');
			if($created_by == 'self'){$created_by_id = '0';}
			if($created_by == 'parents'){$created_by_id = '1';}
			if($created_by == 'sibling'){$created_by_id = '2';}
			if($created_by == 'relative'){$created_by_id = '3';}
			if($created_by == 'friend'){$created_by_id = '4';}
			$gender = $this->input->post('gender');
			if($gender == 'male'){$gender_id = '0';}
			if($gender == 'female'){$gender_id = '1';}
			$marital_status = $this->input->post('marital_status');
			if($marital_status == 'unmarried'){$marital_status_id = '0';}
			if($marital_status == 'widow/widower'){$marital_status_id = '1';}
			if($marital_status == 'divorced'){$marital_status_id = '2';}
			if($marital_status == 'seperated'){$marital_status_id = '3';}
			$name_b_g = $this->input->post('name_b_g');
			$dob = $this->input->post('dob');
			$phone_no = $this->input->post('phone_no');
			$email = $this->input->post('email');
			$enc_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$unique_id = random_string('alnum', round(rand(8,14)));
			$data = array(
				'email' => $email,
				'unique_id' => $unique_id,
				'email_verified' => '0',
				'phone_no' => $phone_no,
				'phone_no_verified' => '0',
				'password' => $enc_password,
				'created_by' => $created_by,
				'created_by_id' => $created_by_id,
				'name' => $name_b_g,
				'gender' => $gender,
				'gender_id' => $gender_id,
				'dob' => $dob,
				'marital_status' => $marital_status,
				'marital_status_id' => $marital_status_id,
				'ip_address' => $this->get_model->get_client_ip(),
				'level_1' => '1',
			);
			$table_name = 'users';
			$user_id = $this->insert_model->insert_fm($table_name,$data);
			// $user_id is the insert_id
			// $this->db->insert_id();
			$array_items = array('created_by','gender','marital_status','name_b_g','dob','phone_no','email');
		$this->session->unset_userdata($array_items);

			$this->session->set_userdata('user_id',$user_id);
			$this->session->set_userdata('logged_in','1');
			$this->get_model->set_userdata_from_db($user_id);
			$official_email_sl_no = '1';
			$this->verification_model->send_email_verication_link_fc($user_id,$official_email_sl_no);
		
			redirect('home');
		}
		
		// var_dump($this->session->userdata());
	}
// ------------------------------------------
public function check_email_exists_fc($email){

    $this->form_validation->set_message('check_email_exists_fc', 'Email is already registered');

    if($this->get_model->check_email_exists_fm($email)){
        // returned true from model
        return false;
        // this will return true to set_rules on top
    }else{

        return true;
    }
    // this will returns to set_rules on top
}
// ------------------------------------------
public function login_fc(){
	// $this->session->sess_destroy();
    $this->form_validation->set_rules('email','Email','required|callback_check_email_registered_fc');
	$this->form_validation->set_message('check_email_registered_fc', 'This email is not registered');
    $this->form_validation->set_rules('password','Password','required');
    if($this->form_validation->run() === false){
		$this->load->view('templates/head/header');
		$this->load->view('login/login');

		$this->load->view('templates/foot/footer');
	
	}else{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$table_name = 'users';
    $col_name_of_known_value = 'email';
    $col_name_of_op_value = 'password';
    $known_value = $email;
    $hash = $this->get_model->get_any_field_fm($table_name,$known_value,$col_name_of_known_value,$col_name_of_op_value);
    if(password_verify($password, $hash))
    {
        $this->db->where('email', $email);
        $result = $this->db->get('users')->result_array();
        $user_id = $result[0]['user_id'];
		$unique_id = $result[0]['unique_id'];
		$email_verified = $result[0]['email_verified'];

		$this->session->set_userdata('logged_in','1');
		$this->session->set_userdata('user_id',$user_id);
		$this->session->set_userdata('unique_id',$unique_id);
		$this->session->set_userdata('email_verified',$email_verified);
		$this->session->set_userdata('level_1',$result[0]['level_1']);
		$this->session->set_userdata('level_2',$result[0]['level_2']);
		$this->session->set_userdata('level_3',$result[0]['level_3']);
		$this->session->set_userdata('level_4',$result[0]['level_4']);
		$this->session->set_userdata('level_5',$result[0]['level_5']);
		$this->session->set_userdata('level_6',$result[0]['level_6']);
		$this->session->set_userdata('level_7',$result[0]['level_7']);

		$this->session->set_flashdata('success','Login Successfull');
		redirect('home');
		// var_dump($this->session->userdata());
	}else{
		$this->session->set_flashdata('error','Login is invalid');
		// var_dump($this->session->flashdata());
		// var_dump($this->session->userdata());
		redirect('login');
		
	}


	}
}
// ------------------------------------------
public function check_email_registered_fc($email){

    if($this->get_model->check_email_exists_fm($email)){
        // returned false from model if email dosent exists
        return true;
        // this will return (false) changed from true to set_rules on top
    }else{
        return false;
    }
}
// ------------------------------------------

public function logout_fc(){
	$this->session->sess_destroy();
	// var_dump($this->session->userdata());
	redirect('');
}
// ------------------------------------------

// ------------------------------------------
// ------------------------------------------
// ------------------------------------------
public function community_details_fc(){
	// if($this->session->userdata('logged_in') != '1'){redirect('login');}
	// if($this->session->userdata('level_3') == '1'){redirect('home');}
	$this->check_access_model->check_reg_page_access_fm();


		
	$query = $this->db->get('relegion_list');
	$result = $query->result_array();
	$data['relegion_list'] = $result;

	// $this->db->order_by('no_of_users','desc');
	$query = $this->db->get('language_list');
	$result = $query->result_array();
	$data['language_list'] = $result;

	$query = $this->db->get('caste_id');
	$result = $query->result_array();
	$data['caste_id_table'] = $result;


	$this->load->view('templates/head/header');
    $this->load->view('register/community_details',$data);
    $this->load->view('templates/foot/footer');

}
// ------------------------------------------
public function caste_selected(){
	if($this->session->userdata('logged_in') != '1'){redirect('login');}
	if($this->session->userdata('level_3') == '1'){redirect('home');}
	$this->check_access_model->check_reg_page_access_fm();

	$language = $this->input->post('language');
	$relegion = $this->input->post('relegion');
	// $this->session->set_userdata('temp_rel',$relegion);
	$caste = $this->input->post('caste');
	// $this->session->set_userdata('temp_cas',$caste);

// var_dump($this->session->userdata());
	redirect('community-details/'.$language.'/'.$relegion.'/'.$caste);

}
// ------------------------------------------
public function community_details_language_relegion_caste_fc($language,$relegion,$caste){
	if($this->session->userdata('logged_in') != '1'){redirect('login');}
	if($this->session->userdata('level_3') == '1'){redirect('home');}
	$this->check_access_model->check_reg_page_access_fm();

	

	$this->session->set_userdata('temp_lan',$language);
	$this->session->set_userdata('temp_rel',$relegion);
	$this->session->set_userdata('temp_cas',$caste);

	$query = $this->db->get('relegion_list');
	$result = $query->result_array();
	$data['relegion_list'] = $result;
	
	$query = $this->db->get('language_list');
	$result = $query->result_array();
	$data['language_list'] = $result;

	$query = $this->db->get('caste_id');
	$result = $query->result_array();
	$data['caste_id_table'] = $result;
	$data['caste_name'] = $caste;
	$data['relegion'] = $relegion;

	$this->db->where('caste',$caste);
	$query = $this->db->get('caste_list');
	$result = $query->result_array();
	// var_dump($result);
	$data['sub_caste_list'] = $result; 

	$this->load->view('templates/head/header');
    $this->load->view('register/community_details',$data);
    $this->load->view('templates/foot/footer');
}
// ------------------------------------------
public function sub_caste_selected(){
	if($this->session->userdata('logged_in') != '1'){redirect('login');}
	if($this->session->userdata('level_3') == '1'){redirect('home');}
	$this->check_access_model->check_reg_page_access_fm();

	$language = $this->session->userdata('temp_lan');
	$relegion = $this->session->userdata('temp_rel');
	$caste = $this->session->userdata('temp_cas');
	$sub_caste = $this->input->post('sub_caste');
	$this->session->set_userdata('temp_sub_cas',$sub_caste);
	// var_dump($this->session->userdata());
	redirect('community-details/'.$language.'/'.$relegion.'/'.$caste.'/'.$sub_caste);
}

// ------------------------------------------
public function community_details_language_relegion_caste_subcaste_fc($language,$relegion,$caste,$sub_caste){
	if($this->session->userdata('logged_in') != '1'){redirect('login');}
	if($this->session->userdata('level_3') == '1'){redirect('home');}
	$this->check_access_model->check_reg_page_access_fm();

	// $query = $this->db->get('caste_id');
	// $result = $query->result_array();
	// $data['caste_id_table'] = $result;
	// $data['caste_name'] = $caste;
	// $this->db->where('caste',$caste);
	// $query = $this->db->get('caste_list');
	// $result = $query->result_array();
	// $data['sub_caste_list'] = $result; 
	// $data['sub_caste_name'] = $sub_caste;
	// $data['relegion'] = ucwords(strtolower($this->session->userdata('temp_rel')));
	// $data['language'] = $language;
	$known_value = $language;
	$table_name = 'language_list';
	$col_name_of_known_value = 'slug';
	$col_name_of_op_value = 'language';
	$mother_tounge = $this->get_model->get_any_field_fm($table_name,$known_value,$col_name_of_known_value,$col_name_of_op_value);
	$data['language'] = $mother_tounge;
	$col_name_of_op_value = 'sl_no';
	$language_id = $this->get_model->get_any_field_fm($table_name,$known_value,$col_name_of_known_value,$col_name_of_op_value);
	$data['relegion'] = $relegion;
	$data['caste'] = $caste;
	$data['sub_caste'] = $sub_caste;
	$this->form_validation->set_rules('caste','Caste','required');
	if(!$this->form_validation->run()){
	$this->load->view('templates/head/header');
    $this->load->view('register/save_community_details',$data);
    $this->load->view('templates/foot/footer');
	}else{
		$data = array(
			'mother_tounge' => $mother_tounge,
			'language_id' => $language_id,
			'relegion' => $relegion,
			'caste' => $caste,
			'sub_caste' => $sub_caste,
			'level_3' => '1',
		);
		$user_id = $this->session->userdata('user_id');
		// echo $user_id;
		// var_dump($this->session->userdata());
		$this->db->where('user_id',$user_id);
		$this->db->update('users',$data);
		redirect('home');
	}
}
// ------------------------------------------
public function go_back_to_community(){
	$this->session->unset_userdata('temp_lan');
	$this->session->unset_userdata('temp_rel');
	$this->session->unset_userdata('temp_cas');
	$this->session->unset_userdata('temp_sub_cas');
	redirect('community-details');
}

// --------------------================================----------------------
// ------------------------------------------
public function family_details_fc(){
	if($this->session->userdata('logged_in') != '1'){redirect('login');}
	if($this->session->userdata('level_5') == '1'){redirect('home');}
	$this->check_access_model->check_reg_page_access_fm();

	$data['family_class_list'] = $this->db->get('family_class')->result_array();

	$this->form_validation->set_rules('family_class','','required');
	if(!$this->form_validation->run()){
	$this->load->view('templates/head/header');
    $this->load->view('register/family_details',$data);
    $this->load->view('templates/foot/footer');
	}else{
		$mothers_name = $this->input->post('mothers_name');
		$fathers_name = $this->input->post('fathers_name');
		$family_class = $this->input->post('family_class');
		$data = array(
			'mothers_name' => $mothers_name,
			'fathers_name' => $fathers_name,
			'family_class' => $family_class,
			'level_5' => 1,
		);
		$user_id = $this->session->userdata('user_id');
		$this->db->where('user_id',$user_id);
		$this->db->update('users',$data);
		redirect('home');
	}
}
// ------------------------------------------
public function height_calculator_fc(){
	// add-height
	if($this->session->userdata('logged_in') != '1'){redirect('login');}
	$this->check_access_model->check_reg_page_access_fm();
	$user_id = $this->session->userdata('user_id');
	$this->form_validation->set_rules('height_in_cm','','required');
	$data_to_view['current_value'] = $this->db->where('user_id',$user_id)->get('users')->row_array()['height_cm'];

	if(!$this->form_validation->run()){
	$this->load->view('templates/head/header');
    $this->load->view('register/height_details',$data_to_view);
    $this->load->view('templates/foot/footer');
	}else{
		// height in cm
		$height_in_cm = $this->input->post('height_in_cm');

		//height in feet and inch
		$height_in_feet = ($height_in_cm / 30.48);
		$whole = floor($height_in_feet);
		$decimal = $height_in_feet - $whole ;
		$inch = floor($decimal * 12) ;
		$string = $whole.' ft '.$inch.' in';
		// 1 feet = 12 inches
		// $whole feet #inch inch

		//height in feet only
		$height_in_feet_rounded = number_format($height_in_feet,1);

		$data = array(
			'height_cm' => $height_in_cm,
			'height_feet' => $height_in_feet_rounded,
			'height_feet_inch' => $string,
			'level_6' => 1,
		);
		$user_id = $this->session->userdata('user_id');
		$this->db->where('user_id',$user_id);
		$this->db->update('users',$data);
		if(!is_null($data_to_view['current_value'])){

			redirect('your-profile/#height');
	}else{
		redirect('home');
	}
	}
}
// ------------------------------------------
// ------------------------------------------
// ------------------------------------------
// ------------------------------------------
// ------------------------------------------
public function privacy_policy_fc(){
	$this->load->view('templates/head/header');
    $this->load->view('policies/privacy_policy');
    $this->load->view('templates/foot/footer');
}
// ------------------------------------------
public function terms_and_conditions_fc(){
	$this->load->view('templates/head/header');
    $this->load->view('policies/terms_and_conditions');
    $this->load->view('templates/foot/footer');
}
// ------------------------------------------
// ------------------------------------------
// ------------------------------------------





}
