<?php

namespace App\StorableEvents\User;

use App\Enum\RolesEnum;
use App\Models\User;
use App\StorableEvents\StoredEvent;

class UserCreated extends StoredEvent
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $upei_id,
        public string $phone,
        public RolesEnum $role,
    ) {
    }

    public function handle()
    {
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'upei_id' => $this->upei_id,
            'phone' => $this->phone,
        ])->syncRoles($this->role->value);
    }

    public function react()
    {
    }
}
