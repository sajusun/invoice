{{--<x-app-layout>--}}
{{--    <x-slot name="title">Contact Us - Invozen</x-slot>--}}

{{--    <div class="bg-gray-50 py-12">--}}
{{--        <div class="max-w-7xl mx-auto px-6 lg:px-8">--}}
{{--            <!-- Header -->--}}
{{--            <div class="text-center mb-12">--}}
{{--                <h2 class="text-3xl font-bold text-gray-900">Get in Touch</h2>--}}
{{--                <p class="mt-3 text-gray-600 max-w-2xl mx-auto">--}}
{{--                    Have questions about Invozen? We'd love to hear from you.--}}
{{--                    Fill out the form below or reach us through our contact details.--}}
{{--                </p>--}}
{{--            </div>--}}

{{--            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">--}}
{{--                <!-- Contact Form -->--}}
{{--                <div class="bg-white shadow-sm rounded-xl p-8">--}}
{{--                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Send a Message</h3>--}}
{{--                    <form action="{{route('contact.form')}}" method="POST" class="space-y-5">--}}
{{--                        @csrf--}}
{{--                        <div>--}}
{{--                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>--}}
{{--                            <input type="text" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>--}}
{{--                            <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>--}}
{{--                            <textarea name="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary"></textarea>--}}
{{--                        </div>--}}
{{--                        <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-medium hover:bg-primary-dark transition-colors">--}}
{{--                            Send Message--}}
{{--                        </button>--}}
{{--                    </form>--}}
{{--                </div>--}}

{{--                <!-- Contact Info -->--}}
{{--                <div class="bg-white shadow-sm rounded-xl p-8">--}}
{{--                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Contact Information</h3>--}}
{{--                    <ul class="space-y-6">--}}
{{--                        <li class="flex items-start">--}}
{{--                            <div class="p-3 rounded-lg bg-indigo-100 text-primary mr-4">--}}
{{--                                <i class="fa-solid fa-location-dot text-lg"></i>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <p class="font-medium text-gray-900">Our Office</p>--}}
{{--                                <p class="text-gray-600">Dhaka, Bangladesh</p>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="flex items-start">--}}
{{--                            <div class="p-3 rounded-lg bg-green-100 text-secondary mr-4">--}}
{{--                                <i class="fa-solid fa-envelope text-lg"></i>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <p class="font-medium text-gray-900">Email</p>--}}
{{--                                <p class="text-gray-600">support@invozen.com</p>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li class="flex items-start">--}}
{{--                            <div class="p-3 rounded-lg bg-amber-100 text-accent mr-4">--}}
{{--                                <i class="fa-solid fa-phone text-lg"></i>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <p class="font-medium text-gray-900">Phone</p>--}}
{{--                                <p class="text-gray-600">+880 123-456-789</p>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                    </ul>--}}

{{--                    <!-- Socials -->--}}
{{--                    <div class="mt-8">--}}
{{--                        <h4 class="text-sm font-medium text-gray-700 mb-3">Follow us</h4>--}}
{{--                        <div class="flex space-x-4">--}}
{{--                            <a href="#" class="p-3 bg-gray-100 rounded-full hover:bg-primary hover:text-white transition">--}}
{{--                                <i class="fab fa-facebook-f"></i>--}}
{{--                            </a>--}}
{{--                            <a href="#" class="p-3 bg-gray-100 rounded-full hover:bg-primary hover:text-white transition">--}}
{{--                                <i class="fab fa-twitter"></i>--}}
{{--                            </a>--}}
{{--                            <a href="#" class="p-3 bg-gray-100 rounded-full hover:bg-primary hover:text-white transition">--}}
{{--                                <i class="fab fa-linkedin-in"></i>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</x-app-layout>--}}
<x-app-layout>
    <x-slot name="title">Contact Us - Invozen</x-slot>

    <div class="bg-gray-50 py-12" x-data="contactForm()">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Get in Touch</h2>
                <p class="mt-3 text-gray-600 max-w-2xl mx-auto">
                    Have questions about Invozen? We'd love to hear from you.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <div class="bg-white shadow-sm rounded-xl p-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Send a Message</h3>
                    <form @submit.prevent="submitForm" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text" x-model="form.name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" x-model="form.email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea rows="5" x-model="form.message" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-medium hover:bg-primary-dark transition">
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="bg-white shadow-sm rounded-xl p-8">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Contact Information</h3>
                    <ul class="space-y-6">
                        <li class="flex items-start">
                            <div class="p-3 rounded-lg bg-indigo-100 text-primary mr-4">
                                <i class="fa-solid fa-location-dot text-lg"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Our Office</p>
                                <p class="text-gray-600">Dhaka, Bangladesh</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="p-3 rounded-lg bg-green-100 text-secondary mr-4">
                                <i class="fa-solid fa-envelope text-lg"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Email</p>
                                <p class="text-gray-600">support@invozen.com</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <div class="p-3 rounded-lg bg-amber-100 text-accent mr-4">
                                <i class="fa-solid fa-phone text-lg"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Phone</p>
                                <p class="text-gray-600">+880 123-456-789</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Google Map -->
            <div class="mt-12">
                <iframe
                    class="w-full h-80 rounded-xl shadow-sm"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3649.788972023086!2d90.41251831536368!3d23.780777893465956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8c3d16d93c3%3A0x9c95b2e4c8b7d1b1!2sDhaka!5e0!3m2!1sen!2sbd!4v1633547281234!5m2!1sen!2sbd"
                    style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>

        <!-- Toast Notifications -->
        <div x-show="toast.show" x-transition
             class="fixed bottom-5 right-5 bg-white shadow-lg rounded-lg px-6 py-3 border border-gray-200"
             x-text="toast.message"
             :class="toast.type === 'success' ? 'text-green-600 border-green-300' : 'text-red-600 border-red-300'">
        </div>
    </div>

    <script>
        function contactForm() {
            return {
                form: { name: '', email: '', message: '' },
                toast: { show: false, message: '', type: 'success' },
                async submitForm() {
                    try {
                        // Fake API call (replace with axios.post('/contact', this.form))
                        await new Promise(r => setTimeout(r, 1000));

                        this.toast = { show: true, message: 'Message sent successfully!', type: 'success' };
                        this.form = { name: '', email: '', message: '' };

                        setTimeout(() => this.toast.show = false, 3000);
                    } catch (e) {
                        this.toast = { show: true, message: 'Failed to send message.', type: 'error' };
                        setTimeout(() => this.toast.show = false, 3000);
                    }
                }
            }
        }
    </script>
</x-app-layout>
