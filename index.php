<?php
	ob_start();

	// include the facebook sdk
    require_once('facebook-php-sdk-master/facebook.php');

	// Set the xml/ rss version
	echo '<?xml version="1.0" encoding="utf-8"?>';
	echo '<rss xmlns:dc="http://purl.org/dc/elements/1.1/" version="2.0">';

	// Open and set title and description
	echo '<channel>';
	echo '<title>Facebook RSS Feed</title>';
	echo '<link>www.mourad-sabour.fr</link>';
	echo '<description>PHP Crawler</description>';

    include 'config.php';

    // instantiate
    $facebook = new Facebook($config);

    // set page id
    $pageid = isset($_GET['pageid']) ?  $_GET['pageid'] : $config['defaultPage'];

    // now we can access various parts of the graph, starting with the feed
    $pagefeed = $facebook->api("/" . $pageid . "/feed");
          
	/********** functions **********/
	
	function setDescription($post, $index) {
		$description = $post[$index];
		
		// check if description is null or empty. If so then take the message or caption as the description.
		if (is_null($description) || empty($description))
			$description = isset($post['message']) ? $post['message'] : (isset($post['caption']) ? $post['caption'] : "No description found");

		// check if the photo is available if yes add it to the description.
		if ($post['type'] == 'photo')
			$description .= "<br/><br/><a href='" .$post['link']. "'><img src='" .$post['picture']. "' /></a>";

		return ($description);
	}
	
	function setTitle($post, $index) {
		$title = $post[$index];
		
		// check if title is null or empty. If so then take the message as the description.
		if (is_null($title) || empty($title))
			return isset($post['message']) ? $post['message'] : "No description found";
		return ($title);
	}
	
	function setTime($post, $index) {
		// According to http://validator.w3.org/ pubDate must be an RFC-822 date-time.
		// http://validator.w3.org/feed/
		return date("r", strtotime($post[$index]));
	}
	
	// Handle Particular Cases
	function handleFormat($post, $index) {
		// set an array of Functions
		$array = array('description' => 'setDescription', 'name' => 'setTitle', 'created_time' => 'setTime');
		
		// check if the key exist
		if (array_key_exists($index, $array))
		    return $array[$index]($post, $index);
		return $post[$index];
	}
	
	/********** End functions **********/
	
	// set counter to 0.
    $i = 0;
	
	// By default we set the variable to 20 posts maximum.
	isset($_GET['numberPosts']) ? $numberPosts = $_GET['numberPosts'] : $numberPosts = 20;
	
	// RSS Required channel elements. To get a new FB fields just add it to the list.
	// Fore more information go to : https://developers.facebook.com/docs/graph-api/reference/page/ 
    $channel = array('name' 		=> 'title',
    				'link'			=> 'link',
    				'link'			=> 'guid',
    				'description' 	=> 'description', 
    				'created_time' 	=> 'pubDate');
	
	// Convert the Data To Xml	
	foreach($pagefeed['data'] as $post) {
			
		// open the item
        echo "<item>";
		
		// Use a list and foreach in order to avoid Arrow Antipattern.
		// And use htmlspecialchars to ensure the well-formedness of XML documents.
		foreach ($channel as $index => $value) {
			echo "<" . $value . ">" . htmlspecialchars(handleFormat($post, $index), ENT_QUOTES) . "</" . $value . ">";
		}
		
		// Get the author name if exist
		if ($post['from']['name']) {
			echo "<dc:creator>" . $post['from']['name'] . "</dc:creator>"; 
		}
		
		// close item
        echo "</item>";
		
        // add 1 to the counter if our condition for $post['type'] is met  
        $i++; 
        
        //  break out of the loop if counter has reached the numberPosts value
        if ($i == $numberPosts)
          break;
	}
        
	// close the xml  
	echo '</channel>';
	echo '</rss>';

	ob_flush();
?>