<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: User
 * 
 * Automatically generated via CLI.
 */
class Crud_Controller extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->model('crud_Model');
        $this->call->library('form_validation');

        // $this->call->helper('message');
    }

       public function read() 
    {
        
        $page = 1;
        if(isset($_GET['page']) && ! empty($_GET['page'])) {
            $page = $this->io->get('page');
        }

        $q = '';
        if(isset($_GET['q']) && ! empty($_GET['q'])) {
            $q = trim($this->io->get('q'));
        }

        $records_per_page = 2;

        $all = $this->crud_Model->page($q, $records_per_page, $page);
        $data['all'] = $all['records'];
        $total_rows = $all['total_rows'];
        $this->pagination->set_options([
            'first_link'     => '⏮ First',
            'last_link'      => 'Last ⏭',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);
        $this->pagination->set_theme('bootstrap'); // or 'tailwind', or 'custom'
        $this->pagination->initialize($total_rows, $records_per_page, $page, '/?q='.$q);
        $data['page'] = $this->pagination->paginate();
        $this->call->view('index', $data);
    }


 public function createUser()
    {
        $this->form_validation
            ->name('student_id')->required()->max_length(20)
            ->name('full_name')->required()->max_length(100)
            ->name('class')->required()->max_length(50)
            ->name('section')->required()->max_length(10)
            ->name('attendance_date')->required()
            ->name('time_in')->required()
            ->name('time_out')->required();
        

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->get_errors();
            setErrors($errors);
            redirect('/');
        } else {
            $this->crud_Model->insert([
                'student_id'      => $_POST['student_id'],
                'full_name'       => $_POST['full_name'],
                'class'           => $_POST['class'],
                'section'         => $_POST['section'],
                'attendance_date' => $_POST['attendance_date'],
                'time_in'         => $_POST['time_in'],
                'time_out'        => $_POST['time_out']
            ]);

            setMessage('success', 'Attendance record added!');
            redirect('/');
        }
    }

    public function updateUser($id){
        $this->crud_Model->update($id, [
            'student_id'      => $_POST['student_id'],
            'full_name'       => $_POST['full_name'],
            'class'           => $_POST['class'],
            'section'         => $_POST['section'],
            'attendance_date' => $_POST['attendance_date'],
            'time_in'         => $_POST['time_in'],
            'time_out'        => $_POST['time_out']
        ]);
        setMessage('success', 'Attendance record updated!');
        redirect('/');
    }

    public function deleteUser($id){
        $this->crud_Model->delete($id);
        setMessage('danger', 'Attendance record deleted.');
        redirect('/');
    }
}

