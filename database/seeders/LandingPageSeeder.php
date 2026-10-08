<?php

namespace Database\Seeders;

use App\Models\LandingHighlight;
use App\Models\LandingPlan;
use App\Models\LandingSetting;
use App\Models\LandingStep;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    public function run()
    {
        LandingSetting::current()->update([
            'hero_title' => 'Grow Your Store with FlyerAll',
            'hero_subtitle' => 'Send text messages, share your weekly ads, reward your customers and keep them coming back.',
            'monthly_fee_amount' => '$125',
            'monthly_fee_label' => 'per month',
            'redeem_banner_text' => 'Redeem rewards only when you are at the store and ready to check out.',
            'cta_text' => 'Get Started',
            'cta_url' => '#',
            'about_title' => 'About FlyerAll',
            'about_body' => "FlyerAll helps local stores grow by sending weekly ads and promotions straight to customers' phones, rewarding loyal shoppers with points, and giving every store its own branded app — all from one simple in-store tablet.",
            'contact_email' => 'support@flyerall.net',
            'contact_phone' => '+1 (000) 000-0000',
            'contact_address' => null,
        ]);

        $plans = [
            [
                'name' => 'Starter Plan',
                'subtitle' => '3,000 Text Messages',
                'price' => '$75',
                'price_subtext' => 'Total for 3,000 messages',
                'tablets_included' => 3,
                'tablets_label' => 'tablets included',
                'rate_text' => '2.5¢ per text message',
                'color' => 'primary',
                'is_popular' => false,
                'badge_text' => null,
                'sort_order' => 1,
            ],
            [
                'name' => 'Standard Plan',
                'subtitle' => '6,000 Text Messages',
                'price' => '$150',
                'price_subtext' => 'Total for 6,000 messages',
                'tablets_included' => 4,
                'tablets_label' => 'tablets included',
                'rate_text' => '2.5¢ per text message',
                'color' => 'danger',
                'is_popular' => false,
                'badge_text' => null,
                'sort_order' => 2,
            ],
            [
                'name' => 'Pro Plan',
                'subtitle' => '10,000 Text Messages',
                'price' => '$250',
                'price_subtext' => 'Total for 10,000 messages',
                'tablets_included' => 5,
                'tablets_label' => 'tablets included',
                'rate_text' => '2.5¢ per text message',
                'color' => 'purple',
                'is_popular' => true,
                'badge_text' => 'MOST POPULAR',
                'sort_order' => 3,
            ],
            [
                'name' => 'Business Plan',
                'subtitle' => '20,000 Text Messages',
                'price' => '$500',
                'price_subtext' => 'Total for 20,000 messages',
                'tablets_included' => 6,
                'tablets_label' => 'tablets included',
                'rate_text' => '2.5¢ per text message',
                'color' => 'orange',
                'is_popular' => false,
                'badge_text' => null,
                'sort_order' => 4,
            ],
        ];

        $planFeatures = [
            'Send text messages to customers',
            'Customer points & rewards',
            'Weekly ads',
            'In-store check-in tablet',
        ];

        foreach ($plans as $planData) {
            $plan = LandingPlan::updateOrCreate(['name' => $planData['name']], $planData);

            $plan->features()->delete();

            foreach ($planFeatures as $index => $text) {
                $plan->features()->create(['text' => $text, 'sort_order' => $index + 1]);
            }
        }

        $steps = [
            [
                'number' => 1,
                'title' => 'Customer Enters Phone Number',
                'description' => 'At the checkout counter, customers enter their mobile phone number on the FlyerAll tablet.',
                'color' => 'primary',
                'sort_order' => 1,
                'features' => ['Quick & easy sign up', 'One time per day', 'Built for your store'],
            ],
            [
                'number' => 2,
                'title' => 'Review & Agree',
                'description' => 'Customers must agree to receive text messages from the store, including weekly specials, discounts and promotions.',
                'color' => 'success',
                'sort_order' => 2,
                'features' => ['Clear privacy policy', 'Customers choose to opt in', 'Compliant and secure'],
            ],
            [
                'number' => 3,
                'title' => 'Receive Promotions by Text Message & View in the App',
                'description' => "The store can send weekly ads, coupons, deals and announcements directly to customers by text. Customers can also open your store's app to see all promotions, rewards, store information and more.",
                'color' => 'danger',
                'sort_order' => 3,
                'features' => ['Send weekly specials', 'Share coupons and announcements', 'Customers can view everything in your app'],
            ],
            [
                'number' => 4,
                'title' => 'Get Points & Rewards',
                'description' => 'After signing up, customers get points for every visit. They can see their points and available rewards on the tablet and in the app.',
                'color' => 'warning',
                'sort_order' => 4,
                'features' => ['Automatic points per visit (example: 25 points)', 'Custom rewards (you control it)', 'Redeem from the app'],
            ],
            [
                'number' => 5,
                'title' => 'Redeem Your Reward In Store',
                'description' => 'When you have enough points, redeem the reward in the app and show the barcode at checkout to get your item. Rewards can only be redeemed in the store.',
                'color' => 'purple',
                'sort_order' => 5,
                'features' => ['Tap Redeem on the reward', 'Show the barcode to the cashier', 'Get your item in the store'],
            ],
        ];

        foreach ($steps as $stepData) {
            $features = $stepData['features'];
            unset($stepData['features']);

            $step = LandingStep::updateOrCreate(['number' => $stepData['number']], $stepData);

            $step->features()->delete();

            foreach ($features as $index => $text) {
                $step->features()->create(['text' => $text, 'sort_order' => $index + 1]);
            }
        }

        LandingHighlight::where('section', LandingHighlight::SECTION_HOME_HERO)->delete();
        LandingHighlight::where('section', LandingHighlight::SECTION_PLANS_FOOTER)->delete();

        $homeHero = [
            ['icon' => 'bi-people-fill', 'color' => 'primary', 'title' => 'More Customers'],
            ['icon' => 'bi-megaphone-fill', 'color' => 'danger', 'title' => 'Send Weekly Specials'],
            ['icon' => 'bi-trophy-fill', 'color' => 'success', 'title' => 'Loyalty Points & Rewards'],
            ['icon' => 'bi-phone-fill', 'color' => 'purple', 'title' => 'Your Own Store App'],
        ];

        foreach ($homeHero as $index => $data) {
            LandingHighlight::create($data + [
                'section' => LandingHighlight::SECTION_HOME_HERO,
                'sort_order' => $index + 1,
            ]);
        }

        $plansFooter = [
            ['icon' => 'bi-gift-fill', 'color' => 'success', 'title' => 'Customer Rewards', 'description' => 'Customizable points system you control.'],
            ['icon' => 'bi-file-earmark-text-fill', 'color' => 'danger', 'title' => 'Send Weekly Ads', 'description' => 'Share your promotions with one click.'],
            ['icon' => 'bi-bar-chart-fill', 'color' => 'primary', 'title' => 'Track Results', 'description' => 'See delivery rates and customer activity.'],
            ['icon' => 'bi-phone-fill', 'color' => 'purple', 'title' => 'Your Own App', 'description' => 'Fully customized for your store.'],
        ];

        foreach ($plansFooter as $index => $data) {
            LandingHighlight::create($data + [
                'section' => LandingHighlight::SECTION_PLANS_FOOTER,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
