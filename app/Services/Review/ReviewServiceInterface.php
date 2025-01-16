<?php
namespace App\Services\Review;

use Illuminate\Http\Request;

interface ReviewServiceInterface{

    public function all();
    public function find(int|string $id);
    public function create(array $data);
    public function update(string|int $id, array $data);
    public function delete(int|string $id);
    public function forceDelete(int|string $id);
    public function restore(int|string $id);
    public function getByLikes();
    public function toggleLike(int $review_id, int $user_id);
    public function reviewsByProduct(int|string $productId);
    public function canReview(int $userId, int $productId);
}
