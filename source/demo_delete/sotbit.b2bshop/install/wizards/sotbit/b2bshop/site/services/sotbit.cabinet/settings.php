<?

if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true )
	die();

if( !CModule::IncludeModule( "sotbit.cabinet" ) )
	return;

$moduleId = 'sotbit.b2bshop';
	
$holder1 = array(
		'GADGETS' => array(
				'PROFILE@' . rand() => array(
						'COLUMN' => 0,
						'ROW' => 0,
						'HIDE' => 'N' 
				),
				'HTML_AREA@' . rand() => array(
						'COLUMN' => 0,
						'ROW' => 1,
						'HIDE' => 'N' 
				),
				'DELAYBASKET@' . rand() => array(
						'COLUMN' => 0,
						'ROW' => 2,
						'HIDE' => 'N' 
				),
				'BASKET@' . rand() => array(
						'COLUMN' => 0,
						'ROW' => 3,
						'HIDE' => 'N' 
				),
				'ACCOUNTPAY@' . rand() => array(
						'COLUMN' => 1,
						'ROW' => 0,
						'HIDE' => 'N' 
				),
				'FAVORITES@' . rand() => array(
						'COLUMN' => 1,
						'ROW' => 1,
						'HIDE' => 'N' 
				),
				'SUBSCRIBE@' . rand() => array(
						'COLUMN' => 1,
						'ROW' => 2,
						'HIDE' => 'N' 
				),
				'ORDERS@' . rand() => array(
						'COLUMN' => 2,
						'ROW' => 0,
						'HIDE' => 'N' 
				),
				'REVIEWS@' . rand() => array(
						'COLUMN' => 2,
						'ROW' => 1,
						'HIDE' => 'N' 
				),
				'WEATHER@' . rand() => array(
						'COLUMN' => 2,
						'ROW' => 2,
						'HIDE' => 'N' 
				) 
		) 
);

$holder2 = array(
		'GADGETS' => array(
				'PROFILE@' . rand() => array(
						'COLUMN' => 0,
						'ROW' => 0,
						'HIDE' => 'N' 
				),
				'BASKET@' . rand() => array(
						'COLUMN' => 0,
						'ROW' => 1,
						'HIDE' => 'N' 
				),
				'DELAYBASKET@' . rand() => array(
						'COLUMN' => 0,
						'ROW' => 2,
						'HIDE' => 'N' 
				),
				'HTML_AREA@' . rand() => array(
						'COLUMN' => 0,
						'ROW' => 3,
						'HIDE' => 'N' 
				),
				'FAVORITES@' . rand() => array(
						'COLUMN' => 0,
						'ROW' => 4,
						'HIDE' => 'N' 
				),
				'BUYORDER@' . rand() => array(
						'COLUMN' => 1,
						'ROW' => 0,
						'HIDE' => 'N' 
				),
				'BLANK@' . rand() => array(
						'COLUMN' => 1,
						'ROW' => 1,
						'HIDE' => 'N' 
				),
				'BUYERS@' . rand() => array(
						'COLUMN' => 1,
						'ROW' => 2,
						'HIDE' => 'N' 
				),
				'SUBSCRIBE@' . rand() => array(
						'COLUMN' => 1,
						'ROW' => 3,
						'HIDE' => 'N' 
				),
				'ORDERS@' . rand() => array(
						'COLUMN' => 2,
						'ROW' => 0,
						'HIDE' => 'N' 
				),
				'REVIEWS@' . rand() => array(
						'COLUMN' => 2,
						'ROW' => 1,
						'HIDE' => 'N' 
				),
				'WEATHER@' . rand() => array(
						'COLUMN' => 2,
						'ROW' => 2,
						'HIDE' => 'N' 
				) 
		) 
);

CUserOptions::SetOption( "intranet", "~gadgets_holder1", $holder1, true, 0 );
if( MODULE_NAME == 'sotbit.b2bshop' )
{
	CUserOptions::SetOption( "intranet", "~gadgets_holder2", $holder2, true, 0 );
}

$result = \Bitrix\Main\UserTable::getList( array(
		'select' => array(
				'ID' 
		),
		'filter' => array() 
) );
while ( $User = $result->fetch() )
{
	$holder1 = array(
			'GADGETS' => array(
					'PROFILE@' . rand() => array(
							'COLUMN' => 0,
							'ROW' => 0,
							'HIDE' => 'N' 
					),
					'HTML_AREA@' . rand() => array(
							'COLUMN' => 0,
							'ROW' => 1,
							'HIDE' => 'N' 
					),
					'DELAYBASKET@' . rand() => array(
							'COLUMN' => 0,
							'ROW' => 2,
							'HIDE' => 'N' 
					),
					'BASKET@' . rand() => array(
							'COLUMN' => 0,
							'ROW' => 3,
							'HIDE' => 'N' 
					),
					'ACCOUNTPAY@' . rand() => array(
							'COLUMN' => 1,
							'ROW' => 0,
							'HIDE' => 'N' 
					),
					'FAVORITES@' . rand() => array(
							'COLUMN' => 1,
							'ROW' => 1,
							'HIDE' => 'N' 
					),
					'SUBSCRIBE@' . rand() => array(
							'COLUMN' => 1,
							'ROW' => 2,
							'HIDE' => 'N' 
					),
					'ORDERS@' . rand() => array(
							'COLUMN' => 2,
							'ROW' => 0,
							'HIDE' => 'N' 
					),
					'REVIEWS@' . rand() => array(
							'COLUMN' => 2,
							'ROW' => 1,
							'HIDE' => 'N' 
					),
					'WEATHER@' . rand() => array(
							'COLUMN' => 2,
							'ROW' => 2,
							'HIDE' => 'N' 
					) 
			) 
	);
	
	$holder2 = array(
			'GADGETS' => array(
					'PROFILE@' . rand() => array(
							'COLUMN' => 0,
							'ROW' => 0,
							'HIDE' => 'N' 
					),
					'BASKET@' . rand() => array(
							'COLUMN' => 0,
							'ROW' => 1,
							'HIDE' => 'N' 
					),
					'DELAYBASKET@' . rand() => array(
							'COLUMN' => 0,
							'ROW' => 2,
							'HIDE' => 'N' 
					),
					'HTML_AREA@' . rand() => array(
							'COLUMN' => 0,
							'ROW' => 3,
							'HIDE' => 'N' 
					),
					'FAVORITES@' . rand() => array(
							'COLUMN' => 0,
							'ROW' => 4,
							'HIDE' => 'N' 
					),
					'BUYORDER@' . rand() => array(
							'COLUMN' => 1,
							'ROW' => 0,
							'HIDE' => 'N' 
					),
					'BLANK@' . rand() => array(
							'COLUMN' => 1,
							'ROW' => 1,
							'HIDE' => 'N' 
					),
					'BUYERS@' . rand() => array(
							'COLUMN' => 1,
							'ROW' => 2,
							'HIDE' => 'N' 
					),
					'SUBSCRIBE@' . rand() => array(
							'COLUMN' => 1,
							'ROW' => 3,
							'HIDE' => 'N' 
					),
					'ORDERS@' . rand() => array(
							'COLUMN' => 2,
							'ROW' => 0,
							'HIDE' => 'N' 
					),
					'REVIEWS@' . rand() => array(
							'COLUMN' => 2,
							'ROW' => 1,
							'HIDE' => 'N' 
					),
					'WEATHER@' . rand() => array(
							'COLUMN' => 2,
							'ROW' => 2,
							'HIDE' => 'N' 
					) 
			) 
	);
	CUserOptions::SetOption( "intranet", "~gadgets_holder1", $holder1, 0, $User['ID'] );
	if( $moduleId == 'sotbit.b2bshop' )
	{
		CUserOptions::SetOption( "intranet", "~gadgets_holder2", $holder2, 0, $User['ID'] );
	}
}