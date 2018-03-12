<?php

require_once(dirname(__FILE__) . '/../init.php');

try {

	$itaucripto = new \Itaucripto\Itaucripto();
	$itaucripto->setCompanyCode  ('J0098765430001220000002598');
	$itaucripto->setEncryptionKey('12ASDFG456KWE078');

	$itaucripto->setOrderNumber 		 (substr(time(),-8));
	$itaucripto->setAmount 				 ('1,57');
	$itaucripto->setDraweeName 			 ('Fabiano Couto');
	$itaucripto->setDraweeDocTypeCode 	 ('01');
	$itaucripto->setDraweeDocNumber 	 ('61022645099');
	$itaucripto->setDraweeAddress 		 ('Av Presidente Vargas');
	$itaucripto->setDraweeAddressDistrict('Centro');
	$itaucripto->setDraweeAddressCity	 ('Rio de Janeiro');
	$itaucripto->setDraweeAddressState	 ('RJ');
	$itaucripto->setDraweeAddressZipCode ('20070006');

	// $itaucripto->setCallbackUrl('http://www.domain.com/callback');

	$itaucripto->setBankSlipDueDate  (date('dmY', strtotime('+7 day')));
	$itaucripto->setBankSlipNoteLine1('Sr. Caixa,');
	$itaucripto->setBankSlipNoteLine1('Não receber após o vencimento.');
	$itaucripto->setBankSlipNoteLine1('Obrigado.');

	$data = $itaucripto->generateData();

} catch (Exception $e) {

	die(var_dump($e));
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SHOPLINE</title>
</head>
<body>
<form action="https://shopline.itau.com.br/shopline/shopline.aspx" method="post" name="form" onsubmit="itauShoplinePopup()" target="SHOPLINE">
	<input type="hidden" name="DC" value="<?php print $data; ?>" />
	<input type="submit" name="Shopline" value="Itaú Shopline" />
</form>
<script language='JavaScript'>
function itauShoplinePopup(){
	window.open('','SHOPLINE','toolbar=yes,menubar=yes,resizable=yes,status=no,scrollbars=yes,width=815,height=575');
}
</script>
</body>
</html>