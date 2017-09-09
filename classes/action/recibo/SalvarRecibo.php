<?php 
require_once "../../entity/Recibo.php";
require_once "../../entity/ItemRecibo.php";
require_once "../../dao/ReciboDAO.php";
require_once "../../processor/ReciboProcessor.php";

$json = file_get_contents("php://input");

// TODO: Remover após testes

/*$json = '{"numero":"17000","data":"2017-09-03T15:16:00.517Z","cliente":{"cnpj":"21339044000110","nome":"ultra frios","uf":"df","cidade":"brasilia","bairro":"vicente pires","logradouro":"shvp chacara 134 galpoes 02 e 03","telefone":"6130367789","celular":"61992366154","email":"ultrafrios@gmail.com","responsavel":"wellington"},"itens":[{"produto":{"codigo":"10","nome":"picole limao"},"quantidade":"40"},{"produto":{"codigo":"12","nome":"picole morango"},"quantidade":"65"}]}';
*/

$recibo = json_decode($json);
ReciboProcessor::processarRecibo($recibo);
ReciboDAO::salvar($recibo);


?>