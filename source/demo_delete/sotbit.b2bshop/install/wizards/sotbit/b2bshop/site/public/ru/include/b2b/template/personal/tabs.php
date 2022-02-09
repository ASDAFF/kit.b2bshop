<?php
$opt = new \Sotbit\B2BShop\Client\Shop\Opt();
if( $opt->hasAccess() )
{
	$tabs = new \Sotbit\B2BShop\Client\Personal\Tab();
	?>
	<div class="tabs personal-tabs">
		<a href="<?=$tabs->getUrl(1)?>">
			<div id="personal-tab-first" class="personal-tab <?=($tabs->getOpen() == 1)?'personal-tab-active':''?> personal-tab-first">
				<span class="personal-tab-img"></span>
				<span>
					Розничный
				</span>
			</div>
		</a>
		<a href="<?=$tabs->getUrl(2)?>">
			<div id="personal-tab-second" class="personal-tab <?=($tabs->getOpen() == 2)?'personal-tab-active':''?> personal-tab-second">
				<span class="personal-tab-img"></span>
				<span>
					B2B кабинет
				</span>
			</div>
		</a>
	</div>
	<?php
}
?>