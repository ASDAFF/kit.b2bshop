<?
if (! defined ( 'B_PROLOG_INCLUDED' ) || B_PROLOG_INCLUDED !== true)
	die ();
	$arResult['SECTIONS'] = array();
	if($arResult['ID'] > 0)
	{
		$rsParentSections =\Bitrix\Iblock\SectionTable::getList(array(
				'select' => array('ID','LEFT_MARGIN','RIGHT_MARGIN','DEPTH_LEVEL'),
				'filter' => array('ID' => $arResult['ID']),
				'order' => array('SORT' => 'ASC','ID' => 'ASC')
		));
		while($ParentSection = $rsParentSections->fetch())
		{
			$rsChildSections = $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),array(
					'IBLOCK_ID' => $arParams["IBLOCK_ID"],
					'>LEFT_MARGIN' => $ParentSection['LEFT_MARGIN'],
					'<RIGHT_MARGIN' => $ParentSection['RIGHT_MARGIN'],
					'>DEPTH_LEVEL' => $ParentSection['DEPTH_LEVEL'],
			),false,array('ID','SECTION_PAGE_URL','DETAIL_PICTURE','UF_BRICK_SORT'),false);
			while($ChildSection = $rsChildSections->GetNext())
			{
				if($ChildSection['UF_BRICK_SORT']!= '' && $ChildSection['UF_BRICK_SORT'] >= 0)
				{
					$i = sizeof($arResult['SECTIONS']);
					while(isset($arResult['SECTIONS'][$i]))
					{
						++$i;
						if($i>50)
						{
							break;
						}
					}
					$ChildSectionPicture = CFile::GetFileArray( $ChildSection['DETAIL_PICTURE'] );
					if($ChildSection['UF_BRICK_SORT'] >= 0)
					{
						$k = $ChildSection['UF_BRICK_SORT'];
						if(isset($arResult['SECTIONS'][$k]))
						{
							$arResult['SECTIONS'][] = $arResult['SECTIONS'][$k];
						}
						$arResult['SECTIONS'][$k]['SECTION_PAGE_URL'] = $ChildSection['SECTION_PAGE_URL'];
						$arResult['SECTIONS'][$k]['BRICK_IMAGE']["HEIGHT"] = $ChildSectionPicture["HEIGHT"];
						$arResult['SECTIONS'][$k]['BRICK_IMAGE']["WIDTH"] = $ChildSectionPicture["WIDTH"];
						$arResult['SECTIONS'][$k]['BRICK_IMAGE']["SRC"] = $ChildSectionPicture["SRC"];
						$arResult['SECTIONS'][$k]['BRICK_IMAGE']["FILE_SIZE"] = $ChildSectionPicture["FILE_SIZE"];
						$arResult['SECTIONS'][$k]['BRICK_IMAGE']['WIDTH_CLASS'] = round($ChildSectionPicture["WIDTH"]/234);
						$arResult['SECTIONS'][$k]['BRICK_IMAGE']['HEIGHT_CLASS'] = round($ChildSectionPicture["HEIGHT"]/234);
					}
					else
					{
						$arResult['SECTIONS'][$i]['SECTION_PAGE_URL'] = $ChildSection['SECTION_PAGE_URL'];
						$arResult['SECTIONS'][$i]['BRICK_IMAGE']["HEIGHT"] = $ChildSectionPicture["HEIGHT"];
						$arResult['SECTIONS'][$i]['BRICK_IMAGE']["WIDTH"] = $ChildSectionPicture["WIDTH"];
						$arResult['SECTIONS'][$i]['BRICK_IMAGE']["SRC"] = $ChildSectionPicture["SRC"];
						$arResult['SECTIONS'][$i]['BRICK_IMAGE']["FILE_SIZE"] = $ChildSectionPicture["FILE_SIZE"];
						$arResult['SECTIONS'][$i]['BRICK_IMAGE']['WIDTH_CLASS'] = round($ChildSectionPicture["WIDTH"]/234);
						$arResult['SECTIONS'][$i]['BRICK_IMAGE']['HEIGHT_CLASS'] = round($ChildSectionPicture["HEIGHT"]/234);
					}
					
				}
			}
		}
	}
	ksort($arResult['SECTIONS']);
	
	$this->__component->arResultCacheKeys = array_merge ( $this->__component->arResultCacheKeys, array (
			
	) );
	?>