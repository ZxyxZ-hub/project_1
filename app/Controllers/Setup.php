<?php

namespace App\Controllers;

class Setup extends BaseController
{
    public function index()
    {
        // Enable this only in development mode
        if (ENVIRONMENT !== 'development') {
            return "Setup is disabled in production";
        }

        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();
        $messages = [];

        try {
            // Create users table if it doesn't exist
            if (!$db->tableExists('users')) {
                $forge->addField([
                    'id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'auto_increment' => true,
                    ],
                    'email' => [
                        'type' => 'VARCHAR',
                        'constraint' => 100,
                        'unique' => true,
                    ],
                    'password' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ],
                    'full_name' => [
                        'type' => 'VARCHAR',
                        'constraint' => 100,
                    ],
                    'role' => [
                        'type' => 'ENUM',
                        'constraint' => ['pending', 'user', 'admin'],
                        'default' => 'pending',
                    ],
                    'status' => [
                        'type' => 'ENUM',
                        'constraint' => ['pending', 'approved', 'rejected'],
                        'default' => 'pending',
                    ],
                    'created_at' => [
                        'type' => 'DATETIME',
                        'null' => true,
                    ],
                    'updated_at' => [
                        'type' => 'DATETIME',
                        'null' => true,
                    ],
                ]);

                $forge->addPrimaryKey('id');
                $forge->createTable('users');
                $messages[] = '✓ Users table created successfully';
            } else {
                $messages[] = '✓ Users table already exists';
            }

            // Create forms table if it doesn't exist
            if (!$db->tableExists('forms')) {
                $forge->addField([
                    'id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'auto_increment' => true,
                    ],
                    'from_name' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                        'null' => true,
                    ],
                    'date_received' => [
                        'type' => 'DATE',
                        'null' => true,
                    ],
                    'origin' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                        'null' => true,
                    ],
                    'reference_no' => [
                        'type' => 'VARCHAR',
                        'constraint' => 100,
                        'null' => true,
                    ],
                    'subject' => [
                        'type' => 'TEXT',
                        'null' => true,
                    ],
                    'instructions' => [
                        'type' => 'TEXT',
                        'null' => true,
                    ],
                    'created_at' => [
                        'type' => 'DATETIME',
                        'null' => true,
                    ],
                    'updated_at' => [
                        'type' => 'DATETIME',
                        'null' => true,
                    ],
                ]);

                $forge->addPrimaryKey('id');
                $forge->createTable('forms');
                $messages[] = '✓ Forms table created successfully';
            } else {
                $messages[] = '✓ Forms table already exists';
            }

            // Insert admin user if not exists
            $builder = $db->table('users');
            $admin = $builder->where('email', 'admin')->get()->getRow();

            if (!$admin) {
                $now = date('Y-m-d H:i:s');
                $builder->insert([
                    'email' => 'admin',
                    'password' => password_hash('admin123', PASSWORD_BCRYPT),
                    'full_name' => 'Administrator',
                    'role' => 'admin',
                    'status' => 'approved',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $messages[] = '✓ Admin user created';
                $messages[] = '<strong>Admin Credentials:</strong> Email: <code>admin</code> | Password: <code>admin123</code>';
            } else {
                $messages[] = '✓ Admin user already exists';
            }

            $data['messages'] = $messages;
            $data['success'] = true;

        } catch (\Exception $e) {
            $data['messages'] = ['✗ Error: ' . $e->getMessage()];
            $data['success'] = false;
        }

        return view('setup', $data);
    }
}
