@extends('layouts.frontend')

@section('title', 'Ruqyah & Hijama Healing Center - Islamic Traditional Medicine')

@section('navigation-links')
    <a href="#home" class="text-gray-700 hover:text-indigo-600 font-medium">Home</a>
    <a href="#about" class="text-gray-700 hover:text-indigo-600 font-medium">About</a>
    <a href="#services" class="text-gray-700 hover:text-indigo-600 font-medium">Services</a>
    <a href="#testimonials" class="text-gray-700 hover:text-indigo-600 font-medium">Testimonials</a>
    <a href="#contact" class="text-gray-700 hover:text-indigo-600 font-medium">Contact</a>
@endsection

@section('mobile-navigation-links')
    <a href="#home" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Home</a>
    <a href="#about" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">About</a>
    <a href="#services" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Services</a>
    <a href="#testimonials" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Testimonials</a>
    <a href="#contact" class="block px-3 py-2 text-gray-700 hover:text-indigo-600">Contact</a>
@endsection

@section('content')

    <!-- Hero Section -->
    <section id="home" class="gradient-bg text-white py-20 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="mb-6">
                    <i class="fas fa-hand-holding-heart text-6xl mb-4 opacity-80"></i>
                </div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Islamic Healing & Wellness
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto opacity-90">
                    Experience the power of traditional Islamic healing through authentic Ruqyah and Hijama treatments, guided by Quran and Sunnah
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#services" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                        Our Services
                    </a>
                    <a href="#contact" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition duration-300">
                        Book Consultation
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">About Our Center</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Dedicated to providing authentic Islamic healing methods rooted in the Quran and Sunnah
                </p>
            </div>
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Our Mission</h3>
                    <p class="text-gray-600 mb-6">
                        We are committed to providing authentic Islamic healing services that combine spiritual and physical wellness. Our practitioners are trained in traditional methods that have been practiced for centuries, always following the guidance of the Quran and Sunnah.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-gray-700">Certified Islamic healing practitioners</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-gray-700">Authentic methods from Quran and Sunnah</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-gray-700">Holistic approach to wellness</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-gray-700">Safe and sterile environment</span>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg p-8 text-white">
                        <i class="fas fa-mosque text-6xl mb-4"></i>
                        <h4 class="text-2xl font-bold mb-4">Islamic Wellness</h4>
                        <p class="text-lg">
                            "And We send down of the Quran that which is healing and mercy for the believers"
                        </p>
                        <p class="text-sm mt-2 opacity-80">- Quran 17:82</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Our Services</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Traditional Islamic healing methods for spiritual and physical wellness
                </p>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Ruqyah Service -->
                <div class="bg-white rounded-lg shadow-lg p-8 card-shadow">
                    <div class="text-center mb-6">
                        <i class="fas fa-book-open text-4xl text-indigo-600 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800">Ruqyah Healing</h3>
                    </div>
                    <p class="text-gray-600 mb-6">
                        Spiritual healing through the recitation of Quranic verses and supplications. Ruqyah is a powerful Islamic practice used to seek Allah's protection and cure from various ailments.
                    </p>
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-2"></i>
                            <span class="text-gray-700">Treatment for spiritual ailments</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-2"></i>
                            <span class="text-gray-700">Protection from evil eye and black magic</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-2"></i>
                            <span class="text-gray-700">Anxiety and depression support</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-2"></i>
                            <span class="text-gray-700">Spiritual cleansing and purification</span>
                        </div>
                    </div>
                    <div class="bg-indigo-50 rounded-lg p-4">
                        <h4 class="font-semibold text-indigo-800 mb-2">What to Expect:</h4>
                        <p class="text-sm text-indigo-700">
                            Our qualified practitioners will recite specific Quranic verses and make supplications according to authentic Islamic traditions. Sessions are conducted in a peaceful, spiritual environment.
                        </p>
                    </div>
                </div>

                <!-- Hijama Service -->
                <div class="bg-white rounded-lg shadow-lg p-8 card-shadow">
                    <div class="text-center mb-6">
                        <i class="fas fa-hand-holding-medical text-4xl text-green-600 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-800">Hijama (Cupping)</h3>
                    </div>
                    <p class="text-gray-600 mb-6">
                        Traditional Islamic cupping therapy that involves creating suction on the skin to promote healing. This Sunnah practice has been used for centuries to treat various physical ailments.
                    </p>
                    <div class="space-y-3 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-heart text-red-500 mr-2"></i>
                            <span class="text-gray-700">Improves blood circulation</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-heart text-red-500 mr-2"></i>
                            <span class="text-gray-700">Relieves muscle tension and pain</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-heart text-red-500 mr-2"></i>
                            <span class="text-gray-700">Detoxification and purification</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-heart text-red-500 mr-2"></i>
                            <span class="text-gray-700">Headache and migraine relief</span>
                        </div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <h4 class="font-semibold text-green-800 mb-2">Treatment Process:</h4>
                        <p class="text-sm text-green-700">
                            Using sterile cups and following strict hygiene protocols, our trained practitioners perform wet and dry cupping according to authentic Sunnah methods. All equipment is disposable and sterile.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Additional Services -->
            <div class="mt-12 grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <i class="fas fa-users text-3xl text-purple-600 mb-4"></i>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Family Consultations</h4>
                    <p class="text-gray-600">Healing sessions for entire families including children and elderly</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <i class="fas fa-home text-3xl text-blue-600 mb-4"></i>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Home Visits</h4>
                    <p class="text-gray-600">Convenient home-based treatments for those unable to visit our center</p>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 text-center">
                    <i class="fas fa-graduation-cap text-3xl text-orange-600 mb-4"></i>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Islamic Healing Education</h4>
                    <p class="text-gray-600">Learn authentic Islamic healing methods and self-treatment techniques</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">What Our Clients Say</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Real experiences from those who have benefited from our Islamic healing services
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-50 rounded-lg p-6 card-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Ahmad Ibrahim</h4>
                            <p class="text-sm text-gray-600">Regular Client</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "The Ruqyah sessions have brought incredible peace to my life. I was struggling with anxiety for years, and after just a few sessions, I felt a significant improvement. Alhamdulillah!"
                    </p>
                    <div class="flex text-yellow-500">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 card-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Fatima Al-Zahra</h4>
                            <p class="text-sm text-gray-600">Hijama Client</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "The Hijama treatment was professionally done with utmost care for hygiene. My chronic headaches have reduced significantly, and I feel more energetic. Highly recommended!"
                    </p>
                    <div class="flex text-yellow-500">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 card-shadow">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800">Omar Hassan</h4>
                            <p class="text-sm text-gray-600">Family Client</p>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "We brought our whole family for treatment. The practitioners are knowledgeable and follow authentic Islamic methods. Our home feels more peaceful now. May Allah reward them!"
                    </p>
                    <div class="flex text-yellow-500">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-50">
        @php
            $contactInfo = \App\Models\ContactInformation::getActive();
        @endphp
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Get In Touch</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Book your consultation or learn more about our Islamic healing services
                </p>
            </div>
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Contact Information</h3>
                    <div class="space-y-4">
                        @if($contactInfo && $contactInfo->address)
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-indigo-600 mr-4 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-800">Address</p>
                                <p class="text-gray-600">{{ $contactInfo->address }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($contactInfo && $contactInfo->phone)
                        <div class="flex items-center">
                            <i class="fas fa-phone text-indigo-600 mr-4 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-800">Phone</p>
                                <p class="text-gray-600">{{ $contactInfo->phone }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($contactInfo && $contactInfo->email)
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-indigo-600 mr-4 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-800">Email</p>
                                <p class="text-gray-600">{{ $contactInfo->email }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($contactInfo && $contactInfo->business_hours)
                        <div class="flex items-center">
                            <i class="fas fa-clock text-indigo-600 mr-4 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-800">Hours</p>
                                @foreach($contactInfo->business_hours_array as $hour)
                                    <p class="text-gray-600">{{ $hour }}</p>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    @if($contactInfo && ($contactInfo->facebook_url || $contactInfo->twitter_url || $contactInfo->instagram_url || $contactInfo->whatsapp_url || $contactInfo->youtube_url || $contactInfo->linkedin_url))
                    <div class="mt-8">
                        <h4 class="text-xl font-bold text-gray-800 mb-4">Follow Us</h4>
                        <div class="flex space-x-4">
                            @if($contactInfo->facebook_url)
                            <a href="{{ $contactInfo->facebook_url }}" target="_blank" class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white hover:bg-blue-700">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            @endif
                            
                            @if($contactInfo->twitter_url)
                            <a href="{{ $contactInfo->twitter_url }}" target="_blank" class="w-10 h-10 bg-blue-400 rounded-full flex items-center justify-center text-white hover:bg-blue-500">
                                <i class="fab fa-twitter"></i>
                            </a>
                            @endif
                            
                            @if($contactInfo->instagram_url)
                            <a href="{{ $contactInfo->instagram_url }}" target="_blank" class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center text-white hover:bg-pink-700">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @endif
                            
                            @if($contactInfo->whatsapp_url)
                            <a href="{{ $contactInfo->whatsapp_url }}" target="_blank" class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white hover:bg-green-700">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            @endif
                            
                            @if($contactInfo->youtube_url)
                            <a href="{{ $contactInfo->youtube_url }}" target="_blank" class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center text-white hover:bg-red-700">
                                <i class="fab fa-youtube"></i>
                            </a>
                            @endif
                            
                            @if($contactInfo->linkedin_url)
                            <a href="{{ $contactInfo->linkedin_url }}" target="_blank" class="w-10 h-10 bg-blue-700 rounded-full flex items-center justify-center text-white hover:bg-blue-800">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">
                        {{ $contactInfo ? $contactInfo->contact_form_title : 'Book a Consultation' }}
                    </h3>
                    @if($contactInfo && $contactInfo->contact_form_description)
                    <p class="text-gray-600 mb-6">{{ $contactInfo->contact_form_description }}</p>
                    @endif
                    <form id="contactForm" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Full Name</label>
                            <input type="text" name="full_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter your full name">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email Address</label>
                            <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter your email">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Phone Number</label>
                            <input type="tel" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter your phone number">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Message</label>
                            <textarea name="message" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Tell us about your needs..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center mb-4">
                        <i class="fas fa-moon text-indigo-400 text-2xl mr-2"></i>
                        <span class="text-xl font-bold">Ruqyah & Hijama Center</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Providing authentic Islamic healing services rooted in Quran and Sunnah for spiritual and physical wellness.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Ruqyah Healing</a></li>
                        <li><a href="#" class="hover:text-white">Hijama (Cupping)</a></li>
                        <li><a href="#" class="hover:text-white">Family Consultations</a></li>
                        <li><a href="#" class="hover:text-white">Home Visits</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#about" class="hover:text-white">About Us</a></li>
                        <li><a href="#services" class="hover:text-white">Our Services</a></li>
                        <li><a href="#testimonials" class="hover:text-white">Testimonials</a></li>
                        <li><a href="#contact" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Islamic Guidance</h4>
                    <div class="bg-gray-700 rounded-lg p-4 mb-4">
                        <p class="text-sm text-gray-300 italic">
                            "And We send down of the Quran that which is healing and mercy for the believers"
                        </p>
                        <p class="text-xs text-gray-400 mt-2">- Quran 17:82</p>
                    </div>
                    <div class="bg-gray-700 rounded-lg p-4">
                        <p class="text-sm text-gray-300 italic">
                            "Whoever does a good deed, it is for his own soul, and whoever does evil, it is against it"
                        </p>
                        <p class="text-xs text-gray-400 mt-2">- Quran 45:15</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    © {{ date('Y') }} Ruqyah & Hijama Healing Center. All rights reserved. | May Allah bless and guide us all.
                </p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
                // Close mobile menu if open
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });

        // Form submission handler - only for contact form
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                
                // Disable button and show loading
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                
                fetch('/contact-form/submit', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        // Reload the page after alert is clicked
                        window.location.reload();
                    } else {
                        alert(data.message || 'Something went wrong. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong. Please try again.');
                })
                .finally(() => {
                    // Re-enable button
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                });
            });
        }
    </script>
@endsection
