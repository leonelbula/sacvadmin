<?php

namespace App\Interfaces;


interface KardexRepositoryInterface
{
    public function create(array $data);
    public function all();
    public function search($query);
    public function allId(int $id);
    public function getId(int $id);
    public function countRegister();
}
