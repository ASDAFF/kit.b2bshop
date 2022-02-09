<?php
use Bitrix\Main\Web\Json;


global ${$arParams[1]['FILTER_NAME']};
?>
	<div class="row">
		<div class="col-sm-12">
			<form method="POST" action="" onsubmit="">
				<input type="submit" name="subtitle" style="display:none" />
				<div id="blank_categorii" class="blank_categorii">
					Категории
					<div class="blank_categorii_menu"></div>
				</div>
				<div class="col-sm-24 sm-padding-right-no sort-catalog">
					<div id="blank_list" style="display:none;" class="blank_list">
						<div class="blank_list_in">
							<div class="blank_list_in_menu">
								<div class="blank_list_in_in_menu">
								<?php
								echo tree($arParams[0]['ROOT']['CHILD'], $arParams[0]['ADDITIONAL_FILTER']['SECTIONS']);
								?>
								</div>
							</div>
						</div>
						<div class="blank_kategorii_button" id="blank_kategorii_button">Применить</div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-sm-6 sm-padding-left-no">
			<div class="blank_excel_in_wrapper">
				<div id="blank_excel_in" class="blank_excel_in blank_excel">
					<div class="blank_excel_in_text blank_excel_text"><div class="blank_excel_in_img blank_excel_img"></div>Загрузить из Excel</div>
				</div>
				<div id="excel_in_form" class="js" style="display:none;">
					<form method="post" action="" enctype="multipart/form-data" novalidate class="box">
						<div class="blank_excel_in_form">
							<div class="box__input">
								<div class="error_blank_excel_in"></div>
								<input type="file" name="files[]" id="file" class="box__file" />
								<label for="file"><strong>Выберите файл</strong><span class="box__dragndrop"> или перетащите его сюда</span>.</label>
								<button type="button" class="box__button">Отправить</button>
							</div>
							<div class="box__uploading">Uploading&hellip;</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?$APPLICATION->ShowViewContent('blank_excel_out_filter');?>	</div>
	<div class="row">
		<div class="col-sm-24">
			<?php
			$searchIblocks = array($arParams[1]['IBLOCK_ID']);
			$skuIblock = CCatalogSKU::GetInfoByProductIBlock($arParams[1]['IBLOCK_ID']);

			if($skuIblock['IBLOCK_ID'])
			{
				$searchIblocks[] = $skuIblock['IBLOCK_ID'];
			}


			if(isset($_REQUEST['q']) && empty($_REQUEST['q']))
			{
				unset($_SESSION['blank_search']);
			}

			if(isset($_REQUEST['q']) && !empty($_REQUEST['q']))
			{
				$_SESSION['blank_search'] = $_REQUEST['q'];
			}
			
			if($_SESSION['blank_search'])
			{
				$_REQUEST['q'] = $_SESSION['blank_search'];
			}

			$arElements = $APPLICATION->IncludeComponent(
				"bitrix:search.page",
				"blank_search",
				Array(
					"RESTART" => "Y",
					"NO_WORD_LOGIC" => "Y",
					"USE_LANGUAGE_GUESS" => "Y",
					"CHECK_DATES" => "Y",
					"arrFILTER" => array("iblock_".$arParams[1]["IBLOCK_TYPE"]),
					"arrFILTER_iblock_".$arParams[1]["IBLOCK_TYPE"] => $searchIblocks,
					"USE_TITLE_RANK" => "N",
					"DEFAULT_SORT" => "rank",
					"FILTER_NAME" => "",
					"SHOW_WHERE" => "N",
					"arrWHERE" => array(),
					"SHOW_WHEN" => "N",
					"PAGE_RESULT_COUNT" => 50,
					"DISPLAY_TOP_PAGER" => "N",
					"DISPLAY_BOTTOM_PAGER" => "N",
					"PAGER_TITLE" => '',
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => "N",

				),
				$component
			);
			if (is_array($arElements))
			{
				if(count($arElements) == 0)
				{
					$arElements = array(0);
				}
				${$arParams[1]['FILTER_NAME']}['ID'] = $arElements;
			}
			if($_REQUEST['q'])
			{
				$_SESSION['blank_search'] = $_REQUEST['q'];
			}
			?>
		</div>
	</div>
<?php
function tree($parent, $checked = array())
{
	$out='<ul class="blank_menu">';
	foreach($parent as $child)
	{
		$out .= '<li';
		if($child['CHILD'])
		{
			$out .= ' class="dropdown"';
		}
		$out .= '>';
		if($child['CHILD'])
		{
			$out.= '<span class="open_close_menu" onclick="open_close_menu(this, \'.inner-menu\',true);"></span>';
		}
		$out .= '<input ';
		if(in_array($child['ID'], $checked))
		{
			$out .="checked='checked'";
		}
		$out .=' type="checkbox" name="sections[]" value="'.$child['ID'].'" id="section_'.$child['ID'].'"><label class="check ';
		if(in_array($child['ID'], $checked))
		{
			$out .="label-active";
		}
		$out .='" for="section_'.$child['ID'].'">'.$child['NAME'].'</label>';
		if($child['CHILD'])
		{
			$out.='<div class="inner-menu">';
			$out.=tree($child['CHILD'], $checked);
			$out.='</div>';
		}
		$out .= '</li>';
	}
	$out .= '</ul>';
	return $out;
}
?>
<script>

'use strict';

;( function ( document, window, index )
{
	// feature detection for drag&drop upload
	var isAdvancedUpload = function()
		{
			var div = document.createElement( 'div' );
			return ( ( 'draggable' in div ) || ( 'ondragstart' in div && 'ondrop' in div ) ) && 'FormData' in window && 'FileReader' in window;
		}();


	// applying the effect for every form
	var forms = document.querySelectorAll( '.box' );
	Array.prototype.forEach.call( forms, function( form )
	{
		var input		 = form.querySelector( 'input[type="file"]' ),
			label		 = form.querySelector( 'label' ),
			errorMsg	 = form.querySelector( '.box__error span' ),
			restart		 = form.querySelectorAll( '.box__restart' ),
			droppedFiles = false,
			showFiles	 = function( files )
			{
				label.textContent = files.length > 1 ? ( input.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', files.length ) : files[ 0 ].name;
			},
			triggerFormSubmit = function()
			{
				var event = document.createEvent( 'HTMLEvents' );
				event.initEvent( 'submit', true, false );
				form.dispatchEvent( event );
			};

		// letting the server side to know we are going to make an Ajax request
		var ajaxFlag = document.createElement( 'input' );
		ajaxFlag.setAttribute( 'type', 'hidden' );
		ajaxFlag.setAttribute( 'name', 'ajax' );
		ajaxFlag.setAttribute( 'value', 1 );
		form.appendChild( ajaxFlag );

		// automatically submit the form on file select
		input.addEventListener( 'change', function( e )
		{
			showFiles( e.target.files );


		});

		// drag&drop files if the feature is available
		if( isAdvancedUpload )
		{
			form.classList.add( 'has-advanced-upload' ); // letting the CSS part to know drag&drop is supported by the browser

			[ 'drag', 'dragstart', 'dragend', 'dragover', 'dragenter', 'dragleave', 'drop' ].forEach( function( event )
			{
				form.addEventListener( event, function( e )
				{
					// preventing the unwanted behaviours
					e.preventDefault();
					e.stopPropagation();
				});
			});
			[ 'dragover', 'dragenter' ].forEach( function( event )
			{
				form.addEventListener( event, function()
				{
					form.classList.add( 'is-dragover' );
				});
			});
			[ 'dragleave', 'dragend', 'drop' ].forEach( function( event )
			{
				form.addEventListener( event, function()
				{
					form.classList.remove( 'is-dragover' );
				});
			});
			form.addEventListener( 'drop', function( e )
			{
				droppedFiles = e.dataTransfer.files;
				showFiles( droppedFiles );

			});
		}

		$('.box__button').on('click',(function(e) {
			var ajaxData = new FormData( form );
			if( droppedFiles )
			{
				for (var i = 0; i < droppedFiles.length; i++)
				{
					ajaxData.append('file', droppedFiles[i]);
				}
			}

			var xhr = new XMLHttpRequest();
			xhr.open('POST', '/include/ajax/blank_excel_in.php');
			xhr.onload = function ()
			{
				if (xhr.status === 200)
				{
					var data = xhr.responseText;
					if(data != '')
					{
						$('.error_blank_excel_in').html(data);
					}
					else
					{
						location.reload();
					}
				}
				else
				{
					console.log('blarrghhhhh...');
				}
			};
			xhr.send(ajaxData);
			return false;
		}));
	});
}( document, window, 0 ));
</script>