<?php

namespace App\Http\Classes;

use Request;

Class Theme
{
    /**
     * Get theme y day.
     *
     * @return string
     */
	public static function getThemeByDay()
	{
		$day = date('d');
		switch($day)
		{
			case '01':
				return 'ajax.theme.css';
				break;
			case '02':
				return 'alizarin-crimson.theme.css';
				break;
			case '03':
				return 'amazon.theme.css';
				break;
			case '04':
				return 'amber.theme.css';
				break;
			case '05':
				return 'android-green.theme.css';
				break;
			case '06':
				return 'angularjs-theme.css';
				break;
			case '07':
				return 'antique-brass.theme.css';
				break;
			case '08':
				return 'antique-bronze.theme.css';
				break;
			case '09':
				return 'artichoke.theme.css';
				break;
			case '10':
				return 'atomic-tangerine.theme.css';
				break;
			case '11':
				return 'bazaar.theme.css';
				break;
			case '12':
				return 'bistre-brown.theme.css';
				break;
			case '13':
				return 'bittersweet.theme.css';
				break;
			case '14':
				return 'black-and-white.theme.css';
				break;
			case '15':
				return 'blue.theme.css';
				break;
			case '16':
				return 'blueberry.theme.css';
				break;
			case '17':
				return 'blue-gray.theme.css';
				break;
			case '18':
				return 'blue-sea.theme.css';
				break;
			case '19':
				return 'brown.theme.css';
				break;
			case '20':
				return 'bud-green.theme.css';
				break;
			case '21':
				return 'codeigniter.theme.css';
				break;
			case '22':
				return 'cyan.theme.css';
				break;
			case '23':
				return 'green.theme.css';
				break;
			case '24':
				return 'green-army.theme.css';
				break;
			case '25':
				return 'laravel.theme.css';
				break;
			case '26':
				return 'material-design.theme.css';
				break;
			case '27':
				return 'php.theme.css';
				break;
			case '28':
				return 'purple.theme.css';
				break;
			case '29':
				return 'purple-wine.theme.css';
				break;
			case '30':
				return 'red.theme.css';
				break;
			case '31':
				return 'yellow.theme.css';
				break;
		}
	}
}