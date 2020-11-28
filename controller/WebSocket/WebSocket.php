<?php

class WebSocket
{
    private $host = 'localhost'; //host
    private $port = 9000; //port
    private $null = NULL; //null var

    private $socket;
    private $clients;

    function __construct($host='localhost',$port=9000)
    {
        echo "- Initializing WebSocket Server ...\n";

        $this->host = $host;
        $this->port = $port;

        $this->_initializingWebSocket();
    }

    private function _initializingWebSocket(){
        //Create TCP/IP sream socket
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        //reuseable port
        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);
        //bind socket to specified host
        socket_bind($this->socket, 0, $this->port);
        //listen to port
        socket_listen($this->socket);
        //create & add listning socket to the list
        $this->clients = array($this->socket);
        //start endless loop, so that our script doesn't stop

        echo "- Server is ready to use socket connections\n";
        echo "- SERVER ADDR : [".$this->host."]\n";
        echo "- SERVER PORT : [".$this->port."]\n";
        echo "------------------------------------------\n";
    }

    function start(){
        //start endless loop, so that our script doesn't stop
        while (true) {
            //manage multiple connections
            $changed = $this->clients;
            //returns the socket resources in $changed array
            socket_select($changed, $this->null, $this->null, 0, 10);

            //check for new socket
            if (in_array($this->socket, $changed)) {
                $socket_new = socket_accept($this->socket); //accpet new socket
                $this->clients[] = $socket_new; //add socket to client array

                $header = socket_read($socket_new, 1024); //read data sent by the socket
                $this->perform_handshaking($header, $socket_new, $this->host, $this->port); //perform websocket handshake

                socket_getpeername($socket_new, $ip); //get ip address of connected socket
                $response = $this->mask(json_encode(array('type'=>'system', 'message'=>$ip.' connected'))); //prepare json data
                $this->send_message($response); //notify all users about new connection
                echo "- new Person connected with ip address $ip\n";

                //make room for new socket
                $found_socket = array_search($socket, $changed);
                unset($changed[$found_socket]);
            }

            //loop through all connected sockets
            foreach ($changed as $changed_socket) {

                //check for any incomming data
                while(socket_recv($changed_socket, $buf, 1024, 0) >= 1)
                {
                    $received_text = $this->unmask($buf); //unmask data
                    $tst_msg = json_decode($received_text); //json decode
                    $user_name = $tst_msg->name; //sender name
                    $user_message = $tst_msg->message; //message text
                    $user_color = $tst_msg->color; //color

                    //prepare data to be sent to client
                    $response_text = $this->mask(json_encode(array('type'=>'usermsg', 'name'=>$user_name, 'message'=>$user_message, 'color'=>$user_color)));
                    $this->send_message($response_text); //send data
                    echo "- new message from $user_name (".date('M d Y H:i:s').")\n";
                    echo "- $user_message\n\n";
                    break 2; //exist this loop
                }

                $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
                if ($buf === false) { // check disconnected client
                    // remove client for $clients array
                    $found_socket = array_search($changed_socket, $this->clients);
                    socket_getpeername($changed_socket, $ip);
                    unset($this->clients[$found_socket]);

                    //notify all users about disconnected connection
                    $response = $this->mask(json_encode(array('type'=>'system', 'message'=>$ip.' disconnected')));
                    $this->send_message($response);
                    echo "- Person with ip address $ip disconnected!\n";
                }
            }
        }
        // close the listening socket
        socket_close($this->socket);
    } // start function ends here


    function send_message($msg)
    {
        foreach($this->clients as $changed_socket)
        {
            @socket_write($changed_socket,$msg,strlen($msg));
        }
        return true;
    }
    //Unmask incoming framed message
    private function unmask($text) {
        $length = ord($text[1]) & 127;
        if($length == 126) {
            $masks = substr($text, 4, 4);
            $data = substr($text, 8);
        }
        elseif($length == 127) {
            $masks = substr($text, 10, 4);
            $data = substr($text, 14);
        }
        else {
            $masks = substr($text, 2, 4);
            $data = substr($text, 6);
        }
        $text = "";
        for ($i = 0; $i < strlen($data); ++$i) {
            $text .= $data[$i] ^ $masks[$i%4];
        }
        return $text;
    }
    //Encode message for transfer to client.
    private function mask($text)
    {
        $b1 = 0x80 | (0x1 & 0x0f);
        $length = strlen($text);

        if($length <= 125)
            $header = pack('CC', $b1, $length);
        elseif($length > 125 && $length < 65536)
            $header = pack('CCn', $b1, 126, $length);
        elseif($length >= 65536)
            $header = pack('CCNN', $b1, 127, $length);
        return $header.$text;
    }
    //handshake new client.
    private function perform_handshaking($receved_header,$client_conn, $host, $port)
    {
        $headers = array();
        $lines = preg_split("/\r\n/", $receved_header);
        foreach($lines as $line)
        {
            $line = chop($line);
            if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
            {
                $headers[$matches[1]] = $matches[2];
            }
        }

        $secKey = $headers['Sec-WebSocket-Key'];
        $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
        //hand shaking header
        $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "WebSocket-Origin: $host\r\n" .
            "WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
            "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
        socket_write($client_conn,$upgrade,strlen($upgrade));
    }
}

