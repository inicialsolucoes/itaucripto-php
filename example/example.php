<?php

require_once(dirname(__FILE__) . '/../init.php');

try {

	$companyCode           = 'J0098765430001220000002598';
	$encrytionKey          = '12ASDFG456KWE078';
	$orderNumber           = substr(time(),-8);
	$amount                = '1,55';
	$draweeName            = 'Fabiano Couto';
	$draweeDocTypeCode     = '01';
	$draweeDocNumber       = '61022645099';
	$draweeAddress         = 'Av Presidente Vargas';
	$draweeAddressDistrict = 'Centro';
	$draweeAddressCity     = 'Rio de Janeiro';
	$draweeAddressState    = 'RJ';
	$draweeAddressZipCode  = '20070006';
	$bankSlipDueDate       = date('dmY', strtotime('+7 day'));
	$bankSlipNoteLine1     = 'Sr. Caixa,';
	$bankSlipNoteLine2     = 'Não receber após o vencimento.';
	$bankSlipNoteLine3     = 'Obrigado.';

	$itaucripto = new \Itaucripto\Itaucripto();
	$itaucripto->setCompanyCode   	     ($companyCode);
	$itaucripto->setEncryptionKey 		 ($encrytionKey);
	$itaucripto->setOrderNumber 		 ($orderNumber);
	$itaucripto->setAmount 				 ($amount);
	$itaucripto->setDraweeName 			 ($draweeName);
	$itaucripto->setDraweeDocTypeCode 	 ($draweeDocTypeCode);
	$itaucripto->setDraweeDocNumber 	 ($draweeDocNumber);
	$itaucripto->setDraweeAddress 		 ($draweeAddress);
	$itaucripto->setDraweeAddressDistrict($draweeAddressDistrict);
	$itaucripto->setDraweeAddressCity	 ($draweeAddressCity);
	$itaucripto->setDraweeAddressState	 ($draweeAddressState);
	$itaucripto->setDraweeAddressZipCode ($draweeAddressZipCode);
	$itaucripto->setBankSlipDueDate  	 ($bankSlipDueDate);
	$itaucripto->setBankSlipNoteLine1 	 ($bankSlipNoteLine1);
	$itaucripto->setBankSlipNoteLine2 	 ($bankSlipNoteLine2);
	$itaucripto->setBankSlipNoteLine3 	 ($bankSlipNoteLine3);

	// $itaucripto->setCallbackUrl('http://www.domain.com/callback');

	$dataGenerate = $itaucripto->generateData();
	$dataQuery    = $itaucripto->generateQuery(0);

} catch (Exception $e) {

	die(var_dump($e));
}
?>
<!DOCTYPE html>
<html>
<head>
<title>SHOPLINE</title>
<link href="style.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css">
body {font-family: Futura, 'Trebuchet MS', Arial, sans-serif; background-color: #fe6100; font-size: 13px;}
div  {background-color: #fff; margin: 25px; border-radius: 5px; padding: 25px; display: block; width: auto;}
input[type=submit] {background-color: #011f7c; color: #faf73d; border-radius: 5px; padding: 8px; margin-bottom: 5px; width: 100px;}
form {display: inline; padding: 0; margin: 0;}
</style>
</head>
<body>
<div>
	<h1>Itaú Shopline</h1>
	<p>
		Order: <?php print $orderNumber; ?> <br>
		Amount: R$ <?php print $amount; ?> <br>
		Name: <?php print $draweeName; ?> <br>
		Address: <?php print $draweeAddress.', '.$draweeAddressDistrict.', '.$draweeAddressCity.', '.$draweeAddressState.', '.$draweeAddressZipCode; ?> <br>
	</p>
	<form action="https://shopline.itau.com.br/shopline/shopline.aspx" method="post" name="form" onsubmit="itauShoplinePopup()" target="SHOPLINE">
		<input type="hidden" name="DC" value="<?php print $dataGenerate; ?>" />
		<input type="submit" name="Shopline" value="Generate" />
	</form>
	<form action="https://shopline.itau.com.br/shopline/consulta.aspx" method="post" name="form" onsubmit="itauShoplinePopup()" target="SHOPLINE">
		<input type="hidden" name="DC" value="<?php print $dataQuery; ?>" />
		<input type="submit" name="Shopline" value="Query" />
	</form>
</div>
<script language='JavaScript'>
function itauShoplinePopup(){
	window.open('','SHOPLINE','toolbar=yes,menubar=yes,resizable=yes,status=no,scrollbars=yes,width=815,height=575');
}
</script>
</body>
</html>