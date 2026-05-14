<?php

namespace App\Console\Commands;

use App\Models\KnowledgeArticle;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:seed-knowledge-base')]
#[Description('Command description')]
class seedKnowledgeBase extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $articles = [
            [
                'title' => 'How to reset your password',
                'category' => 'Account Management',
                'content' => 'To reset your password, click on the "Forgot Password" link on the login page and follow the instructions.',
            ],
            [
                'title' => 'How to contact support',
                'category' => 'Support',
                'content' => 'You can contact our support team by emailing [email] or by calling [phone number].',
            ],
            [
                'title' => 'How to update your profile',
                'category' => 'Account Management',
                'content' => 'To update your profile, go to the "Profile" section in your account settings and make the necessary changes.',
            ],
            [
                'title' => 'How to track your order',
                'category' => 'Orders',
                'content' => 'To track your order, go to the "Orders" section in your account and click on the "Track Order" button next to the relevant order.',
            ],
            [
                'title' => 'How to request a refund',
                'category' => 'Orders',
                'content' => 'To request a refund, go to the "Orders" section in your account, click on the relevant order, and then click on the "Request Refund" button.',
            ],
            [
                'title' => 'How to change your email address',
                'category' => 'Account Management',
                'content' => 'To change your email address, go to the "Profile" section in your account settings and update your email information.',
            ],
            [
                'title' => 'How to delete your account',
                'category' => 'Account Management',
                'content' => 'To delete your account, go to the "Profile" section in your account settings and click on the "Delete Account" button. Please note that this action is irreversible.',
            ],
            [
                'title' => 'How to subscribe to our newsletter',
                'category' => 'General',
                'content' => 'To subscribe to our newsletter, go to the "Newsletter" section in your account settings and click on the "Subscribe" button.',
            ],
            [
                'title' => 'How to change your notification settings',
                'category' => 'Account Management',
                'content' => 'To change your notification settings, go to the "Notifications" section in your account settings and adjust your preferences.',
            ],
            [
                'title' => 'How to use our mobile app',
                'category' => 'General',
                'content' => 'To use our mobile app, download it from the App Store or Google Play, and log in with your account credentials.',
            ],
        ];

        $this->info('Seeding knowledge base articles...');
        $bar = $this->output->createProgressBar(count($articles));

        foreach ($articles as $data) {
            $article = KnowledgeArticle::updateOrCreate(
                ['title' => $data['title']],
                $data
            );

            $article->generateEmbedding();
            //  retry(5, function () use ($article) {

            //     $article->generateEmbedding();

            // }, 5000);

            // throttle requests
            // usleep(500000); // 0.5 second
            $bar->advance();
        }
      
        $bar->finish();
        $this->newLine();
        $this->info('knowledgebase seed with ' . count($articles) . ' articles');
    }
}
