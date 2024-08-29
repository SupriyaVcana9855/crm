<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_101 extends App_module_migration
{
    public function up()
    {
      add_option('pushover_admin_reply', 'client_only');
    }
}
