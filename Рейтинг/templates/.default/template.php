<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<div class="ratingContainer ntm" id="rating<?=$arResult['ID']?>">
	<span>Рейтинг: </span>
	<span class="ib">
	<div class="ratingstars <? if($arParams['IN_LINE'] == "Y")echo "ib";?>">
		<div class="star"></div>
		<div class="star"></div>
		<div class="star"></div>
		<div class="star"></div>
		<div class="star"></div>
	</div>
	
	<script type="text/javascript">
		$(document).ready(function(){RatingSet(<? if($arResult['UFRATING'])echo $arResult['UFRATING'];else echo 'null'?> ,<?=$arResult['RATING']?>, <?=$arResult['ID']?>)});
	</script>
	<? if($arParams['ALLOW_SET'] != "N"){ ?>
		<span class="a_expand rating">
			<a class="RatingSet_label alike_dt">Проголосовать</a>
			<div class="expand rc4">
			<img class="popcorn" src="/bitrix/templates/.default/images/popcorn.gif">
				<div class="RatingSet_popup">
					<a class="RatingSet_revote alike_dt">Переголосовать</a><br>
					Вы поставили:
				</div>
				
				<?if($USER->isAuthorized()){ ?>
					<div class="setratingstars nbm">
					<div class="star"></div>
					<div class="star"></div>
					<div class="star"></div>
					<div class="star"></div>
					<div class="star"></div>
				<?}else{?>
					<div class="nbm">
						Голосовать могут только<br>авторизированые пользователи.<br>
						<a href="/login/?register=yes">зарегистрироваться</a> или <a href="/ogin/">войти</a>
				<? }?>
					</div>
			</div>
		</span>
	
	</span>
	<? }?>

</div>
					