<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = [
            [
                'title' => 'Login page bug',
                'description' => 'Users cannot login using Google OAuth.',
                'summary' => 'OAuth login failing',
                'category' => 'bug',
                'priority' => 'high',
                'status' => 'open',
            ],
            [
                'title' => 'Add dark mode',
                'description' => 'Users requested dark mode support for UI.',
                'summary' => 'UI enhancement',
                'category' => 'feature',
                'priority' => 'medium',
                'status' => 'pending',
            ],
            [
                'title' => 'Email not sending',
                'description' => 'SMTP server fails when sending ticket notifications.',
                'summary' => 'Email issue',
                'category' => 'bug',
                'priority' => 'high',
                'status' => 'open',
            ],
            [
                'title' => 'Improve dashboard speed',
                'description' => 'Dashboard loads slowly when fetching large datasets.',
                'summary' => 'Performance optimization',
                'category' => 'feature',
                'priority' => 'medium',
                'status' => 'pending',
            ],
            [
                'title' => 'Support mobile layout',
                'description' => 'Fix UI issues on small screen devices.',
                'summary' => 'Responsive design fix',
                'category' => 'support',
                'priority' => 'low',
                'status' => 'closed',
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }
    }
}