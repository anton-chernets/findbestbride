<?php

// вычисл€ем возраст исход€ из даты рождени€
// $bdate = 1980-29-12
function getAgeFromDate($bDate)
{
	$bDate = strtotime($bDate);
	$age = date('Y') - date('Y', $bDate);
	// прошло ли уже ƒ–?
	if (date('md', $bDate) > date('md'))
	{
		$age--;
	}
	
	return $age;
}

function isOnlineUser($time)
{
	$timeNow = time();
	
	if ($time > $timeNow)
	{
		return true;
	}
	
	return false;
}


// присваиваем рост

function getUserHeight($data)
{
	$height = '0';
	
	switch ($data)
	{
		case 1: $height = "4'7''-4'9'' (140-145 cm)"; break;
		case 2: $height = "4'10''-4'11'' (146-150 cm)"; break;
		case 3: $height = "5'0''-5'1'' (151-155 cm)"; break;
		case 4: $height = "5'2''-5'3'' (156-160 cm)"; break;
		case 5: $height = "5'4''-5'5'' (161-165 cm)"; break;
		case 6: $height = "5'6''-5'7'' (166-170 cm)"; break;
		case 7: $height = "5'8''-5'9'' (171-175 cm)"; break;
		case 8: $height = "5'10'-5'11'' (176-180 cm)"; break;
		case 9: $height = "6'0''-6'1'' (181-185 cm)"; break;
		case 10: $height = "6'2''-6'3'' (186-190 cm)"; break;
		case 11: $height = "6'4'' (191 cm) or above"; break;
	}
	
	return $height;
}


// присваиваем вес

function getUserWeight($type)
{
	$startKg = '40';
	$startLb = '88';
	
	$addToKg = $type * 5;
	$addToLb = $type * 11;
	
	$kg = $startKg + $addToKg;
	$kg2 = $kg + 5;
	
	$lb = $startLb + $addToLb;
	$lb2 = $lb + 11;
	
	return $kg . 'kg-' . $kg2 . 'kg';
}

// выпадающий список годов рождени€ (надо ли он?)

function getSelectYear()
{
	//$end = date('Y') - 18;
	$years = array();
	
	for ($i = 1929; $i < 1996; $i++)
	{
		$years[$i] = $i;
	}
	
	return $years;
}

// выпадающий список дней (а зачем плодить хтмл?)

function getSelectDays()
{
	$days = array();
	
	for ($i = 1; $i < 32; $i++)
	{
		$days[$i] = $i;
	}
	
	return $days;
}


function getEmptyPhotos($count)
{
	if ($count == 0)
	{
		$return = '<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png" ></div>
					<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png"></div>
					<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png"></div>
					<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png"></div>
					<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png"></div>';
	}
	elseif ($count == 1)
	{
				$return = '<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png" ></div>
					<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png"></div>
					<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png"></div>
					<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png"></div>
				';
		
	}
	elseif ($count == 2)
	{
				$return = '<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png" ></div>
					<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png"></div>
					<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png"></div>
				';
		
	}
	elseif ($count == 3)
	{
				$return = '<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png" ></div>
					<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png"></div>
				';
		
	}
	elseif ($count == 4)
	{
				$return = '<div class="col-foto"><img src="'.base_url().'content/img/photo-profile.png" ></div>
				';
		
	}
	elseif ($count == 5)
	{
		$return = '';
	}
	
	return $return;
}


/*****************************************************/
function createMinMaxAge()
{
	$return = array();
	for ($i = 18; $i < 81; $i++)
	{
		$return[$i] = $i;
	}
	
	return $return;
}


function userCountry($selected = '')
{
	$c = array();
	$c['0'] = '';
	$c['1'] = 'Afghanistan';
	$c['2'] = 'Albania';
	$c['3'] = 'Algeria';
	$c['4'] = 'Am. Samoa';
	$c['5'] = 'Andorra';
	$c['6'] = 'Angola';
	$c['7'] = 'Anguilla';
	$c['8'] = 'Argentina';
	$c['9'] = 'Armenia';
	$c['10'] = 'Aruba';
	$c['11'] = 'Australia';
	$c['12'] = 'Austria';
	$c['13'] = 'Azerbaijan';
	$c['14'] = 'Bahamas';
	$c['15'] = 'Bahrain';
	$c['16'] = 'Bangladesh';
	$c['17'] = 'Barbados';
	$c['18'] = 'Belarus';
	$c['19'] = 'Belgium';
	$c['20'] = 'Belize';
	$c['21'] = 'Benin';
	$c['22'] = 'Bermuda';
	$c['23'] = 'Bhutan';
	$c['24'] = 'Bolivia';
	$c['25'] = 'Bosnia Herz.';
	$c['26'] = 'Botswana';
	$c['27'] = 'Bouvet Isl.';
	$c['28'] = 'Brazil';
	$c['29'] = 'Brunei';
	$c['30'] = 'Bulgaria';
	$c['31'] = 'Burkina Faso';
	$c['32'] = 'Burundi';
	$c['33'] = 'Cambodia';
	$c['34'] = 'Cameroon';
	$c['35'] = 'Canada';
	$c['36'] = 'Cape Verde';
	$c['37'] = 'Cayman Isl.';
	$c['38'] = 'Cen. Afr. Rep.';
	$c['39'] = 'Chad';
	$c['40'] = 'Chile';
	$c['41'] = 'China';
	$c['42'] = 'Christmas Isl.';
	$c['43'] = 'Colombia';
	$c['44'] = 'Comoros';
	$c['45'] = 'Congo';
	$c['46'] = 'Cook Islands';
	$c['47'] = 'Costa Rica';
	$c['48'] = 'Cote DIvoire';
	$c['49'] = 'Croatia';
	$c['51'] = 'Cyprus';
	$c['52'] = 'Czech Rep.';
	$c['53'] = 'Congo';
	$c['54'] = 'Denmark';
	$c['55'] = 'Djibouti';
	$c['56'] = 'Dominica';
	$c['57'] = 'Dominican Rep.';
	$c['58'] = 'East Timor';
	$c['59'] = 'Ecuador';
	$c['60'] = 'Egypt';
	$c['61'] = 'El Salvador';
	$c['62'] = 'England';
	$c['63'] = 'Equatorial G.';
	$c['64'] = 'Eritrea';
	$c['65'] = 'Estonia';
	$c['66'] = 'Ethiopia';
	$c['67'] = 'Falkland Isl.';
	$c['68'] = 'Faroe Isl.';
	$c['69'] = 'Fiji';
	$c['70'] = 'Finland';
	$c['71'] = 'France';
	$c['72'] = 'Fr. Guiana';
	$c['73'] = 'Fr. Polynesia';
	$c['74'] = 'Gabon';
	$c['75'] = 'Gambia';
	$c['76'] = 'Georgia';
	$c['77'] = 'Germany';
	$c['78'] = 'Ghana';
	$c['79'] = 'Gibraltar';
	$c['80'] = 'Greece';
	$c['81'] = 'Greenland';
	$c['82'] = 'Grenada';
	$c['83'] = 'Guadeloupe';
	$c['84'] = 'Guam';
	$c['85'] = 'Guatemala';
	$c['86'] = 'Guinea';
	$c['87'] = 'Guinea-Bissau';
	$c['88'] = 'Guyana';
	$c['89'] = 'Haiti';
	$c['90'] = 'Honduras';
	$c['91'] = 'Hong Kong';
	$c['92'] = 'Hungary';
	$c['93'] = 'Iceland';
	$c['94'] = 'India';
	$c['95'] = 'Indonesia';
	$c['97'] = 'Iraq';
	$c['98'] = 'Ireland';
	$c['99'] = 'Israel';
	$c['100'] = 'Italy';
	$c['101'] = 'Jamaica';
	$c['102'] = 'Japan';
	$c['103'] = 'Jordan';
	$c['104'] = 'Kazakhstan';
	$c['105'] = 'Kenya';
	$c['106'] = 'Kiribati';
	$c['109'] = 'Kuwait';
	$c['110'] = 'Kyrgyzstan';
	$c['111'] = 'Lao';
	$c['112'] = 'Latvia';
	$c['113'] = 'Lebanon';
	$c['114'] = 'Lesotho';
	$c['115'] = 'Liberia';
	$c['116'] = 'Libya';
	$c['117'] = 'Liechtenstein';
	$c['118'] = 'Lithuania';
	$c['119'] = 'Luxembourg';
	$c['120'] = 'Macao';
	$c['121'] = 'Macedonia';
	$c['122'] = 'Madagascar';
	$c['123'] = 'Malawi';
	$c['124'] = 'Malaysia';
	$c['125'] = 'Maldives';
	$c['126'] = 'Mali';
	$c['127'] = 'Malta';
	$c['128'] = 'Marshall Isl.';
	$c['129'] = 'Martinique';
	$c['130'] = 'Mauritania';
	$c['131'] = 'Mauritius';
	$c['132'] = 'Mayotte';
	$c['133'] = 'Mexico';
	$c['134'] = 'Micronesia';
	$c['135'] = 'Moldova';
	$c['136'] = 'Monaco';
	$c['137'] = 'Mongolia';
	$c['138'] = 'Montserrat';
	$c['139'] = 'Morocco';
	$c['140'] = 'Mozambique';
	$c['142'] = 'Namibia';
	$c['143'] = 'Nauru';
	$c['144'] = 'Nepal';
	$c['145'] = 'Netherlands';
	$c['146'] = 'New Caledonia';
	$c['147'] = 'New Zealand';
	$c['148'] = 'Nicaragua';
	$c['149'] = 'Niger';
	$c['150'] = 'Nigeria';
	$c['151'] = 'Niue';
	$c['152'] = 'Norfolk Isl.';
	$c['153'] = 'Norway';
	$c['154'] = 'Oman';
	$c['155'] = 'Other';
	$c['156'] = 'Pakistan';
	$c['157'] = 'Palau';
	$c['158'] = 'Panama';
	$c['159'] = 'Papua new G.';
	$c['160'] = 'Paraguay';
	$c['161'] = 'Peru';
	$c['162'] = 'Philippines';
	$c['163'] = 'Pitcairn Isl.';
	$c['164'] = 'Poland';
	$c['165'] = 'Portugal';
	$c['166'] = 'Puerto Rico';
	$c['167'] = 'Qatar';
	$c['168'] = 'Reunion';
	$c['169'] = 'Romania';
	$c['170'] = 'Russia';
	$c['171'] = 'Rwanda';
	$c['172'] = 'Saint Lucia';
	$c['173'] = 'Samoa';
	$c['174'] = 'San Marino';
	$c['175'] = 'Saudi Arabia';
	$c['176'] = 'Scotland';
	$c['177'] = 'Senegal';
	$c['178'] = 'Seychelles';
	$c['179'] = 'Sierra Leone';
	$c['180'] = 'Singapore';
	$c['181'] = 'Slovak Rep.';
	$c['182'] = 'Slovenia';
	$c['183'] = 'Solomon Isl.';
	$c['184'] = 'Somalia';
	$c['185'] = 'South Africa';
	$c['186'] = 'Spain';
	$c['187'] = 'Sri Lanka';
	$c['188'] = 'St Helena';
	$c['190'] = 'Suriname';
	$c['191'] = 'Swaziland';
	$c['192'] = 'Sweden';
	$c['193'] = 'Switzerland';
	$c['195'] = 'Taiwan';
	$c['196'] = 'Tajikistan';
	$c['197'] = 'Tanzania';
	$c['198'] = 'Thailand';
	$c['199'] = 'Togo';
	$c['200'] = 'Tokelau';
	$c['201'] = 'Tonga';
	$c['202'] = 'Trinidad & Tob.';
	$c['203'] = 'Tunisia';
	$c['204'] = 'Turkey';
	$c['205'] = 'Turkmenistan';
	$c['206'] = 'Tuvalu';
	$c['207'] = 'Uganda';
	$c['208'] = 'Ukraine';
	$c['209'] = 'UAE';
	$c['210'] = 'United States';
	$c['211'] = 'Uruguay';
	$c['212'] = 'Uzbekistan';
	$c['213'] = 'Vanuatu';
	$c['214'] = 'Venezuela';
	$c['215'] = 'Vietnam';
	$c['216'] = 'Virgin Islands (Br)';
	$c['217'] = 'Virgin Islands (US)';
	$c['218'] = 'Wales';
	$c['219'] = 'West Sahara';
	$c['220'] = 'Yemen';
	$c['221'] = 'Yugoslavia';
	$c['222'] = 'Zambia';
	$c['223'] = 'Zimbabwe';
	
	
	return (!empty($selected)) ? $c[$selected] : $c;
}

function gift_price($gift_id, $count = 0)
{
	$CI =& get_instance();
	$prices = $CI->mainModel->getGiftPrice($gift_id);
	
	switch($gift_id)
	{
		case 1:
			$prices = explode(',', $prices);
			if ($count == 3)
			{
				$price = $prices[0];
			}
			elseif ($count == 5)
			{
				$price = $prices[1];
			}
			elseif ($count == 7)
			{
				$price = $prices[2];
			}
			elseif ($count == 11)
			{
				$price = $prices[3];
			}
			elseif ($count == 15)
			{
				$price = $prices[4];
			}
			elseif ($count == 23)
			{
				$price = $prices[5];
			}
			break;
		case 2:
			$prices = explode(',', $prices);
			if ($count == 3)
			{
				$price = $prices[0];
			}
			elseif ($count == 5)
			{
				$price = $prices[1];
			}
			elseif ($count == 7)
			{
				$price = $prices[2];
			}
			elseif ($count == 11)
			{
				$price = $prices[3];
			}
			elseif ($count == 15)
			{
				$price = $prices[4];
			}
			elseif ($count == 23)
			{
				$price = $prices[5];
			}
			break;
		case 3:
			$prices = explode(',', $prices);
			if ($count == 3)
			{
				$price = $prices[0];
			}
			elseif ($count == 5)
			{
				$price = $prices[1];
			}
			elseif ($count == 7)
			{
				$price = $prices[2];
			}
			elseif ($count == 11)
			{
				$price = $prices[3];
			}
			elseif ($count == 15)
			{
				$price = $prices[4];
			}
			elseif ($count == 23)
			{
				$price = $prices[5];
			}
			break;
		case 4:
		case 7:
		case 8:
		case 9:
		case 10:
		case 11:
		case 12:
		case 13:
		case 14:
		case 16:
		case 17:
		case 18:
		case 19:
		case 20:
		case 21:
		case 23:
		case 24:
			$price = $prices; 
			break;
		case 5:
			$prices = explode(',', $prices);
			if ($count == 3)
			{
				$price = $prices[0];
			}
			elseif ($count == 5)
			{
				$price = $prices[1];
			}
			elseif ($count == 7)
			{
				$price = $prices[2];
			}
			elseif ($count == 11)
			{
				$price = $prices[3];
			}
			elseif ($count == 15)
			{
				$price = $prices[4];
			}
			elseif ($count == 23)
			{
				$price = $prices[5];
			}
			break;
		case 6:
			$prices = explode(',', $prices);
			if ($count == 3)
			{
				$price = $prices[0];
			}
			elseif ($count == 5)
			{
				$price = $prices[1];
			}
			elseif ($count == 7)
			{
				$price = $prices[2];
			}
			elseif ($count == 11)
			{
				$price = $prices[3];
			}
			elseif ($count == 15)
			{
				$price = $prices[4];
			}
			elseif ($count == 23)
			{
				$price = $prices[5];
			}
			break;
		case 15:
			$prices = explode(',', $prices);
			if ($count == 50)
			{
				$price = $prices[0];
			}
			elseif ($count == 100)
			{
				$price = $prices[1];
			}
			break;
		case 22:
			$prices = explode(',', $prices);
			if ($count == 1)
			{
				$price = $prices[0];
			}
			elseif ($count == 2)
			{
				$price = $prices[1];
			}
			elseif ($count == 3)
			{
				$price = $prices[2];
			}
			elseif ($count == 4)
			{
				$price = $prices[3];
			}
			break;
	}
	
	return $price;
}

function returnSupport($id)
{
	switch($id)
	{
		case 1:
			$return = 'Registration'; break;
		case 2:
			$return = 'Profile and Subscribtion'; break;
		case 3:
			$return = 'Policies and Rules'; break;
		case 4:
			$return = 'Payments and Billing'; break;
		case 5:
			$return = 'Services and Features'; break;
		case 6:
			$return = 'Online Chat'; break;
		case 7:
			$return = 'Real Meetings and Tours'; break;
		case 8:
			$return = 'Technical Issues'; break;
		case 9:
			$return = 'Report Fraud'; break;
		case 10:
			$return = 'Dating Advice'; break;
		case 11:
			$return = 'Suggestions'; break;
		case 12:
			$return = 'Other'; break;
	}
	
	return $return;
}