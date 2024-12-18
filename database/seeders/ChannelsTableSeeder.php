<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Repositories\ChannelRepository;

class ChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Check if any channel(s) exist or not. If no channel exists then only create the channels.
         */
        $channelRepository = new ChannelRepository();
        $numberOfChannels = $channelRepository->getTotalChannels();

        if ($numberOfChannels == 0) {
            $channelRepository->createChannel([
                'name' => 'Aircraft',
                'slug' => 'aircraft'
            ]);

            $channelRepository->createChannel([
                'name' => 'DGCA Exam',
                'slug' => 'dgca-exam'
            ]);

            $channelRepository->createChannel([
                'name' => 'Medical',
                'slug' => 'medical'
            ]);

            $channelRepository->createChannel([
                'name' => 'CPL',
                'slug' => 'cpl'
            ]);

            $channelRepository->createChannel([
                'name' => 'ATPL',
                'slug' => 'atpl'
            ]);

            $channelRepository->createChannel([
                'name' => 'Flying training',
                'slug' => 'flying-training'
            ]);

            $channelRepository->createChannel([
                'name' => 'Type rating',
                'slug' => 'type-rating'
            ]);

            $channelRepository->createChannel([
                'name' => 'Cadet Pilot Programme',
                'slug' => 'cadet-pilot-programme'
            ]);

            $channelRepository->createChannel([
                'name' => 'Airline Interview',
                'slug' => 'airline-interview'
            ]);

            $channelRepository->createChannel([
                'name' => 'Computer Number',
                'slug' => 'computer-number'
            ]);

            $channelRepository->createChannel([
                'name' => 'VISA',
                'slug' => 'visa'
            ]);

            $channelRepository->createChannel([
                'name' => 'JOB',
                'slug' => 'job'
            ]);

            $channelRepository->createChannel([
                'name' => 'Cabin crew',
                'slug' => 'cabin-crew'
            ]);

            $channelRepository->createChannel([
                'name' => 'Air traffic controller',
                'slug' => 'air-traffic-controller'
            ]);

            $channelRepository->createChannel([
                'name' => 'Aircraft maintenance engineer',
                'slug' => 'aircraft-maintenance-engineer'
            ]);
        }
    }
}
