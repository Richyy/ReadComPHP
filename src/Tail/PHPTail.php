<?php

namespace App\Tail;

class PHPTail
{
    /**
     * Location of the log file we're tailing
     * @var string
     */
    private $log = "";
    /**
     * This variable holds the maximum amount of bytes this application can load into memory (in bytes).
     * @var string
     */
    private $maxSizeToLoad;

    /**
     *
     * PHPTail constructor
     * @param string $log the location of the log file
     * @param integer $maxSizeToLoad This variable holds the maximum amount of bytes this application can load into memory (in bytes). Default is 2 Megabyte = 2097152 byte
     */
    public function __construct($log, $maxSizeToLoad = 2097152)
    {
        $this->log = $log;
        $this->maxSizeToLoad = $maxSizeToLoad;
        if (!file_exists($this->log) && is_writeable($this->log)) {
            file_put_contents($this->log, "");
        }
    }

    /**
     * This function is in charge of retrieving the latest lines from the log file
     * @param int $lastFetchedSize The size of the file when we lasted tailed it.
     * @param string $grepKeyword The grep keyword. This will only return rows that contain this word
     * @return array Returns the JSON representation of the latest file size and appended lines.
     */
    public function getNewLines(int $lastFetchedSize = 0, string $grepKeyword = "", bool $invert = false)
    {
        if (!file_exists($this->log) || !is_readable($this->log)) {
            return ["size" => -1, "file" => $this->log, "data" => []];
        }
        /**
         * Clear the stat cache to get the latest results
         */
        clearstatcache();
        /**
         * Define how much we should load from the log file
         * @var
         */
        $fsize = filesize($this->log);
        $maxLength = ($fsize - $lastFetchedSize);
        /**
         * Verify that we don't load more data then allowed.
         */
        if ($maxLength > $this->maxSizeToLoad) {
            $maxLength = ($this->maxSizeToLoad / 2);
        }
        /**
         * Actually load the data
         */
        $data = array();
        if ($maxLength > 0) {

            $fp = fopen($this->log, 'r');
            fseek($fp, -$maxLength, SEEK_END);
            $data = explode("\n", fread($fp, $maxLength));

        }
        if (!empty($grepKeyword)) {
            if ($invert) {
                $data = preg_grep("/$grepKeyword/", $data);
            } else {
                $data = preg_grep("/$grepKeyword/", $data, PREG_GREP_INVERT);
            }
        }
        /**
         * If the last entry in the array is an empty string lets remove it.
         */
        if (end($data) == "") {
            array_pop($data);
        }
        return ["size" => $fsize, "file" => $this->log, "data" => $data];
    }
}
