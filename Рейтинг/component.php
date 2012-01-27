<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
	if(CModule::IncludeModule("iblock")){ 
		
		global $USER;
		if($arParams["EDIT"] == "Y")$isEdit = true;
		$id = $arParams["ID"];
		$newMark = $arParams["NEW_MARK"];
		
		$rsUser = CUser::GetByID($USER->GetID());
		$arUser = $rsUser->Fetch();
		
	 	if($arUser['UF_RATING']){
	 		$UFrating = unserialize($arUser['UF_RATING']);
	 		$arResult['UFRATING'] = $UFrating[$id];
	 	}
		
		$arDbRes = CIBlockElement::GetList(
			  false,
			  Array("ID"=>$id),
			  false,
			  false,
			  Array("ID","PROPERTY_RATING_NUM","PROPERTY_RATING", "IBLOCK_ID")
		);
		
		$arFetched = $arDbRes->fetch();

		if($arFetched["PROPERTY_RATING_VALUE"] == false)
			$arFetched["PROPERTY_RATING_VALUE"] = $arFetched["PROPERTY_RATING_NUM_VALUE"] = 0;
		
		$rating = $arFetched["PROPERTY_RATING_VALUE"];
		$rating_num = $arFetched["PROPERTY_RATING_NUM_VALUE"];
		$ibid = $arFetched['IBLOCK_ID'];

		$arResult['ID'] = $id;
		$arResult['RATING'] = $rating;
		
		if($isEdit){
			if($UFrating[$id]){
				$rating -= ($UFrating[$id] - $rating) / --$rating_num;
				unset($UFrating[$id]);
			}
			$rating += ($newMark - $rating) / ++$rating_num ;
			$UFrating[$id] = $newMark;
			
	 		$USER->Update($USER->GetID(), Array("UF_RATING" => serialize($UFrating) ));
	 		
			CIBlockElement::SetPropertyValues($id, $ibid, $rating_num, "RATING_NUM");
			CIBlockElement::SetPropertyValues($id, $ibid, $rating, "RATING");
			
			echo '{"RatingNum":"'.$rating_num.'", "Rating":"'.$rating.'","RatingSet":"'.$newMark.'"}';
		}
		else $this->IncludeComponentTemplate();

	}
?>