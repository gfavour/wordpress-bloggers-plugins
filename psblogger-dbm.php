<?php
global $ps_db_version;
$ps_db_version = '1.0';
$psb_tbltestimony = 'psb_testimony';
$psb_tblrequest = 'psb_request';

function psbTestimonial_table() {
	global $wpdb, $ps_db_version;
	$charset_collate = $wpdb->get_charset_collate();
	$tablename = $wpdb->prefix.'psb_testimony';
	//u-user, c-contestant accounts
	$sql = "CREATE TABLE $tablename (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		title varchar(40) DEFAULT '' NULL,
		lastname varchar(50) DEFAULT '' NULL,
		firstname varchar(50) DEFAULT '' NULL,
		company varchar(40) DEFAULT '' NULL,
		message varchar(400) DEFAULT '' NULL,
		email varchar(80) DEFAULT '' NULL,
		phone varchar(40) DEFAULT '' NULL,
		regdate varchar(40) DEFAULT '' NULL,
		photo varchar(80) DEFAULT '' NULL,
		ispermit varchar(20) DEFAULT '1' NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once(ABSPATH.'wp-admin/includes/upgrade.php' );
	dbDelta($sql);
	add_option( 'ps_db_version', $ps_db_version);
}

function psbRequest_table() {
	global $wpdb, $ps_db_version;
	$charset_collate = $wpdb->get_charset_collate();
	$tablename = $wpdb->prefix.'psb_request';
	//u-user, c-contestant accounts
	$sql = "CREATE TABLE $tablename (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name varchar(50) DEFAULT '' NULL,
		email varchar(80) DEFAULT '' NULL,
		phone varchar(60) DEFAULT '' NULL,
		product varchar(80) DEFAULT '' NULL,
		subject varchar(60) DEFAULT '' NULL,
		message varchar(500) DEFAULT '' NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once(ABSPATH.'wp-admin/includes/upgrade.php' );
	dbDelta($sql);
	add_option( 'ps_db_version', $ps_db_version);
}
?>