<?php

namespace App\StorableEvents\User;

use App\Aggregates\IncidentAggregateRoot;
use App\Enum\RolesEnum;
use App\Mail\UserAdded;
use App\Models\User;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Mail;

class UserCreated extends StoredEvent
{
    public function __construct(
        public string    $name,
        public string    $email,
        public string    $password,
        public string    $upei_id,
        public string    $phone,
        public RolesEnum $role,
        public ?string $incident_id = null,
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

        if ($this->incident_id && $this->role === RolesEnum::SUPERVISOR) {
            IncidentAggregateRoot::retrieve($this->incident_id)->assignSupervisor($user->id)->persist();
        }
    }

    public function react()
    {
        Mail::to($this->email)->send(new UserAdded);
    }
}
