<?php
include "db.php";
class database
{
    public $dbhost = dbhost;
    public $dbuser = dbuser;
    public $dbpass = dbpass;
    public $dbname = dbname;

    public $error = "Connection Problem";
    public $link;

    public function __construct()
    {
        $this->connection();
    }

    private function connection()
    {
        $this->link = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
        if (mysqli_error($this->link)) {
            echo $this->error;
        }
    }
    //insert data
    public function insert($data)
    {
        $insert_row = $this->link->query($data) or die($this->link->error . __LINE__);
        if ($insert_row) {
            return $insert_row;
        }

        else
        {
            return false;
        }
    }

    // show data

    public function show($data)
    {
        $result = $this->link->query($data) or die($this->link->error . __LINE__);
      
       if(mysqli_num_rows($result) >0 )
       {
            return $result;
       }

        else
        {
            return false;
        }
    }
    public function delete($data)
    {
        $result = $this->link->query($data) or die($this->link->error . __LINE__);
      
       if($result)
       {
            return $result;
       }

        else
        {
            return false;
        }
    }

}

?>
