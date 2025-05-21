<x-layouts.app title="Bank Sampah">

    <section class="h-screen flex p-16 bg-gray-50">
        <div class="w-[60%] flex flex-col">
            <h1 class="text-6xl text-emerald-700 font-semibold text-wrap mb-4">Selamat Datang di Bank Sampah IPB</h1>
            <div class="leading-8 text-lg">Bank Sampah IPB hadir sebagai solusi cerdas untuk mengelola sampah dengan
                lebih efisien dan bertanggung jawab. Kami menyediakan wadah bagi Anda untuk menukarkan sampah yang
                terpilah dengan nilai ekonomi yang bermanfaat, sekaligus berkontribusi pada pelestarian lingkungan.
                Mari jadi bagian dari perubahan positif dengan mengelola sampah secara bijak.</div>
            <div class="flex mt-8 gap-4">
                <a href="{{ route('auth.login.choice') }}"
                    class="px-5 py-3 bg-emerald-600 text-white font-medium rounded-full shadow-md border-1 border-emerald-700 hover:bg-emerald-700 hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300 flex items-center">Bergabung
                    Sekarang</a>
                <a href="#second"
                    class="px-5 py-3 bg-white text-emerald-600 font-medium rounded-full shadow-md border-1 border-emerald-600 hover:bg-gray-100 hover:shadow-lg transform hover:-translate-y-0.5 transition duration-300 flex items-center">Eksplor
                    Sekarang</a>
            </div>
        </div>
        <div class="flex items-center justify-center overflow-y-hidden">
            <img src="{{ asset('assets/recycling-icon-design 1.png') }}" alt="Recycling Image"
                class="w-128 h-auto object-cover">
        </div>

    </section>

    <section id="second" class="h-screen bg-emerald-100 flex flex-col justify-center items-center overflow-hidden">
        <h1 class="text-4xl font-semibold mb-8">Sudahkah Anda menukar sampah hari ini?</h1>
        <div class="text-center w-[50%] mb-4">
            "Selamat datang di platform penukaran Bank Sampah! Tukar sampah Anda dengan nilai lebih untuk membantu
            menjaga kebersihan lingkungan. Setiap kontribusi Anda berperan penting dalam menciptakan bumi yang lebih
            bersih dan sehat. Bergabunglah bersama kami, wujudkan lingkungan yang lebih baik untuk masa depan!"
        </div>
        <div class="overflow-hidden">

            <img src="{{ asset('assets/extrude-group.png') }}" alt="Orang bertukar" class="w-64 h-auto object-cover">
        </div>
    </section>

    <section>

    </section>

    <section>

    </section>

    <section>

    </section>


</x-layouts.app>
