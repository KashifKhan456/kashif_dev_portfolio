<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $experiences = [
            [
                'company' => 'Meshsq Pvt Ltd',
                'role' => 'Full Stack Developer',
                'period' => 'April 20, 2026 – Present',
                'location' => 'Rawalpindi, Pakistan',
                'work_type' => 'Full-time',
                'description' => 'Contributing to the end-to-end engineering of DocHyve, an enterprise web platform designed to streamline digital workflows and collaborative operations. Responsible for designing and maintaining robust backend RESTful APIs, complex business logic, and transactional database architecture, while constructing reusable, high-performance UI components with a strong focus on usability and system responsiveness. Actively collaborate across agile sprints to translate product requirements into maintainable features, conduct thorough code reviews, and enforce rigorous software engineering standards.',
                'highlights' => null,
                'technologies' => ['Laravel', 'React.js', 'Tailwind CSS', 'RESTful APIs', 'Git'],
                'type' => 'work',
                'order' => 1,
            ],
            [
                'company' => 'Goritmi Pvt Ltd',
                'role' => 'Senior Software Developer | Team Lead',
                'period' => 'Sept 1, 2025 – 1 April, 2026',
                'location' => 'Peshawar, Pakistan',
                'work_type' => 'Full-time',
                'description' => 'Led a cross-functional engineering team in architecting and delivering an enterprise Electronic Point of Sale (EPOS) and Kitchen Display System engineered for high-volume hospitality environments. Spearheaded core modules including real-time order dispatch, cashier shift auditing, dynamic promotional engines, automated thermal receipt printing, and live inventory depletion tracking. Engineered bi-directional WebSocket channels for real-time customer and kitchen status synchronizations, integrated secure payment gateways, and dramatically enhanced throughput via advanced database indexing, caching strategies, and modular clean architecture.',
                'highlights' => null,
                'technologies' => ['Laravel', 'Vue.js', 'Tailwind CSS', 'Stripe', 'SendGrid', 'AWS S3', 'EPOS System', 'RESTful APIs'],
                'type' => 'work',
                'order' => 2,
            ],
            [
                'company' => 'Cloud Rexpo',
                'role' => 'Laravel Developer',
                'period' => 'May, 2025 – 30 Aug, 2025',
                'location' => 'Rawalpindi, Pakistan',
                'work_type' => 'Full-time',
                'description' => 'Contributed to the engineering and modernization of a high-traffic Real Estate CRM platform. Collaborated closely with senior developers to refactor legacy codebases, resolve complex system bottlenecks, and integrate critical third-party services including automated payment handling, bidirectional Google Calendar scheduling, cloud asset storage, and transaction-driven email notifications. Architected a granular role-based access control (RBAC) engine alongside real-time user notification queues, significantly accelerating response times and improving cross-team operational transparency.',
                'highlights' => null,
                'technologies' => ['Laravel', 'Stripe', 'Google Calendar', 'AWS S3', 'SendGrid', 'RBAC', 'RESTful APIs'],
                'type' => 'work',
                'order' => 3,
            ],
            [
                'company' => 'Techinn360',
                'role' => 'Full Stack Developer',
                'period' => 'June, 2024 – May 2025',
                'location' => 'Rawalpindi, Pakistan',
                'work_type' => 'Full-time',
                'description' => 'Architected and deployed multiple customer-facing web platforms, including an international automotive e-commerce marketplace serving clients across the UAE and GCC region, a real-time speed auction bidding engine, and an interactive learning management system. Focused heavily on high-traffic performance optimization, complex frontend state orchestration, and search visibility, achieving a perfect 100 SEO score, 96 Best Practices, and 93 Accessibility rating on Google Lighthouse under WCAG 2.2 guidelines. Championed Test-Driven Development (TDD) and iterative Scrum ceremonies to consistently ship reliable, production-ready releases.',
                'highlights' => null,
                'technologies' => ['Laravel', 'Vue.js', 'React', 'TDD', 'Agile/Scrum', 'WCAG 2.2', 'SEO', 'E-Commerce'],
                'type' => 'work',
                'order' => 4,
            ],
            [
                'company' => 'TriTech Soft Solutions',
                'role' => 'Junior Laravel Developer',
                'period' => 'March, 2023 – June 2024',
                'location' => 'Mardan, Pakistan',
                'work_type' => 'Full-time',
                'description' => 'Developed and maintained dynamic web applications and core customer relationship management (CRM) systems with an emphasis on reliable API architectures and database efficiency. Built and documented modular RESTful API endpoints, implemented transactional business logic, and designed interactive user interfaces that improved client workflow productivity. Managed schema migrations, optimized relational database queries, and collaborated actively across Git version-controlled agile environments to maintain high code quality.',
                'highlights' => null,
                'technologies' => ['Laravel', 'JavaScript', 'React.js', 'Vue.js', 'RESTful APIs', 'Git', 'MySQL'],
                'type' => 'work',
                'order' => 5,
            ],
            [
                'company' => 'National Freelancing Training Program (NFTP)',
                'role' => 'Full Stack Training',
                'period' => 'Dec 09, 2022 – March 2023',
                'location' => 'Mardan, Pakistan',
                'work_type' => 'Certification',
                'description' => 'Completed comprehensive software engineering and freelancing training focusing on modern full-stack web architectures, industry coding standards, and agile project delivery. Developed hands-on technical proficiencies in web applications, API integrations, collaborative Git workflows, and client-centric project management.',
                'highlights' => null,
                'technologies' => ['Full Stack Development', 'PHP', 'JavaScript', 'Freelancing', 'Project Management'],
                'type' => 'certification',
                'order' => 6,
            ],
            [
                'company' => 'University of Engineering and Technology Mardan',
                'role' => 'Bachelor of Computer Software Engineering',
                'period' => 'Oct, 2020 – June 2024',
                'location' => 'Mardan, Pakistan',
                'work_type' => 'Degree',
                'description' => 'Graduated with a Bachelor of Computer Software Engineering, establishing a deep technical foundation in software architecture, algorithms, data structures, relational database management systems, and object-oriented software engineering principles. Completed hands-on coursework and capstone projects in distributed systems and modern web technologies.',
                'highlights' => null,
                'technologies' => ['Software Engineering', 'Algorithms', 'Databases', 'Git', 'Web Development'],
                'type' => 'education',
                'order' => 7,
            ],
        ];

        Experience::truncate();
        foreach ($experiences as $expData) {
            Experience::create($expData);
        }
    }
}
