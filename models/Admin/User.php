<?php

namespace Admin;

use \models\Model as Model;
use Admin\Apartment as Apartment;

class User extends Model
{
    public function get_users(string $condition='')
    {
        $users = [];

        $db = \DB::get_connection();

        $sql = "SELECT u.id, u.role_id, u.login, u.name, u.surname, u.patronymic, u.password, r.name as role, GROUP_CONCAT(DISTINCT g.name SEPARATOR ', ') AS groups FROM users u INNER JOIN users_groups u_g ON u.id = u_g.user_id JOIN groups g ON u_g.group_id = g.id JOIN roles r ON r.id = u.role_id $condition GROUP BY u.id";
        
        $query = $db->prepare($sql);

        if ($query->execute()) {        
            $i = 0; 
            while ($row = $query->fetch()) { 
                $users[$i]['id'] = $row['id'];
                $users[$i]['role_id'] = $row['role_id'];
                $users[$i]['role'] = $row['role'];
                $users[$i]['login'] = $row['login'];
                $users[$i]['name'] = $row['name'];
                $users[$i]['surname'] = $row['surname'];
                $users[$i]['patronymic'] = $row['patronymic'];
                $users[$i]['password'] = $row['password'];
                $users[$i]['groups'] = $row['groups'];
                $i++;
            }

            return $users;
        } else {
            return false;
        }

    }

    public function create(array $data): bool
    {
        $data = $this->validate($data, [
            'login' => 'Логин|empty|length',
            'name' => 'Имя|empty|length',
            'surname' => 'Фамилия|empty|length',
            'role' => 'Роль|empty|length',
            'group' => 'Группа|empty|length',
            'password' => 'Пароль|empty|length',
        ]);

        $db = \DB::get_connection();
        $sql = 'INSERT INTO users (role_id, login, name, surname, patronymic, password) VALUES (:role, :login, :name, :surname, :patronymic, :password)';

        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $role = (int) $data['role'];

        $query = $db->prepare($sql);
        $query->bindParam(':role', $role);
        $query->bindParam(':login', $data['login']);
        $query->bindParam(':name', $data['name']);
        $query->bindParam(':surname', $data['surname']);
        $query->bindParam(':patronymic', $data['patronymic']);
        $query->bindParam(':password', $password);

        if ($query->execute()) {
            $user_id = $db->lastInsertId();

            $sql = 'INSERT INTO users_groups (user_id, group_id) VALUES (:user_id, :group_id)';
            $query = $db->prepare($sql);

            $result = 0;
            foreach ($data['group'] as &$group_id) {
                $query->bindParam(':user_id', $user_id);
                $query->bindParam(':group_id', $group_id);

                if ($query->execute()) {
                    $result += 1;
                } else {
                    $result -= 1;
                }
            }

            if ($result > 0) {
                if ($data['apartments']) {
                    $sql = 'INSERT INTO tesla_users_apartments (user_id, apartment_id) VALUES (:user_id, :apartment_id)';
                    $query = $db->prepare($sql);

                    $result = 0;
                    foreach ($data['apartments'] as &$apartment_id) {
                        $query->bindParam(':user_id', $user_id);
                        $query->bindParam(':apartment_id', $apartment_id);

                        if ($query->execute()) {
                            $result += 1;
                        } else {
                            $result -= 1;
                        }
                    }

                    if ($result > 0) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function show(int $id)
    {
        $db = \DB::get_connection();

        $sql = "SELECT u.id, u.login, u.name, u.surname, u.patronymic, GROUP_CONCAT(DISTINCT r.id, r.name SEPARATOR ', ') AS roles, GROUP_CONCAT(DISTINCT g.id, g.name SEPARATOR ', ') AS groups, GROUP_CONCAT(DISTINCT u_a.apartment_id SEPARATOR ', ') AS apartments FROM users u INNER JOIN roles r ON u.role_id = r.id INNER JOIN users_groups u_g ON u.id = u_g.user_id INNER JOIN groups g ON u_g.group_id = g.id LEFT JOIN tesla_users_apartments u_a ON u.id = u_a.user_id WHERE u.id = :id GROUP BY u.id";
        
        $query = $db->prepare($sql);

        $query->bindParam(':id', $id);

        if ($query->execute()) {
            return $query->fetch(\PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function update(array $data): bool
    {
        $data = $this->validate($data, [
            'login' => 'Логин|empty|length',
            'name' => 'Имя|empty|length',
            'surname' => 'Фамилия|empty|length',
            'patronymic' => 'Отчество|empty|length',
            'role' => 'Роль|empty',
            'group' => 'Группа|empty',
        ]);

        $db = \DB::get_connection();
        
        // На тот случай если пользователь хочет оставить старый пароль
        if (!$data['password']) {
            $condition = 'role_id = :role_id, login = :login, name = :name, surname = :surname, patronymic = :patronymic'; 
        } else {
            $condition = 'role_id = :role_id, login = :login, name = :name, surname = :surname, patronymic = :patronymic, password = :password';
        }

        $sql = "UPDATE users SET $condition WHERE id = :id";

        $user_id = (int) $data['id'];
        $role = (int) $data['role'];

        $query = $db->prepare($sql);
        $query->bindParam(':id', $user_id);
        $query->bindParam(':role_id', $role);
        $query->bindParam(':login', $data['login']);
        $query->bindParam(':name', $data['name']);
        $query->bindParam(':surname', $data['surname']);
        $query->bindParam(':patronymic', $data['patronymic']);

        // На тот случай если пользователь хочет оставить старый пароль
        if ($data['password']) {
            $password = password_hash($data['password'], PASSWORD_BCRYPT);
            $query->bindParam(':password', $password);
        }

        if ($query->execute()) {

            $sql = 'DELETE FROM users_groups WHERE user_id = :user_id';
            $query = $db->prepare($sql);
            $query->bindParam(':user_id', $user_id);

            if ($query->execute()) {
                $sql = 'DELETE FROM tesla_users_apartments WHERE user_id = :user_id';
                $query = $db->prepare($sql);
                $query->bindParam(':user_id', $user_id);

                if ($query->execute()) {
                    $sql = 'INSERT INTO users_groups (user_id, group_id) VALUES (:user_id, :group_id)';
                    $query = $db->prepare($sql);

                    $result = 0;
                    foreach ($data['group'] as &$group_id) {
                        $query->bindParam(':user_id', $user_id);
                        $query->bindParam(':group_id', $group_id);

                        if ($query->execute()) {
                            $result += 1;
                        } else {
                            $result -= 1;
                        }
                    }

                    if ($result > 0) {
                        if ($data['apartments']) {
                            $sql = 'INSERT INTO tesla_users_apartments (user_id, apartment_id) VALUES (:user_id, :apartment_id)';
                            $query = $db->prepare($sql);

                            $result = 0;
                            foreach ($data['apartments'] as &$apartment_id) {
                                $query->bindParam(':user_id', $user_id);
                                $query->bindParam(':apartment_id', $apartment_id);

                                if ($query->execute()) {
                                    $result += 1;
                                } else {
                                    $result -= 1;
                                }
                            }

                            if ($result > 0) {
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return true;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function delete(int $id): bool
    {
        $db = \DB::get_connection();

        $sql = 'DELETE FROM users WHERE id = :id';
        $query = $db->prepare($sql);

        $query->bindParam(':id', $id);

        if ($query->execute()) {
            $sql = 'DELETE FROM users_groups WHERE user_id = :user_id';
            $query = $db->prepare($sql);
            $query->bindParam(':user_id', $id);

            if ($query->execute()) {
                $sql = 'DELETE FROM tesla_users_apartments WHERE user_id = :user_id';
                $query = $db->prepare($sql);
                $query->bindParam(':user_id', $id);

                if ($query->execute()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function check_exists(array $data)
    {
        $data = $this->validate($data, [
            'login' => 'Логин|empty|length',
        ]);

        $db = \DB::get_connection();

        $sql = "SELECT u.id, u.role_id, u.login, u.name, u.surname, u.password, r.name AS role_name, GROUP_CONCAT(DISTINCT g.id SEPARATOR ', ') AS groups FROM users u INNER JOIN users_groups u_g ON u.id = u_g.user_id INNER JOIN groups g ON g.id = u_g.group_id INNER JOIN roles r ON u.role_id = r.id WHERE login = :login GROUP BY u.id";

        $query = $db->prepare($sql);
        $query->bindParam(':login', $data['login']);
        $query->execute();
        $user = $query->fetch(\PDO::FETCH_ASSOC);

        if ($user) {
            return $user;
        } else {
            return false;
        }
    }

    public function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['roles']);
        unset($_SESSION['groups']);
        unset($_SESSION['user_name_surname']);
        unset($_SESSION['role_name']);
        header('Location: /login');
    }
}