<x-app-layout>
    @section('title', 'Our Partners')
    <body class="text-redb scroll-smooth">
        <p class="font-bold text-redb text-3xl text-center mt-12 mb-4 px-96">
            OUR PARTNER
        </p>
        <p class="font-regular text-redb text-lg text-center mb-10 px-72">
            <span class="font-bold">HelpHunger</span> cannot work alone. We believe that <span class="font-bold">collaboration</span> is the key to creating sustainable solutions to hunger and food waste. Through <span class="font-bold">partnerships</span> with various groups — from local communities and NGOs to orphanages — we build a supportive network of solidarity. Each partner plays a vital role in expanding our reach, strengthening distribution, and ensuring aid is delivered to the right people. <br> <br>
            <span class="font-bold">Together</span> with our partners, we’re not just <span class="font-bold">sharing food</span> — we’re <span class="font-bold">sharing hope</span>.
        </p>

        <div class="flex items-center justify-center pl-8 pr-8 pt-4">
            <hr class="border-t-2 border-redb w-full">
        </div>

        <div id="community" class="m-10">
            <p class="text-3xl text-redb font-bold mb-2">Community Partner</p>
            <p class="text-lg text-redb font-regular mb-10">Local communities play a vital role in reaching areas and groups most in need. HelpHunger collaborates with various communities to coordinate food distribution, organize public kitchens, and raise awareness about the importance of sharing. Together with communities, we build grassroots solidarity.</p>
            <div class="flex flex-row justify-center items-center gap-12 bg-greenbg p-8 rounded-lg h-72">
                @foreach($partners as $partner)
                    @if ($partner->type === 'community')
                        
                        <a target="_blank" rel="noopener noreferrer" href="{{ $partner->partner_link }}" class="group relative flex flex-col items-center justify-center bg-creamcard p-6 h-full w-40 rounded-lg shadow-quadrupleNonHover hover:shadow-quadrupleHover hover:text-greenbg transition duration-300 ease-in-out">
                            <div class="flex items-center">
                                <p class="text-center text-redb font-bold text-lg leading-tight">{{ $partner->partner_name }}</p>
                            </div>
                            <div class="h-14 flex items-center mt-6">
                                <img src="{{ asset('/assets/community-partner.svg') }}" alt="" class="object-contain max-h-full">
                            </div>

                            <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center px-4 text-center opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out backdrop-blur-sm bg-redb/100 rounded-lg">
                                <p class="text-creamcard font-bold text-base">Explore the Community</p>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-center pl-8 pr-8 pt-4">
            <hr class="border-t-2 border-redb w-full">
        </div>

        <div id="ngo" class="m-10">
            <p class="text-3xl text-redb font-bold mb-2 text-right">NGO Partner</p>
            <p class="text-lg text-redb font-regular text-right mb-10">Non-profit organizations are strategic allies in our mission. HelpHunger partners with NGOs working in food, humanitarian, and social sectors to expand the reach of aid, strengthen distribution systems, and develop sustainable, high-impact programs.</p>
            <div class="flex flex-row justify-center items-center gap-12 bg-greenbg p-8 rounded-lg h-72">
                @foreach($partners as $partner)
                    @if ($partner->type === 'ngo')
                        <a target="_blank" rel="noopener noreferrer" href="{{ $partner->partner_link }}" class="group relative flex flex-col items-center justify-center bg-creamcard p-6 h-full w-40 rounded-lg shadow-quadrupleNonHover hover:shadow-quadrupleHover hover:text-greenbg transition duration-300 ease-in-out">
                            <div class="flex items-center">
                                <p class="text-center text-redb font-bold text-lg leading-tight">{{ $partner->partner_name }}</p>
                            </div>
                            <div class="h-14 flex items-center mt-6">
                                <img src="{{ asset('/assets/community-partner.svg') }}" alt="" class="object-contain max-h-full">
                            </div>

                            <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center px-4 text-center opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out backdrop-blur-sm bg-redb/100 rounded-lg">
                                <p class="text-creamcard font-bold text-base">Explore the NGO</p>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-center pl-8 pr-8 pt-4">
            <hr class="border-t-2 border-redb w-full">
        </div>

        <div id="orphanage" class="m-10">
            <p class="text-3xl text-redb font-bold mb-2">Orphanage Partner</p>
            <p class="text-lg text-redb font-regular mb-10">Local communities play a vital role in reaching areas and groups most in need. HelpHunger collaborates with various communities to coordinate food distribution, organize public kitchens, and raise awareness about the importance of sharing. Together with communities, we build grassroots solidarity.</p>
            <div class="flex flex-row justify-center items-center gap-12 bg-greenbg p-8 rounded-lg h-72">
                @foreach($partners as $partner)
                    @if ($partner->type === 'orphanage')
                        
                        <a target="_blank" rel="noopener noreferrer" href="{{ $partner->partner_link }}" class="group relative flex flex-col items-center justify-center bg-creamcard p-6 h-full w-40 rounded-lg shadow-quadrupleNonHover hover:shadow-quadrupleHover hover:text-greenbg transition duration-300 ease-in-out">
                            <div class="flex items-center">
                                <p class="text-center text-redb font-bold text-lg leading-tight">{{ $partner->partner_name }}</p>
                            </div>
                            <div class="h-14 flex items-center mt-6">
                                <img src="{{ asset('/assets/community-partner.svg') }}" alt="" class="object-contain max-h-full">
                            </div>

                            <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center px-4 text-center opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out backdrop-blur-sm bg-redb/100 rounded-lg">
                                <p class="text-creamcard font-bold text-base">Explore the Orphanage</p>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="flex items-center justify-center pl-8 pr-8 pt-4">
            <hr class="border-t-2 border-redb w-full">
        </div>

        <div class="flex flex-col justify-center items-center gap-2 text-center mt-8 mb-10 m-72">
            <div class="font-bold text-redb text-3xl ">
                <p >Be Part of a Network of Kindness</p>
            </div>
            <div class="font-bold text-redb text-lg leading-tight">
                <p >Are you part of a community, NGO, orphanage, or other social organization that cares about food waste and hunger issues? Join HelpHunger as a partner and let’s work together to build a faster, fairer, and more sustainable food distribution system.</p>
            </div>
            <div class="font-regular text-redb text-lg">
                <p>💡 By becoming a partner, you will:</p>
                <ul class="list-disc text-redb list-inside">
                    <li>
                        Connect with a network of donors and volunteers
                    </li>
                    <li>
                        Get logistical and technical support
                    </li>
                    <li>
                        Expand the reach and impact of your social mission
                    </li>
                </ul>
            </div>

            <a href="{{ route('register') }}" class="bg-creamcard font-bold text-redb text-base px-8 py-2 border border-2 border-redb rounded-lg mt-4 hover:text-greenbg hover:border-greenbg transition duration-300 ease-in-out">Apply as a Partner</a>
        </div>
    </body>
</x-app-layout>