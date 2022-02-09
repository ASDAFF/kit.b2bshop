<?php
use Bitrix\Main\Localization\Loc;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
Loc::loadMessages(__FILE__);
if($arResult['ITEMS'])
{
	?>
	<div class="row">
		<div class="col-sm-24">
			<div class="sotbit-seometa-tags-wrapper">
				<div class="sotbit-seometa-tags-title">
					<?php echo Loc::getMessage('seometa.tag_POPULAR_TAGS');?>
				</div>
				<?php
				$i = 0;
				foreach($arResult['ITEMS'] as $Item)
				{
					if($Item['TITLE'] && $Item['URL'])
					{
						?>
						<a class="sotbit-seometa-tag-link <?php echo ($i == 0)?'sotbit-seometa-tag-link-first':'';?> <?php echo ($i == sizeof($arResult['ITEMS']) - 1)?'sotbit-seometa-tag-link-last':'';?>" href="<?=$Item['URL'] ?>" title="<?=$Item['TITLE'] ?>">#<?=$Item['TITLE'] ?></a>
						<?
					}
					++$i;
				}
				?>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<?php
}
?>