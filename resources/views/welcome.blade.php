@extends('layouts.app')

@section('title', 'Home | YBANAGIFY')

@section('content')
<!-- Hero Section -->
<section class="hero d-flex align-items-center justify-content-center text-center text-white">
    <div>
        <h1 class="display-3 fw-bold">Welcome to <strong class="text-sienna fw-bold">YBANAGIFY</strong></h1>
        <p class="fs-5">Preserving and Translating Aparri’s Native Language</p>
        <a href="{{ route('translate') }}" 
           class="btn btn-lg btn-light mt-3 px-4 rounded-pill shadow hero-btn">
            Start Translating
        </a>
    </div>
</section>

<!-- Barangay Image Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f3e8dc, #e0cfc1);">
    <div class="container">
        <div class="row align-items-center">
            <!-- Image Column -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="position-relative rounded-4 overflow-hidden shadow-lg border border-3 border-brown">
                    <img src="{{ asset('images/brgy.jpg') }}" alt="Barangay Bisagu" class="img-fluid">
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-25"></div>
                </div>
            </div>

            <!-- Text Column -->
            <div class="col-lg-6">
                <div class="p-4 bg-white rounded-4 shadow h-100 d-flex flex-column justify-content-center">
                    <h2 class="fw-bold mb-3 text-coffee">
                        <i class="bi bi-geo-alt-fill me-2 text-sienna"></i>Our Community
                    </h2>
                    <p class="text-dark fs-5" style="text-align: justify;">
                        <strong>YBANAGIFY</strong> is born from the heart of <strong>Barangay Bisagu, Aparri</strong> —
                        a vibrant community where the Ybanag language continues to flourish. This platform is our
                        tribute to their heritage, helping preserve their stories, words, and wisdom in the digital age.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testing Center Section -->
<section class="py-5" style="background-color: #fdfaf6;">
    <div class="container text-center">
        <h2 class="fw-bold mb-3 text-coffee">Testing Center</h2>
        <p class="fs-5 text-muted">
            Our initial testing center is located in <strong>Barangay Bisagu, Aparri</strong>, where
            native speakers and language experts help validate translations before wider release.
        </p>
    </div>
</section>

<!-- Map Section --> 
<section class="py-5" style="background-color:#efe6dd;">
    <div class="container">
        <h2 class="text-center fw-bold text-coffee mb-4">Ybanag Across Aparri</h2>
        <p class="text-center text-muted mb-4">Explore the distribution of Ybanag-speaking communities in Aparri.</p>
        
        <div class="ratio ratio-16x9 shadow rounded-4 overflow-hidden">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d663341.4085071167!2d120.97862784052944!3d18.58432072483004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x338602b3115fcb13%3A0xa0d0fe4e715c2759!2sAparri%2C%20Cagayan!5e0!3m2!1sen!2sph!4v1757082872631!5m2!1sen!2sph" 
                width="100%" height="450" style="border:0;" 
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

<!-- Mission & Vision Section (Static) -->
<section class="py-5 bg-cream">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-coffee">Mission & Vision</h2>
            <p class="text-muted">What drives our purpose and inspires our future</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="p-4 rounded-4 shadow-sm h-100 bg-white border-start border-4 border-sienna">
                    <h4 class="fw-bold mb-3 text-coffee">
                        <i class="bi bi-bullseye me-2 text-sienna"></i>Our Mission
                    </h4>
                    <p class="text-muted" style="text-align: justify;">
                        To empower the Ybanag-speaking community by providing a digital tool that preserves and promotes
                        the Ybanag language through accessible technology.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-4 rounded-4 shadow-sm h-100 bg-white border-start border-4 border-sienna">
                    <h4 class="fw-bold mb-3 text-coffee">
                        <i class="bi bi-eye-fill me-2 text-sienna"></i>Our Vision
                    </h4>
                    <p class="text-muted" style="text-align: justify;">
                        A future where the Ybanag language thrives both in daily life and digital platforms—bridging
                        generations and fostering cultural pride.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Admin Approved Section -->
<section class="py-5" style="background-color:#f9f4ef;">
    <div class="container text-center">
        <h2 class="fw-bold text-coffee mb-3">Admin & Language Experts</h2>
        <p class="fs-5 text-muted">
            All translations are <strong>reviewed and approved by native Ybanag speakers and language experts</strong>
            to ensure accuracy. Contributions from different barangays are carefully checked before being added.
        </p>
    </div>
</section>

<!-- Features with Images -->
<section class="py-5" style="background-color: #fdfaf6;">
    <div class="container">
        <h2 class="text-center fw-bold mb-5 text-coffee">Key Features</h2>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100 border-top border-4 border-sienna">
                    <img src="{{ asset('images/dictionary.png') }}" alt="Dictionary" class="mb-3" style="height: 90px;">
                    <h5 class="fw-bold text-coffee">Word Dictionary</h5>
                    <p class="text-muted small">Search Ybanag words with pronunciation and examples to deepen understanding.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100 border-top border-4 border-sienna">
                    <img src="{{ asset('images/translate.svg') }}" alt="Translator" class="mb-3" style="height: 90px;">
                    <h5 class="fw-bold text-coffee">Instant Translation</h5>
                    <p class="text-muted small">Translate seamlessly between Filipino and Ybanag in real-time.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100 border-top border-4 border-sienna">
                    <img src="{{ asset('images/responsive.png') }}" alt="Responsive Design" class="mb-3" style="height: 90px;">
                    <h5 class="fw-bold text-coffee">Responsive Design</h5>
                    <p class="text-muted small">Optimized for mobile, tablet, and desktop—use it anywhere, anytime.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-5" style="background-color: #efe6dd;">
    <div class="container text-center">
        <h2 class="fw-bold text-uppercase mb-3" style="color: #5e3b2c;">About YBANAGIFY</h2>
        <p class="fs-5 text-muted mx-auto" style="max-width: 720px;">
            Created with passion, YBANAGIFY preserves the language of Barangay Bisagu and makes it accessible to all through digital innovation.
        </p>
    </div>
</section>

<!-- Disclaimer -->
<section class="py-4" style="background-color:#fff3e6;">
    <div class="container text-center">
        <p class="mb-0 text-muted small">
            <strong>Disclaimer:</strong> Some Ybanag words may carry different meanings depending on the barangay or context.
        </p>
    </div>
</section>

<!-- FAQ Section -->
<div class="container py-5">
  <h2 class="text-center fw-bold mb-5 text-coffee">Frequently Asked Questions</h2>
  <div class="row g-4">
    <div class="col-md-6">
      <div class="faq-card p-4 rounded shadow-sm bg-white d-flex align-items-start gap-3 border-sienna" style="border-left: 5px solid #a97453;">
        <span class="faq-icon fs-3 text-brown">❓</span>
        <div>
          <h5 class="mb-2 text-coffee">What is YBANAGIFY?</h5>
          <p class="text-muted">YBANAGIFY is a web-based translator that helps users translate between Filipino and Ybanag, focused on preserving the Ybanag language of Barangay Bisagu, Aparri.</p>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="faq-card p-4 rounded shadow-sm bg-white d-flex align-items-start gap-3 border-sienna" style="border-left: 5px solid #a97453;">
        <span class="faq-icon fs-3 text-brown">📱</span>
        <div>
          <h5 class="mb-2 text-coffee">Is this available on mobile?</h5>
          <p class="text-muted">Yes, the system is fully responsive and works well on smartphones, tablets, and desktops.</p>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="faq-card p-4 rounded shadow-sm bg-white d-flex align-items-start gap-3 border-sienna" style="border-left: 5px solid #a97453;">
        <span class="faq-icon fs-3 text-brown">👥</span>
        <div>
          <h5 class="mb-2 text-coffee">Who can use this translator?</h5>
          <p class="text-muted">Anyone interested in learning or understanding the Ybanag language can use YBANAGIFY for free.</p>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="faq-card p-4 rounded shadow-sm bg-white d-flex align-items-start gap-3 border-sienna" style="border-left: 5px solid #a97453;">
        <span class="faq-icon fs-3 text-brown">🎯</span>
        <div>
          <h5 class="mb-2 text-coffee">How accurate is the translation?</h5>
          <p class="text-muted">Translations are reviewed by <strong>language experts and native speakers</strong> to ensure accuracy and cultural relevance.</p>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="faq-card p-4 rounded shadow-sm bg-white d-flex align-items-start gap-3 border-sienna" style="border-left: 5px solid #a97453;">
        <span class="faq-icon fs-3 text-brown">🌱</span>
        <div>
          <h5 class="mb-2 text-coffee">Will more words be added over time?</h5>
          <p class="text-muted">Yes! We are continually expanding our dictionary with more Ybanag words and phrases.</p>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="faq-card p-4 rounded shadow-sm bg-white d-flex align-items-start gap-3 border-sienna" style="border-left: 5px solid #a97453;">
        <span class="faq-icon fs-3 text-brown">✍️</span>
        <div>
          <h5 class="mb-2 text-coffee">Can I contribute new words or phrases?</h5>
          <p class="text-muted">
              Yes! You can contribute by submitting through our 
              <a href="{{ route('dictionary.index') }}" class="text-sienna fw-bold">Contribute Form</a> 
              or by reaching out to our admin team.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
    /* Hero Section */
    .hero {
        height: 80vh;
        position: relative;
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                    url('{{ asset("images/bisagu.jpg") }}') center/cover no-repeat;
    }

    /* Optional: text shadow para mas readable */
    .hero h1, 
    .hero p {
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.6);
    }

    /* Button hover effect */
    .hero-btn {
        transition: 0.3s ease-in-out;
    }
    .hero-btn:hover {
        background-color: #f5f5f5;
        color: #6b4f3b;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.3);
    }

    /* Custom Colors */
    .text-coffee { color: #6b4f3b; }
    .text-sienna { color: #a97449; }
    .border-sienna { border-color: #a97449 !important; }

    /* FAQ hover */
    .faq-card:hover { 
        box-shadow: 0 4px 15px rgba(171, 110, 51, 0.3); 
    }

    /* Responsive */
    @media (max-width: 768px) {
        .display-5 { font-size: 2rem; }
        .lead { font-size: 1rem; }
    }
</style>
@endpush
