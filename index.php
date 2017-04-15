<?php
define('DIR_BASE', str_replace('\\', '/', realpath(dirname(__FILE__))) . '/');

require_once(DIR_BASE . 'library/utf8.php');

$lists = array();
$blacklists = array();
$output = '';

$files[] = 'https://raw.githubusercontent.com/epiksel/spammerbye/master/spammers.txt';
$files[] = 'https://raw.githubusercontent.com/piwik/referrer-spam-blacklist/master/spammers.txt';
$files[] = 'https://raw.githubusercontent.com/Stevie-Ray/referrer-spam-blocker/master/src/domains.txt';
$files[] = 'https://raw.githubusercontent.com/Flameeyes/modsec-flameeyes/master/rules/flameeyes_bad_referrers.data';
$files[] = 'https://raw.githubusercontent.com/desbma/referer-spam-domains-blacklist/master/spammers.txt';

foreach ($files as $file) {
	$lists = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	foreach ($lists as $list) {
		$blacklists[utf8_strtolower($list)] = utf8_strtolower($list);
	}
}

ksort($blacklists);

foreach ($blacklists as $blacklist) {
	$output .= $blacklist . "\n";
}

$file = fopen(DIR_BASE . 'blacklist', 'w') or die ('Could not open blacklist file!');
fwrite($file, $output);
fclose($file);

echo 'Spam referrer blacklist was created.';
