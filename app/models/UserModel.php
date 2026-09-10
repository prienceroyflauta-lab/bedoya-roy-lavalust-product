<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserModel extends Model {
    protected $table = 'users';
    protected $primary_key = 'id';
    protected $fillable = ['username', 'email', 'password', 'role', 'is_active'];
    protected $guarded = ['id'];

    public function __construct()
    {
        parent::__construct();
        try {
            $this->ensure_users_table();
        } catch (Throwable $e) {
            // DB may still be unavailable; fail gracefully.
        }
    }

    public function ensure_users_table()
    {
        try {
            $this->db->raw("CREATE TABLE IF NOT EXISTS users (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL UNIQUE,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin','moderator','user') NOT NULL DEFAULT 'user',
                is_active TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        } catch (Throwable $e) {
            // ignore; DB may not be configured yet
        }
    }

    private function user_value($user, $key)
    {
        if (is_array($user)) {
            return $user[$key] ?? null;
        }

        if (is_object($user)) {
            return $user->$key ?? null;
        }

        return null;
    }

    public function ensure_default_admin()
    {
        try {
            $this->ensure_users_table();

            $admin = $this->find_by('username', 'admin');
            $admin_password = password_hash('admin123', PASSWORD_DEFAULT);

            if ($admin) {
                $admin_id = $this->user_value($admin, 'id');
                $stored_admin_password = $this->user_value($admin, 'password');

                if (!password_verify('admin123', $stored_admin_password ?? '')) {
                    if ($admin_id) {
                        $this->update($admin_id, ['password' => $admin_password]);
                    }
                }
            } else {
                $this->insert([
                    'username' => 'admin',
                    'email' => 'admin@nursery-rhyme.local',
                    'password' => $admin_password,
                    'role' => 'admin',
                    'is_active' => 1,
                ]);
            }

            $user = $this->find_by('username', 'user');
            $user_password = password_hash('user123', PASSWORD_DEFAULT);

            if (!$user) {
                $this->insert([
                    'username' => 'user',
                    'email' => 'user@nursery-rhyme.local',
                    'password' => $user_password,
                    'role' => 'user',
                    'is_active' => 1,
                ]);
            } else {
                $user_id = $this->user_value($user, 'id');
                $stored_user_password = $this->user_value($user, 'password');

                if (!password_verify('user123', $stored_user_password ?? '')) {
                    if ($user_id) {
                        $this->update($user_id, ['password' => $user_password]);
                    }
                }
            }

            return $this->find_by('username', 'admin');
        } catch (Throwable $e) {
            return null;
        }
    }

    public function authenticate($username, $password)
    {
        try {
            $user = $this->find_by('username', trim($username));
            if (!$user) {
                return null;
            }

            $stored_password = $this->user_value($user, 'password');
            if (!isset($stored_password) || !password_verify($password, $stored_password)) {
                return null;
            }

            return $user;
        } catch (Throwable $e) {
            return null;
        }
    }
}
