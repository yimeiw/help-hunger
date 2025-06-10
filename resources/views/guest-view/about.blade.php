<x-guest-layout>
    @section('title', 'About HelpHunger')
    <body>
        <img src="{{ asset('/assets/logo-about.svg') }}" alt="" class="w-80 h-64 mx-auto">
        <div class="flex items-center justify-center pl-8 pr-8 pb-8 pt-4">
            <hr class="border-t-2 border-redb w-full">
        </div>

        <div class="flex items-center justify-center text-center pl-64 pr-64">
            <p class="font-regular text-redb text-lg"><span class="font-bold">HelpHunger</span> is a digital platform designed to bridge the gap between the food needs of underprivileged communities and surplus food sources that are still fit for consumption. Originating from two major issues—hunger and food waste—HelpHunger connects individuals, restaurants, supermarkets, households, and social organizations through an integrated food donation system, a map of food aid locations, and a volunteer network. <br>
            Through <span class="font-bold">technology</span> and <span class="font-bold">collaboration</span>, HelpHunger creates a mutual support ecosystem that facilitates access to free food, reduces waste, and accelerates the efficient distribution of aid. More than just a platform, HelpHunger is a digital social movement that raises awareness and promotes real action in addressing food inequality.</p>
        </div>

        <div class="flex items-center justify-center pl-96 pr-96 pb-12 pt-4">
            <hr class="border-t-2 border-redb w-full">
        </div>

        <p class="flex w-full items-center justify-center font-bold text-redb text-2xl mt-8">VISION</p>
        <div class="flex flex-row pl-56 pr-48 items-center justify-center gap-4 text-center">
            <div class="p-8">
                <p class="font-regular text-redb text-lg mb-4">Create a world without hunger through the use of technology and social collaboration.</p>
                <hr class="border-t-2 border-redb w-full">
            </div>

            <div class="p-8">
                <p class="font-regular text-redb text-lg mb-4">Become the leading platform for sustainable and impactful food waste reduction.</p>
                <hr class="border-t-2 border-redb w-full">
            </div>

            <div class="p-8">
                <p class="font-regular text-redb text-lg mb-4">Build a connected digital solidarity ecosystem among communities, businesses, and social organizations.</p>
                <hr class="border-t-2 border-redb w-full">
            </div>
        </div>

        <p class="flex w-full items-center justify-center font-bold text-redb text-2xl mt-8">MISION</p>
        <div class="flex flex-row pl-48 pr-56 items-center justify-center gap-4 text-center">
            <div class="p-8">
                <p class="font-regular text-redb text-lg mb-4">Providing easy access for communities to find food assistance through maps and real-time notifications.</p>
            </div>

            <div class="p-8">
                <p class="font-regular text-redb text-lg mb-4">Encouraging active public participation through contribution tracking features and collaboration with NGOs and local communities.</p>
            </div>

            <div class="p-6">
                <p class="font-regular text-redb text-lg mb-4">Optimize surplus food distribution through a transparent and efficient donation system.</p>
            </div>
        </div>
        <div class="flex items-center justify-center pl-8 pr-8 pt-4">
            <hr class="border-t-2 border-redb w-full">
        </div>

        <div class="flex flex-col bg-greenbg p-8 m-12 text-creamhh rounded-lg">
            <p class="font-bold text-xl pb-4">Testimoni from Aid Recipient</p>
            <p class="font-regular text-lg pb-4">"I used to worry about what to eat each day. Since I found out about HelpHunger, I can easily find the nearest public kitchen using my phone. Thank you so much to everyone who has shared—it's been a huge help for those of us struggling."</p>
            <p class="font-regular text-lg">— <span class="font-bold text-lg">Budi</span>, daily laborer, Jakarta</p>
        </div>
    </body>
</x-guest-layout>