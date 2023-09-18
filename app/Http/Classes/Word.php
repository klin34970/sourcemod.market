<?php

namespace App\Http\Classes;
use Purifier;

Class Word
{
	/**
     * Limit the $text to x work $limit
	 *
	 * @param string 	$text
	 * @param int		$limit
     * @return ORM
     */
	public static function limitWord($text, $limit)
	{
		$text = strip_tags($text);
		$words = str_word_count($text, 2);
		$pos = array_keys($words);
		if(count($words) > $limit )
		{
			$text = trim(substr($text, 0, $pos[$limit])).'...';
		};
		return $text;
	}
	
	public static function clean($str)
	{    
		$str = strip_tags($str);
		//$str = htmlentities($str);
		$str = str_replace("&nbsp;", " ", $str);
		$str = preg_replace('/\s+/', ' ',$str);
		$str = trim($str);
		return $str;
	}	
	
	public static function cleanDescription($str)
	{    
		$str = strip_tags(str_replace('<', ' <', $str));
		//$str = htmlentities($str);
		$str = str_replace("&nbsp;", " ", $str);
		//$str = preg_replace('/\s+/', ' ',$str);
		$str = str_replace("\"", " ", $str);
		$str = preg_replace('/[^A-Za-z0-9\-]/', ' ', $str);
		$str = trim($str);
		return $str;
	}
	
	public static function PrePurify($input)
	{
		$text = $input;
		//$text = htmlentities($text);
		// $text = str_replace('<pre', '<head', $text);
		// $text = str_replace('</pre>', '</head>', $text);
		// $text = Purifier::clean($text);
		// $text = str_replace('<pre', '<pre', $text);
		// $text = str_replace('</head>', '</pre>', $text);
		return $text;
	}
   
}