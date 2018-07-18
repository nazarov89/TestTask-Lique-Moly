<?php

class Tree
{
    const TABLE = 'tree';
    private $db;
    private $folder = __DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'db.db';

    public function __construct()
    {
        $this->db = new PDO('sqlite:'.$this->folder);
    }

    public function getTree(int $parentId = 0): array
    {
        $rows = $this->db->query('SELECT * FROM '.self::TABLE.' WHERE `parent` = '.$parentId.' ORDER BY `name`')->fetchAll();
        $tree = [];
        foreach ($rows as $row) {
            $tree[$row['id']] = $row;
            $tree[$row['id']]['child'] = $this->getTree($row['id']);
        }

        return $tree;
    }

    public function addNode(string $name, int $parent = 0): int
    {
        $item = [
            'name' => '"'.$name.'"',
            'parent' => $parent,
        ];
        $this->db->exec('INSERT INTO '.self::TABLE.'(`name`, `parent`) VALUES('.implode(',', $item).')');
        return $this->db->query('SELECT last_insert_rowid() as id')->fetch()['id'];
    }

    public function getNode(int $id): array
    {
        return $this->db->query('SELECT * FROM '.self::TABLE.' WHERE id = '.$id)->fetch();
    }

    public function updateNode(int $nodeID, int $parentId = 0): void
    {
        $this->db->exec('UPDATE '.self::TABLE.' set `parent`= '.$parentId . ' WHERE id = '.$nodeID);
    }

    public function createTable(): void
    {
        $this->db->exec('CREATE TABLE '.self::TABLE.'(
            `id` INTEGER PRIMARY KEY,
            `name` varchar(255) NOT NULL,
            `parent` INTEGER DEFAULT 0
        )');
    }
