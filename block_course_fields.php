<?php
/**
 * *************************************************************************
 * *                  Course Fields Block                                 **
 * *************************************************************************
 * @copyright   emeneo.com                                                **
 * @link        emeneo.com                                                **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************
*/
class block_course_fields extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_course_fields');
    }

    public function instance_allow_multiple() {
        return false;
    }

    public function has_config() {
        return true;
    }

	public function get_content() {
		global $CFG, $COURSE, $USER, $DB;

		if ($this->content !== null) {
		  return $this->content;
		}

		if(has_capability('block/course_fields:admin', get_context_instance(CONTEXT_COURSE, $COURSE->id))){
			require_once($CFG->dirroot."/local/course_fields/course/course_form.php");
			$categorys = $DB->get_records('course_info_categories', array('course_category'=>$COURSE->category));
			$usedFields = $DB->get_records('course_info_data', array('course_id'=>$COURSE->id));
			$savedFields = array();
			foreach($usedFields as $usedField){
				$savedFields[$usedField->fieldid] = $usedField->data;
			}

			if(count($categorys)){
				$build = '';
			$build.= '<div style="margin-left:15px;">';
			$build.= '<form autocomplete="off" action="'.$CFG->wwwroot.'/blocks/course_fields/update.php" method="post" accept-charset="utf-8" id="mform1" class="mform">';
			$build.= '<input type="hidden" name="courseid" value="'.$COURSE->id.'">';
			$build.= '<input type="hidden" name="return" value="'.$CFG->wwwroot.'/course/view.php?id='.$COURSE->id.'">';
			foreach($categorys as $category){
				$fields = $DB->get_records('course_info_field', array('categoryid'=>$category->categoryid));
				if(count($fields)){
					$fieldCategory = $DB->get_record('course_info_category', array('id'=>$category->categoryid));
					$build.='<div style="margin:10px 0 0 0;"><strong>'.$fieldCategory->name.'</strong></div>';
					foreach($fields as $field){
						$checked = '';
						if(isset($savedFields[$field->id])){
							if($savedFields[$field->id] == 1)$checked = 'checked';
						}else{
							if($field->defaultdata == 1){
								$checked = 'checked';
							}
						}

						$build.='<div id="fitem_id_profile_field_'.$field->shortname.'" style="margin:5px 0 0 0;">';
						$build.='<div style="float:left;padding-right:5px;">';
						$build.='<label for="id_profile_field_'.$field->shortname.'">'.$field->name.'</label>';
						$build.='</div>';
						$build.='<div class="felement fcheckbox">';
						$build.='<span><input type="hidden" name="profile_field_'.$field->shortname.'" value="0"><input name="profile_field_'.$field->shortname.'" type="'.$field->datatype.'" value="1" id="id_profile_field_'.$field->shortname.'" '.$checked.'></span>';
						$build.='</div>';
						$build.='</div>';
					}
				}
			}
			$build.='<div style="margin-top:10px;algin:center;"><input name="submitbutton" value="Save changes" type="submit" id="id_submitbutton"></div>';
			$build.='</form>';
			$build.= '</div>';
			}else{
				$build = get_string('nocursefields','block_course_fields');
			}

			$this->content         =  new stdClass;
			$this->content->text   = $build;
 
			return $this->content;
		}
	}
}
?>