<?php
namespace Kit\B2BShop\Base\Shop;

use \Kit\B2BShop;

class Element extends \Kit\B2BShop\Client\Shop\Catalog
{
	protected $id = 0;
	protected $name = '';
	protected $photos = array();
	protected $offers;
	protected $color  = '';
	public function __construct(
			$arResult = array(),
			$arParams = array(),
			$settings = array()
	)
	{
		$catalog = parent::getCatalog();

		$this->offers = new B2BShop\Collection();
		if($arResult['OFFERS'])
		{
			$settings['propMorePhoto'] = $catalog->getSetting('propMorePhotoOffers');
			foreach($arResult['OFFERS'] as $offer)
			{
				$offerElement = new B2BShop\Client\Shop\Element($offer, $arParams, $settings);
				$this->offers->addItem($offerElement);
				if($offerElement->getPhotos())
				{
					foreach($offerElement->getPhotos() as $key => $img)
					{
						$catalog::setImage($key, $img);
					}

					//$catalog::setImages($offerElement->getPhotos());
				}
			}
		}
		else
		{
			$settings['propMorePhoto'] = $catalog->getSetting('propMorePhotoProduct');
		}
		$this->setId($arResult['ID']);
		$this->setName($arResult['NAME']);
		$this->collectImages($arResult, $settings);

		return $this;
	}


	public function collectImages($arResult = array(), $settings = array())
	{
		$images = array();

		$img = $arResult['DETAIL_PICTURE'] ? $arResult['DETAIL_PICTURE'] : $arResult['PREVIEW_PICTURE'];
		if($img)
		{
			if(is_array($img))
			{
				$images[$img['ID']] = $img;
			}
			else
			{
				$images[$img] = $img;
			}
		}

		if($arResult["PROPERTIES"][$settings['propMorePhoto']]["VALUE"])
		{
			foreach($arResult["PROPERTIES"][$settings['propMorePhoto']]["VALUE"] as $img)
			{
				if(is_array($img))
				{
					$images[$img['ID']] = $img;
				}
				else
				{
					$images[$img] = $img;
				}
			}
		}
		$this->setPhotos($images);
		return $images;
	}

	/**
	 * @return number
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return multitype:
	 */
	public function getPhotos()
	{
		return $this->photos;
	}

	/**
	 * @param number $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param multitype: $photos
	 */
	public function setPhotos($photos)
	{
		$this->photos = $photos;
	}


}
?>