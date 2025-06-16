<x-app-layout>
    <a href="{{ route('donatur.donations.landing') }}" class="flex m-8">
        <svg width="44" height="44" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="9" y="9" width="52" height="52" rx="26" stroke="#3F8044" stroke-width="2"/>
            <rect x="11" y="11" width="48" height="48" rx="24" fill="#1E1E1E"/>
            <rect x="11" y="11" width="48" height="48" rx="24" stroke="#D9D9D9" stroke-width="2"/>
            <path d="M39 22.5L27 35L39 47.5" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </a>

    <div class="w-full flex justify-center items-center mb-4">
        <div class="w-full sm:max-w-2xl m-8 shadow-md sm:rounded-xl border border-2 border-blackAuth">
            <div class="border border-2 border-redb rounded-lg p-0">
                <div class="border border-2 px-11 py-10 h-auto border-creamhh bg-greenAuth rounded-lg">
                    <h2 class="text-2xl font-bold text-creamcard mb-6 text-center">Confirm Your Donation</h2>
                    
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

                    <div class="mb-6 border-b pb-4 p-4 bg-creamcard shadow-lg rounded-md">
                        <p class="text-md font-medium text-redb">Donation Event: <span class="font-bold text-redb">{{ $donation->event->event_name }}</span></p>
                        <p class="text-md font-medium text-redb mt-2">Total Donation: <span class="text-redb font-bold">IDR {{ number_format($donation->amount, 0, ',', '.') }}</span></p>
                        <p class="text-md font-medium text-redb mt-2">Metode Pembayaran: <span class="font-bold">{{ $donation->payment_method }}</span></p>
                    </div>

                    <div class="mb-6 bg-yellow-50 border-l-4 shadow-lg rounded-lg border-yellow-400 text-yellow-800 text-sm p-4" role="alert">
                        <p class="font-bold">Important!</p>
                        <p>Silakan lakukan transfer ke detail rekening di bawah ini dan unggah bukti pembayaran Anda.</p>
                        <p>Donasi Anda akan berstatus <span class="font-bold">Pending</span> hingga verifikasi pembayaran selesai.</p>
                    </div>

                    <h3 class="text-xl font-bold text-creamcard mb-3">Detail Rekening Tujuan:</h3>
                    <div class="bg-creamcard shadow-lg p-4 rounded-md mb-6">
                        <p class="text-md text-redb">Bank: <span class="font-bold text-redb">{{ $partnerAccount->rekening_type }}</span></p>
                        <p class="text-md text-redb">Nomor Rekening: <span class="font-bold text-redb text-2xl">{{ $partnerAccount->no_rekening }}</span></p>
                        <p class="text-md text-redb">Atas Nama: <span class="font-bold text-redb">{{ $donation->event->partner->partner_name }}</span></p>
                    </div>

                    <h3 class="text-xl font-bold text-creamcard mb-3">Unggah Bukti Pembayaran:</h3>
                    <form action="{{ route('donatur.donations.upload-proof', ['donation_id' => $donation->id]) }}" method="POST" enctype="multipart/form-data" class="mb-6">
                        @csrf
                        <div class="mb-4">
                            <label for="payment_proof" class="block text-creamcard text-sm font-bold mb-2">Pilih File Bukti Transfer:</label>
                            <div class="relative flex items-center w-full text-creamcard leading-tight focus-within:outline-none focus-within:shadow-outline border-none"> 
                                <div class="flex-grow flex items-center gap-6 py-2  cursor-pointer" id="custom_upload_button">
                                    <span class="flex-shrink-0 ml-2 bg-creamcard shadow-quadrupleNonHover hover:shadow-quadrupleHover text-redb font-bold py-2 px-4 rounded">
                                        Choose File
                                    </span>
                                    <span id="file_name_display" class="text-creamcard truncate">
                                        No file chosen
                                    </span> 
                            </div>

                            <input type="file" name="payment_proof" id="payment_proof" class="hidden" required>
                        </div>
                        </div>
                        <div class="flex items-center justify-center ">
                            <button type="submit" class="bg-creamcard text-redb shadow-quadrupleNonHover font-bold py-2 px-4 rounded hover:shadow-quadrupleHover focus:outline-none focus:shadow-outline w-1/2">
                                Unggah Bukti
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const customUploadButton = document.getElementById('custom_upload_button');
        const paymentProofInput = document.getElementById('payment_proof');
        const fileNameDisplay = document.getElementById('file_name_display');

        customUploadButton.addEventListener('click', () => {
            paymentProofInput.click(); // Memicu klik pada input asli
        });

        paymentProofInput.addEventListener('change', () => {
            if (paymentProofInput.files.length > 0) {
                fileNameDisplay.textContent = paymentProofInput.files[0].name;
                // Anda bisa tambahkan/hapus kelas di sini jika ingin mengubah tampilan setelah file dipilih
            } else {
                fileNameDisplay.textContent = 'No file chosen';
            }
        });
    });
</script>
</x-app-layout>