<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
use \Sotbit\B2BShop\Seo\Og;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
$APPLICATION->ShowViewContent('ms_big_data');
$APPLICATION->ShowViewContent('ms_product_view');
Loc::loadMessages(__FILE__);
					if(defined('ERROR_404'))
					{?>
							</div>
						</div>
					<?
					}
					elseif ($Template::getCurPage()=='/catalog/' || $Template::getCurPage()=='/brands/' || $Template::getCurPage() =='/personal/order/make/' || $Template::getCurPage() =='/personal/' || $Template::getCurPage() =='/personal/profile/' || $Template::getCurPage() == '/personal/subscribe/' || $Template::getCurPage() == '/personal/order/')
					{?>
						</div>
					<?
					}
					elseif($Template::getCurPage() == '/about/contacts/' || $Template::getCurPage() == '/news/'  || $Template::getCurPage() == '/login/' ||  $Template::getCurPage() == '/auth/')
					{
					}
					else
					{?>
									</div>
								</div>
							</div>
						</div>
					<?}?>
					</div>
				</div>
			</div>
			<?
			$APPLICATION->ShowViewContent('ms_big_data_detail');
			$APPLICATION->ShowViewContent('ms_product_view_detail');
			?>
		</div>
	</div>
	<div class='footer bootstrap_style' id='footer'>
		<?if (!defined('ERROR_404') || ( Loader::includeModule('sotbit.b2bshop') && $Template::getCurPage() != 'personal/order/make/'))
		{
			$APPLICATION->IncludeComponent(
				'sotbit:sotbit.mailing.email.get',
				'ms_main',
				Array(
					'TYPE' => 'FIELD',
					'INFO_TEXT' => Loc::getMessage('MAILING_INFO_TEXT'),
					'EMAIL_SEND_END' =>  Loc::getMessage('MAILING_EMAIL_SEND_END'),
					'COLOR_BUTTON' => '6e7278',
					'DISPLAY_IF_ADMIN' => 'Y',
					'DISPLAY_NO_AUTH' => 'Y',
					'CATEGORIES_ID' => unserialize(Option::get('sotbit.b2bshop', 'MAILING_CATEGORIES_ID', 'a:0:{}')),
					'JQUERY' => 'N'
				),
			false
			);
		}?>
	<div class='footer_block_second'>
			<div class='container'>
				<div class='footer_block_center'>
					<div class='row'>
						<div class='col-sm-18 sm-padding-right-no'>
							<?$APPLICATION->IncludeComponent('bitrix:menu', 'ms_footer_menu', Array(
								'ROOT_MENU_TYPE' => 'bottom',
								'MENU_CACHE_TYPE' => 'A',
								'MENU_CACHE_TIME' => '3600',
								'MENU_CACHE_USE_GROUPS' => 'Y',
								'MENU_CACHE_GET_VARS' => '',
								'MAX_LEVEL' => '2',
								'CHILD_MENU_TYPE' => 'bottom_inner',
								'USE_EXT' => 'N',
								'DELAY' => 'N',
								'ALLOW_MULTI_SELECT' => 'N',
								),
								false
							);?>
						</div>

						<div class='col-sm-6'>
						   <div class='footer_block_center_left'>
								<h3 class='center_left_title'>
									<?$APPLICATION->IncludeFile(SITE_DIR.'include/miss-footer-right-title.php',
										Array(),
										Array('MODE'=>'html')
									);?>
								</h3>
								<div class='center_left_email'>
									<?
									echo Option::get('sotbit.b2bshop', 'EMAIL', '');
									?>
								</div>
								<div class='footer_wrap_phone'>
									<?
									echo Option::get('sotbit.b2bshop', 'TEL', '');
									?>
								</div>
								<div class='footer_social'>
									<?$APPLICATION->IncludeFile(SITE_DIR.'/include/miss-footer-social.php',
										Array(),
										Array('MODE'=>'php')
									);?>
								</div>
						   </div>
						</div>
					</div>
				</div>

				<div class='footer_block_bottom'>
					<div class='row'>
						<div class='col-sm-5 sm-padding-no'>
							<div class='copyright'>
								<?= Option::get('sotbit.b2bshop', 'COPYRIGHT', '');?>
							 </div>
						</div>
						<div class='col-sm-4 sm-padding-no'>
							<a href='https://www.sotbit.ru/' target='_blank' class='sotbit'><?=Loc::getMessage('FOOTER_COMPANY_SOTBIT')?></a>
						</div>
						<div class='col-sm-6 hidden-xs'>
							<div class='footer_bottom_center'>
								<div class='text hidden-md hidden-sm'>
									<?$APPLICATION->IncludeFile(SITE_DIR.'include/miss-footer-delivery-title.php',
										Array(),
										Array('MODE'=>'html')
									);?>
								</div>
								<div class='block_bottom_center'>
									<?$APPLICATION->IncludeFile(SITE_DIR.'include/miss-footer-delivery.php',
										Array(),
										Array('MODE'=>'html')
									);?>
								</div>
							</div>
						</div>
						<div class='col-sm-9 sm-padding-no hidden-xs'>
							<div class='footer_bottom_right'>
								<div class='text hidden-md hidden-sm'>
									<?$APPLICATION->IncludeFile(SITE_DIR.'include/miss-footer-pay-title.php',
										Array(),
										Array('MODE'=>'html')
									);?>
								</div>
								<div class='block_bottom_right'>
									<?$APPLICATION->IncludeFile(SITE_DIR.'include/miss-footer-pay.php',
										Array(),
										Array('MODE'=>'html')
									);?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	   </div>
		<?
		//????????????? START
		$APPLICATION->IncludeComponent(
			'coffeediz:schema.org.OrganizationAndPlace',
			'',
			Array(
				'ADDRESS' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_ADDRESS', ''),
				'COMPONENT_TEMPLATE' => '.default',
				'COUNTRY' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_STRANA', ''),
				'DESCRIPTION' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_DESCRIPTION', ''),
				'EMAIL' => unserialize(Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_EMAIL', '')),
				'FAX' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_FAX', ''),
				'IMAGE' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_IMAGE', ''),
				'ITEMPROP' => '',
				'LOCALITY' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_CITY', ''),
				'LOGO' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_LOGO', ''),
				'LOGO_CAPTION' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_LOGO_CAPTION', ''),
				'LOGO_DESCRIPTION' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_LOGO_DESCRIPTION', ''),
				'LOGO_HEIGHT' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_LOGO_HEIGHT', ''),
				'LOGO_NAME' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_LOGO_NAME', ''),
				'LOGO_TRUMBNAIL_CONTENTURL' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_LOGO_THUMBNAIL_CONTENT_URL', ''),
				'LOGO_WIDTH' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_LOGO_WIDTH', ''),
				'NAME' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_NAME', ''),
				'OPENING_HOURS_ROBOT'=>array(),
				'PARAM_RATING_SHOW' => 'N',
				'PHONE' => unserialize(Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_PHONE', '')),
				'PHOTO_SRC' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_LOGO', ''),
				'POST_CODE' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_POSTCODE', ''),
				'PRICE_RANGE' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_PRICE_RANGE', ''),
				'REGION' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_REGION', ''),
				'SHOW' => 'Y',
				'SITE' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_SITE', ''),
				'TAXID' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_TAXID', ''),
				'TYPE' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_TYPE1', ''),
				'TYPE_2' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_TYPE2', ''),
				'TYPE_3' => Option::get('sotbit.b2bshop', 'MICRO_ORGANIZATION_TYPE3', ''),

			)
		);
		if(class_exists(Og))
		{
			$Og = new Sotbit\B2BShop\Seo\Og();
			$Og->load(array('og:description'));
			$Ogs = array('og:title','og:type');
			if($Og->getField('og:description'))
			{
				$Og->unsetField('og:description');
			}
			else
			{
				$Ogs[] = 'og:description';
			}
			$Og->generate($Ogs);
			$Og->set();
			unset($Ogs);
			unset($Og);
		}
		unset($Og);
		?>
	</div>
</body>
</html>