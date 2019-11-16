<?php

namespace App\Model;

/**
 * Class RaceManager
 *
 */
class RaceManager extends AbstractManager
{
    const TABLE = 'race';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllInAnimals(): array
    {
        $query = "SELECT r.name race_name, r.id, price, c.name category, a.name animal FROM " . self::TABLE . " r
                    JOIN category c ON c.id=r.category_id
                        JOIN animal a ON a.id=c.animal_id";
        return $this->pdo->query($query)->fetchAll();
    }

    public function selectOneById(int $id)
    {
        $statement = $this->pdo->prepare("
            SELECT r.*, c.name category_name FROM " . self::TABLE . " r 
                JOIN category c ON c.id = r.category_id
                WHERE r.id=:id
            ");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function update(array $data)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . "
                SET name=:name, price=:price, image=:image, description=:description            
                WHERE id=:id
            ");
        $statement->bindValue('name', $data['name'], \PDO::PARAM_STR);
        $statement->bindValue('price', $data['price'], \PDO::PARAM_STR);
        $statement->bindValue('image', $data['image'], \PDO::PARAM_INT);
        $statement->bindValue('description', $data['description'], \PDO::PARAM_STR);
        $statement->bindValue('id', $data['id'], \PDO::PARAM_INT);
        $statement->execute();
    }

    public function delete(int $id)
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
