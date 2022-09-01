<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Query\Builder;
class ViewUserAction extends UserAction
{
    protected $table;

    public function __construct(Builder $table) {
        $this->table = $table;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user = $this->userRepository->findUserOfId($userId);

        $this->logger->info("User of id `${userId}` was viewed.");

        $records = $this->table->where('name', 'like', '%foo%')->get();


        return $this->respondWithData($user);
    }
}
