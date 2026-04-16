<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Главная');
?> 
<?$APPLICATION->IncludeComponent(
	"custom:visitors.log",
	"",
	[
		'HLB_ID' => 1, // ID HL-блока
	]
);?>
<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>