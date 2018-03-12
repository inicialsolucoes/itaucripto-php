<?php

namespace Itaucripto;

/**
 * Itaucripto
 * @author Inicial Soluções <contato@inicial.com.br>
 *
 * @link https://github.com/inicialcombr/itaucripto-php
 */
class Itaucripto
{
	const ITAU_KEY            = 'SEGUNDA12345ITAU';
	const COMPANY_CODE_SIZE   = 26;
	const ENCRYPTION_KEY_SIZE = 16;

	/**
     * @access private
     * @var array
     */
	private $__sbox = array();

	/**
     * @access private
     * @var array
     */
	private $__key = array();

	/**
     * @access private
     * @var string
     */
    private $__companyCode = null;

    /**
     * @access private
     * @var string
     */
    private $__encryptionKey = null;

    /**
     * @access private
     * @var string
     */
    private $__paymentTypeCode = null;

    /**
     * @access private
     * @var int
     */
    private $__orderNumber = null;

    /**
     * @access private
     * @var float
     */
    private $__amount = null;

    /**
     * @access private
     * @var string
     */
    private $__note = null;

    /**
     * @access private
     * @var string
     */
    private $__draweeName = null;

    /**
     * @access private
     * @var string
     */
    private $__draweeDocTypeCode = null;

    /**
     * @access private
     * @var string
     */
    private $__draweeDocNumber = null;

    /**
     * @access private
     * @var string
     */
    private $__draweeAddress = null;

    /**
     * @access private
     * @var string
     */
    private $__draweeAddressDistrict = null;

    /**
     * @access private
     * @var string
     */
    private $__draweeAddressCity = null;

    /**
     * @access private
     * @var string
     */
    private $__draweeAddressState = null;

    /**
     * @access private
     * @var string
     */
    private $__draweeAddressZipCode = null;

    /**
     * @access private
     * @var date
     */
    private $__bankSlipDueDate = null;

    /**
     * @access private
     * @var string
     */
    private $__bankSlipNoteLine1 = null;

    /**
     * @access private
     * @var string
     */
    private $__bankSlipNoteLine2 = null;

    /**
     * @access private
     * @var string
     */
    private $__bankSlipNoteLine3 = null;

    /**
     * @access private
     * @var string
     */
    private $__callbackUrl = null;

    /**
     * @param string $value
     */
    public function setCompanyCode($value)
    {
    	$this->__companyCode = $value;
    }

    /**
     * @param string $value
     */
    public function setEncryptionKey($value)
    {
    	$this->__encryptionKey = $value;
    }

    /**
     * @param string $value
     */
    public function setPaymentTypeCode($value)
    {
    	$this->__paymentTypeCode = $value;
    }

    /**
     * @param string $value
     */
    public function setOrderNumber($value)
    {
    	$this->__orderNumber = $value;
    }

    /**
     * @param float $value (Example: 1,99)
     */
    public function setAmount($value)
    {
    	$this->__amount = $value;
    }

    /**
     * @param string $value
     */
    public function setNote($value)
    {
    	$this->__note = $value;
    }

    /**
     * @param string $value
     */
    public function setDraweeName($value)
    {
    	$this->__draweeName = $value;
    }

    /**
     * @param string $value (01- CPF, 02 - CNPJ)
     */
    public function setDraweeDocTypeCode($value)
    {
    	$this->__draweeDocTypeCode = $value;
    }

    /**
     * @param string $value
     */
    public function setDraweeDocNumber($value)
    {
    	$this->__draweeDocNumber = $value;
    }

    /**
     * @param string $value
     */
    public function setDraweeAddress($value)
    {
    	$this->__draweeAddress = $value;
    }

    /**
     * @param string $value
     */
    public function setDraweeAddressDistrict($value)
    {
    	$this->__draweeAddressDistrict = $value;
    }

    /**
     * @param string $value
     */
    public function setDraweeAddressCity($value)
    {
    	$this->__draweeAddressCity = $value;
    }

    /**
     * @param string $value
     */
    public function setDraweeAddressState($value)
    {
    	$this->__draweeAddressState = $value;
    }

    /**
     * @param string $value
     */
    public function setDraweeAddressZipCode($value)
    {
    	$this->__draweeAddressZipCode = $value;
    }

    /**
     * @param string $value
     */
    public function setBankSlipDueDate($value)
    {
    	$this->__bankSlipDueDate = $value;
    }

    /**
     * @param string $value
     */
    public function setBankSlipNoteLine1($value)
    {
    	$this->__bankSlipNoteLine1 = $value;
    }

    /**
     * @param string $value
     */
    public function setBankSlipNoteLine2($value)
    {
    	$this->__bankSlipNoteLine2 = $value;
    }

    /**
     * @param string $value
     */
    public function setBankSlipNoteLine3($value)
    {
    	$this->__bankSlipNoteLine3 = $value;
    }

    /**
     * @param string $value
     */
    public function setCallbackUrl($value)
    {
    	$this->__callbackUrl = $value;
    }

    /**
     * @param  string $key
     * @return void
     */
    private function __init($key)
	{
		$m = strlen($key);

		for ($j = 0; $j <= 255; $j++) {

			$this->__key[$j]  = substr($key, ($j % $m), 1);
			$this->__sbox[$j] = $j;
		}

		$k = 0;

		for ($j = 0; $j <= 255; $j++) {

			$k = ($k + $this->__sbox[$j] + ord($this->__key[$j])) % 256;
			$i = $this->__sbox[$j];

			$this->__sbox[$j] = $this->__sbox[$k];
			$this->__sbox[$k] = $i;
		}
	}

	/**
	 * @param  string $param
	 * @param  string $key
	 * @return string
	 */
	private function __algorithm($param, $key)
	{
		$this->__init($key);

		$k   = 0;
		$m   = 0;
		$str = null;

		for ($j = 1; $j <= strlen($param); $j++) {

			$k = ($k + 1) % 256;
			$m = ($m + $this->__sbox[$k]) % 256;
			$i = $this->__sbox[$k];

			$this->__sbox[$k] = $this->__sbox[$m];
			$this->__sbox[$m] = $i;

			$n = $this->__sbox[(($this->__sbox[$k] + $this->__sbox[$m]) % 256)];

			$i1 = (ord(substr($param, ($j - 1), 1)) ^ $n);

			$str = $str . chr($i1);
		}

		return $str;
	}

	/**
	 * @param  string $param
	 * @param  int    $count
	 * @return string
	 */
	private function __fillWithSpace($param, $count)
	{
		while (strlen($param) < $count) {
			$param = $param . ' ';
		}

		return substr($param, 0, $count);
	}

	/**
	 * @param  string $param
	 * @param  int    $count
	 * @return string
	 */
	private function __fillWithZero($param, $count)
	{
		while (strlen($param) < $count) {
			$param = '0' . $param;
		}

		return substr($param, 0, $count);
	}

	/**
	 * @return int
	 */
	private function __randomNumber()
	{
		return rand(0, 999999999) / 1000000000;
	}

	/**
	 * @param  string $str
	 * @return string
	 */
	private function __decodeCharacters($str)
	{
		return strtr(utf8_decode($str),utf8_decode('ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'),'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');
	}

	/**
	 * @param  string $param
	 * @param  bool   $undo
	 * @return string
	 */
	private function __convert($param, $undo = false)
	{
		if ($undo) {

			$s = '';

			for ($i = 0; $i < strlen($param); $i++) {

				$t = '';
				$c = substr($param, $i, 1);

				while (is_numeric($c)) {

					$t .= substr($param, $i, 1);
					$i += 1;
					$c  = substr($param, $i, 1);
				}

				if ($t != '') {

					$j  = $t + 0;
					$s .= chr($j);
				}
			}

		} else {

			$s = (string) chr(floor(26.0 * $this->__randomNumber() + 65.0));

			for ($i = 0; $i < strlen($param); $i++) {

				$k = substr($param, $i, 1);
				$j = ord($k);
				$s = $s . $j;
				$c = chr(floor(26.0 * $this->__randomNumber() + 65.0));
				$s = $s . $c;
			}

		}

		return $s;
	}

	/**
	 * @return string
	 */
	public function generateData()
	{
		if (strlen($this->__companyCode) != Itaucripto::COMPANY_CODE_SIZE) {
			return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
		}

		if (strlen($this->__encryptionKey) != Itaucripto::ENCRYPTION_KEY_SIZE) {
			return "Erro: tamanho da chave da chave diferente de 16 posições.";
		}

		if (strlen($this->__orderNumber) < 1 || strlen($this->__orderNumber) > 8) {
			return "Erro: número do pedido inválido.";
		}

		if (is_numeric($this->__orderNumber)) {
			$this->__orderNumber = $this->__fillWithZero($this->__orderNumber, 8);
		} else {
			return "Erro: numero do pedido não é numérico.";
		}

		if (strlen($this->__amount) < 1 || strlen($this->__amount) > 11) {
			return "Erro: valor da compra inválido.";
		}

		$commaPos = strpos($this->__amount, ',');

		if ($commaPos !== FALSE) {

			$amount = substr($this->__amount, ($commaPos + 1));

			if (!is_numeric($amount)) {
				return "Erro: valor decimal não é numérico.";
			}

			if (strlen($amount) != 2) {
				return "Erro: valor decimal da compra deve possuir 2 posições após a virgula.";
			}

			$this->__amount = substr($this->__amount, 0, strlen($this->__amount) - 3) . $amount;

		} else {

			if (!is_numeric($this->__amount)) {
				return "Erro: valor da compra não é numérico.";
			}

			if (strlen($this->__amount) > 8) {
				return "Erro: valor da compra deve possuir no máximo 8 posições antes da virgula.";
			}

			$this->__amount = $this->__amount . '00';
		}

		$this->__amount = $this->__fillWithZero($this->__amount, 10);

		if ($this->__draweeDocTypeCode != "02" && $this->__draweeDocTypeCode != "01" && $this->__draweeDocTypeCode != "") {
			return "Erro: código de inscrição inválido.";
		}

		if ($this->__draweeDocNumber != "" && !is_numeric($this->__draweeDocNumber) && strlen($this->__draweeDocNumber) > 14) {
			return "Erro: número de inscrição inválido.";
		}

		if ($this->__draweeAddressZipCode != "" && (!is_numeric($this->__draweeAddressZipCode) || strlen($this->__draweeAddressZipCode) != 8)) {
			return "Erro: cep inválido.";
		}

		if ($this->__bankSlipDueDate != "" && (!is_numeric($this->__bankSlipDueDate) || strlen($this->__bankSlipDueDate) != 8)) {
			return "Erro: data de vencimento inválida.";
		}

		if (strlen($this->__bankSlipNoteLine1) > 60) {
			return "Erro: observação adicional 1 inválida.";
		}

		if (strlen($this->__bankSlipNoteLine2) > 60) {
			return "Erro: observação adicional 2 inválida.";
		}

		if (strlen($this->__bankSlipNoteLine3) > 60) {
			return "Erro: observação adicional 3 inválida.";
		}

		$this->__note                  = $this->__decodeCharacters($this->__note);
		$this->__draweeName            = $this->__decodeCharacters($this->__draweeName);
		$this->__draweeAddress         = $this->__decodeCharacters($this->__draweeAddress);
		$this->__draweeAddressDistrict = $this->__decodeCharacters($this->__draweeAddressDistrict);
		$this->__draweeAddressCity     = $this->__decodeCharacters($this->__draweeAddressCity);
		$this->__bankSlipNoteLine1     = $this->__decodeCharacters($this->__bankSlipNoteLine1);
		$this->__bankSlipNoteLine2     = $this->__decodeCharacters($this->__bankSlipNoteLine2);
		$this->__bankSlipNoteLine3     = $this->__decodeCharacters($this->__bankSlipNoteLine3);

		$this->__note                  = $this->__fillWithSpace($this->__note                  , 40);
		$this->__draweeName            = $this->__fillWithSpace($this->__draweeName            , 30);
		$this->__draweeDocTypeCode     = $this->__fillWithSpace($this->__draweeDocTypeCode     , 2);
		$this->__draweeDocNumber       = $this->__fillWithSpace($this->__draweeDocNumber       , 14);
		$this->__draweeAddress         = $this->__fillWithSpace($this->__draweeAddress         , 40);
		$this->__draweeAddressDistrict = $this->__fillWithSpace($this->__draweeAddressDistrict , 15);
		$this->__draweeAddressZipCode  = $this->__fillWithSpace($this->__draweeAddressZipCode  , 8);
		$this->__draweeAddressCity     = $this->__fillWithSpace($this->__draweeAddressCity     , 15);
		$this->__draweeAddressState    = $this->__fillWithSpace($this->__draweeAddressState    , 2);
		$this->__bankSlipDueDate       = $this->__fillWithSpace($this->__bankSlipDueDate       , 8);
		$this->__callbackUrl           = $this->__fillWithSpace($this->__callbackUrl           , 60);
		$this->__bankSlipNoteLine1     = $this->__fillWithSpace($this->__bankSlipNoteLine1     , 60);
		$this->__bankSlipNoteLine2     = $this->__fillWithSpace($this->__bankSlipNoteLine2     , 60);
		$this->__bankSlipNoteLine3     = $this->__fillWithSpace($this->__bankSlipNoteLine3     , 60);

		$algorithm = $this->__algorithm($this->__orderNumber . $this->__amount . $this->__note . $this->__draweeName . $this->__draweeDocTypeCode . $this->__draweeDocNumber . $this->__draweeAddress . $this->__draweeAddressDistrict . $this->__draweeAddressZipCode . $this->__draweeAddressCity . $this->__draweeAddressState . $this->__bankSlipDueDate . $this->__callbackUrl . $this->__bankSlipNoteLine1 . $this->__bankSlipNoteLine2 . $this->__bankSlipNoteLine3, $this->__encryptionKey);

		$algorithm = $this->__algorithm($this->__companyCode . $algorithm, Itaucripto::ITAU_KEY);

		return $this->__convert($algorithm);
	}

	/**
	 * @param  string $data
	 * @return string
	 */
	public function generateGenericData($data)
	{
		if (strlen($this->__companyCode) != Itaucripto::COMPANY_CODE_SIZE) {
			return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
		}

		if (strlen($this->__encryptionKey) != Itaucripto::ENCRYPTION_KEY_SIZE) {
			return "Erro: tamanho da chave da chave diferente de 16 posições.";
		}

		if (strlen($data) < 1) {
			return "Erro: sem dados.";
		}

		$algorithm = $this->__algorithm($data, $this->__encryptionKey);

		$algorithm = $this->__algorithm($this->__companyCode . $algorithm, Itaucripto::ITAU_KEY);

		return $this->__convert($str2);
	}

	/**
	 * @param  int $formatCode (0 or 1)
	 * @return string
	 */
	public function generateQuery($formatCode)
	{
		if (strlen($this->__companyCode) != Itaucripto::COMPANY_CODE_SIZE) {
			return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
		}

		if (strlen($this->__encryptionKey) != Itaucripto::ENCRYPTION_KEY_SIZE) {
			return "Erro: tamanho da chave da chave diferente de 16 posições.";
		}

		if (strlen($this->__orderNumber) < 1 || strlen($this->__orderNumber) > 8) {
			return "Erro: número do pedido inválido.";
		}

		if (is_numeric($this->__orderNumber)) {
			$this->__orderNumber = $this->__fillWithZero($this->__orderNumber, 8);
		} else {
			return "Erro: numero do pedido não é numérico.";
		}

		if ($formatCode != 0 && $formatCode != 1) {
			return "Erro: formato inválido.";
		}

		$algorithm = $this->__algorithm($this->__orderNumber . $formatCode, $this->__encryptionKey);

		$algorithm = $this->__algorithm($this->__companyCode . $algorithm, Itaucripto::ITAU_KEY);

		return $this->__convert($algorithm);
	}

	/**
	 * @return string
	 */
	public function cripto()
	{
		if (strlen($this->__companyCode) != Itaucripto::COMPANY_CODE_SIZE) {
			return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
		}

		if (strlen($this->__encryptionKey) != Itaucripto::ENCRYPTION_KEY_SIZE) {
			return "Erro: tamanho da chave diferente de 16 posições.";
		}

		if (empty($this->__draweeDocNumber)) {
			return "Erro: código do sacado inválido.";
		}

		$algorithm = $this->__algorithm($this->__draweeDocNumber, $this->__encryptionKey);

		$algorithm = $this->__algorithm($this->__companyCode . $algorithm, Itaucripto::ITAU_KEY);

		return $this->__convert($algorithm);
	}

	/**
	 * @param  string $cripto
	 * @return string
	 */
	public function decripto($cripto)
	{
		$decripto = $this->__convert($cripto, true);

		$algorithm = $this->__algorithm($decripto, $this->__encryptionKey);

		$this->__companyCode     = substr($algorithm, 0, 26);
		$this->__orderNumber     = substr($algorithm, 26, 8);
		$this->__paymentTypeCode = substr($algorithm, 34, 2);

		return $algorithm;
	}
}