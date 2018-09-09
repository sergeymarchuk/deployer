<?php namespace App\Repositories;

/**
 * Interface RepositoryInterface
 * @package App\Repositories
 */
interface AbstractRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);
}