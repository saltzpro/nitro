<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventAge;
use App\Models\EventShirt;
use App\Models\EventPickup;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // add seeder event 
        $event = Event::create([
            'user_id' => 1,
            'title' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
            'description' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.",
            'event_start' => '2025-07-05',
            'event_end' => '2025-07-05',
            'location' => "SM City Butuan, J.C Aquino Avenue, Butuan City",
            'fb_link' => 'https://www.facebook.com/menardjemely',
            'event_waiver' => 'test waiver only er since the 1500s, when an unknown printer took a galley of type and scrambled it to',
            'terms_and_condition' => 'test terms and condition terms_and_condition nly er since the 1500s, when an unknown printer took a galley of ty',
            'pickup_notes' => 'bisag asa lang ninyo kuhaa bahala namo'
        ]);

        EventCategory::create([ 'event_id' => $event->id, 'name' => '5KM', 'sub_name' => 'Inclusion tanan pangapil namo ui.' ]);
        EventCategory::create([ 'event_id' => $event->id, 'name' => '10KM', 'sub_name' => 'Inclusion tanan pangapil namo ui.' ]);
        EventCategory::create([ 'event_id' => $event->id, 'name' => '20KM', 'sub_name' => 'Inclusion tanan pangapil namo ui.' ]);

        EventAge::create([ 'event_id' => $event->id, 'age_from' => '18', 'age_to' => '29' ]);
        EventAge::create([ 'event_id' => $event->id, 'age_from' => '30', 'age_to' => '40' ]);
        EventAge::create([ 'event_id' => $event->id, 'age_from' => '41', 'age_to' => '50' ]);
        EventAge::create([ 'event_id' => $event->id, 'age_from' => '51', 'age_to' => '60' ]);
        EventAge::create([ 'event_id' => $event->id, 'age_from' => '61', 'age_to' => 'above' ]);

        EventPickup::create([ 'event_id' => $event->id, 'pickup_lists' => 'SM City Butuan alas 2pm to 9pm' ]);
        EventPickup::create([ 'event_id' => $event->id, 'pickup_lists' => 'Robinsons Butuan alas 2pm to 9pm' ]);
        EventPickup::create([ 'event_id' => $event->id, 'pickup_lists' => 'Gaisano Butuan alas 2pm to 9pm' ]);

        $sizes = [
            '18', "S", "M", 'L', 'XL', '2XL', '3XL'
        ];

        EventShirt::create([
            'event_id' => $event->id,
            'shirt_title' => 'Singlet, Tshirt and finisher shirt 1 size only',
            'shirt_description' => "it's the protocol used to send and receive email messages over the internet, enabling",
            'shirt_sizes' => json_encode($sizes)
        ]);
        
    }
}
