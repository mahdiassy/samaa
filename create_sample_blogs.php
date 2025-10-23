<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Blog;
use App\Models\User;

// Get or create a user for the blogs
$user = User::first();
if (!$user) {
    $user = User::create([
        'name' => 'SAMAA Admin',
        'email' => 'admin@samaa.com',
        'password' => bcrypt('password'),
        'email_verified_at' => now()
    ]);
}

// Delete existing blogs if any
Blog::truncate();

// Create sample blogs with realistic images
$blogs = [
    [
        'user_id' => $user->id,
        'title' => json_encode([
            'en' => 'Understanding Music Therapy',
            'ar' => 'فهم العلاج بالموسيقى', 
            'fr' => 'Comprendre la musicothérapie'
        ]),
        'content' => json_encode([
            'en' => 'Discover how music therapy can transform mental health and provide healing through sound. Our innovative approach combines neuroscience with therapeutic music to create personalized healing experiences that address anxiety, depression, and stress-related disorders.',
            'ar' => 'اكتشف كيف يمكن للعلاج بالموسيقى أن يحول الصحة النفسية ويوفر الشفاء من خلال الصوت. يجمع نهجنا المبتكر بين علم الأعصاب والموسيقى العلاجية لخلق تجارب شفاء شخصية تعالج القلق والاكتئاب والاضطرابات المرتبطة بالتوتر.',
            'fr' => 'Découvrez comment la musicothérapie peut transformer la santé mentale et fournir la guérison par le son. Notre approche innovante combine les neurosciences avec la musique thérapeutique pour créer des expériences de guérison personnalisées qui traitent l\'anxiété, la dépression et les troubles liés au stress.'
        ]),
        'image' => 'assets/images/music-therapy.jpg',
        'created_at' => now(),
        'updated_at' => now()
    ],
    [
        'user_id' => $user->id,
        'title' => json_encode([
            'en' => 'AI-Powered Mental Healthcare Revolution',
            'ar' => 'ثورة الرعاية الصحية النفسية بالذكاء الاصطناعي',
            'fr' => 'Révolution des soins de santé mentale alimentée par l\'IA'
        ]),
        'content' => json_encode([
            'en' => 'How artificial intelligence is revolutionizing therapy and mental health treatment. Learn about our AI-powered assessment tools, personalized treatment plans, and real-time monitoring systems that adapt to your unique needs and progress.',
            'ar' => 'كيف يحدث الذكاء الاصطناعي ثورة في العلاج وعلاج الصحة النفسية. تعرف على أدوات التقييم المدعومة بالذكاء الاصطناعي وخطط العلاج الشخصية وأنظمة المراقبة في الوقت الفعلي التي تتكيف مع احتياجاتك وتقدمك الفريد.',
            'fr' => 'Comment l\'intelligence artificielle révolutionne la thérapie et le traitement de la santé mentale. Découvrez nos outils d\'évaluation alimentés par l\'IA, nos plans de traitement personnalisés et nos systèmes de surveillance en temps réel qui s\'adaptent à vos besoins et progrès uniques.'
        ]),
        'image' => 'assets/images/revolution.png',
        'created_at' => now()->subDay(),
        'updated_at' => now()->subDay()
    ],
    [
        'user_id' => $user->id,
        'title' => json_encode([
            'en' => 'The Science Behind SAMAA\'s Success',
            'ar' => 'العلم وراء نجاح سماع',
            'fr' => 'La science derrière le succès de SAMAA'
        ]),
        'content' => json_encode([
            'en' => 'Research and evidence supporting our innovative approach to mental wellness. Explore the clinical trials, peer-reviewed studies, and scientific validation that prove our methodology\'s effectiveness in treating mental health conditions through therapeutic music and AI technology.',
            'ar' => 'البحث والأدلة التي تدعم نهجنا المبتكر للعافية النفسية. استكشف التجارب السريرية والدراسات المراجعة من قبل الأقران والتحقق العلمي الذي يثبت فعالية منهجيتنا في علاج حالات الصحة النفسية من خلال الموسيقى العلاجية وتكنولوجيا الذكاء الاصطناعي.',
            'fr' => 'Recherche et preuves soutenant notre approche innovante du bien-être mental. Explorez les essais cliniques, les études évaluées par des pairs et la validation scientifique qui prouvent l\'efficacité de notre méthodologie dans le traitement des troubles de santé mentale par la musique thérapeutique et la technologie IA.'
        ]),
        'image' => 'assets/images/our-work.png',
        'created_at' => now()->subDays(2),
        'updated_at' => now()->subDays(2)
    ]
];

foreach ($blogs as $blogData) {
    Blog::create($blogData);
}

echo "✅ Successfully created " . count($blogs) . " sample blog articles!\n";
echo "📚 The Resource section should now display content.\n";
echo "🔄 Refresh your browser to see the changes.\n";
