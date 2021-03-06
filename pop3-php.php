 <?php
/**
* @author Tim Boormans for Direct Web Solutions (info@directwebsolutions)
* @desc POP3 emailbox manager. Lists messages and reads them. Parses all emails to an array for alternate processing (e.g. SIDN DRS4).
* @date 15 September 2009
* @license free to use in all programs as long as no commercial (used) programs or libraries.
**/

/**
* PROCEDURE:
* USER x (login)
* PASS x (login)
* STAT (retrieve messages count)
* RETR x (retrieve message size and headers + body)
* 
* Also possible:
* LIST -> gives a list of message ids and their size
**/
$new_email = array(); // the result array which will contain all received emails at the end of this script
$bind_ip = "mail.verificarfirma.cl";
$pop3_ip = "mail.verificarfirma.cl";
$pop3_port = "110";
$pop3_user = "contacto@verificarfirma.cl";
$pop3_pass = "91829182";
$debug = false;
$burn_after_reading = false; /* CAUTION: WHILE TESTING ALWAYS SET THIS TO 'false' !! */

// Do not change anything below here!
/******************************************************************************************************************************/
// connect
$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($sock, $bind_ip);
socket_connect($sock, $pop3_ip, $pop3_port);
$login_msg = socket_read($sock, 1024);
if($debug)
    print $login_msg;

// login user
if($debug)
    print "USER ".$pop3_user."\r\n";
socket_write($sock, "USER ".$pop3_user."\r\n");
$login_user_res = socket_read($sock, 1024);
if(!preg_match("/\+OK/", $login_user_res))
    exit("POP3 username not recognized.\n");
else
    if($debug)
        print $login_user_res;
if(!strpos($login_user_res, "\r\n"))
    exit("no user end.\n");
    
// login pass
if($debug)
    print "PASS ".$pop3_pass."\r\n";
socket_write($sock, "PASS ".$pop3_pass."\r\n");
$login_pass_res = socket_read($sock, 1024);
if(!preg_match("/\+OK/", $login_pass_res))
    exit("POP3 password incorrect.\n");
else
    if($debug)
        print $login_pass_res;
if(!strpos($login_pass_res, "\r\n"))
    exit("no pass end.\n");
    
// successful login
if($debug)
    print "Successfully loggedin.\n";

// check how many new emails are in the pop3 box
$n_messages = 0;
$stat = false;
while(!$stat) {
    socket_write($sock, "STAT\r\n");
    $stat_res = socket_read($sock, 1024);
    if(preg_match('/\+OK ([0-9]{1,}) ([0-9]{1,})/i', $stat_res, $matches)) {
        /*
            '+OK 1 977' will become:
            [0] => +OK 1 977
            [1] => 1
            [2] => 977
            --> there is 1 new message
            --> the total messages size is 997 bytes (useless information, though)
        */
        $n_messages = $matches[1];
        $stat = true;
    } else {
        $stat = false;
    }
}
if($debug)
    print "There are ".$n_messages." new messages waiting for you.\n";

// download every new message
for($i_msg = 1; $i_msg <= $n_messages; $i_msg++) {
    // download the first line of $i_msg to parse the total message size
    if($debug)
        print "RETR ".$i_msg."\r\n";
    socket_write($sock, "RETR ".$i_msg."\r\n");
    
    // read the length of the message (displayed in 1 textline, e.g.: +OK 977 octets)
    $retr_res = socket_read($sock, 12);
    while(!strpos($retr_res, "\r\n")) {
        $retr_res .= socket_read($sock, 1); // read each time 1 byte until the end of the line is reached
    }
    if($debug)
        print $retr_res;
    if(preg_match('/\+OK ([0-9]{1,}) octets/i', $retr_res, $matches1)) {
        // match the length from the textline
        $msg_len = $matches1[1];
    } else {
        $msg_len = 0;
    }
    
    // read e-mail header + body
    // calculate how many times to use socket_read for reading
    $buf_size = 128;
    $times = floor($msg_len / $buf_size);
    $rest = $msg_len - ($ftimes * $buf_size);
    $email = "";
    for($o = 0; $o < $times; $o++) {
        // read $times * $buf_size bytes from the stream (1 character = 1 byte)
        $email .= socket_read($sock, $buf_size);
    }
    $email .= socket_read($sock, $rest); // read the $rest bytes from the stream
    if($debug)
        print $email;
    
    // Parse email to a more useful processing format
    list($plainheader, $plainbody, $plainend) = split("\r\n\r\n", $email);
    $headers = array();
    
    // copy all headers to the $headers array
    $h_lines = explode("\n", $plainheader);
    foreach($h_lines as $hl) {
        // example: 'Date: Mon, 14 Sep 2009 17:10:25 +0200 (CEST)'
        $ex = explode(": ", $hl);
        $headers[strtolower($ex[0])] = str_replace("\r", "", $ex[1]);
    }
    
    // add all infos to the main $new_email array
    $new_email[$i_msg] = array(
        'message_id' => $i_msg,
        'message_length' => $msg_len,
        'headers' => $headers,
        'body' => $plainbody,
        'plaintext' => array('header' => $plainheader,
                            'body' => $plainbody,
                            'end' => $plainend),
        );
    
    if($burn_after_reading) {
        // delete message after reading
        socket_write($sock, "DELE ".$i_msg."\r\n");
        $dele_res = socket_read($sock, 1024);
        if($debug)
            print $dele_res;
    }
}

// QUIT the pop3 server
if($debug)
    print "QUIT\r\n";
socket_write($sock, "QUIT\r\n");
$quit_res = socket_read($sock, 1024); // for downloading the termination interrupt
if($debug)
    print $quit_res;

// close the socket connection
socket_close($sock);
/******************************************************************************************************************************/
if($debug)
    print_r($new_email);
?> 