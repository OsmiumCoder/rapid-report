<?php

namespace App\Data;

use App\Enum\IncidentType;
use App\Enum\RoleType;
use App\Models\Incident;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/**
 * Request data for creation of an incident.
 *
 * @see Incident The model that will be created for this data.
 */
class IncidentData extends Data
{
    /**
     * @param bool $anonymous If the reporter of this incident is remaining anonymous.
     * @param bool $on_behalf If the reporter is reporting for themselves or for someone else.
     * @param bool $on_behalf_anonymous If the incident is about someone who is not the reporter and wants to be anonymous.
     * @param RoleType|null $role Optional. The role of the individual involved in the incident.
     * @param string|null $last_name Optional. The last name of the individual involved in the incident.
     * @param string|null $first_name Optional. The first name of the individual involved in the incident.
     * @param string|null $upei_id Optional. The UPEI ID number of the individual involved in the incident.
     * @param string|null $email Optional. The email of the individual involved in the incident.
     * @param string|null $phone Optional. The phone number of the individual involved in the incident.
     * @param bool $work_related If the incident was related to workplace conditions.
     * @param bool $workers_comp_submitted If the individual involved submitted workers compensation.
     * @param Carbon|null $happened_at Optional. The date on which the incident occurred.
     * @param string|null $location Optional. The location of the incident.
     * @param string|null $room_number Optional. The room number or general area of the incident within the location.
     * @param array<int, array<string, string>>|null $witnesses Optional. The list of witnesses to the incident. Each witness has a name and optionally an email and phone.
     * @param IncidentType $incident_type The category or type of incident.
     * @param string $descriptor The descriptor chosen based on the incident type.
     * @param string|null $description Optional. The general description of the incident.
     * @param string|null $injury_description Optional. The description of any injuries that occurred.
     * @param string|null $first_aid_description Optional. The description of any first aid that was administered.
     * @param string|null $reporters_email Optional. The email of the reporter. Will not be present if they remain anonymous.
     * @param string|null $supervisor_name Optional. The supervisor that was given on submission.
     */
    public function __construct(
        public bool         $anonymous,
        public bool         $on_behalf,
        public bool         $on_behalf_anonymous,
        public ?RoleType    $role,
        public ?string      $last_name,
        public ?string      $first_name,
        public ?string      $upei_id,
        public ?string      $email,
        public ?string      $phone,
        public bool         $work_related,
        public bool         $workers_comp_submitted,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon      $happened_at,
        public ?string      $location,
        public ?string      $room_number,
        public ?array       $witnesses,
        public IncidentType $incident_type,
        public string       $descriptor,
        public ?string      $description,
        public ?string      $injury_description,
        public ?string      $first_aid_description,
        public ?string      $reporters_email,
        public ?string      $supervisor_name,
    ) {
    }
}
