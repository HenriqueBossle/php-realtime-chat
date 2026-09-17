<?php

namespace App\Services;

use App\Repositories\UserRepository;

final class UserPageService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function getCurrentUser(int $userId): ?array
    {
        return $this->userRepository->findById($userId);
    }

    public function countOnlineUsersExcept(int $currentUserId): int
    {
        $count = $this->userRepository->countOnlineExcept($currentUserId);
        return max(0, $count);
    }

    public function getUsersForList(int $currentUserId): array
    {
        return $this->userRepository->findAllExcept($currentUserId);
    }
}