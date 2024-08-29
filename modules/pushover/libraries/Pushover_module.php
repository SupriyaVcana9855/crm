<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pushover_module
{
    private $ci;
    private $pushover_token = '';
    private $pushover_key = '';
    private $pushover_admin_reply = '';

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ci->load->model('tickets_model');
        $this->ci->load->model('projects_model');
        $this->ci->load->model('leads_model');
        $this->ci->load->model('payments_model');
        $this->pushover_token = get_option('pushover_token');
        $this->pushover_key = get_option('pushover_key');
        $this->pushover_admin_reply = get_option('pushover_admin_reply');
    }

    public function send_new_ticket_alert( $id = '' )
    {
        if( !isset($this->pushover_token) && $this->pushover_token != '' || !isset($this->pushover_key) && $this->pushover_key != '' ){
            log_activity(_l('pushover_key_not_set'));
            die();
        }else{
            $ticket = $this->ci->tickets_model->get_ticket_by_id($id);
            $title = _l('pushover_new_ticket_created').': #'.$id;
            $url = admin_url('tickets/ticket/' . $id );
            // Send the notification
            $this->send_pushover($title, $ticket->message, $url); // Send the notification
        }
    }

    public function send_update_ticket_alert( $data = [] )
    {
        if( !isset($this->pushover_token) && $this->pushover_token != '' || !isset($this->pushover_key) && $this->pushover_key != '' ){
            log_activity(_l('pushover_key_not_set'));
            die();
        }else{

            $ticket = $this->ci->tickets_model->get_ticket_by_id( $data['data']['ticketid'] );

            if( $this->pushover_admin_reply == 'client_only' && $data['data']['admin'] != 1 ){
                // Notification Set To Only Alert On Client Resonse
                $title = _l('pushover_new_ticket_reply').': #'.$data['data']['ticketid'];
                $url = admin_url('tickets/ticket/' . $data['data']['ticketid'] );
                // Send the notification
                $this->send_pushover($title, $ticket->ticketid, $data['data']['message'], $url);
            }else if( $this->pushover_admin_reply == 'client_admin' ){
                // Notify of both client and admin responses
                $title = _l('pushover_new_ticket_reply').': #'.$data['data']['ticketid'];
                $url = admin_url('tickets/ticket/' . $data['data']['ticketid'] );
                // Send the notification
                $this->send_pushover($title, $data['data']['message'], $url);
            }

        }
    }

    public function send_new_project_alert( $id = '')
    {
        if( !isset($this->pushover_token) && $this->pushover_token != '' || !isset($this->pushover_key) && $this->pushover_key != '' ){
            log_activity(_l('pushover_key_not_set'));
            die();
        }else{
            // Notify New Project Created
            $project = $this->ci->projects_model->get( $id );
            $title = _l('pushover_new_project_created').': '.$project->name;
            $url = admin_url('projects/view/' . $id );
            // Send the notification
            $this->send_pushover($title, $project->description, $url );
        }

    }

    public function send_new_lead_alert( $id = '')
    {
        if( !isset($this->pushover_token) && $this->pushover_token != '' || !isset($this->pushover_key) && $this->pushover_key != '' ){
            log_activity(_l('pushover_key_not_set'));
            die();
        }else{
            // Notify New Project Created
            $lead = $this->ci->leads_model->get( $id );
            $title = _l('pushover_new_lead_created').': '.$lead->id;
            $url = admin_url('admin/leads/index/' . $id );
            // Send the notification
            $this->send_pushover($title, $lead->name, $url );
        }

    }

    public function send_new_payment_alert( $id = '')
    {
        if( !isset($this->pushover_token) && $this->pushover_token != '' || !isset($this->pushover_key) && $this->pushover_key != '' ){
            log_activity(_l('pushover_key_not_set'));
            die();
        }else{
            // Notify New Project Created
            $payment = $this->ci->payments_model->get( $id );
            $title = _l('pushover_new_payment_created').': '.$id;
            $url = admin_url('admin/payments/payment/' . $id );
            $message = 'Invoice: '.$payment->invoiceid.'<br>Amount: '.$payment->amount;
            // Send the notification
            $this->send_pushover($title, $message, $url );
        }

    }

    public function send_new_task_alert( $id = '')
    {
        if( !isset($this->pushover_token) && $this->pushover_token != '' || !isset($this->pushover_key) && $this->pushover_key != '' ){
            log_activity(_l('pushover_key_not_set'));
            die();
        }else{
            // Notify New Project Created
            $task = $this->ci->tasks_model->get( $id );
            $title = _l('pushover_new_task_created').': '.$id. ' - ' . $task->name;
            $url = admin_url('admin/tasks/view/' . $id );
            // Send the notification
            $this->send_pushover($title, $task->description, $url );
        }

    }

    public function send_new_task_comment_alert( $data = '')
    {
        if( !isset($this->pushover_token) && $this->pushover_token != '' || !isset($this->pushover_key) && $this->pushover_key != '' ){
            log_activity(_l('pushover_key_not_set'));
            die();
        }else{
            // Notify New Project Created
            $task = $this->ci->tasks_model->get( $data['task_id'] );
            $task_comment = $task->comments[0]['staff_full_name'] . ' - ' .$task->comments[0]['content'];
            $title = _l('pushover_new_task_comment').': '.$task->name;
            $url = admin_url('admin/tasks/view/' . $id );
            // Send the notification
            $this->send_pushover($title, $task_comment, $url );
        }

    }

    public function send_new_task_proposal_accepted_alert( $data = '' )
    {
        // Tast Accepted Alert Coming Soon
    }

    public function send_pushover($title = '', $message = '', $url = '')
    {
        $push = new Pushover();
        $push->setToken($this->pushover_token);
        $push->setUser($this->pushover_key);
        $push->setTitle($title);
        $push->setHtml(1);
        $push->setMessage($message);
        $push->setUrl($url);
        $push->setUrlTitle(get_option('companyname'));
        $push->setPriority(str_replace('p','',get_option('pushover_priority'))); // workaround for bug in select2 where zero wont set
        $push->setTimestamp(time());
        $push->setSound(get_option('pushover_sound'));
        $go = $push->send();

        log_activity(_l('pushover_log_activity').$this->pushover_key);
    }
}
