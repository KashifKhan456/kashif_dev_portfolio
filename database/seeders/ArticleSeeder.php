<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, clear legacy placeholder articles so only the high-impact engineering articles remain
        Article::truncate();

        $articles = [
            [
                'title' => 'Architecting Real-Time EPOS Systems: WebSocket Order Dispatch & Low-Latency ESC/POS Hardware Integration',
                'slug' => 'architecting-realtime-epos-websockets-escpos-hardware',
                'excerpt' => 'Engineering an ultra-resilient restaurant point-of-sale and kitchen display system with sub-second order dispatching, offline-first transaction buffering, and raw ESC/POS thermal printing.',
                'content' => '<h2>The High-Stakes Nature of Hospitality Point of Sale</h2>
<p>In high-volume restaurant and hospitality environments, an electronic point of sale (EPOS) is not just a digital cash register—it is the mission-critical nervous system of the dining room. During peak Friday dinner rushes with hundreds of concurrent seatings, a dropped ticket or a three-second latency spike cascades immediately into kitchen bottlenecks, delayed food preparation, and frustrated diners.</p>
<p>When architecting modern multi-station EPOS and Kitchen Display Systems (KDS), off-the-shelf HTTP polling architectures fall apart. To guarantee split-second synchronization across floor terminals, kitchen expeditor screens, and receipt printers, we engineered a distributed, event-driven infrastructure centered around low-latency bi-directional WebSockets, deterministic offline queuing, and direct raw byte hardware streaming.</p>

<h3>1. Dual-Channel Real-Time Event Dispatch: Floor-to-Kitchen Pipeline</h3>
<p>Traditional REST polling imposes unacceptable server load and introduces unpredictable latency gaps. We designed a dual-tiered event dispatching pipeline:</p>
<ul>
    <li><strong>Primary Real-Time Pipe (WebSockets):</strong> Floor order submissions instantly broadcast targeted payloads across dedicated Redis pub/sub channels to kitchen display stations segmented by prep station (e.g., Grill, Cold Prep, Bar, Expeditor).</li>
    <li><strong>Fallback Heartbeat & State Reconciliation:</strong> In the event of temporary WiFi instability, client-side listeners execute monotonic version polling to detect missed sequence IDs and transparently backfill pending orders without requiring manual page refreshes.</li>
</ul>

<blockquote><strong>Architecture Principle:</strong> Kitchen screens must never query the server for complete order books. They consume differential mutation events (<code>ORDER_CREATED</code>, <code>ITEM_BUMPED</code>, <code>MODIFIER_UPDATED</code>) that update in-memory client state reactively in sub-100 milliseconds.</blockquote>

<h3>2. Direct-to-Hardware ESC/POS Thermal Printing via Raw Byte Streams</h3>
<p>A major failure mode in commercial POS installations is printer spooler lag. Operating system print dialogues introduce modal delays and render bitmap graphics that print slowly and unpredictably over network thermal printers.</p>
<p>Instead of relying on OS printer drivers, we built a specialized ESC/POS byte-compilation engine that generates raw hexadecimal command strings directly in the application layer:</p>
<pre><code>// Example ESC/POS low-level command composition for network thermal printers
$commands = [
    "\x1B\x40",          // Initialize printer (ESC @)
    "\x1B\x61\x01",      // Center justification
    "\x1D\x21\x11",      // Double width + height heading
    "KITCHEN EXPEDITE TICKET\n",
    "\x1D\x21\x00",      // Normal text font
    "Table: 14  |  Server: Alex M.  |  Cover: 4\n",
    str_repeat("-", 42) . "\n",
    "\x1B\x61\x00",      // Left justification
    "[x2] Dry-Aged Ribeye (Medium Rare)\n",
    "     * Sub Truffle Fries\n",
    "[x1] Pan-Seared Chilean Sea Bass\n",
    str_repeat("-", 42) . "\n",
    "\x1D\x56\x41\x03",  // Full cut with feed (GS V 65 3)
];
$socketPayload = implode(\'\', $commands);
$fp = fsockopen($printerIp, 9100, $errno, $errstr, 2.0);
fwrite($fp, $socketPayload);
fclose($fp);</code></pre>
<p>By streaming raw ESC/POS byte packets directly over TCP port <code>9100</code> to network receipt printers, ticket generation occurs in under 80 milliseconds—eliminating print dialogs entirely and ensuring crisp monospace formatting on standard 80mm thermal paper rolls.</p>

<h3>3. Offline-First Resilience & Conflict-Free Transaction Replay</h3>
<p>Network connectivity inside commercial kitchens is notoriously vulnerable to physical interference, walk-in coolers, and microwave radiation. A system that halts when disconnected is unacceptable in live operations.</p>
<p>We implemented a client-side IndexedDB persistence layer paired with a write-ahead log (WAL). If the POS terminal loses connectivity:</p>
<ul>
    <li>Floor waitstaff continue taking orders, entering seat modifiers, and closing split checks uninterrupted.</li>
    <li>Each mutation receives an idempotent UUIDv7 client timestamp and is stored in a local pending queue.</li>
    <li>Local thermal printers connected via USB/Serial or local subnet continue printing directly from the terminal.</li>
    <li>Upon connection restoration, an exponential-backoff synchronizer replays queued transactions sequentially against the backend API with optimistic locking checks.</li>
</ul>

<h3>Measurable Impact</h3>
<p>This architecture reduced average kitchen ticket arrival latency from 3.2 seconds down to 180 milliseconds, eliminated order duplication during network brownouts, and sustained 100% operational uptime across high-turnover multi-venue dining establishments.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1556742049-0a67c5574f73?auto=format&fit=crop&w=1200&q=80',
                'read_time' => 7,
                'tags' => ['EPOS Systems', 'WebSockets', 'Hardware Integration', 'Distributed Systems', 'Performance'],
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'views_count' => 348,
                'order' => 1,
            ],
            [
                'title' => 'Scaling Multi-Tier Automotive E-Commerce: Dynamic Vehicle Fitment & Achieving 100 Google Lighthouse',
                'slug' => 'scaling-automotive-ecommerce-fitment-engines-lighthouse-100',
                'excerpt' => 'How we engineered a sub-50ms Year/Make/Model compatibility lookup across 50,000+ automotive SKUs while achieving perfect 100 Google Lighthouse scores and WCAG 2.2 compliance.',
                'content' => '<h2>The Unique Complexity of Automotive E-Commerce</h2>
<p>Unlike apparel or standard retail where a customer selects a size and color, automotive e-commerce carries zero margin for fitment error. If a customer in Dubai orders an oil filter or ceramic brake rotor that does not precisely match their vehicle’s exact Year, Make, Model, Trim, and Engine variant, the cost of international returns and mechanic restocking fees quickly erodes profit margins.</p>
<p>When engineering high-throughput automotive platforms across the GCC region, we were tasked with solving two seemingly opposing challenges: providing an instant, multi-tier Year/Make/Model (YMM) compatibility engine across tens of thousands of complex SKUs, while simultaneously attaining a flawless <strong>100/100 Google Lighthouse</strong> score across Performance, Accessibility, Best Practices, and SEO.</p>

<h3>1. Solving the Combinatorial Explosion: The Vehicle Fitment Matrix</h3>
<p>In raw relational databases, mapping 50,000 products against 15,000 vehicle configurations generates over 750 million potential compatibility pairings. Naive multi-table joins (<code>products</code> &rarr; <code>product_fitments</code> &rarr; <code>engines</code> &rarr; <code>models</code> &rarr; <code>makes</code>) will quickly exhaust database memory and produce 800ms+ response times.</p>
<p>We engineered a denormalized composite indexing and bitmasking strategy:</p>
<ul>
    <li><strong>Hierarchical Vehicle Tree Caching:</strong> The complete vehicle ontology (Year &rarr; Make &rarr; Model &rarr; Engine) is pre-computed into compressed hierarchical JSON payloads cached at edge reverse proxies. Dynamic dropdowns populate in zero round-trips.</li>
    <li><strong>Bitwise Compatibility Indexes:</strong> For rapid product catalog filtering, vehicles are mapped to deterministic integer IDs. Compatibility verification executes via indexed integer range lookups rather than recursive string comparisons.</li>
    <li><strong>Pre-Computed Search Aggregations:</strong> Faceted search counts (e.g., "14 Air Filters compatible with 2022 Porsche 911 GT3") are maintained via asynchronous worker materialization, ensuring catalog queries execute in under 35 milliseconds.</li>
</ul>

<h3>2. The Path to Flawless 100/100 Google Lighthouse</h3>
<p>Achieving 100 across all four Google Lighthouse categories requires obsessive elimination of layout shifts, execution bottlenecks, and accessibility friction:</p>
<pre><code>// Performance Budget & Core Web Vitals Targets Met in Production:
- First Contentful Paint (FCP): 0.6s  [Target: < 1.8s]
- Largest Contentful Paint (LCP): 0.9s  [Target: < 2.5s]
- Total Blocking Time (TBT): 0ms      [Target: < 200ms]
- Cumulative Layout Shift (CLS): 0.00 [Target: < 0.1]
- Speed Index: 0.8s                   [Target: < 3.4s]</code></pre>

<p>Key optimizations implemented to achieve these numbers:</p>
<ul>
    <li><strong>Zero Cumulative Layout Shift (CLS = 0.00):</strong> All vehicle selectors, high-resolution automotive imagery, and price calculation widgets enforce strictly defined aspect-ratio containers and SVG skeleton placeholders to prevent DOM reflows during hydration.</li>
    <li><strong>Critical CSS Inlining & Dynamic Code Splitting:</strong> The critical rendering path loads minimal inline structural styling; non-essential interactive modules (interactive 3D exploded parts diagrams, review carousels) are lazy-loaded upon intersection observer trigger.</li>
    <li><strong>Modern Next-Gen Image Pipelines:</strong> High-resolution OEM parts diagrams are transformed into AVIF/WebP formats with responsive <code>srcset</code> attributes, reducing image payload sizes by 72% with zero perceptual fidelity loss.</li>
</ul>

<h3>3. WCAG 2.2 Level AA & Native Arabic (RTL) Layout Orchestration</h3>
<p>To serve enterprise institutional fleet buyers and retail customers across Saudi Arabia, the UAE, and Qatar, seamless accessibility and bilingual capability were mandatory:</p>
<ul>
    <li><strong>Complete Bi-Directional Layouts:</strong> Dynamic CSS logical properties (<code>margin-inline-start</code>, <code>padding-inline-end</code>) ensure flawless switching between English (LTR) and Arabic (RTL) without duplicating stylesheets or triggering repaint cascades.</li>
    <li><strong>Screen Reader Semantic Landmarks:</strong> Full compliance with WCAG 2.2 guidelines, providing descriptive ARIA live announcements as vehicle fitment status is updated (e.g., "Confirmed: This brake pad fits your 2021 Toyota Land Cruiser V8").</li>
</ul>

<h3>Business Outcomes</h3>
<p>The re-engineered platform achieved sub-50ms catalog lookups, increased organic SEO search visibility by 140% within 90 days due to the 100 Lighthouse benchmark, and drove down fitment-related return rates by over 68%.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1200&q=80',
                'read_time' => 8,
                'tags' => ['E-Commerce', 'Performance Optimization', 'Database Indexing', 'WCAG 2.2', 'SEO'],
                'is_published' => true,
                'published_at' => now()->subDays(6),
                'views_count' => 412,
                'order' => 2,
            ],
            [
                'title' => 'Mission-Critical Healthcare Systems: Clinical SOAP Encounters, Fractional Unit Math & FIFO Batch Expiry',
                'slug' => 'mission-critical-healthcare-soap-encounters-fifo-batch-expiry',
                'excerpt' => 'Architecting MedSync PRO: Designing audit-compliant clinical SOAP workflows, fractional pharmaceutical unit conversions, and automated FIFO/FEFO expiration depletion.',
                'content' => '<h2>Why Healthcare and Clinical ERPs Require Strict Engineering Rigor</h2>
<p>In standard business software, minor rounding errors in inventory or delayed record updates are mere bookkeeping inconveniences. In clinical healthcare and pharmacy operations, however, data errors carry legal, financial, and life-critical ramifications. Dispensing an expired pharmaceutical batch, losing track of clinical consultation histories, or improperly calculating fractional medication dosages is completely unacceptable.</p>
<p>When designing <strong>MedSync PRO</strong>—an integrated healthcare consultation and pharmaceutical inventory platform—we engineered the system from the ground up around clinical data immutability, automated regulatory compliance, and high-precision fractional dispensing logic.</p>

<h3>1. Structuring Clinical Consultations: The SOAP Architecture</h3>
<p>Clinical practitioners require a standardized, distraction-free workflow for documenting patient encounters while maintaining legally defensible, tamper-evident records. We implemented the clinical <strong>SOAP framework</strong> (Subjective, Objective, Assessment, Plan):</p>
<ul>
    <li><strong>Subjective:</strong> Captures the patient\'s stated chief complaints, history of present illness (HPI), and symptom progression in structured, searchable formats.</li>
    <li><strong>Objective:</strong> Validates vital signs (Blood Pressure, Heart Rate, SpO2, Blood Glucose) against physiological threshold constraints with instant visual warning indicators.</li>
    <li><strong>Assessment:</strong> Connects primary and differential clinical diagnoses with ICD-10 codification for automated insurance reconciliation.</li>
    <li><strong>Plan & Electronic Prescriptions:</strong> Directly links therapeutic recommendations to the dispensary catalog with automated drug-drug interaction warnings and allergy cross-checks.</li>
</ul>

<blockquote><strong>Forensic Clinical Audit Trails:</strong> In compliance with healthcare standards, once a SOAP encounter note is finalized and digitally signed by the attending physician, the record enters an immutable write-once state. Any subsequent addendum is stored as a timestamped revision block linked to the original encounter ID, preserving forensic legal validity.</blockquote>

<h3>2. The Fractional Unit Math Problem in Pharmaceutical Logistics</h3>
<p>Standard inventory software operates on discrete, whole-integer quantities. In a hospital pharmacy, however, medications are purchased, stocked, and dispensed in multiple packaging tiers:</p>
<pre><code>// The Multi-Tier Packaging Conversion Hierarchy:
1 Shipping Carton = 20 Master Boxes
1 Master Box     = 10 Blister Strips
1 Blister Strip  = 10 Tablets (Individual Dispensing Units)</code></pre>
<p>If a doctor prescribes <code>3 tablets</code>, a naive integer database that only tracks "boxes" is forced into floating-point math (e.g., <code>0.03 boxes</code>). Over thousands of prescriptions, IEEE 754 floating-point inaccuracies cause cumulative ghost inventory discrepancies.</p>
<p>We solved this by enforcing a <strong>Smallest Common Unit (SCU)</strong> architecture:</p>
<ul>
    <li>All inventory ledger records track stock exclusively in their fundamental indivisible unit (e.g., single tablet, milliliter, or vial) as 64-bit unsigned integers.</li>
    <li>Presentation layers dynamically decompose integers into user-friendly packaging tiers (e.g., <code>"2 Boxes, 3 Strips, 4 Tablets"</code>) for warehouse pickers and pharmacy staff.</li>
    <li>Dispensing operations deduct strictly at the SCU level, ensuring zero mathematical drift across millions of transactions.</li>
</ul>

<h3>3. Strict FEFO/FIFO Batch Expiration Allocation</h3>
<p>Dispensing pharmaceuticals requires strict adherence to <strong>FEFO (First-Expired, First-Out)</strong> logistics. MedSync PRO enforces automated batch-level depletion at the database level:</p>
<pre><code>// Database transaction allocating stock by closest expiration date
DB::transaction(function () use ($medicationId, $unitsNeeded) {
    $batches = MedicationBatch::where(\'medication_id\', $medicationId)
        ->where(\'remaining_units\', \'>\', 0)
        ->where(\'expiry_date\', \'>\', now())
        ->lockForUpdate()
        ->orderBy(\'expiry_date\', \'asc\')
        ->get();

    $remainingToFulfill = $unitsNeeded;
    foreach ($batches as $batch) {
        $deduct = min($batch->remaining_units, $remainingToFulfill);
        $batch->decrement(\'remaining_units\', $deduct);
        $remainingToFulfill -= $deduct;

        InventoryDepletionLog::create([
            \'batch_id\' => $batch->id,
            \'lot_number\' => $batch->lot_number,
            \'units_deducted\' => $deduct,
            \'expiry_date\' => $batch->expiry_date,
        ]);

        if ($remainingToFulfill === 0) break;
    }

    if ($remainingToFulfill > 0) {
        throw new InsufficientUnexpiredStockException("Insufficient unexpired stock available.");
    }
});</code></pre>
<p>Pessimistic row locking (<code>lockForUpdate()</code>) ensures that concurrent dispensary checkout lanes cannot oversell the same physical lot number, even during high-traffic clinic surges.</p>

<h3>Key Architectural Takeaways</h3>
<p>By engineering around atomic database transactions, indivisible unit quantification, and immutable audit logs, MedSync PRO eliminated stock discrepancy margins, automated statutory expiry reports, and delivered an enterprise-grade medical platform trusted by healthcare professionals.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80',
                'read_time' => 9,
                'tags' => ['Healthcare Tech', 'Inventory Logistics', 'Data Integrity', 'Audit Compliance', 'Domain Architecture'],
                'is_published' => true,
                'published_at' => now()->subDays(11),
                'views_count' => 529,
                'order' => 3,
            ],
            [
                'title' => 'Enterprise RBAC & Financial Auditing: Protecting Sensitive Workflows in High-Concurrency Platforms',
                'slug' => 'enterprise-rbac-forensic-auditing-concurrency',
                'excerpt' => 'Designing multi-tier permission matrices, tamper-evident double-entry audit trails, and distributed idempotency locks for secure commercial applications.',
                'content' => '<h2>The Baseline for Enterprise Security: Beyond Simple Role Flags</h2>
<p>In early-stage prototypes, developers often suffice with a rudimentary <code>is_admin</code> boolean column on the user table. But as platforms scale into enterprise commercial operations handling multi-million-dollar transactions, multi-branch operations, and third-party regulatory oversight, naive role checks become critical security liabilities.</p>
<p>Modern enterprise platforms require a defense-in-depth authorization and auditing architecture that answers three vital questions at any microsecond:</p>
<ol>
    <li>Does this authenticated principal hold verified authority to execute this exact action on this specific scoped entity?</li>
    <li>If network jitter causes the client to retry a financial mutation three times, will the system execute it exactly once?</li>
    <li>If an unauthorized adjustment occurs, does an immutable, tamper-evident audit trail exist that can withstand forensic examination?</li>
</ol>

<h3>1. Hierarchical, Context-Aware RBAC (Role-Based Access Control)</h3>
<p>Instead of hardcoded roles, we implement a decoupled permissions model where roles are simply bundles of atomic permissions (e.g., <code>inventory.adjust</code>, <code>pos.void_check</code>, <code>report.export_financials</code>). Furthermore, permissions are evaluated within hierarchical multi-tenant organizational boundaries:</p>
<ul>
    <li><strong>Tenant Isolation:</strong> A Store Manager role granted in "Downtown Branch" possesses zero privileges in "Airport Terminal", enforced automatically via global query scopes and middleware assertions.</li>
    <li><strong>Privilege Escalation Barriers:</strong> Users can never assign permissions or grant roles exceeding their own security clearance, preventing malicious lateral movement.</li>
    <li><strong>Dual-Authorization ("Four-Eyes" Principle):</strong> High-risk operations—such as writing off inventory over $1,000 or issuing manual customer refunds—require cryptographic secondary approval tokens from a supervising officer.</li>
</ul>

<h3>2. Distributed Idempotency: Eliminating Double Billing</h3>
<p>Under erratic mobile network conditions, client applications frequently time out before receiving a success response, prompting cashiers or customers to repeatedly click "Submit Payment". Without strict idempotency controls, this creates duplicate charges and balance discrepancies.</p>
<p>We engineered an atomic idempotency middleware utilizing distributed Redis locks and token hashes:</p>
<pre><code>// Client sends unique X-Idempotency-Key header with mutating requests
$idempotencyKey = $request->header(\'X-Idempotency-Key\');
$lockKey = "idempotency:lock:{$idempotencyKey}";

// Attempt to acquire atomic 15-second distributed lock
if (!Cache::lock($lockKey, 15)->get()) {
    return response()->json([
        \'error\' => \'Transaction already in progress. Please do not re-submit.\'
    ], 409);
}

// Check if cached response already exists for this exact key
if ($cachedResponse = Cache::get("idempotency:response:{$idempotencyKey}")) {
    return response()->json($cachedResponse[\'data\'], $cachedResponse[\'status\']);
}

// Execute the critical payment mutation inside an isolated DB transaction
$result = DB::transaction(function () use ($request) {
    return $this->paymentGateway->charge($request->validated());
});

// Cache final successful response for 24 hours
Cache::put("idempotency:response:{$idempotencyKey}", [
    \'status\' => 200,
    \'data\' => $result,
], 86400);</code></pre>
<p>This pattern guarantees that even under extreme network retries or malicious concurrent replay attacks, financial mutations execute exactly once.</p>

<h3>3. Cryptographic Tamper-Evident Forensic Audit Logging</h3>
<p>Standard application logs (e.g., rotating text files in <code>storage/logs/</code>) are easily altered, rotated out of existence, or deleted by compromised privileged accounts. Financial auditors require immutable proof of data lineage.</p>
<p>We designed an append-only <strong>Forensic Audit Trail</strong> where every state mutation records:</p>
<ul>
    <li>The exact <code>before_state</code> and <code>after_state</code> serialized snapshots in JSONB format.</li>
    <li>The authenticated user ID, impersonation context, geographic IP, and user-agent signature.</li>
    <li>A chained SHA-256 hash containing the previous record\'s hash: <code>hash = SHA256(previous_hash + current_payload + timestamp)</code>.</li>
</ul>
<p>Much like a blockchain block, any manual modification of a database row invalidates the entire subsequent hash chain, immediately alerting compliance administrators to unauthorized database tampering.</p>

<h3>Conclusion</h3>
<p>Treating security, idempotency, and auditability as foundational architectural pillars rather than post-launch afterthoughts is what separates fragile software from resilient enterprise systems capable of operating at global scale.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1200&q=80',
                'read_time' => 6,
                'tags' => ['Application Security', 'RBAC', 'Idempotency', 'Forensic Auditing', 'FinTech'],
                'is_published' => true,
                'published_at' => now()->subDays(18),
                'views_count' => 682,
                'order' => 4,
            ],
        ];

        foreach ($articles as $articleData) {
            Article::updateOrCreate(
                ['slug' => $articleData['slug']],
                $articleData
            );
        }
    }
}
