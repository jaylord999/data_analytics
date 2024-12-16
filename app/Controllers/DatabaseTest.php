<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class DatabaseTest extends Controller
{
    public function index()
    {
        $db = Database::connect();
        if ($db->connID) {
            echo "Successfully connected to the database!";
        } else {
            echo "Connection failed!";
        }
    }
}