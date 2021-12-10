<?php

namespace App\Services\Admin;

use App\Events\UserEmailHadChanged;
use App\Models\User;

class UserService
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function update(array $params): void
    {
        if (data_get($params, 'verify') === "1") {
            $params['email_verified_at'] = now();
        } elseif ($params['email'] !== $this->user->email) {
            $params['email_verified_at'] = null;
            event(new UserEmailHadChanged($this->user));
        }
        $this->user->update($params);
    }
}
