// Mourad Sabour

<?php
	// Send the headers
	header('Content-type: text/xml');
	header('Pragma: public');
	header('Cache-control: private');
	header('Expires: -1');
	
	// connect to app
    $config = array();
	$config['appId'] = 'YOUR_APP_ID';
	$config['secret'] = 'YOUR_APP_SECRET';
	$config['fileUpload'] = false; // optional
	$config['defaultPage'] = 'FB_PAGE'; // by default hackforla fb page
?>