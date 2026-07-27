<?php

namespace App\Interfaces;


interface KardexRepositoryInterface
{
    public function create(array $data);
    public function all();
    public function search($query);
    public function allId($id);
    public function getId($id);
    public function countRegister();
}
