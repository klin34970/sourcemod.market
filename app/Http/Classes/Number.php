<?php

namespace App\Http\Classes;

Class Number
{
	/**
     * Change number format
	 *
	 * @param int		$input
     * @return string
     */
	public static function changeFormat($input)
	{
		if($input != "")
		{
			$suffixes = array('', 'K', 'M', 'B', 'T');
			$suffixIndex = 0;

			while(abs($input) >= 1000 && $suffixIndex < sizeof($suffixes))
			{
				$suffixIndex++;
				$input /= 1000;

				if(is_float($input))
				{
					$inputdata = number_format($input, 2);
					$inputarray = explode(".",$inputdata,2);
					if($inputarray[1] != "" && substr($inputarray[1], 0 , 1) != 0)
					{
						$input = $inputarray[0].".".substr($inputarray[1], 0 , 1);
					}
					else
					{
						$input = $inputarray[0];
					}
				}
			}

			return ($input) . $suffixes[$suffixIndex];
		}
	}
}