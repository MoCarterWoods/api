<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issue_Ticket extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Issue_Ticket_model', 'iss');
    }

    
    public function drop_job_type (){
        $result = $this->iss->drop_job_type();

        echo json_encode($result);
    } 


    public function drop_tool (){
        $result = $this->iss->drop_tool();

        echo json_encode($result);
    } 

    public function drop_problem (){
        $result = $this->iss->drop_problem();

        echo json_encode($result);
    } 

    public function drop_inspec_method (){
        $result = $this->iss->drop_inspec_method();

        echo json_encode($result);
    } 

    public function drop_trouble (){
        $result = $this->iss->drop_trouble();

        echo json_encode($result);
    } 
}