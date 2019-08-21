<?
	use Bitrix\Main\Localization\Loc;
	use Bitrix\Main\Page\Asset; 
	

	Loc::loadMessages(__FILE__);
	$sum = roundEx($params['SUM'], 2);
?>
	<script>
<?
	$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/payment/uzcard/template/script.js"); 
?>
	</script>
	<style>
<?
	$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH."/payment/uzcard/template/style.css"); 
?>
	</style>
<div class="sale-paysystem-uzcard-wrapper" onmouseover="uzcardActive();">
	<p>Cчет № <?=htmlspecialcharsbx($params['PAYMENT_ID']."  ".$params["PAYMENT_DATE_INSERT"])?></p>
	<p><span class="tablebodytext">
		Сумма к оплате: </br>
		<b><?=SaleFormatCurrency($params['SUM'], $payment->getField('CURRENCY'));?></b>
	</span>
	</p>
	<form name="ShopFormUzcard" action="" method="post">
		<input name="url" value="<?=htmlspecialcharsbx($params['URL']);?>" type="hidden">
		<input name="login" value="<?=htmlspecialcharsbx($params['UZCARD_LOGIN']);?>" type="hidden">
		<input name="psw" value="<?=htmlspecialcharsbx($params['UZCARD_PASSWORD']);?>" type="hidden">
		<input name="key" value="<?=htmlspecialcharsbx($params['UZCARD_KEY']);?>" type="hidden">
		<input name="eposId" value="<?=htmlspecialcharsbx($params['UZCARD_EPOSID']);?>" type="hidden">
		<input name="customerNumber" value="<?=htmlspecialcharsbx($params['PAYMENT_BUYER_ID']);?>" type="hidden">
		<input name="orderNumber" value="<?=htmlspecialcharsbx($params['PAYMENT_ID']);?>" type="hidden">
		<input name="Sum" value="<?=$sum?>" type="hidden">
		<input name="BX_HANDLER" value="UZCARD" type="hidden">
		<div class="sale-paysystem-uzcard-button-container">
			<p><input type="text" class="maskPhone" name="cardTel" placeholder="Ваш номер подключенный к карте"></p>
			<p><input type="text" class="maskCard" name="cardNumber" placeholder="последние 6 цифр карты"></p>
			<p><input type="text" class="maskValid" name="cardValid" placeholder="Срок действия"></p>	
			<span class="uzcardNext button small inline-block-item"><?=Loc::getMessage('SALE_HANDLERS_PAY_SYSTEM_UZCARD_REDIRECT_MESS');?></span>
			<span style="display:none;" class="uzcardPay button small inline-block-item">Оплатить</span>
			<div class="errorMessage" style="color:red;"></div>
		</div><!--sale-paysystem-uzcard-button-container-->
	</form>
</div>
<script>
	var urlAPI = "<?=$params['URL'];?>";
</script>
