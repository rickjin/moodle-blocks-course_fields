<?php
/**
 * *************************************************************************
 * *                  Course Marking Block                                **
 * *************************************************************************
 * @copyright   emeneo.com                                                **
 * @link        emeneo.com                                                **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************
*/
require('../../config.php');

global $CFG, $COURSE, $USER, $DB;

$data = $_POST;
$fields = array();
foreach($data as $key=>$val){
	if(substr($key,0,14) == 'profile_field_'){
		$res = $DB->get_record("course_info_field",array("shortname"=>str_replace(substr($key,0,14),'',$key)));
		if($res){
			if($res->required == 1 && $val<1){
				print_error(get_string('somedataerror', 'block_course_fields'));
				redirect($data['return']);
			}
			$fields[] = array('field_id'=>$res->id,'data'=>$val);
		}
	}
}

if(count($fields)){
	$DB->delete_records('course_info_data', array('course_id'=>$data['courseid']));
	foreach($fields as $field){
		$fieldData->course_id = $data['courseid'] ;
		$fieldData->fieldid = $field['field_id'];
		$fieldData->data = $field['data'];
		$DB->insert_record('course_info_data', $fieldData);
	}
}

redirect($data['return']);
?>