<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('viewStatus'))
{
	function viewStatus($status_id)
	{
	if($status_id==1)
		return '<span style="color: green;" >Active</span>';
	else if($status_id==0)
		return '<span style="color: red;" >Inactive</span>';
	else
		return '';
	}
}

if ( ! function_exists('minuteAdd')){
	function minuteAdd($date,$add){
	 $date = date_create($date);
	
	 date_add($date,date_interval_create_from_date_string($add." minutes"));
	 return date_format($date,"Y-m-d H:i:s");
	}
}

if ( ! function_exists('minuteDiffrence')){
function minuteDiffrence($start,$end){
$start_date = new DateTime($start);
$since_start = $start_date->diff(new DateTime($end));

$minutes = $since_start->days * 24 * 60;
$minutes += $since_start->h * 60;
$minutes += $since_start->i;
return $minutes;
}
}


if ( ! function_exists('ipLockAction')){
	function ipLockAction($type='login'){
		$CI = &get_instance();
		$lock_session = $CI->session->all_userdata();
		if(isset($lock_session) && (!empty($lock_session['qc_lockdown']))){
            return 'Your account has been locked for 30 minutes.';
        }

        $ip = $_SERVER['REMOTE_ADDR'];
		$res = $CI->common_model->getData('tbl_ip_lockdown',array('ip'=>$ip,'DATE_ADD(lock_time, INTERVAL 30 MINUTE) >='=>date('Y-m-d H:i:s'),'type'=>$type), 'single');
		if(!empty($res)){
          if($res->count>=3){
          	$minuteAdd = minuteAdd($res->lock_time,30);
          	$CI->session->set_userdata('qc_lockdown', strtotime($minuteAdd));
          	return 'Your account has been locked. You can login after '.minuteDiffrence($res->lock_time,$minuteAdd). ' minutes';
          }
          else{
          	$post['lock_time'] = date('Y-m-d H:i:s');
          	$post['count'] = $res->count+1;
          	$CI->common_model->updateData('tbl_ip_lockdown',array('id'=>$res->id), $post);
          	return '';
          }
		}
		else{
			$post['ip'] = $ip;
			$post['lock_time'] = date('Y-m-d H:i:s');
			$post['count'] = 1;
			$post['type '] = $type;
			$CI->common_model->addData('tbl_ip_lockdown',$post);
			return '';
		}
	}
}