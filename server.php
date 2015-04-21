<?php
	$tcp = getprotobyname('tcp');
	//var_dump($tcp);
	$socket = socket_create(AF_INET, SOCK_STREAM, $tcp);
	socket_bind($socket, '127.0.0.1', 10008);
	//var_dump($socket);
	socket_listen($socket);
	
	//initial a data
	$buffer = "connect";
	while(true) {
		$connection = socket_accept($socket);
		if(!$connection) {
			echo "connect fail";
		} else {
			echo "Socket connected";
			if ($buffer != "") {
				echo "send data to client\n";
				socket_write($connection, $buffer . "\n");
				echo "Wrote to socket";
			} else {
				echo "no data in the buffer\n";
			}
			while ($data = @socket_read($connection, 1024, PHP_NORMAL_READ)) {
				printf("Buffer:". $data ."\n");
				socket_write($connection, "Infomation Received\n");
			}
		}
		socket_close($connection);
		printf("closed socket");
	}
