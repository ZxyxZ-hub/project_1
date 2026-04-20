<?php

namespace App\Controllers;

class Setup extends Controller
{
    public function index()
    {
        // Enable this only in development mode
        if (ENVIRONMENT !== 'development') {
            return "Setup is disabled in production";
        }

        $db = \Config\Database::connect();
        $forge = $db->forge();
        $output = "<h2>Setup Output</h2>";

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
            $output .= "<p>✓ Users table created successfully</p>";
        } else {
            $output .= "<p>✓ Users table already exists</p>";
        }

        // Insert admin user if not exists
        $builder = $db->table('users');
        $admin = $builder->where('email', 'admin')->get()->getRow();

        if (!$admin) {
            $builder->insert([
                'email' => 'admin',
                'password' => password_hash('admin123', PASSWORD_BCRYPT),
                'full_name' => 'Administrator',
                'role' => 'admin',
                'status' => 'approved',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $output .= "<p>✓ Admin user created</p>";
            $output .= "<p><strong>Login Credentials:</strong></p>";
            $output .= "<p>Username: <code>admin</code></p>";
            $output .= "<p>Password: <code>admin123</code></p>";
        } else {
            $output .= "<p>✓ Admin user already exists</p>";
        }

        $output .= "<p><br><a href='/auth/login'>Go to Login Page</a></p>";

        return $output;
    }
}
