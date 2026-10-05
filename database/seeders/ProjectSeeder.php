<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'EPOS System – Restaurant & Cafe (Multi-Platform)',
                'slug' => 'epos-restaurant-cafe-system',
                'category' => 'Laravel & Vue',
                'summary' => 'A multi-platform Electronic Point of Sale (EPOS) & Kitchen Display System engineered for high-volume hospitality with real-time WebSocket order sync, receipt printing, and role-based access.',
                'description' => '<p>A comprehensive, multi-platform Electronic Point of Sale (EPOS) system engineered specifically for restaurants and cafes. The system delivers unified synchronization between web management dashboards, Flutter-based mobile tablets for waitstaff, desktop POS terminals for cashiers, and real-time Kitchen Display Systems (KDS).</p><h3>Core Engineering Highlights</h3><ul><li><strong>Cross-Platform Synchronization:</strong> Real-time order dispatch and ticket updates across web, mobile, and desktop terminals via WebSockets and Laravel Echo.</li><li><strong>Multi-Channel Order Management:</strong> Streamlined processing for Dine-in, Takeaway, and Delivery workflows with automated kitchen routing and ticket timers.</li><li><strong>Hardware & Receipt Integration:</strong> ESC/POS thermal printer integration for kitchen chits, guest receipts, and cash drawer triggers.</li><li><strong>Inventory & Batch Tracking:</strong> Ingredient-level stock depletion, batch management, supplier tracking, and automated expiration/low-stock alerts.</li><li><strong>Fine-Grained RBAC:</strong> Comprehensive role-based access control (Admin, Manager, Cashier, Chef, Waiter, Inventory Staff) with fast PIN-code switching for high-tempo shifts.</li><li><strong>Table & Floor Plan Management:</strong> Visual table layout, reservation engine, and live table occupancy tracking.</li></ul><h3>Architecture & Tech Stack</h3><p>Built on <strong>Laravel 12</strong> and <strong>Vue 3</strong> with <strong>Inertia.js</strong>, paired with cross-platform <strong>Flutter</strong> clients for iOS, Android, and Windows desktop. Secure API communication is driven by <strong>Laravel Sanctum</strong>, with <strong>MySQL</strong> persistence and <strong>Stripe</strong> payment integration.</p>',
                'image_path' => '/images/epos-system.png',
                'tech_stack' => ['Laravel 12', 'Vue 3', 'Inertia.js', 'Flutter', 'MySQL', 'WebSockets', 'Tailwind CSS', 'Stripe'],
                'demo_url' => 'https://www.goritmi.co.uk',
                'github_url' => 'https://github.com/Goritmi-Global/epos-system',
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'title' => 'ShopAuto – Auto Parts & Off-Road E-Commerce Platform',
                'slug' => 'shopauto-auto-parts-ecommerce',
                'category' => 'Fullstack',
                'summary' => 'A high-performance automotive e-commerce and off-road parts marketplace in the UAE featuring dynamic vehicle fitment filtering, shipping calculations, and admin order fulfillment.',
                'description' => '<p>ShopAuto is a premier automotive spare parts and 4x4 off-road modifications e-commerce platform serving the UAE and GCC region. Engineered with a scalable Laravel and Inertia.js architecture, the application delivers lightning-fast part discovery, vehicle-specific fitment verification, and streamlined checkout flows.</p><h3>Key Features & Architectural Highlights</h3><ul><li><strong>Vehicle Fitment Filtering Engine:</strong> Interactive multi-tier part search filtering by vehicle manufacturer, model, year, and trim variant to ensure 100% component compatibility.</li><li><strong>Comprehensive E-Commerce Suite:</strong> Real-time cart management, dynamic location-based shipping calculation across Emirates, multi-currency support, and automated tax invoicing.</li><li><strong>Customer Account & Order Tracking:</strong> Real-time delivery timeline tracking, customer order history, wishlists, and verified buyer product reviews.</li><li><strong>Administrative Operations Suite:</strong> Full-featured back-office management for product catalog (SKU, brand, category, vehicle mapping), automated order processing, PDF invoice generation, and customer communication workflows.</li></ul><h3>Technology Stack</h3><p>Engineered using <strong>Laravel</strong>, <strong>Vue.js 3</strong> with <strong>Inertia.js</strong>, <strong>Ziggy</strong> routing, <strong>Tailwind CSS</strong>, and <strong>MySQL</strong> with Redis caching for rapid catalog querying and responsive performance.</p>',
                'image_path' => '/images/shopauto.png',
                'tech_stack' => ['Laravel', 'Vue 3', 'Inertia.js', 'Tailwind CSS', 'MySQL', 'Ziggy', 'Redis'],
                'demo_url' => 'https://shopauto.ae/',
                'github_url' => null,
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'title' => 'MedSync PRO – Pharmacy & Clinical Healthcare Management System',
                'slug' => 'medsync-pro',
                'category' => 'Laravel & Vue',
                'summary' => 'An enterprise-grade Pharmacy & Healthcare Management System bridging clinical SOAP encounters, hierarchical multi-unit pharmaceutical inventory, high-velocity POS with ESC/POS thermal printing, and B2B wholesale distribution.',
                'description' => '<p>MedSync PRO is a next-generation, high-performance Pharmacy & Healthcare Management System engineered to bridge the gap between clinical decision-making and pharmaceutical supply chain management. Built on a "Healthcare First" architectural philosophy, every transaction is treated as an integrated medical event—synchronizing clinical consultation encounters, multi-packaging inventory depletion, patient credit ledgers, and regulatory compliance in real time.</p><h3>Core Engineering & Architectural Highlights</h3><ul><li><strong>Clinical Care & SOAP Encounters:</strong> Comprehensive patient master registry, appointment queue lifecycle (Scheduled &rarr; Checked-In &rarr; Completed), standardized clinical SOAP notes (Subjective, Objective, Assessment, Plan), and persistent physiological vitals telemetry (BP, Temperature, Pulse, SpO2, Weight).</li><li><strong>Hierarchical Multi-Unit Pharmaceutical Engine:</strong> Dynamic packaging conversion engine supporting Primary (Boxes), Secondary (Strips), and Base units (Tablets/Vials) with real-time decimal precision restocking and return calculations.</li><li><strong>High-Velocity Retail POS Terminal:</strong> Native HID barcode scanner support, instant search-as-you-type drug lookup, dynamic multi-unit pricing toggles, and multi-gateway checkout (Cash with automated change calculation, Stripe card processing, and digital wallets).</li><li><strong>Hardware & Cross-Platform ESC/POS Thermal Printing:</strong> Ultra-fast (<0.5s) native hardware printing bridge supporting Windows (via WMIC discovery) and Linux/CUPS with ghost-print prevention, zero-config default printer discovery, and silent background printing.</li><li><strong>FIFO Expiry & Enterprise Wastage Guard:</strong> First-In, First-Out batch rotation logic, expiry threshold monitoring (30/60/90 days), and multi-tier approval-gated wastage workflows with complete forensic accountability.</li><li><strong>Wholesale (B2B) Logistics & Automated Debt Recovery:</strong> Bulk commercial ordering with live price negotiation, DRAP/Govt license expiry guarding, credit limit enforcement, and automated background schedulers dispatching overdue PDF statements.</li><li><strong>Forensic Auditing & Granular RBAC:</strong> High-density Spatie role-based access control with 30+ granular permissions categorized across modules, adaptive sidebar synchronization, and persistent forensic logging (IP, User-Agent, monetary normalization).</li></ul><h3>Architecture & Tech Stack</h3><p>Engineered with <strong>Laravel 12</strong> and <strong>Vue 3</strong> via <strong>Inertia.js</strong>, styled with a high-contrast glassmorphic <strong>Tailwind CSS</strong> dark theme. Robust backend persistence is powered by <strong>MySQL</strong> with atomic transactions, paired with <strong>ESC/POS</strong> thermal printing connectors, <strong>Stripe</strong> integration, and <strong>Spatie Laravel Permission</strong>.</p>',
                'image_path' => '/images/medsync-pro.png',
                'tech_stack' => ['Laravel 12', 'Vue 3', 'Inertia.js', 'Tailwind CSS', 'MySQL', 'ESC/POS', 'Stripe', 'Spatie RBAC'],
                'demo_url' => 'https://medsync-pro.kashifkhan.dev',
                'github_url' => 'https://github.com/kashifkhan-dev/medsync-pro',
                'is_featured' => true,
                'order' => 3,
            ]
        ];

        // Clean up legacy placeholder if present
        Project::where('slug', 'healthcare-patient-portal')->delete();

        foreach ($projects as $projectData) {
            Project::updateOrCreate(
                ['slug' => $projectData['slug']],
                $projectData
            );
        }
    }
}
