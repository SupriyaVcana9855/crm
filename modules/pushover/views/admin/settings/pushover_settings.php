<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Pushover Priorities
$priorities = [
  [ 'priorityid' => 'p0',  'name'  =>  _l('pushover_priority_default') ],
  [ 'priorityid' => 'p-2', 'name' => _l('pushover_priority_lowest') ],
  [ 'priorityid' => 'p-1', 'name' => _l('pushover_priority_low') ],
  [ 'priorityid' => 'p1',  'name'  =>  _l('pushover_priority_high') ],
];

// Pushover Sounds
$sounds = [
  [ 'soundid' => 'pushover', 'name' => 'Pushover' ],
  [ 'soundid' => 'bike', 'name' => 'Bike' ],
  [ 'soundid' => 'bugle', 'name'=> 'bugle' ],
  [ 'soundid' => 'cashregister', 'name' => 'Cash Register' ],
  [ 'soundid' => 'classical', 'name' => 'classical' ],
  [ 'soundid' => 'cosmic', 'name' => 'cosmic' ],
  [ 'soundid' => 'falling', 'name' => 'falling' ],
  [ 'soundid' => 'gamelan', 'name' => 'Gamelan' ],
  [ 'soundid' => 'incoming', 'name' => 'Incoming' ],
  [ 'soundid' => 'intermission', 'name' => 'Intermission' ],
  [ 'soundid' => 'magic', 'name' => 'Magic' ],
  [ 'soundid' => 'mechanical', 'name' => 'Mechanical' ],
  [ 'soundid' => 'pianobar', 'name' => 'Piano Bar' ],
  [ 'soundid' => 'siren', 'name' => 'Siren' ],
  [ 'soundid' => 'spacealarm', 'name' => 'Space Alarm' ],
  [ 'soundid' => 'tugboat', 'name' => 'Tug Boat' ],
  [ 'soundid' => 'alien', 'name' => 'Alien Alarm (long)' ],
  [ 'soundid' => 'climb', 'name' => 'Climb (long)' ],
  [ 'soundid' => 'persistent', 'name' => 'Persistent (long)' ],
  [ 'soundid' => 'echo', 'name' => 'Pushover Echo (long)' ],
  [ 'soundid' => 'updown', 'name' => 'Up Down (long)' ],
  [ 'soundid' => 'none', 'name' => 'None' ],
];

?>

<div class="horizontal-scrollable-tabs">
    <div class="scroller arrow-left" style="display: none;"><i class="fa fa-angle-left"></i></div>
    <div class="scroller arrow-right" style="display: none;"><i class="fa fa-angle-right"></i></div>
    <div class="horizontal-tabs">
        <ul class="nav nav-tabs nav-tabs-horizontal" role="tablist">
            <li role="presentation" class="active">
                <a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a>
            </li>
            <li role="presentation">
                <a href="#support" aria-controls="support" role="tab" data-toggle="tab">Support</a>
            </li>
            <!--
            <li role="presentation">
                <a href="#projects" aria-controls="projects" role="tab" data-toggle="tab">Projects</a>
            </li>
            <li role="presentation">
                <a href="#leads" aria-controls="leads" role="tab" data-toggle="tab">Leads</a>
            </li>
            <li role="presentation">
                <a href="#proposals" aria-controls="proposals" role="tab" data-toggle="tab">Proposals</a>
            </li>-->
        </ul>
    </div>
</div>

<div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="general">
        <div class="row">
          <div class="col-md-12">
            <h4><?php echo _l('pushover'); ?> Settings (General)</h4>
            <p>These settings are required to enable Pushover notifications - See Setup Documentation for more information</p>
            <hr />
            <?php $attrs = (get_option('pushover_token') != '' ? array() : array('autofocus'=>true)); ?>
            <?php echo render_input('settings[pushover_token]','settings_pushover_token',get_option('pushover_token'),'text',$attrs); ?>
            <hr />
            <?php echo render_input('settings[pushover_key]','settings_pushover_key',get_option('pushover_key')); ?>
            <hr />
            <?php echo render_select('settings[pushover_priority]',$priorities,array('priorityid','name'),'settings_pushover_priority',get_option('pushover_priority'),array(),array('data-toggle'=>'tooltip','data-html'=>'true','title'=>'settings_pushover_priority_tooltip')); ?>
            <p>
                <a href="https://pushover.net/api#priority" target="_blank" class="settings-textarea-merge-field" data-to="pushover_sound">More Notification Priority Information From Pushover.net</a>
            </p>
            <hr />
            <?php echo render_select('settings[pushover_sound]',$sounds,array('soundid','name'),'settings_pushover_sound',get_option('pushover_sound'),array(),array()); ?>
            <p>
                <a href="https://pushover.net/api#sounds" target="_blank" class="settings-textarea-merge-field" data-to="pushover_sound">More Notification Sound Information From Pushover.net</a>
            </p>

          </div>
        </div>
    </div>

    <div role="tabpanel" class="tab-pane" id="support">
        <div class="row">
            <div class="col-md-12">
                <h4><?php echo _l('pushover'); ?> Settings (Support Tickets)</h4>
                <p>These settings allow you to modify Support Ticket push notifications</p>
                <hr />
                <?php echo render_select('settings[pushover_admin_reply]',[['id'=>'client_only', 'name'=>'Client Only'],['id'=>'client_admin','name'=>'Admin & Client']],array('id','name'),'pushover_admin_reply',get_option('pushover_admin_reply'),array(),array()); ?>
                <p>Send push notifications on client only support ticket replies, or notifications for both client and admin support ticket replys</p>
            </div>
        </div>
    </div>

    <div role="tabpanel" class="tab-pane" id="projects">
        <!-- Coming Soon -->
    </div>

    <div role="tabpanel" class="tab-pane" id="leads">
        <!-- Coming Soon -->
    </div>

    <div role="tabpanel" class="tab-pane" id="proposals">
        <!-- Coming Soon -->
    </div>

</div>
