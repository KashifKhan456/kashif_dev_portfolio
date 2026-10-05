<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Backend
            ['name' => 'Laravel (PHP)', 'category' => 'Backend', 'proficiency' => 95, 'icon' => 'Server', 'order' => 1],
            ['name' => 'Node.js & Express.js', 'category' => 'Backend', 'proficiency' => 88, 'icon' => 'Server', 'order' => 2],
            ['name' => 'RESTful API Design', 'category' => 'Backend', 'proficiency' => 95, 'icon' => 'Workflow', 'order' => 3],
            // Frontend
            ['name' => 'Vue.js 3 & Inertia.js', 'category' => 'Frontend', 'proficiency' => 95, 'icon' => 'Code', 'order' => 4],
            ['name' => 'React.js & Redux', 'category' => 'Frontend', 'proficiency' => 92, 'icon' => 'Code', 'order' => 5],
            ['name' => 'JavaScript (ES6+)', 'category' => 'Frontend', 'proficiency' => 95, 'icon' => 'Code', 'order' => 6],
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'proficiency' => 98, 'icon' => 'Palette', 'order' => 7],
            ['name' => 'HTML5 & CSS3', 'category' => 'Frontend', 'proficiency' => 98, 'icon' => 'Palette', 'order' => 8],
            // Databases
            ['name' => 'MySQL', 'category' => 'Database/DevOps', 'proficiency' => 92, 'icon' => 'Database', 'order' => 9],
            ['name' => 'Redis', 'category' => 'Database/DevOps', 'proficiency' => 88, 'icon' => 'Database', 'order' => 10],
            ['name' => 'MongoDB', 'category' => 'Database/DevOps', 'proficiency' => 85, 'icon' => 'Database', 'order' => 11],
            // Cloud & DevOps
            ['name' => 'AWS (S3, EC2)', 'category' => 'Database/DevOps', 'proficiency' => 88, 'icon' => 'Cloud', 'order' => 12],
            ['name' => 'Docker & CI/CD', 'category' => 'Database/DevOps', 'proficiency' => 85, 'icon' => 'Container', 'order' => 13],
            ['name' => 'Linux & Nginx', 'category' => 'Database/DevOps', 'proficiency' => 88, 'icon' => 'Terminal', 'order' => 14],
            // Architecture & Tools
            ['name' => 'Clean Architecture & MVC', 'category' => 'Tools', 'proficiency' => 94, 'icon' => 'Layers', 'order' => 15],
            ['name' => 'Git & GitHub', 'category' => 'Tools', 'proficiency' => 96, 'icon' => 'GitBranch', 'order' => 16],
            ['name' => 'TDD & WCAG 2.2 Accessibility', 'category' => 'Tools', 'proficiency' => 90, 'icon' => 'CheckCircle', 'order' => 17],
            ['name' => 'Agile / Scrum Leadership', 'category' => 'Tools', 'proficiency' => 92, 'icon' => 'Users', 'order' => 18],
        ];

        Skill::truncate();
        foreach ($skills as $skillData) {
            Skill::create($skillData);
        }
    }
}
