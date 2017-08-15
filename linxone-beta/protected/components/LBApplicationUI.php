<?php
class LBApplicationUI
{
    public static function getStatusBadge($status_code)
    {
        $badge_css = '';
        if($status_code==  LbInvoice::LB_INVOICE_STATUS_CODE_DRAFT)
            $badge_css =  '';
        if($status_code==LbInvoice::LB_INVOICE_STATUS_CODE_OPEN)
            $badge_css =  'badge-success';
        if($status_code==LbInvoice::LB_INVOICE_STATUS_CODE_OVERDUE)
            $badge_css =  'badge-warning';
        if($status_code==LbInvoice::LB_INVOICE_STATUS_CODE_WRITTEN_OFF)
            $badge_css =  'badge-warning';
        if($status_code==LbInvoice::LB_INVOICE_STATUS_CODE_PAID)
            $badge_css = 'badge-success';
        
        $status_name = LbInvoice::model()->getDisplayInvoiceStatus($status_code);
        
        return '<div class="badge '.$badge_css.'">'.$status_name.'</div>';
    }
    
	public static function getAppUIController()
	{
		return new Controller('LBApplicationUI');
	}	
	
	public static function newButton($label, $config = null)
	{
		if ($config == null)
			$config = array();
		
		$config['label'] = '<i class="icon-plus"></i>&nbsp;' . $label;
		$config['encodeLabel']=false;
		
		// default button type is link
		if (!isset($config['buttonType'])
				|| $config['buttonType'] == null)
			$config['buttonType']='link';
		
		self::getAppUIController()->widget('bootstrap.widgets.TbButton', $config);
	}
	
	public static function newButtonGroup($label, $config)
	{	
		$config['buttons'][0]['label'] = '<i class="icon-plus"></i>&nbsp;' . $label;
		$config['encodeLabel']=false;
		
		// default button type is link
		if (!isset($config['buttonType'])
				|| $config['buttonType'] == null)
			$config['buttonType']='link';
		
		// print
		self::getAppUIController()->widget('bootstrap.widgets.TbButtonGroup', $config);
	}

    public static function ajaxButton($label, $url, $ajaxOptions = array(), $htmlOptions = array())
    {
        $htmlOptions['live'] = false;

        self::button($label, array(
            'url'=> $url,
            'buttonType'=>'ajaxSubmit',
            'ajaxOptions'=>$ajaxOptions,
            'htmlOptions'=>$htmlOptions,
        ));
    }
	
	/**
	 * Print go back button
	 * 
	 * @param mixed $url
	 * @param boolean $workspaceLink ajax or not
	 * @param array $config
	 */
	public static function backButton($url, $workspaceLink = true, $config = array())
	{
		$config['label'] = '<i class="icon-arrow-left"></i>&nbsp;Back';
		$config['encodeLabel']=false;
		
		// default button type is link
		$config['buttonType']='link';
		$config['url'] = $url;
		
		// is it an ajax link?
		if ($workspaceLink)
		{
			if (!isset($config['htmlOptions']) ||
					$config['htmlOptions'] == null)
				$config['htmlOptions'] = array();
			
			$config['htmlOptions']['data-workspace'] = 1;
		}
		
		// print
		self::getAppUIController()->widget('bootstrap.widgets.TbButton', $config);
	}
	
	public static function submitButton($label, $config = null)
	{
		if ($config == null)
			$config = array();
		
		$config['label'] = '<i class="icon-ok icon-white"></i>&nbsp;' . $label;
		$config['encodeLabel']=false;
		$config['type'] = 'success';
	
		// default button type is link
		if (!isset($config['buttonType']) ||
				$config['buttonType'] == null)
			$config['buttonType']='submit';
		
		self::getAppUIController()->widget('bootstrap.widgets.TbButton', $config);
	}

    public static function button($label, $config =  array())
    {
        $config['label'] = $label;
        $config['encodeLabel']=false;

        self::getAppUIController()->widget('bootstrap.widgets.TbButton', $config);
    }
	
	public static function countriesDropdownData()
	{
		return array(
			'0'=>'Select',
			'Others'=>'Others',	
			'AD' => 'Andorra',
			'AE' => 'United Arab Emirates',
			'AF' => 'Afghanistan',
			'AG' => 'Antigua &amp; Barbuda',
			'AI' => 'Anguilla',
			'AL' => 'Albania',
			'AM' => 'Armenia',
			'AN' => 'Netherlands Antilles',
			'AO' => 'Angola',
			'AQ' => 'Antarctica',
			'AR' => 'Argentina',
			'AS' => 'American Samoa',
			'AT' => 'Austria',
			'AU' => 'Australia',
			'AW' => 'Aruba',
			'AZ' => 'Azerbaijan',
			'BA' => 'Bosnia and Herzegovina',
			'BB' => 'Barbados',
			'BD' => 'Bangladesh',
			'BE' => 'Belgium',
			'BF' => 'Burkina Faso',
			'BG' => 'Bulgaria',
			'BH' => 'Bahrain',
			'BI' => 'Burundi',
			'BJ' => 'Benin',
			'BM' => 'Bermuda',
			'BN' => 'Brunei Darussalam',
			'BO' => 'Bolivia',
			'BR' => 'Brazil',
			'BS' => 'Bahama',
			'BT' => 'Bhutan',
			'BU' => 'Burma (no longer exists)',
			'BV' => 'Bouvet Island',
			'BW' => 'Botswana',
			'BY' => 'Belarus',
			'BZ' => 'Belize',
			'CA' => 'Canada',
			'CC' => 'Cocos (Keeling) Islands',
			'CF' => 'Central African Republic',
			'CG' => 'Congo',
			'CH' => 'Switzerland',
			'CI' => 'Côte D\'ivoire (Ivory Coast)',
			'CK' => 'Cook Iislands',
			'CL' => 'Chile',
			'CM' => 'Cameroon',
			'CN' => 'China',
			'CO' => 'Colombia',
			'CR' => 'Costa Rica',
			'CU' => 'Cuba',
			'CV' => 'Cape Verde',
			'CX' => 'Christmas Island',
			'CY' => 'Cyprus',
			'CZ' => 'Czech Republic',
			'DE' => 'Germany',
			'DJ' => 'Djibouti',
			'DK' => 'Denmark',
			'DM' => 'Dominica',
			'DO' => 'Dominican Republic',
			'DZ' => 'Algeria',
			'EC' => 'Ecuador',
			'EE' => 'Estonia',
			'EG' => 'Egypt',
			'EH' => 'Western Sahara',
			'ER' => 'Eritrea',
			'ES' => 'Spain',
			'ET' => 'Ethiopia',
			'FI' => 'Finland',
			'FJ' => 'Fiji',
			'FK' => 'Falkland Islands (Malvinas)',
			'FM' => 'Micronesia',
			'FO' => 'Faroe Islands',
			'FR' => 'France',
			'FX' => 'France, Metropolitan',
			'GA' => 'Gabon',
			'GB' => 'United Kingdom (Great Britain)',
			'GD' => 'Grenada',
			'GE' => 'Georgia',
			'GF' => 'French Guiana',
			'GH' => 'Ghana',
			'GI' => 'Gibraltar',
			'GL' => 'Greenland',
			'GM' => 'Gambia',
			'GN' => 'Guinea',
			'GP' => 'Guadeloupe',
			'GQ' => 'Equatorial Guinea',
			'GR' => 'Greece',
			'GS' => 'South Georgia and the South Sandwich Islands',
			'GT' => 'Guatemala',
			'GU' => 'Guam',
			'GW' => 'Guinea-Bissau',
			'GY' => 'Guyana',
			'HK' => 'Hong Kong',
			'HM' => 'Heard &amp; McDonald Islands',
			'HN' => 'Honduras',
			'HR' => 'Croatia',
			'HT' => 'Haiti',
			'HU' => 'Hungary',
			'ID' => 'Indonesia',
			'IE' => 'Ireland',
			'IL' => 'Israel',
			'IN' => 'India',
			'IO' => 'British Indian Ocean Territory',
			'IQ' => 'Iraq',
			'IR' => 'Islamic Republic of Iran',
			'IS' => 'Iceland',
			'IT' => 'Italy',
			'JM' => 'Jamaica',
			'JO' => 'Jordan',
			'JP' => 'Japan',
			'KE' => 'Kenya',
			'KG' => 'Kyrgyzstan',
			'KH' => 'Cambodia',
			'KI' => 'Kiribati',
			'KM' => 'Comoros',
			'KN' => 'St. Kitts and Nevis',
			'KP' => 'Korea, Democratic People\'s Republic of',
			'KR' => 'Korea, Republic of',
			'KW' => 'Kuwait',
			'KY' => 'Cayman Islands',
			'KZ' => 'Kazakhstan',
			'LA' => 'Lao People\'s Democratic Republic',
			'LB' => 'Lebanon',
			'LC' => 'Saint Lucia',
			'LI' => 'Liechtenstein',
			'LK' => 'Sri Lanka',
			'LR' => 'Liberia',
			'LS' => 'Lesotho',
			'LT' => 'Lithuania',
			'LU' => 'Luxembourg',
			'LV' => 'Latvia',
			'LY' => 'Libyan Arab Jamahiriya',
			'MA' => 'Morocco',
			'MC' => 'Monaco',
			'MD' => 'Moldova, Republic of',
			'MG' => 'Madagascar',
			'MH' => 'Marshall Islands',
			'ML' => 'Mali',
			'MN' => 'Mongolia',
			'MM' => 'Myanmar',
			'MO' => 'Macau',
			'MP' => 'Northern Mariana Islands',
			'MQ' => 'Martinique',
			'MR' => 'Mauritania',
			'MS' => 'Monserrat',
			'MT' => 'Malta',
			'MU' => 'Mauritius',
			'MV' => 'Maldives',
			'MW' => 'Malawi',
			'MX' => 'Mexico',
			'MY' => 'Malaysia',
			'MZ' => 'Mozambique',
			'NA' => 'Namibia',
			'NC' => 'New Caledonia',
			'NE' => 'Niger',
			'NF' => 'Norfolk Island',
			'NG' => 'Nigeria',
			'NI' => 'Nicaragua',
			'NL' => 'Netherlands',
			'NO' => 'Norway',
			'NP' => 'Nepal',
			'NR' => 'Nauru',
			'NU' => 'Niue',
			'NZ' => 'New Zealand',
			'OM' => 'Oman',
			'PA' => 'Panama',
			'PE' => 'Peru',
			'PF' => 'French Polynesia',
			'PG' => 'Papua New Guinea',
			'PH' => 'Philippines',
			'PK' => 'Pakistan',
			'PL' => 'Poland',
			'PM' => 'St. Pierre &amp; Miquelon',
			'PN' => 'Pitcairn',
			'PR' => 'Puerto Rico',
			'PT' => 'Portugal',
			'PW' => 'Palau',
			'PY' => 'Paraguay',
			'QA' => 'Qatar',
			'RE' => 'Réunion',
			'RO' => 'Romania',
			'RU' => 'Russian Federation',
			'RW' => 'Rwanda',
			'SA' => 'Saudi Arabia',
			'SB' => 'Solomon Islands',
			'SC' => 'Seychelles',
			'SD' => 'Sudan',
			'SE' => 'Sweden',
			'SG' => 'Singapore',
			'SH' => 'St. Helena',
			'SI' => 'Slovenia',
			'SJ' => 'Svalbard &amp; Jan Mayen Islands',
			'SK' => 'Slovakia',
			'SL' => 'Sierra Leone',
			'SM' => 'San Marino',
			'SN' => 'Senegal',
			'SO' => 'Somalia',
			'SR' => 'Suriname',
			'ST' => 'Sao Tome &amp; Principe',
			'SV' => 'El Salvador',
			'SY' => 'Syrian Arab Republic',
			'SZ' => 'Swaziland',
			'TC' => 'Turks &amp; Caicos Islands',
			'TD' => 'Chad',
			'TF' => 'French Southern Territories',
			'TG' => 'Togo',
			'TH' => 'Thailand',
			'TJ' => 'Tajikistan',
			'TK' => 'Tokelau',
			'TM' => 'Turkmenistan',
			'TN' => 'Tunisia',
			'TO' => 'Tonga',
			'TP' => 'East Timor',
			'TR' => 'Turkey',
			'TT' => 'Trinidad &amp; Tobago',
			'TV' => 'Tuvalu',
			'TW' => 'Taiwan, Province of China',
			'TZ' => 'Tanzania, United Republic of',
			'UA' => 'Ukraine',
			'UG' => 'Uganda',
			'UM' => 'United States Minor Outlying Islands',
			'US' => 'United States of America',
			'UY' => 'Uruguay',
			'UZ' => 'Uzbekistan',
			'VA' => 'Vatican City State (Holy See)',
			'VC' => 'St. Vincent &amp; the Grenadines',
			'VE' => 'Venezuela',
			'VG' => 'British Virgin Islands',
			'VI' => 'United States Virgin Islands',
			'VN' => 'Viet Nam',
			'VU' => 'Vanuatu',
			'WF' => 'Wallis &amp; Futuna Islands',
			'WS' => 'Samoa',
			'YE' => 'Yemen',
			'YT' => 'Mayotte',
			'YU' => 'Yugoslavia',
			'ZA' => 'South Africa',
			'ZM' => 'Zambia',
			'ZR' => 'Zaire',
			'ZW' => 'Zimbabwe');
	}
}