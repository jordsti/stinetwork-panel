<?php

class Notification
{
	public static $Success = 0;
	public static $Warning = 1;
	public static $Error = 2;
	public static $Information = 3;

	public $type;
	public $message;
	
	public function __construct()
	{
		
	}
	
	public function getHTML()
	{
		$class = 'alert';
		$type = 'Warning!';
		
		if($this->type == Notification::$Success)
		{
			$class = 'alert alert-success';
			$type = 'Success!';
		}
		else if($this->type == Notification::$Error)
		{
			$class = 'alert alert-error';
			$type = 'Error!';
		}
		else if($this->type == Notification::$Information)
		{
			$class = 'alert alert-info';
			$type = 'Read this!';
		}
	
		$html = '<div class="'.$class.'">'.
				'<button type="button" class="close" data-dismiss="alert">&times;</button>'.
				'<strong>'.$type.'</strong> '.$this->message.
				'</div>';
				
		return $html;
	}
}