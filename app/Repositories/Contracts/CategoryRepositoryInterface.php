<?php
namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface
{
    public function all();
    public function active($paginate = null);
    public function find($id);
    public function findBySlug(string $slug);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}