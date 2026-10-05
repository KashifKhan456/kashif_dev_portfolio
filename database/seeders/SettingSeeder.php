<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'hero_title' => 'Full Stack Software Engineer',
            'hero_title_1' => 'Kashif Khan',
            'hero_title_2' => 'Full Stack Software Engineer',
            'hero_title_3' => 'Laravel, React.js & Vue.js Specialist',
            'hero_subtitle' => 'Full Stack Software Engineer with 3.5+ years of experience building and scaling production web applications across Laravel, React.js, and Vue.js.',
            'bio' => 'Full Stack Software Engineer with 3.5+ years of experience building and scaling web applications across Laravel, React.js, and Vue.js. Proven track record leading development teams and architecting production systems including a real-time EPOS platform, secure RBAC-driven CRM systems, and maintainable e-commerce, auction, and LMS platforms from requirements through deployment.

Skilled in RESTful API design, clean architecture, database optimization, and third-party integrations (Stripe, AWS S3, SendGrid). Strong advocate for TDD and accessibility (WCAG 2.2), combining solid technical execution with Agile leadership and a track record of mentoring teams and shipping on schedule.',
            'about_text' => 'Full Stack Software Engineer with 3.5+ years of experience building and scaling web applications across Laravel, React.js, and Vue.js. Proven track record leading development teams and architecting production systems including a real-time EPOS platform, secure RBAC-driven CRM systems, and maintainable e-commerce, auction, and LMS platforms from requirements through deployment.

Skilled in RESTful API design, clean architecture, database optimization, and third-party integrations (Stripe, AWS S3, SendGrid). Strong advocate for TDD and accessibility (WCAG 2.2), combining solid technical execution with Agile leadership and a track record of mentoring teams and shipping on schedule.',
            'availability_status' => 'Available for Full-time Roles & Contracts',
            'contact_email' => 'kashif.tech.317@gmail.com',
            'contact_phone' => '+92 3172296768',
            'location' => 'Peshawar, KPK, Pakistan',
            'cal_url' => 'https://cal.com/kashif-khan',
            'github_url' => 'https://github.com/KashifKhan456',
            'linkedin_url' => 'https://linkedin.com/in/kashif-khan456',
            'twitter_url' => 'https://x.com/kashifkhan',
            'resume_url' => '#',
        ];

        foreach ($settings as $key => $value) {
            Setting::setByKey($key, $value);
        }
    }
}
