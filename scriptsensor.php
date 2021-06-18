<?php
$potencia = filter_input(INPUT_GET, 'potencia', FILTER_SANITIZE_NUMBER_FLOAT);
$corrente = filter_input(INPUT_GET, 'corrente', FILTER_SANITIZE_NUMBER_FLOAT);
if (is_null($potencia) || is_null($corrente)){
  //Gravar log de erros
  die("Dados inválidos");
} 
$servername = "localhost";
$username = "root";
$password = "dawsonjwcdf";
$dbname = "celke";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  //Gravar log de erros
  die("Não foi possível estabelecer conexão com o BD: " . $conn->connect_error);
} 
$sql = "INSERT INTO medicao (medicao_corrente, medicao_potencia) VALUES ($corrente,$potencia)";
 
if (!$conn->query($sql)) {
  //Gravar log de erros
  die("Erro na gravação dos dados no BD");
}
$conn->close();
?>