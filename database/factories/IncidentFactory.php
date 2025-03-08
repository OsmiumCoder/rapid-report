<?php

namespace Database\Factories;

use App\Enum\IncidentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incident>
 */
class IncidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'anonymous' => false,
            'on_behalf' => false,
            'on_behalf_anonymous' => false,
            'role' => fake()->numberBetween(1, 4),
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'upei_id' => fake()->numberBetween(99999, 9999999),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'work_related' => fake()->boolean,
            'workers_comp_submitted' => false,
            'happened_at' => fake()->date(),
            'location' => fake()->randomElement(['Alumni Hall (ALH) - (38)',
'Atlantic Veterinary College (AVC) - (27)',
'Bernardine Hall (BEH) - (20)',
'Bill and Denise Andrew Hall (AH) - (19)',
'Blanchard Hall (BLH) - (24)',
'Bell Aliant Centre and MacLauchlan Arena (MA) - (1)',
'Canadian Centre for Climate Change and Adaptation (St. Peter\'s, PEI)',
'Cass Science Hall (CSH) - (10)',
'Chaplaincy Centre (CC) - (14)',
'Chi-Wan Young Sports Centre (YSC) - (1)',
'Central Utility Building (CUB) - (2)',
'Dalton Hall (DH) - (7)',
'Daycare Building (DCB) - (16)',
'Don and Marion McDougall Hall (MCDH) - (12)',
'Duffy Science Centre (DSC) - (13)',
'Health Sciences Building (HSB) - (3)',
'K.C. Irving Chemistry Centre (ICC) - (17)',
'Kelley Memorial Building (KMB) - (11)',
'Memorial Hall (MH) - (9)',
'Performing Arts Centre and Residence (PAC) - (21)',
'Regis and Joan Duffy Research Centre (DRC) - (28)',
'Robertson Library (RL) - (15)',
'Faculty of Sustainable Design Engineering building (FSDE) - (30)',
'SDU Main Building (SDMB) - (5)',
'Steel Building (SB) - (6)',
'W.A. Murphy Student Centre (MSC) - (4)',
'Wanda Wyatt Dining Hall (WDH) - (18)']),
            'room_number' => fake()->buildingNumber(),
            'witnesses' => fake()-> randomElements([
                0 => [
                    'name' => fake()->name(),
                    'email' => '',
                    'phone' => fake()->phoneNumber(),
                ],
                1 => [
                    'name' => fake()->name(),
                    'email' => fake()->email(),
                    'phone' => '',
                ],
                3 => [
                    'name' => fake()->name(),
                    'email' => '',
                    'phone' => fake()->phoneNumber(),
                ]
            ], fake()->numberBetween(0, 3)),
            'incident_type' => fake()->randomElement(IncidentType::cases()),
            'descriptor' => fake()->randomElement([
                'Injury',
                'Illness',
                'Exposure',
                'Animal bite/sting/scratch',
                'Needle/sharp/puncture/cut',
                'Slip/Trip/fall',
                'Burn/Shock',
                'Sexual Harassment',
                'Personal Harassment',
                'Discrimination',
                'Near Miss/Hazard',
                'Other',
                'Lab Bio security incident/threat',
                'Theft/Assault',
                'Bomb threat',
                'Violent Threat/Harassment',
                'Property damage/Equipment Loss',
                'Suspicious Activity',
                'Spill',
                'Hazardous Materials',
                'Fire',
                'Infectious Materials',
                'Air/Water pollution',
            ]),
            'description' => fake()->text(),
            'injury_description' => fake()->text(),
            'first_aid_description' => fake()->text(),
        ];
    }
}
