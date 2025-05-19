<?php

namespace App\Libraries;

use Config\Database;
use CodeIgniter\I18n\Time;

class DatabaseInitializer
{
    private static function create_users_table($db, $forge)
    {
        // Check if 'users' table exists
        if (!$db->tableExists('users')) {
            $fields = [
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'uuid' => [
                    'type'       => 'CHAR',
                    'constraint' => '36', // UUID length
                    'unique'     => true,
                ],
                'name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                ],
                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'unique'     => true,
                ],
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255', // bcrypt hashes will fit in this size
                ],
                'image' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255', // Path or URL to image
                    'null'       => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ];

            // Add fields and set primary key
            $forge->addField($fields);
            $forge->addKey('id', true);
            $forge->createTable('users', true);
        }
    }

    private static function insert_initial_data($db)
    {
        // Check if the 'users' table is empty
        $builder = $db->table('users');
        $count = $builder->countAllResults();

        if ($count === 0) {
            // Prepare data for the Administrator user
            $data = [
                'uuid' => generate_uuid(),
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => password_hash('admin123', PASSWORD_BCRYPT), // bcrypt hashed password
                'image' => 'default-user-image.webp',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];

            // Insert initial data
            $builder->insert($data);
        }
    }

    public static function initialize()
    {
        $db = Database::connect();
        $forge = \Config\Database::forge();

        // Create table if it doesn't exist
        self::create_users_table($db, $forge);

        // Insert initial data if the table is empty
        self::insert_initial_data($db);
    }
}
