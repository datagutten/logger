<?Php

use Symfony\Component\Filesystem;

class logger
{
	public $fp;
	public $logpath;
	public $logfile;
	function __construct($subdir, $logpath='/home/logs')
	{
	    $filesystem = new Filesystem\Filesystem();
		$dir="$logpath/$subdir/".date('Y-m');
	    try {
            if (!file_exists($dir))
                $filesystem->mkdir($dir);
            $this->logpath = $logpath;
        }
        catch (Filesystem\Exception\IOException $e)
        {
            $dir="logs/$subdir/".date('Y-m');
            $filesystem->mkdir($dir);
            $this->logpath = realpath('logs');
            $dir = realpath($dir);
        }
        $this->logfile = $dir.'/'.date('Y-m-d').'.txt';
		$this->fp=fopen($this->logfile,'a+'); //Open log file for appending
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