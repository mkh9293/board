<?php
class Log{
    public function __construct()
    {
        $this->path = LOG_PATH;
    }

    private function log($type,$message){
        try{
            $filename = $this->path . "app.log";
            $handle = fopen($filename, "a+");
            fwrite($handle, $type . " : " . $message . PHP_EOL);
            fclose($handle);
        }catch(Exception $e){
            print 'no = '.$e->getMessage();
        }

    }

    public function info($message)
    {
        $this->log("info", $message);
    }
}
?>