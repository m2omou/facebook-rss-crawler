facebook-rss-crawler
====================

A PHP program that grab Facebook pages information and generate a valid W3C RSS feed.

Configuration
=============

Open the file `config.php` and add your own `APP_ID` and `APP_SECRET`

To create one go to https://developers.facebook.com

```php
$config = array();
$config['appId'] = 'YOUR_APP_ID';
$config['secret'] = 'YOUR_APP_SECRET';
$config['fileUpload'] = false; // optional
```

Replace 'FB_PAGE' with the facebook page that you want to get the information from

```php
$config['defaultPage'] = 'FB_PAGE';
```

Code examples
=============

Add to this array the fields that you want to get :
```php
$channel = array(
	'name' => 'title',
	'link' => 'link',
	'description' => 'description',
	'created_time' => 'date'
);
```
Here is a list of fields :

- id
- about
- birthday
- category
- cover
- current_location
- likes
- link
- location
- name
- phone
- website
- ...

RSS Output
==========

```xml
<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:dc="http://purl.org/dc/elements/1.1/" version="2.0">
   <channel>
      <title>Facebook RSS Feed</title>
      <link>www.mourad-sabour.fr</link>
      <description>PHP Crawler</description>
      // Mourad Sabour
      <item>
         <title>Hispanic Couple Shares Code Secrets - NBC News</title>
         <guid>http://www.nbcnews.com/news/latino/hispanic-couple-shares95146</guid>
         <description>Gregorio Rojas said he never intended to pursue a career in technology.</description>
         <pubDate>Mon, 05 May 2014 01:32:06 +0200</pubDate>
         <dc:creator>Hack for L.A.</dc:creator>
      </item>
      <item>...</item>
      <item>...</item>
      <item>...</item>
      <item>...</item>
   </channel>
</rss>
```

For more information, visit the facebook developer page : 
https://developers.facebook.com/docs/graph-api/reference/v2.0/page

License
=======
Facebook-rss-crawler Copyright 2014 Mourad Sabour, mourad.sabour[at]gmail.com.
