<?php
/**
 * MySql DB layer
 * User: Alf Magne Kalleland
 * Date: 03.11.12
 * Time: 01:37
 */
class LudoDB
{
    protected $debug = false;
    protected static $_useMysqlI;
    protected static $instance;
    protected static $loggingEnabled = false;
    protected static $startTime;
    protected static $queryCounter = 0;
    private static $connectionType = 'PDO'; // PDO|MySqlI
    protected static $conn;

    public function __construct()
    {
        if (self::$loggingEnabled) {
            self::$startTime = self::getTime();
        }
    }

    /**
     * Set connection type,  PDO|MySqlI|MySql
     * @param $type
     */
    public static function setConnectionType($type = 'PDO')
    {
        self::$connectionType = $type;
        self::$PDO = null;
        self::$conn = null;
        self::getInstance()->connect();
    }

    public static function mySqlI(){
        self::setConnectionType('MySqlI');
    }

    public static function hasPDO(){
        return self::$connectionType === 'PDO';
    }

    public static function enableLogging()
    {
        self::$loggingEnabled = true;
        if (!isset(self::$startTime)) self::$startTime = self::getTime();
    }

    public static function isLoggingEnabled()
    {
        return self::$loggingEnabled;
    }

    public static function getElapsed()
    {
        return self::getTime() - self::$startTime;
    }

    public static function getQueryCount()
    {
        return self::$queryCounter;
    }

    private static function getTime()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    public static function getInstance($useMysqlI = true)
    {
        if (!isset(self::$instance)) {
            self::$instance = new LudoDBPDO($useMysqlI);
            self::$instance->connect();
        }
        return self::$instance;
    }

    public static function setHost($host)
    {
        LudoDBRegistry::set('DB_HOST', $host);
    }

    public static function setUser($user)
    {
        LudoDBRegistry::set('DB_USER', $user);
    }

    public static function setPassword($pwd)
    {
        LudoDBRegistry::set('DB_PWD', $pwd);
    }

    public static function setDb($dbName)
    {
        LudoDBRegistry::set('DB_NAME', $dbName);
    }

    public function tableExists($tableName)
    {
        return $this->countRows("show tables like ?", array($tableName)) > 0;
    }

    public function log($sql)
    {
        $fh = fopen("sql.txt", "a+");
        fwrite($fh, $sql . "\n");
        fclose($fh);
    }
}