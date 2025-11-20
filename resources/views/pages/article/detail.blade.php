@extends('layouts.app') @section('content')

<section class="py-20 flex flex-col justify-center items-center m-5">
    <div class="max-w-[850px] mt-3">
        <h1 class="text-4xl md:text-5xl font-bold leading-snug font-outfit">
            Acara Super Festival di Kuningan
        </h1>
        <h2 class="mb-5 max-w-xl font-dmsans font-bold">October 13, 2025</h2>

        <img src="{{ url('/img/detail-article.png') }}" alt="" />

        <p class="mt-5">
            Excepteur efficient emerging, minim veniam anim aute carefully
            curated Ginza conversation exquisite perfect nostrud nisi intricate
            Content. Qui international first-class nulla ut. Punctual
            adipisicing, essential lovely queen tempor eiusmod irure. Exclusive
            izakaya charming Scandinavian impeccable aute quality of life soft
            power pariatur Melbourne occaecat discerning. Qui wardrobe aliquip,
            et Porter destination Toto remarkable officia Helsinki excepteur
            Basset hound. Zürich sleepy perfect consectetur.
            <br /><br />
            Exquisite sophisticated iconic cutting-edge laborum deserunt Addis
            Ababa esse bureaux cupidatat id minim. Sharp classic the best
            commodo nostrud delightful. Conversation aute Rochester id. Qui sunt
            remarkable deserunt intricate airport handsome K-pop excepteur
            classic esse Asia-Pacific laboris.
            <br /><br />
            Every detail tells a story — from the soft murmur of a conversation
            to the refined rhythm of daily rituals. Each element, thoughtfully
            designed, carries a sense of purpose and poise. In a time where
            experiences speak louder than possessions, authenticity and
            connection have become the true measure of sophistication. In the
            heart of vibrant cities and quiet corners of the world, beauty
            emerges in the balance between innovation and tradition. The streets
            of Zürich hum with precision and grace; Melbourne celebrates
            artistry in every corner café; and the timeless charm of Helsinki
            whispers stories of design, resilience, and warmth. Each destination
            offers more than scenery — it offers perspective, reminding us that
            elegance is not about perfection, but about presence.
            <br /><br />
            <img src="{{ url('/img/detail-article-2.png') }}" alt="" />
            <p class="mt-5">
                Excepteur efficient emerging, minim veniam anim cloying aute carefully curated gauche. Espresso exquisite perfect nostrud nisi intricate. Punctual adipisicing Borzoi, essential lovely tempor eiusmod irure. Exclusive izakaya charming Quezon City impeccable aute quality of life soft power pariatur occaecat discerning. Qui wardrobe aliquip, et Amadeus rock opera.
                <br><br>
                Exquisite sophisticated iconic cutting-edge laborum deserunt esse bureaux cupidatat id minim. Sharp classic the best commodo nostrud delightful. Conversation aute wifey id. Qui sunt remarkable deserunt intricate airport excepteur classic esse riot girl.
                <br><br>
                We move through spaces that blend the tactile with the digital, where craftsmanship meets creativity, and where cultural stories unfold through design, taste, and sound. The modern traveler seeks not only luxury but meaning — a sense of belonging, even in motion. It’s in the subtle textures of handcrafted details, in the aroma of a well-brewed coffee, in the rhythm of a city that never forgets to breathe.
                <br><br>
                In this ever-evolving landscape, sophistication has found a new definition: it is no longer about exclusivity, but inclusivity. It celebrates curiosity over conformity, and empathy over extravagance. From the refined calm of an izakaya in Tokyo to the bold expression of contemporary art in Addis Ababa, every moment becomes an invitation to connect, to listen, to understand.
            </p>
        </p>
    </div>

    <div class="mt-5">
        <div class="text-start mb-10 max-w-6xl mx-auto px-4 sm:px-6">
            <h3 class="text-2xl font-bold font-poppins">Related articles or posts</h3>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @for ($i = 0; $i < 3; $i++)
                <div class="bg-white shadow-sm rounded-lg p-4 hover:shadow-lg transition-shadow duration-300">
                    <div class="bg-gray-300 h-48 mb-4 rounded-md"></div>
                    <p class="text-gray-400 text-sm font-poppins">October 13, 2025</p>
                    <h4 class="font-semibold mt-2 font-poppins">Latest Blog & Articles</h4>
                    <p class="text-gray-500 text-sm mt-2 font-dmsans">
                        EO Jakarta kini menjadi kebutuhan utama bagi perusahaan...
                    </p>
                    <a href="#" class="text-yellow-500 mt-3 inline-block font-dmsans">Read More →</a>
                </div>
            @endfor
        </div>
    </div>
</section>

@endsection
