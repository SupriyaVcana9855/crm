<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Pushover
Description: Used to send instant Pushover Notifications
Version: 1.0.4
Author: Granulr Ltd
Author URI: https://granulr.uk
Requires at least: 2.7.*
*/

define('PUSHOVER', 'pushover');

// Setup our hooks
hooks()->add_action('admin_init', 'pushover_setup_init_menu_items');
hooks()->add_action('ticket_created', 'pushover_signal_ticket_created');
hooks()->add_action('after_ticket_reply_added', 'pushover_signal_ticket_reply');
hooks()->add_action('lead_created', 'pushover_signal_lead_created');
hooks()->add_action('after_payment_added', 'pushover_signal_payment_created');
hooks()->add_action('task_comment_added', 'pushover_signal_task_comment');
//hooks()->add_action('after_add_project', 'pushover_signal_project_created');
//hooks()->add_action('after_add_task', 'pushover_signal_task_created');
//hooks()->add_action('proposal_accepted', 'pushover_signal_proposal_accepted');

/**
* Register activation module hook
*/
register_activation_hook(PUSHOVER, 'pushover_module_activation_hook');

function pushover_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(PUSHOVER, [PUSHOVER]);

/**
 * Init menu setup module menu items in setup in admin_init hook
 * @return null
 */
function pushover_setup_init_menu_items()
{
    /**
    * If the logged in user is administrator, add custom menu in Setup
    */
    if (is_admin()) {
            $CI = &get_instance();
            $CI->app_tabs->add_settings_tab('pushover', [
                'name'     => _l('settings_group_pushover'),
                'view'     => PUSHOVER.'/admin/settings/pushover_settings',
                'position' => 90,
        ]);
    }
}

/**
* Load the Pushover Class into the system
*/
if (!class_exists('Pushover')) {
    require(__DIR__ . '/vendor/Pushover.php');
}

/**
* Ran when a new ticket is created
*/
function pushover_signal_ticket_created( $id )
{
    $CI = &get_instance();
    $CI->load->library(PUSHOVER . '/' . 'pushover_module');
    $CI->pushover_module->send_new_ticket_alert($id);
}

/**
* Ran when there is a reply to a ticket
*/
function pushover_signal_ticket_reply( $data )
{
    $CI = &get_instance();
    $CI->load->library(PUSHOVER . '/' . 'pushover_module');
    $CI->pushover_module->send_update_ticket_alert($data);
}

/**
* Ran when there is a new project created
*/
function pushover_signal_project_created( $id )
{
    $CI = &get_instance();
    $CI->load->library(PUSHOVER . '/' . 'pushover_module');
    $CI->pushover_module->send_new_project_alert($id);
}

/**
* Ran when there is a new lead created
*/
function pushover_signal_lead_created( $id )
{
    $CI = &get_instance();
    $CI->load->library(PUSHOVER . '/' . 'pushover_module');
    $CI->pushover_module->send_new_lead_alert($id);
}

/**
* Ran when there is a new payment created
*/
function pushover_signal_payment_created( $id )
{
    $CI = &get_instance();
    $CI->load->library(PUSHOVER . '/' . 'pushover_module');
    $CI->pushover_module->send_new_payment_alert($id);
}

/**
* Ran when there is a new task created
*/
function pushover_signal_task_created( $id )
{
    $CI = &get_instance();
    $CI->load->library(PUSHOVER . '/' . 'pushover_module');
    $CI->pushover_module->send_new_task_alert($id);
}

/**
* Ran when there is a comment to a task
*/
function pushover_signal_task_comment( $data )
{
    $CI = &get_instance();
    $CI->load->library(PUSHOVER . '/' . 'pushover_module');
    $CI->pushover_module->send_new_task_comment_alert($data);
}

/**
* Ran when there is a comment to a task
*/
function pushover_signal_proposal_accepted( $data )
{
    $CI = &get_instance();
    $CI->load->library(PUSHOVER . '/' . 'pushover_module');
    $CI->pushover_module->send_new_task_proposal_accepted_alert($data);
}
