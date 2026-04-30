<?php
// Bootstrap CodeIgniter for CLI and create users table safely (no duplicates)
require_once __DIR__ . '/../system/util_bootstrap.php';

$db = \Config\Database::connect();
$forge = \Config\Database::forge();

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
    echo "✓ Users table created successfully\n";
} else {
    echo "✓ Users table already exists\n";
}

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
    echo "✓ Admin user created (username: admin, password: admin123)\n";
} else {
    echo "✓ Admin user already exists\n";
}

echo "\n✓ Setup completed successfully!\n";
