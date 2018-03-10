<?php
    /**
    * Created By Jagabandhu Roy
    * Software Engineer(Web).
    */
    class Data_validator
    {
        public $data      = array();
        protected $check_arr = array();
        protected $errors;
        public $error_prefix	= '';
	    public $error_suffix	= '';

        function __construct()
        {
            $this->error_suffix='<br>';
        }

        // param1 = field_name, param2= lebel, param3= rules
        //$status['username'] = $form_object->set_rules('username', 'Username', array('required', 'maxlength=3') );
        function set_rules( $field, $lebel, $rules=array() )
        {
            $check_arr = NULL;

            foreach ($rules as $key => $value) {

                if (is_numeric($key)) {

                    $value = trim($value);

                    switch ($value) {

                        case 'required':

                            if ( $_POST[$field] == NULL ) {

                                $check_arr .= " ".$lebel." can not be blank!" ;
                            }
                            break;

                        case 'special_char_except':

                            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST[$field])){

                                $check_arr .= " ".$lebel." should not have special characters ".$_POST[$field]." " ;
                            }
                            break;

                        case 'numeric':

                            if ( !is_numeric($_POST[$field]) ) {
                                $check_arr .= " ".$lebel." must be numeric!";
                            }
                            break;

                        case 'not_negative':

                            if ( !is_numeric($_POST[$field]) ) {

                                    $check_arr .= " ".$lebel." should be numeric ";

                                break;
                            }else{
                                if ( $_POST[$field] < 0 ) {
                                    $check_arr .= " ".$lebel." can not be negative ";
                                }
                                break;
                            }

                        case 'integer':

                            if ( !is_int($_POST[$field]) ) {
                                $check_arr .= " ".$lebel." must be integer!";
                            }
                            break;

                        case 'alpha':

                            if ( !ctype_alpha($_POST[$field]) ) {
                                $check_arr .= " ".$lebel." must be alphabet characters!";
                            }
                            break;

                        case 'alphanumeric':

                            if ( !ctype_alnum($_POST[$field]) ) {
                                $check_arr .= " ".$lebel." must be alphanumeric !";
                            }
                            break;

                        case 'valid_email':

                            if (!filter_var($_POST[$field], FILTER_VALIDATE_EMAIL)) {

                                $check_arr .= " Please enter a valid email!" ;
                            }
                            break;

                        case 'valid_url':

                            if (filter_var($_POST[$field], FILTER_VALIDATE_URL) === false) {

                                $check_arr .= " Please enter a valid url!" ;
                            }
                            break;

                        case 'uppercase':

                            if(!ctype_upper($_POST[$field])){
                                
                                $check_arr .= " Please enter only uppercase in ".$lebel." ." ;
                            }
                            break;

                        default:
                            $check_arr .= "PHP error: Invalid Rule on ".$lebel." value: ".$value;
                            break;
                    }

                }else{

                    $key = trim($key);

                    switch ($key) {

                        case 'maxlength':

                            if ( $_POST[$field] != NULL && strlen($_POST[$field]) > $value ) {
                                $check_arr .= " ".$lebel." can not be greater than ".$value." characters!";
                            }
                            break;

                        case 'minlength':

                            if ( $_POST[$field] != NULL && strlen($_POST[$field]) < $value ) {
                                $check_arr .= " ".$lebel." can not be less than ".$value." characters!";
                            }
                            break;

                        case 'exact_length':

                            if ( $_POST[$field] != NULL && strlen($_POST[$field]) != $value ) {
                                $check_arr .= " ".$lebel." can not be exact ".$value." characters!";
                            }
                            break;

                        case 'greater_than':

                            if ( !is_numeric($_POST[$field]) ) {

                                    $check_arr .= " ".$lebel." should be numeric and greater than ".$value;

                                break;
                            }else{
                                if ( $_POST[$field] <= $value ) {
                                    $check_arr .= " ".$lebel." should be greater than ".$value;
                                }
                                break;
                            }

                        case 'not_greater_than':

                            if ( !is_numeric($_POST[$field]) ) {

                                    $check_arr .= " ".$lebel." should be numeric and not greater than ".$value;

                                break;
                            }else{
                                if ( $_POST[$field] > $value ) {
                                    $check_arr .= " ".$lebel." should not be greater than ".$value;
                                }
                                break;
                            }

                        case 'less_than':

                            if ( !is_numeric($_POST[$field]) ) {

                                    $check_arr .= " ".$lebel." should be numeric and less than ".$value;

                                break;
                            }else{
                                if ( $_POST[$field] >= $value ) {
                                    $check_arr .= " ".$lebel." should be less than ".$value;
                                }
                                break;
                            }

                        case 'not_less_than':

                            if ( !is_numeric($_POST[$field]) ) {

                                    $check_arr .= " ".$lebel." should be numeric and not less than ".$value;

                                break;
                            }else{
                                if ( $_POST[$field] < $value ) {
                                    $check_arr .= " ".$lebel." should not be less than ".$value;
                                }
                                break;
                            }

                        case 'match':

                            if ( $_POST[$field] != $_POST[$value] ) {

                                $check_arr .= " ".$lebel." not match with ".$value."!" ;
                            }
                            break;

                        default:
                            $check_arr .= "PHP error: Invalid Rule-> ".$key;
                            break;
                    }
                }

                if ($check_arr != NULL) {
                    break;
                }

            }

            return $check_arr;
        }

	//function to concat error messages.
        public function get_errorMsg($param1=array())
        {
            $errors = '';

            foreach ($param1 as $key => $value)
            {
                if ($value != NULL)
                {
                    $errors .= $this->error_prefix.$value.$this->error_suffix;
                }
            }
            return $errors;
            if ( strlen($errors) > 0)
            {
                return $errors;
            }
            else
            {
                return NULL;
            }
        }
    }
?>
