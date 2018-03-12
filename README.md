# Itaucripto (PHP)

This class was created based on the Java version of Itaucripto.

### Composer

$ composer require inicial/itaucripto-php

### Usage

```php
<?php
require_once(dirname(__FILE__) . '/init.php');

$itaucripto = new \Itaucripto\Itaucripto();
$itaucripto->setCompanyCode('J0098765430001220000002598');
$itaucripto->setEncryptionKey('12ASDFG456KWE078');

$itaucripto->setOrderNumber(substr(time(),-8));
$itaucripto->setAmount('1,57');
$itaucripto->setDraweeName('Fabiano Couto');
$itaucripto->setDraweeDocTypeCode('01');
$itaucripto->setDraweeDocNumber('61022645099');
$itaucripto->setDraweeAddress('Av Presidente Vargas');
$itaucripto->setDraweeAddressDistrict('Centro');
$itaucripto->setDraweeAddressCity('Rio de Janeiro');
$itaucripto->setDraweeAddressState('RJ');
$itaucripto->setDraweeAddressZipCode('20070006');

// $itaucripto->setCallbackUrl('http://www.domain.com/callback');

$itaucripto->setBankSlipDueDate(date('dmY', strtotime('+7 day')));
$itaucripto->setBankSlipNoteLine1('Sr. Caixa,');
$itaucripto->setBankSlipNoteLine1('Não receber após o vencimento.');
$itaucripto->setBankSlipNoteLine1('Obrigado.');

$data = $itaucripto->generateData();
?>
```

### Note

You can find more info about usage on class source code.

Report any bug or suggest changes using git [issues](https://github.com/inicialcombr/itaucripto-php/issues).