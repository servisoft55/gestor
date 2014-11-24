<?php


require('pop3-classphp.php');



$pop3 = new POP3();
$pop3_login = 'contacto@verificarfirma.cl';
$pop3_pass = '91829182';
$pop3_server = 'mail.verificarfirma.cl'; // Por ejemplo pop.gmail.com

if (!$pop3->connect($pop3_server, '110', true))
	die($pop3->ERROR);

$count = $pop3->login($pop3_login, $pop3_pass) 
	or die("USER: $pop3_login, PASS: $pop3_pass ($count)<br/>".$pop3->ERROR);
if (0 == $count) die('There doesn&#8217;t seem to be any new mail.');


for ($i=1; $i <= $count; $i++) :

	$message = $pop3->get($i);

	$content = '';
	$content_type = '';
	$content_transfer_encoding = '';
	$boundary = '';
	$bodysignal = 0;
	$dmonths = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
	foreach ($message as $line) :
		if (strlen($line) < 3) $bodysignal = 1;

		if ($bodysignal) {
			$content .= $line;
		} else {
			if (preg_match('/Content-Type: /i', $line)) {
				$content_type = trim($line);
				$content_type = substr($content_type, 14, strlen($content_type)-14);
				$content_type = explode(';', $content_type);
				$content_type = $content_type[0];
			}
			if (preg_match('/Content-Transfer-Encoding: /i', $line)) {
				$content_transfer_encoding = trim($line);
				$content_transfer_encoding = substr($content_transfer_encoding, 27, strlen($content_transfer_encoding)-14);
				$content_transfer_encoding = explode(';', $content_transfer_encoding);
				$content_transfer_encoding = $content_transfer_encoding[0];
			}
			if (($content_type == 'multipart/alternative') && (preg_match('/boundary="/', $line)) && ($boundary == '')) {
				$boundary = trim($line);
				$boundary = explode('"', $boundary);
				$boundary = $boundary[1];
			}
			if (preg_match('/Subject: /i', $line)) {
				$subject = trim($line);
				$subject = substr($subject, 9, strlen($subject)-9);
				$subject = web_iso_descrambler($subject);
				// Captures any text in the subject before $phone_delim as the subject
				// $subject = explode($phone_delim, $subject);
				// $subject = $subject[0];
			}

			// Set the author using the email address (To or Reply-To, the last used)
			// otherwise use the site admin
			if (preg_match('/From: /', $line))  {
			// if (preg_match('/From: /', $line) | preg_match('/Reply-To: /', $line))  {
				echo "Line = {$line} <p>";
				$author=trim($line);
				if ( ereg("\"(.*)\"", $author , $regs) ) {
					$author_name = $regs[1];
					echo "Author = {$author_name} <p>";
				}
				if ( ereg("([-a-zA-Z0-9_.]+@[-a-zA-z0-9_.]+)", $author , $regs) ) {
					$author_email = $regs[1];
					echo "Email = {$author_email} <p>";
					$res_client = web_dbQuery("SELECT * FROM ".$web_config['tbl_clients']." WHERE email='$author_email'");
					if (web_dbNumRows($res_client))
						{ $client = web_dbFetchArray($res_client); $clientid = $client['clientid']; }
					else
						{ $client=NULL;$clientid = 0; }

					echo "client = [".$clientid."] ".$client['clientusername']."<br/>";
				
					// $author = $wpdb->escape($author);
					// $result = $wpdb->get_row("SELECT ID FROM $wpdb->users WHERE user_email='$author' LIMIT 1");
					if (!$result)
						$post_author = 1;
					else
						$post_author = $result->ID;
				} else
					$post_author = 1;
			}

			if (preg_match('/Date: /i', $line)) { // of the form '20 Mar 2002 20:32:37'
				$ddate = trim($line);
				$ddate = str_replace('Date: ', '', $ddate);
				if (strpos($ddate, ',')) {
					$ddate = trim(substr($ddate, strpos($ddate, ',')+1, strlen($ddate)));
				}
				$date_arr = explode(' ', $ddate);
				$date_time = explode(':', $date_arr[3]);

				$ddate_H = $date_time[0];
				$ddate_i = $date_time[1];
				$ddate_s = $date_time[2];

				$ddate_m = $date_arr[1];
				$ddate_d = $date_arr[0];
				$ddate_Y = $date_arr[2];
				for ($j=0; $j<12; $j++) {
					if ($ddate_m == $dmonths[$j]) {
						$ddate_m = $j+1;
					}
				}

				$time_zn = intval($date_arr[4]) * 36;
				$ddate_U = gmmktime($ddate_H, $ddate_i, $ddate_s, $ddate_m, $ddate_d, $ddate_Y);
				$ddate_U = $ddate_U - $time_zn;
				$date = gmdate('Y-m-d H:i:s', $ddate_U + $time_difference);
				$date_gmt = gmdate('Y-m-d H:i:s', $ddate_U);
			}
		}
	endforeach;

	$subject = trim($subject);

	if ($content_type == 'multipart/alternative') {
		$content = explode('--'.$boundary, $content);
		$content = $content[2];
		$content = explode('Content-Transfer-Encoding: quoted-printable', $content);
		$content = strip_tags($content[1], '<img><p><br><i><b><u><em><strong><strike><font><span><div>');
	}
	$content = trim($content);

	if (stripos($content_transfer_encoding, "quoted-printable") !== false) {
		$content = quoted_printable_decode($content);
	}

	// Captures any text in the body after $phone_delim as the body
	// $content = explode($phone_delim, $content);
	// $content[1] ? $content = $content[1] : $content = $content[0];

	
	echo "<p><b>Content-type:</b> $content_type, <b>Content-Transfer-Encoding:</b> $content_transfer_encoding, <b>boundary:</b> $boundary</p>\n";
	echo "<p><b>Raw content:</b><br /><pre>".$content.'</pre></p>';


	// 
	// INSERTAR EN LA BASE DE DATOS o LO QUE SEA
	//

	if(!$pop3->delete($i)) {
		echo '<p>Oops '.$pop3->ERROR.'</p></div>';
		$pop3->reset();
		exit;
	} else {
		echo "<p>Mission complete, message <strong>$i</strong> deleted.</p>";
	}


endfor;

$pop3->quit();
?>