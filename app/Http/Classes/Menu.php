<?php

namespace App\Http\Classes;

use Request;

Class Menu
{
    /**
     * Get menu active with the segment paramater.
     *
     * @param array $array
     * @param string $set
	 * @param string $unset
     * @return string $set or $unset
     */
	public static function getActiveRoute($array = array(), $set = '', $unset = '', $limit = false)
	{
		if(is_array($array))
		{
			$count = count($array);
			$i = 0;
			foreach($array as $key => $value)
			{
				if(Request::segment($key+1))
				{
					//var_dump($value);
					
					$find = '/('.Request::segment($key+1).')/';
					if(preg_match($find, $value, $matches))
					{
						$i++;
					}
					else if($value == '*')
					{
						$i++;
					}
				}
				else
				{
					/* {!!App\Http\Classes\Menu::getActiveRoute(['root'], 'active')!!}*/
					/* For a root path url */
					if(Request::segment($key+1) == "" && $value == "root")
					{
						$i++;
					}
				}
			}
			
			if(count(Request::segments()) == $count || $limit == false)
			{
				if($i == $count)
				{
					return $set;
				}
				else
				{
					return $unset;
				}
			}
		}
	}
}