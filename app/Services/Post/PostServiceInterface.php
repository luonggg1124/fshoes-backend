<?php
namespace App\Services\Post;

interface PostServiceInterface {
    function getAll(array $params);
    function findById(int|string $id);
    function findByUserId(int|string $id);
    function create(array $data, array $option = []);
    function update(int|string $id,array $data, array $option = []);
    function delete(int|string $id);
    function restore(int|string $id);
    function forceDelete(int|string $id);
    function findBySlug(int|string $slug);
}
