<?Php
class logger
{
	public $fp;
	public $logpath='/home/logs';
	function __construct($subdir)
	{
		$dir="{$this->logpath}/$subdir/".date('Y-m');
		if(!file_exists($dir))
			mkdir($dir,0777,true); //Create folder
		
		$this->fp=fopen($dir.'/'.date('Y-m-d').'.txt','a+'); //Open log file for appending
	}
	function writelog($loginfo)
	{
		if(is_string($loginfo))
			$loginfo=array($loginfo);
		$logline=array_merge(array(date('Y-m-d H:i')),$loginfo);
		return fwrite($this->fp,implode("\t",$logline)."\r\n");
	}
	function __destruct()
	{
		fclose($this->fp);	
	}
}