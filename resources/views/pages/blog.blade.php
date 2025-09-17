<x-app-layout>
    <x-slot name="title">Blog - Invozen</x-slot>

    <div class="bg-gray-50 py-16">
        <div class="max-w-6xl mx-auto px-6">
            <h1 class="text-4xl font-bold text-gray-900 text-center mb-10">Our Blog</h1>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <img src="https://dummyimage.com/400x250/f3f4f6/1f2937&text=Post+1" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold">5 Tips for Better Invoicing</h3>
                        <p class="text-gray-600 mt-2">Learn how to manage clients and get paid faster.</p>
                        <a href="#" class="text-primary mt-3 block font-medium">Read More →</a>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <img src="https://dummyimage.com/400x250/f3f4f6/1f2937&text=Post+2" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold">Why SaaS is the Future</h3>
                        <p class="text-gray-600 mt-2">Exploring the growing trend of SaaS platforms.</p>
                        <a href="#" class="text-primary mt-3 block font-medium">Read More →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
