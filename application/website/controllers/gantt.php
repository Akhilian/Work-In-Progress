<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gantt extends CI_Controller {

	public function index($id = '') {
	
		if(isset($id) && !empty($id) && is_numeric($id))
		{
			$this->load->model('gantt_m');
			$data = $this->gantt_m->getAll($id);
			
			$this->load->view('header');
			$this->load->view('gantt/index', array('diagramms' => $data, 'projectId' => $id));
			$this->load->view('footer');
		}
		else
		{
			redirect(site_url());
		}
	}
	
	public function edit($project, $id = '') {
		
		if( ! empty($id) && is_numeric($id))
		{
			$this->load->model('gantt_m', 'Gantt');
			$this->load->model('project_m');
			
			if( $this->Gantt->checkMember($id) === true )
			{

				// JSON encoded gantt data 
				$ganttData = $this->Gantt->getJSON($id);

				$this->load->view('header');
				$this->load->view('gantt/diagramm3', array('projectId' => $project, 'data' => $ganttData));
				$this->load->view('footer');
			}
			else
				redirect('home/restricted');
		}
		else
			redirect('home/restricted');
	
	}
	
	public function add($idProject) {
	
		$this->load->model('gantt_m');
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="alert">','</p>');
		
		$this->form_validation->set_rules('inputName', 'Intitulé', 'required');
	
		if($this->form_validation->run() == true)
		{
			$this->gantt_m->add($idProject, $this->input->post('inputName'));
			redirect('gantt/index/' . $idProject);
		}
		else
		{
			$this->load->view('header');
			$this->load->view('gantt/addGantt', array('id' => $idProject));
			$this->load->view('footer');
		}
	
	}
	
	public function remove($id) {
	
	}
	
	public function draw() {
	
		$this->load->view('header');
		$this->load->view('gantt/index');
		$this->load->view('footer');
	
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/gantt.php */