<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeds the database with an admin user, sample portfolio projects with images, and technical skills.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ───────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'info@shahzadlabs.com'],
            [
                'name'     => 'Shahzad Labs Admin',
                'password' => Hash::make('Lodhran@345'),
            ]
        );

        // ── Projects ────────────────────────────────────────────────
        $cvBuilder = Project::updateOrCreate(
            ['slug' => 'cv-bulder'],
            [
                'title'       => 'CV-BULDER',
                'description' => "Project Description: CV-BUILDER\n\n📌 Project Overview:\nCV-BUILDER is an intuitive, modern, full-stack resume engineering application that empowers professionals to craft, customize, and export ATS-optimized resumes and CVs with real-time live preview and high-quality PDF generation.",
                'image'       => 'images/projects/cv-builder.jpg',
                'tech_stack'  => ['HTML', 'CSS', 'JS', 'Laravel', 'PHP'],
                'live_url'    => 'https://cv-bulder-livid.vercel.app/cv-builder',
                'github_url'  => null,
                'category'    => 'laravel',
                'metric'      => 'Live PDF Generation',
                'order'       => 1,
                'is_featured' => true,
            ]
        );

        if ($cvBuilder->galleryImages()->count() === 0) {
            $cvBuilder->galleryImages()->createMany([
                [
                    'image'   => 'images/projects/cv-builder.jpg',
                    'caption' => 'Resume Builder Real-time Editor & ATS Optimizer',
                    'order'   => 1,
                ],
                [
                    'image'   => 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=1200&auto=format&fit=crop&q=80',
                    'caption' => 'Modern Template Layouts & Live PDF Export Engine',
                    'order'   => 2,
                ],
                [
                    'image'   => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200&auto=format&fit=crop&q=80',
                    'caption' => 'Responsive Mobile & Tablet View Previewer',
                    'order'   => 3,
                ],
            ]);
        }


        // ── ThinkCode Management System (CRM) ───────────────
        $thinkCrm = Project::updateOrCreate(
            ['slug' => 'thinkcode-crm'],
            [
                'title'       => 'ThinkCode CRM — Enterprise Institute & Task Management System',
                'description' => "Project Description: ThinkCode Management System\n\n📌 Project Overview:\nThinkCode Management System is a comprehensive, production-grade enterprise software house and institute CRM engineered with Laravel 11, robust RESTful APIs, and Flutter mobile application architecture.\n\n⚡ Key Architecture and Features:\n• Multi-Role Polymorphic Authentication: Granular access control for Super Admin, Admin, Teachers, Students, and Interns.\n• Smart Attendance Engine: Dual-validation check-in using QR Code scanning and GPS Geofencing location tracking for anti-fraud accuracy.\n• Interactive Task Management Workflow: Life-cycle task tracking (Pending -> In Progress -> Submitted -> Under Review -> Completed/Rejected) with file submissions and multi-round grading.\n• Automated Fee and Installment Management: Dynamic course fee structures, installment tracking, late fee calculations, and transaction receipts.\n• Push Notifications and Audit Logs: Complete system activity log history with real-time alerting for submissions and reviews.",
                'image'       => 'images/projects/thinkcode-crm.jpg',
                'tech_stack'  => ['Laravel 11', 'PHP 8.3', 'MySQL', 'REST APIs', 'Flutter', 'Docker', 'Tailwind CSS'],
                'live_url'    => 'https://thinkcrm.shahzadlabs.com',
                'github_url'  => null,
                'category'    => 'saas',
                'metric'      => 'QR Attendance & Multi-Role SaaS Engine',
                'order'       => 2,
                'is_featured' => true,
            ]
        );

        if ($thinkCrm->galleryImages()->count() === 0) {
            $thinkCrm->galleryImages()->createMany([
                [
                    'image'   => 'images/projects/thinkcode-crm.jpg',
                    'caption' => 'ThinkCode CRM Executive Dashboard & Real-Time Analytics',
                    'order'   => 1,
                ],
                [
                    'image'   => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&auto=format&fit=crop&q=80',
                    'caption' => 'Comprehensive Reporting, Finance & Performance Metrics',
                    'order'   => 2,
                ],
                [
                    'image'   => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?w=1200&auto=format&fit=crop&q=80',
                    'caption' => 'Attendance Geofencing, Batch Scheduling & Mobile Workflow',
                    'order'   => 3,
                ],
            ]);
        }
        // ── Technical Skills & Stack ─────────────────────────────────
        $skills = [
            // Backend
            ['name' => 'Laravel', 'category' => 'backend', 'proficiency' => 95, 'icon' => '🔴', 'experience' => '5+ Years', 'order' => 1, 'is_featured' => true],
            ['name' => 'PHP 8.3+', 'category' => 'backend', 'proficiency' => 92, 'icon' => '🐘', 'experience' => '5+ Years', 'order' => 2, 'is_featured' => true],
            ['name' => 'RESTful APIs', 'category' => 'backend', 'proficiency' => 94, 'icon' => '🔗', 'experience' => '4+ Years', 'order' => 3, 'is_featured' => true],
            ['name' => 'Queue Workers', 'category' => 'backend', 'proficiency' => 88, 'icon' => '⚡', 'experience' => '3+ Years', 'order' => 4, 'is_featured' => false],

            // Frontend
            ['name' => 'Tailwind CSS', 'category' => 'frontend', 'proficiency' => 95, 'icon' => '🎨', 'experience' => '4+ Years', 'order' => 5, 'is_featured' => true],
            ['name' => 'JavaScript (ES6+)', 'category' => 'frontend', 'proficiency' => 90, 'icon' => '⚡', 'experience' => '5+ Years', 'order' => 6, 'is_featured' => true],
            ['name' => 'Alpine.js / Vue', 'category' => 'frontend', 'proficiency' => 88, 'icon' => '⚛️', 'experience' => '3+ Years', 'order' => 7, 'is_featured' => true],
            ['name' => 'HTML5 & CSS3', 'category' => 'frontend', 'proficiency' => 98, 'icon' => '📄', 'experience' => '6+ Years', 'order' => 8, 'is_featured' => false],

            // Database
            ['name' => 'MySQL', 'category' => 'database', 'proficiency' => 92, 'icon' => '🐬', 'experience' => '5+ Years', 'order' => 9, 'is_featured' => true],
            ['name' => 'Redis Caching', 'category' => 'database', 'proficiency' => 85, 'icon' => '⚡', 'experience' => '3+ Years', 'order' => 10, 'is_featured' => true],
            ['name' => 'Eloquent ORM', 'category' => 'database', 'proficiency' => 96, 'icon' => '🗄️', 'experience' => '5+ Years', 'order' => 11, 'is_featured' => false],

            // DevOps & Cloud
            ['name' => 'Git & GitHub', 'category' => 'devops', 'proficiency' => 92, 'icon' => '🔀', 'experience' => '5+ Years', 'order' => 12, 'is_featured' => true],
            ['name' => 'Docker & Containers', 'category' => 'devops', 'proficiency' => 82, 'icon' => '🐳', 'experience' => '2+ Years', 'order' => 13, 'is_featured' => true],
            ['name' => 'CI/CD Pipelines', 'category' => 'devops', 'proficiency' => 84, 'icon' => '🔄', 'experience' => '3+ Years', 'order' => 14, 'is_featured' => false],

            // Tools & Architecture
            ['name' => 'MVC & Clean Code', 'category' => 'tools', 'proficiency' => 95, 'icon' => '🏛️', 'experience' => '5+ Years', 'order' => 15, 'is_featured' => true],
            ['name' => 'Postman & Swagger', 'category' => 'tools', 'proficiency' => 90, 'icon' => '📜', 'experience' => '4+ Years', 'order' => 16, 'is_featured' => false],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(['name' => $skill['name']], $skill);
        }

        // ── Site Branding Settings ──────────────────────────────────
        $defaultBrandImg = 'images/shahzad-ali.png';
        \App\Models\Setting::updateOrCreate(['key' => 'hero_image'], ['value' => $defaultBrandImg]);
        \App\Models\Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $defaultBrandImg]);
        \App\Models\Setting::updateOrCreate(['key' => 'favicon'], ['value' => $defaultBrandImg]);
        \App\Models\Setting::updateOrCreate(['key' => 'developer_name'], ['value' => 'Shahzad Ali']);
        \App\Models\Setting::updateOrCreate(['key' => 'developer_role'], ['value' => 'Senior Full-Stack Web Architect']);
        \App\Models\Setting::updateOrCreate(['key' => 'hero_tagline'], ['value' => 'Engineering Scalable Web Applications & Digital Experiences']);

        // ── Sample Contact Inquiries ─────────────────────────────────
        Message::firstOrCreate(
            ['email' => 'sarah.j@enterprise-tech.com', 'subject' => 'Enterprise SaaS Platform Development Inquiry'],
            [
                'name'       => 'Sarah Jenkins',
                'message'    => "Hello Shahzad,\n\nWe came across your portfolio and were impressed with your CV-BUILDER case study. We are looking to engineer a custom SaaS portal for automated document processing and candidate evaluation with high-performance Laravel backend and modern frontend.\n\nCould we arrange a discovery call to discuss technical scope and availability?",
                'is_read'    => false,
                'created_at' => now()->subHours(3),
            ]
        );

        Message::firstOrCreate(
            ['email' => 'alex.r@techstart.io', 'subject' => 'Laravel REST API & MySQL Optimization Audit'],
            [
                'name'       => 'Alex Rivera',
                'message'    => "Hi Shahzad,\n\nI need an experienced Laravel architect to review and optimize our Redis caching, queue workers, and relational database schema.\n\nLooking forward to speaking with you.",
                'is_read'    => true,
                'replied_at' => now()->subDay(),
                'created_at' => now()->subDays(2),
            ]
        );
    }
}
