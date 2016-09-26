<?php

{

	class PortalConnection
	{

	    protected static $connection;

	    public function getConnection()
	    {     
	        if (!self::$connection)
	        {
	            self::$connection = new PDO('mysql:host=localhost;dbname=globalv_portal_data', 'root');
	            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	        }
	        return self::$connection;
	    }
	}
}