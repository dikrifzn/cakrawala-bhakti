@extends('layouts.app')

@section('content')
<section class="pt-20 pb-20">
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-20 px-6">
        
        <div>
            <h2 class="text-4xl font-bold mb-6 font-poppins">
                About Cakrawala Bhakti
            </h2>

            <p class="text-gray-600 mb-6 font-dmsans">
                Body text for your whole article or post. We’ll put in some lorem Ipsum 
                to show how a filled-out page might look:
            </p>

            <p class="text-gray-700 leading-relaxed font-dmsans">
                Excepteur efficient emerging, minim veniam anim aute carefully curated 
                Ginza conversation exquisite perfect nostri nisi intricate Content. 
                Qui international first-class nullu ut. Punctual adipiscing, essential 
                lovely queen tempor eiusmod inruv. Exclusive izakaya charming 
                Scandinavian impeccable aute quality of life soft power pariatur 
                Melbourne occaecat discerning. Qui wardrobe aliquip, et Porter 
                destination Toto remarkable officia Helsinki excepteur Basset hound. 
                Zürich sleepy perfect consectetur.
            </p>
        </div>

        <div class="flex justify-center">
            <img 
                src="/mnt/data/53ddf073-6782-490a-bf0b-e7874aa6d115.png"
                class="w-full h-[380px] object-cover rounded-xl bg-gray-200 shadow"
                alt="About Cakrawala"
            >
        </div>

    </div>

    <div class="max-w-xl mx-auto mt-16 px-6">
        <h3 class="text-2xl font-bold mb-6 font-poppins">Contact us</h3>

        <form class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium mb-1">First name</label>
                <input type="text" class="w-full border rounded-lg px-4 py-2" placeholder="Jane">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Last name</label>
                <input type="text" class="w-full border rounded-lg px-4 py-2" placeholder="Smitherton">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Email address</label>
                <input type="email" class="w-full border rounded-lg px-4 py-2" placeholder="email@janesfakedomain.net">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Your message</label>
                <textarea class="w-full border rounded-lg px-4 py-2 h-32" placeholder="Enter your question or message"></textarea>
            </div>

            <div class="md:col-span-2">
                <button class="w-full bg-yellow-400 py-3 rounded-lg font-semibold text-black">
                    Submit
                </button>
            </div>

        </form>
    </div>

</section>
@endsection
