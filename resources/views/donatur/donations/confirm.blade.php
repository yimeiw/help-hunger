<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold text-redb mb-4 text-center">Konfirmasi Donasi Anda</h2>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-6 border-b pb-4">
                <p class="text-lg font-semibold text-gray-700">Event Donasi: <span class="font-bold text-redb">{{ $donation->event->event_name }}</span></p>
                <p class="text-xl font-bold text-gray-800 mt-2">Jumlah Donasi: <span class="text-redb">IDR {{ number_format($donation->amount, 0, ',', '.') }}</span></p>
                <p class="text-md text-gray-700 mt-2">Metode Pembayaran: <span class="font-semibold">{{ $donation->payment_method }}</span></p>
            </div>

            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4" role="alert">
                <p class="font-bold">Penting:</p>
                <p>Silakan lakukan transfer ke detail rekening di bawah ini dan unggah bukti pembayaran Anda.</p>
                <p>Donasi Anda akan berstatus <span class="font-bold">Pending</span> hingga verifikasi pembayaran selesai.</p>
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-3">Detail Rekening Tujuan:</h3>
            <div class="bg-gray-100 p-4 rounded-md mb-6">
                <p class="text-md text-gray-700">Bank: <span class="font-bold text-redb">{{ $partnerAccount->rekening_type }}</span></p>
                <p class="text-md text-gray-700">Nomor Rekening: <span class="font-bold text-redb text-2xl">{{ $partnerAccount->no_rekening }}</span></p>
                <p class="text-md text-gray-700">Atas Nama: <span class="font-bold text-redb">{{ $donation->event->partner->partner_name }}</span></p>
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-3">Unggah Bukti Pembayaran:</h3>
            <form action="{{ route('donatur.donations.upload-proof', ['donation_id' => $donation->id]) }}" method="POST" enctype="multipart/form-data" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label for="payment_proof" class="block text-gray-700 text-sm font-bold mb-2">Pilih File Bukti Transfer:</label>
                    <input type="file" name="payment_proof" id="payment_proof" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <button type="submit" class="bg-redb hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Unggah Bukti
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('donatur.donations.landing') }}" class="text-blue-600 hover:underline">Kembali ke Halaman Donasi</a>
            </div>
        </div>
    </div>
</x-app-layout>