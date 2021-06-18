<?php
exec('script.bat');
require("phpMQTT.php");

//para o botão Ligar
function LigarCarga(){

exec('script.bat');
$server = "m15.cloudmqtt.com";     // change if necessary
$port = 17999;                     // change if necessary
$username = "tlxgjowo";                   // set your username
$password = "x1zhXkwOn75L";                   // set your password
$client_id = "phpMQTT-publisher"; // make sure this is unique for connecting to sever - you could use uniqid()



  $mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);
  if ($mqtt->connect(true, NULL, $username, $password)){
      $mqtt->publish("LED", "D1", 0);
      $mqtt->close();
  }
}

//para o botão Desligar
function DesligarCarga(){

exec('script.bat');
$server = "m15.cloudmqtt.com";     // change if necessary
$port = 17999;                     // change if necessary
$username = "tlxgjowo";                   // set your username
$password = "x1zhXkwOn75L";                   // set your password
$client_id = "phpMQTT-publisher"; // make sure this is unique for connecting to sever - you could use uniqid()

  $mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);
  if ($mqtt->connect(true, NULL, $username, $password)){
      $mqtt->publish("LED", "L1", 0);
      $mqtt->close();
  }
}

//Função para receber as mensagens de um tópico
global $resultado;
$resultado = [];
function inscrever(){
exec('script.bat');
$server = "m15.cloudmqtt.com";     // change if necessary
$port = 17999;                     // change if necessary
$username = "tlxgjowo";                   // set your username
$password = "x1zhXkwOn75L";                   // set your password
$client_id = "phpMQTT-subscriber"; // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new Bluerhinos\phpMQTT($server, $port, $client_id);

if(!$mqtt->connect(true, NULL, $username, $password)) {
  echo "Não conseguiu se conectar ao tópico";
	exit(1);
}
else{
     $topics['/bluerhinos/phpmqtt/Led'] = array("qos" => 0, "function" => "procmsg");
     $mqtt->subscribe($topics, 0);
      if ($mqtt->proc() == 0) {
          echo "Função proc falhou\n";
      }
      else{
        sleep(5);
      }
  }
  $mqtt->close();
}

function procmsg($topic, $message)
{
  array_push($resultado, $topic, $message);
  return $resultado;
}
?>

<html>
    <head>
      <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=no'/>
      <title>ESP8266</title>
      <style>
        body{
          text-align: center;
          font-family: sans-serif;
          font-size:14px;
          padding: 25px;
        }
 
        p{
          color:#444;
        }
        input[type=submit]{
          outline: none;
          border: 2px solid #1fa3ec;
          border-radius:18px;
          background-color:#FFF;
          color: #1fa3ec;
          padding: 10px 50px;
        }
        button:active{
          color: #fff;
          background-color:#1fa3ec;
        }
      </style>
    </head>
    <body>
    <p><b>Acionamento da carga</b></p>
    <div>
			<form action="?a=ok" method="POST">	
				<input type="submit" value="Ligar carga    " />
			</form>
		</div>
		<?php
		if ( isset( $_GET['a'] ) && $_GET['a'] == 'ok') {
			LigarCarga();
		}
		?>

<div>
			<form action="?b=ok" method="POST">	
				<input type="submit" value="Desligar carga" />
			</form>
		</div>
		<?php
		if ( isset( $_GET['b'] ) && $_GET['b'] == 'ok') {
			DesligarCarga();
		}
		?>

    <div>
        <label for="EstadoCarga">O estado atual da carga é: </label>
        <label for="MensagemCarga"><?phpinscrever?></label>
    </div>
		<?php
    inscrever();
		?>
      </body>
  </html>

 