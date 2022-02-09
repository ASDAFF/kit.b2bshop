<?php
namespace Kit\B2BShop\Base\Shop;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use \Bitrix\Main\SystemException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
class Catalog
{
	protected static $instance;
	protected $settings = array();
	protected static $images = array();

	private function __construct()
	{
		try
		{
			$this->setSetting('propBrand', Option::get("kit.b2bshop", "MANUFACTURER_ELEMENT_PROPS", ""));
			$this->setSetting('propMorePhotoProduct',Option::get("kit.b2bshop","MORE_PHOTO_PRODUCT_PROPS",""));
			$this->setSetting('propMorePhotoOffers',Option::get("kit.b2bshop","MORE_PHOTO_OFFER_PROPS",""));
			$this->setSetting('picFromOffer',(Option::get("kit.b2bshop","PICTURE_FROM_OFFER","") == 'Y') ? true : false);
			$this->setSetting('avlDelete',(Option::get("kit.b2bshop","AVAILABLE_DELETE","") == 'Y') ? true : false);
			$this->setSetting('colorInProduct',(Option::get("kit.b2bshop","COLOR_IN_PRODUCT","") == 'Y') ? true : false);
			$this->setSetting('propColorInProduct',Option::get("kit.b2bshop","COLOR_IN_PRODUCT_CODE",""));
			$this->setSetting('propColor',Option::get("kit.b2bshop","OFFER_COLOR_PROP",""));
			$this->setSetting('resizeMode',Option::get("kit.b2bshop","IMAGE_RESIZE_MODE",BX_RESIZE_IMAGE_PROPORTIONAL));
			$this->setSetting('delOfferNoImage',(Option::get("kit.b2bshop","DELETE_OFFER_NOIMAGE","") == 'Y') ? true : false);
		}
		catch (ArgumentNullException $e)
		{
		}
		catch (ArgumentOutOfRangeException $e)
		{
		}
		catch (SystemException $e)
		{
		}

	}
	/**
	 *
	 * @return \Kit\B2BShop\Base\Shop\Catalog
	 */
	public static function getCatalog()
	{
		if (is_null(self::$instance))
		 {
		 	self::$instance = new self;
		}
		return self::$instance;
	}
	/**
	 *
	 * @param string $key
	 * @throws SystemException
	 * @return \Kit\B2BShop\Base\Shop\Catalog
	 */
	public static function getSetting($key = '')
	{
		if( isset( self::$instance->settings[$key] ) )
		{
			return self::$instance->settings[$key];
		}
		else
		{
			throw new SystemException( "Invalid key $key." );
		}
	}

	/**
	 * @param array $arResult
	 * @return array
	 * @throws \Bitrix\Main\LoaderException
	 */
	public function changePricesWithKitPrice($arResult = array())
	{
		if(Loader::includeModule("kit.price"))
		{
			$arResult = \KitPrice::ChangeMinPrice($arResult);
		}
		return $arResult;
	}
	/**
	 *
	 * @param string $key
	 * @param string $value
	 * @throws SystemException
	 */
	public function setSetting($key = '',$value = '')
	{
		if( !$key )
		{
			throw new SystemException( "Key $key doesnt exist." );
		}
		$this->settings[$key] = $value;
	}
	/**
	 * @return multitype:
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param multitype: $images
	 */
	public function setImages($images)
	{
		$this->images = $images;
	}

	/**
	 * @param int $key
	 * @param array $image
	 */
	public function addImage($key = 0,$image = array())
	{
		$this->images[$key] = $image;
	}
}
?>