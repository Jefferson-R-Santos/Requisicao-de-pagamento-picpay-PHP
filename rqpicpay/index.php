<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Requisição de Pagamento</title>
</head>
<body>
<?php 
//Credenciais/token do PicPay
$xPicpayToken = "";

//URL da loja
$callbackUrl = "http://www.sualoja.com.br/callback";
$returnUrl = "http://www.sualoja.com.br/cliente/pedido/";

//Dados da fatura
$referenceId = rand(100000, 999999);
$value = 20.51;
$expiresAt = "2022-05-01T16:00:00-03:00";

//Dados do comprador
$firstName = "João";
$lastName = "Da Silva";
$document = "123.456.789-10";
$email = "test@picpay.com";
$phone = "+55 27 12345-6789";


//Numero Da Fatura
$referenceId= rand(100000, 999999);

$dados = [
    "referenceId" => $referenceId,
    "callbackUrl"=> $callbackUrl,
    "returnUrl"=> $returnUrl . $referenceId,
    "value"=> $valor,
    "expiresAt"=> $expiresAt,
    "buyer"=> [
      "firstName"=> $nome,
      "lastName"=> $sobrenome,
      "document"=> $documentos,
      "email"=> $email,
      "phone"=> $celular
    ]
];
$pd = curl_init('https://appws.picpay.com/ecommerce/public/payments');

curl_setopt($pd, CURLOPT_RETURNTRANSFER, true);
curl_setopt($pd, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($pd, CURLOPT_POSTFIELDS, http_build_query($dados));
//Coloque Token de quem vai receber o dinheiro
curl_setopt($pd, CURLOPT_HTTPHEADER, ['x-picpay-token: ' . $xPicpayToken] );

$resposta = curl_exec($pd);
curl_close($pd);

$retorno = json_decode($resposta);

var_dump($retorno);

//var_dump($retorno) QRCode + Fatura da compra;

echo "<img src='".$retorno->qrcode->base64."'><br><br>";
echo "ID da fatura: " . $retorno->referenceId . "<br>";
echo "Link da fatura: <a href='" . $retorno->paymentUrl . "' target='_blank'>Fatura</a><br>";

?>
</body>
</html>