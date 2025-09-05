<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Advisor;
use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get available fields and advisors
        $fields = Field::all();
        $advisors = Advisor::all();

        if ($fields->isEmpty() || $advisors->isEmpty()) {
            $this->command->warn('Fields or Advisors not found. Please run FieldSeeder and AdvisorSeeder first.');
            return;
        }

        $programs = [
            // Web Development Programs
            [
                'name' => 'Full-Stack Web Development Bootcamp',
                'description' => 'Comprehensive course covering HTML, CSS, JavaScript, React, Node.js, and database management. Perfect for beginners wanting to become full-stack developers.',
                'hours' => '480',
                'start_date' => '2025-01-15',
                'end_date' => '2025-04-15',
                'type' => 'paid',
                'price' => 2500,
                'number' => 25,
                'duration' => 'months',
                'level' => 'beginner',
                'language' => 'English',
                'field_name' => 'Web Development',
                'image' => 'programs/fullstack-bootcamp.jpg'
            ],
            [
                'name' => 'Advanced React & Node.js Development',
                'description' => 'Advanced concepts in React hooks, context, Redux, Node.js APIs, and microservices architecture.',
                'hours' => '200',
                'start_date' => '2025-02-01',
                'end_date' => '2025-03-15',
                'type' => 'paid',
                'price' => 1200,
                'number' => 20,
                'duration' => 'weeks',
                'level' => 'intermediate',
                'language' => 'English',
                'field_name' => 'Web Development',
                'image' => 'programs/react-nodejs.jpg'
            ],

            // Mobile App Development
            [
                'name' => 'iOS App Development with Swift',
                'description' => 'Learn to build native iOS applications using Swift, UIKit, and Core Data. Includes app store deployment.',
                'hours' => '300',
                'start_date' => '2025-01-20',
                'end_date' => '2025-04-20',
                'type' => 'paid',
                'price' => 1800,
                'number' => 18,
                'duration' => 'months',
                'level' => 'beginner',
                'language' => 'English',
                'field_name' => 'Mobile App Development',
                'image' => 'programs/ios-swift.jpg'
            ],
            [
                'name' => 'Android Development with Kotlin',
                'description' => 'Modern Android development using Kotlin, Jetpack Compose, and Material Design principles.',
                'hours' => '280',
                'start_date' => '2025-02-10',
                'end_date' => '2025-05-10',
                'type' => 'paid',
                'price' => 1600,
                'number' => 22,
                'duration' => 'months',
                'level' => 'intermediate',
                'language' => 'English',
                'field_name' => 'Mobile App Development',
                'image' => 'programs/android-kotlin.jpg'
            ],

            // Software Development
            [
                'name' => 'Python Programming Fundamentals',
                'description' => 'Learn Python from scratch: variables, loops, functions, OOP, and basic algorithms.',
                'hours' => '120',
                'start_date' => '2025-01-10',
                'end_date' => '2025-02-10',
                'type' => 'free',
                'price' => null,
                'number' => 30,
                'duration' => 'weeks',
                'level' => 'beginner',
                'language' => 'English',
                'field_name' => 'Software Development',
                'image' => 'programs/python-fundamentals.jpg'
            ],
            [
                'name' => 'Advanced Python & Data Structures',
                'description' => 'Advanced Python concepts, algorithms, data structures, and problem-solving techniques.',
                'hours' => '180',
                'start_date' => '2025-03-01',
                'end_date' => '2025-05-01',
                'type' => 'paid',
                'price' => 900,
                'number' => 20,
                'duration' => 'months',
                'level' => 'intermediate',
                'language' => 'English',
                'field_name' => 'Software Development',
                'image' => 'programs/python-advanced.jpg'
            ],

            // Data Analysis
            [
                'name' => 'Data Analysis with Python & Pandas',
                'description' => 'Learn data manipulation, analysis, and visualization using Python, Pandas, and Matplotlib.',
                'hours' => '160',
                'start_date' => '2025-02-15',
                'end_date' => '2025-04-15',
                'type' => 'paid',
                'price' => 800,
                'number' => 25,
                'duration' => 'weeks',
                'level' => 'intermediate',
                'language' => 'English',
                'field_name' => 'Data Analysis',
                'image' => 'programs/data-analysis-python.jpg'
            ],

            // Artificial Intelligence
            [
                'name' => 'Machine Learning Fundamentals',
                'description' => 'Introduction to machine learning algorithms, supervised and unsupervised learning, and model evaluation.',
                'hours' => '240',
                'start_date' => '2025-03-01',
                'end_date' => '2025-06-01',
                'type' => 'paid',
                'price' => 1500,
                'number' => 20,
                'duration' => 'months',
                'level' => 'intermediate',
                'language' => 'English',
                'field_name' => 'Machine Learning',
                'image' => 'programs/machine-learning.jpg'
            ],

            // Cloud Computing
            [
                'name' => 'AWS Cloud Practitioner',
                'description' => 'AWS fundamentals, services overview, security, and best practices for cloud computing.',
                'hours' => '80',
                'start_date' => '2025-01-25',
                'end_date' => '2025-02-25',
                'type' => 'paid',
                'price' => 600,
                'number' => 28,
                'duration' => 'weeks',
                'level' => 'beginner',
                'language' => 'English',
                'field_name' => 'Cloud Computing',
                'image' => 'programs/aws-cloud.jpg'
            ],

            // Cybersecurity
            [
                'name' => 'Cybersecurity Fundamentals',
                'description' => 'Introduction to cybersecurity concepts, threats, vulnerabilities, and basic defense strategies.',
                'hours' => '140',
                'start_date' => '2025-02-20',
                'end_date' => '2025-04-20',
                'type' => 'paid',
                'price' => 1000,
                'number' => 24,
                'duration' => 'weeks',
                'level' => 'beginner',
                'language' => 'English',
                'field_name' => 'Information Security',
                'image' => 'programs/cybersecurity.jpg'
            ],

            // DevOps
            [
                'name' => 'DevOps & CI/CD Pipeline',
                'description' => 'Learn Docker, Kubernetes, Jenkins, and GitLab CI/CD for modern software development workflows.',
                'hours' => '200',
                'start_date' => '2025-03-15',
                'end_date' => '2025-06-15',
                'type' => 'paid',
                'price' => 1400,
                'number' => 18,
                'duration' => 'months',
                'level' => 'intermediate',
                'language' => 'English',
                'field_name' => 'DevOps',
                'image' => 'programs/devops-cicd.jpg'
            ],

            // Database Administration
            [
                'name' => 'SQL Database Management',
                'description' => 'Comprehensive SQL training covering database design, queries, optimization, and administration.',
                'hours' => '120',
                'start_date' => '2025-01-30',
                'end_date' => '2025-03-30',
                'type' => 'paid',
                'price' => 700,
                'number' => 26,
                'duration' => 'weeks',
                'level' => 'beginner',
                'language' => 'English',
                'field_name' => 'Database Administration',
                'image' => 'programs/sql-database.jpg'
            ],

            // Network Administration
            [
                'name' => 'Network Security & Administration',
                'description' => 'Network protocols, security, monitoring, and administration best practices.',
                'hours' => '180',
                'start_date' => '2025-02-25',
                'end_date' => '2025-05-25',
                'type' => 'paid',
                'price' => 1100,
                'number' => 22,
                'duration' => 'months',
                'level' => 'intermediate',
                'language' => 'English',
                'field_name' => 'Network Administration',
                'image' => 'programs/network-security.jpg'
            ],

            // IT Project Management
            [
                'name' => 'Agile Project Management',
                'description' => 'Learn Scrum, Kanban, and Agile methodologies for IT project management.',
                'hours' => '100',
                'start_date' => '2025-03-10',
                'end_date' => '2025-04-10',
                'type' => 'paid',
                'price' => 800,
                'number' => 30,
                'duration' => 'weeks',
                'level' => 'intermediate',
                'language' => 'English',
                'field_name' => 'IT Project Management',
                'image' => 'programs/agile-project.jpg'
            ],

            // Arabic Language Programs
            [
                'name' => 'تطوير الويب للمبتدئين',
                'description' => 'دورة شاملة في تطوير الويب تغطي HTML و CSS و JavaScript للمبتدئين',
                'hours' => '200',
                'start_date' => '2025-02-01',
                'end_date' => '2025-04-01',
                'type' => 'free',
                'price' => null,
                'number' => 35,
                'duration' => 'weeks',
                'level' => 'beginner',
                'language' => 'Arabic',
                'field_name' => 'Web Development',
                'image' => 'programs/web-arabic.jpg'
            ],

            [
                'name' => 'برمجة Python باللغة العربية',
                'description' => 'تعلم أساسيات البرمجة بلغة Python مع أمثلة عملية وتطبيقات',
                'hours' => '150',
                'start_date' => '2025-01-15',
                'end_date' => '2025-03-15',
                'type' => 'free',
                'price' => null,
                'number' => 40,
                'duration' => 'weeks',
                'level' => 'beginner',
                'language' => 'Arabic',
                'field_name' => 'Software Development',
                'image' => 'programs/python-arabic.jpg'
            ],

            // French Language Programs
            [
                'name' => 'Développement Web Frontend',
                'description' => 'Apprenez HTML, CSS et JavaScript pour créer des sites web modernes et responsifs.',
                'hours' => '180',
                'start_date' => '2025-02-15',
                'end_date' => '2025-04-15',
                'type' => 'paid',
                'price' => 900,
                'number' => 20,
                'duration' => 'weeks',
                'level' => 'beginner',
                'language' => 'French',
                'field_name' => 'Web Development',
                'image' => 'programs/web-development-fr.jpg'
            ],

            // Additional Specialized Programs
            [
                'name' => 'Blockchain Development Fundamentals',
                'description' => 'Introduction to blockchain technology, smart contracts, and decentralized applications.',
                'hours' => '160',
                'start_date' => '2025-04-01',
                'end_date' => '2025-06-01',
                'type' => 'paid',
                'price' => 1200,
                'number' => 15,
                'duration' => 'months',
                'level' => 'advanced',
                'language' => 'English',
                'field_name' => 'Software Development',
                'image' => 'programs/blockchain.jpg'
            ],

            [
                'name' => 'UI/UX Design for Developers',
                'description' => 'Learn design principles, user research, wireframing, and prototyping for better user experiences.',
                'hours' => '140',
                'start_date' => '2025-03-20',
                'end_date' => '2025-05-20',
                'type' => 'paid',
                'price' => 950,
                'number' => 18,
                'duration' => 'weeks',
                'level' => 'intermediate',
                'language' => 'English',
                'field_name' => 'Web Development',
                'image' => 'programs/ui-ux-design.jpg'
            ],

            [
                'name' => 'Game Development with Unity',
                'description' => 'Create 2D and 3D games using Unity engine, C# programming, and game design principles.',
                'hours' => '240',
                'start_date' => '2025-04-15',
                'end_date' => '2025-07-15',
                'type' => 'paid',
                'price' => 1400,
                'number' => 20,
                'duration' => 'months',
                'level' => 'intermediate',
                'language' => 'English',
                'field_name' => 'Software Development',
                'image' => 'programs/game-development.jpg'
            ],

            [
                'name' => 'Data Science with R',
                'description' => 'Statistical analysis, data visualization, and machine learning using R programming language.',
                'hours' => '200',
                'start_date' => '2025-05-01',
                'end_date' => '2025-07-01',
                'type' => 'paid',
                'price' => 1100,
                'number' => 22,
                'duration' => 'months',
                'level' => 'intermediate',
                'language' => 'English',
                'field_name' => 'Data Analysis',
                'image' => 'programs/data-science-r.jpg'
            ],
        ];

        foreach ($programs as $programData) {
            // Find the field by name
            $field = $fields->where('name', $programData['field_name'])->first();
            
            if (!$field) {
                $this->command->warn("Field '{$programData['field_name']}' not found, skipping program '{$programData['name']}'");
                continue;
            }

            // Remove field_name from data and add field_id
            unset($programData['field_name']);
            $programData['field_id'] = $field->id;
            
            // Assign random advisor
            $programData['advisor_id'] = $advisors->random()->id;

            // Create the program
            Program::create($programData);
        }

        $this->command->info('Programs seeded successfully!');
        $this->command->info('Total programs created: ' . count($programs));
        
        // Display summary by field
        $this->command->info("\n📊 Programs by Field:");
        $fieldCounts = Program::with('field')
            ->get()
            ->groupBy('field.name')
            ->map(function($programs) {
                return $programs->count();
            });
        
        foreach ($fieldCounts as $fieldName => $count) {
            $this->command->info("   • {$fieldName}: {$count} programs");
        }
        
        // Display summary by level
        $this->command->info("\n📊 Programs by Level:");
        $levelCounts = Program::all()->groupBy('level')->map(function($programs) {
            return $programs->count();
        });
        
        foreach ($levelCounts as $level => $count) {
            $this->command->info("   • {$level}: {$count} programs");
        }
        
        // Display summary by language
        $this->command->info("\n📊 Programs by Language:");
        $languageCounts = Program::all()->groupBy('language')->map(function($programs) {
            return $programs->count();
        });
        
        foreach ($languageCounts as $language => $count) {
            $this->command->info("   • {$language}: {$count} programs");
        }
    }
}
