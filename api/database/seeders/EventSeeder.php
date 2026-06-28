<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventAge;
use App\Models\EventCategory;
use App\Models\EventPickup;
use App\Models\EventShirt;
use App\Models\PaymentSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event = Event::updateOrCreate(
            [
                'title' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s"
            ],
            [
                'user_id' => 1,
                'description' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.",
                'event_start' => '2025-07-05',
                'event_end' => '2025-07-05',
                'location' => "SM City Butuan, J.C Aquino Avenue, Butuan City",
                'fb_link' => 'https://www.facebook.com/menardjemely',
                'event_waiver' => 'test waiver only er since the 1500s, when an unknown printer took a galley of type and scrambled it to',
                'terms_and_condition' => 'test terms and condition terms_and_condition nly er since the 1500s, when an unknown printer took a galley of ty',
                'pickup_notes' => 'bisag asa lang ninyo kuhaa bahala namo'
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */
        $categories = [
            ['name' => '5KM', 'price' => 700],
            ['name' => '10KM', 'price' => 1000],
            ['name' => '20KM', 'price' => 1500],
        ];

        foreach ($categories as $category) {
            EventCategory::updateOrCreate(
                [
                    'event_id' => $event->id,
                    'name' => $category['name'],
                ],
                [
                    'sub_name' => 'Inclusion tanan pangapil namo ui.',
                    'original_price' => $category['price'],
                    'current_price' => $category['price'],
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Age Groups
        |--------------------------------------------------------------------------
        */
        $ages = [
            ['18', '29'],
            ['30', '40'],
            ['41', '50'],
            ['51', '60'],
            ['61', 'above'],
        ];

        foreach ($ages as [$ageFrom, $ageTo]) {
            EventAge::updateOrCreate(
                [
                    'event_id' => $event->id,
                    'age_from' => $ageFrom,
                ],
                [
                    'age_to' => $ageTo,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pickup Locations
        |--------------------------------------------------------------------------
        */
        $pickups = [
            'SM City Butuan alas 2pm to 9pm',
            'Robinsons Butuan alas 2pm to 9pm',
            'Gaisano Butuan alas 2pm to 9pm',
        ];

        foreach ($pickups as $pickup) {
            EventPickup::updateOrCreate(
                [
                    'event_id' => $event->id,
                    'pickup_lists' => $pickup,
                ],
                []
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Shirt
        |--------------------------------------------------------------------------
        */
        $sizes = ['18', 'S', 'M', 'L', 'XL', '2XL', '3XL'];

        EventShirt::updateOrCreate(
            [
                'event_id' => $event->id,
                'shirt_title' => 'Singlet, Tshirt and finisher shirt 1 size only',
            ],
            [
                'shirt_description' => "it's the protocol used to send and receive email messages over the internet, enabling",
                'shirt_sizes' => json_encode($sizes),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Payment Sources
        |--------------------------------------------------------------------------
        */
        $paymentSources = [
            [
                'source' => 'GCASH',
                'account_number' => '09484770221',
                'account_name' => 'Jemely Catayas',
            ],
        ];

        foreach ($paymentSources as $paymentSource) {
            PaymentSource::updateOrCreate(
                [
                    'event_id' => $event->id,
                    'source' => $paymentSource['source'],
                ],
                [
                    'account_number' => $paymentSource['account_number'],
                    'account_name' => $paymentSource['account_name'],
                ]
            );
        }
    }
}
