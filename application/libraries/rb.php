<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

// Get Redbean
include(APPPATH . '/third_party/rb.php');

class Rb {

	function __construct() {
		// Include database configuration
		include(APPPATH . '/config/database.php');


		// Database data
		$host = $db[$active_group]['hostname'];
		$user = $db[$active_group]['username'];
		$pass = $db[$active_group]['password'];
		$db = $db[$active_group]['database'];

		// Setup DB connection
		R::setup("mysql:host=$host;dbname=$db", $user, $pass);
		R::setStrictTyping(false);
		R::freeze(true);
	}

}
