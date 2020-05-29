<?php

/**
 * HostForm class.
 * HostForm is the data structure for keeping
 * user Host form data. It is used by the 'Host' action of 'ThinuiController'.
 */
class HostForm extends CFormModel
{
        public $oldpass;
        public $newpass;
        public $confirmpass;
        
        public $description;
        public $applicationserver;
        public $routingstring;
        public $routerport;
        public $systemnum;
        public $messageserver;
        public $group;
        public $systemid;
        public $firstname;
        public $lastname;
        public $phoneno;
        public $companyname;
        public $company_name;
        public $company_address;
        public $role;
        public $streetaddress;
        public $city;
        public $state;
        public $country;
        public $bapiversion;
        
    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // name, email, subject and body are required
            // array('firstname, lastname, email, password, repassword, secques1, secans1, secques2, secans2,  street, city, state, country, phone, company', 'required'),
            // email has to be a valid email address
            // array('email', 'email'),
                        // phone has to be a valid phone number
                        // array('phone', 'application.extensions.UKPhoneValidator'),
            // verifyCode needs to be entered correctly
            // array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {   
            return array(
                'oldpass'=>_ENTEROLDPASS.' <span>*</span>:',
                'newpass'=> _ENTERNEWPASS.' <span>*</span>:',
                'confirmpass'=> _CONFIRMPASS.' <span>*</span>:',
                
                'description'=>_DESCRIPTION.'Description <span>*</span>:',
                'applicationserver'=>_APPLICATIONSERVER.' <span>*</span>:',
                'routingstring'=>_ROUTERIP.' / Address :',
                'routerport'=>_ROUTERPORT.' :',
                'systemnum'=> _INSTANCENUMBER.' <span>*</span>:',
                'messageserver'=>_MESAGGESERVER.' <span>*</span>:',
                'group'=>_GROUP.' <span>*</span>:',
                'systemid'=>_SYSTEMID.' <span> *</span>:',
                'language'=>_LANGUAGE.' <span> *</span>:',
                'bapiversion'=>_BAPIVERSION.' <span>*</span>:',
                'firstname'=> _NAME.' <span>*</span>:',
                'lastname'=>_LASTNAME.' <span>*</span>:',
                'phoneno'=>_PHONE.' <span>*</span>:',
                'companyname'=>_COMPANYNAME.' :',
                'company_name'=>_COMPANYNAME.':',
                'company_address'=>_COMPANYADDRESS.':',
                'role'=>_ROLE.' :',
                'streetaddress'=>_STREETADDRESS.' <span>*</span>:',
                'city'=>_CITY.' <span> *</span>:',
                'state'=>_STATE.' <span> *</span>:',
                'country'=>_COUNTRY.' <span> *</span>:',
            );
    }
}