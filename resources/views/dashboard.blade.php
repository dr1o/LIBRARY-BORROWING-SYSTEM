<x-app-layout>
    <!-- Background Container -->
    <div class="relative w-full bg-cover bg-center bg-no-repeat"
         style="height: calc(100vh - 65px); background-image: url('{{ asset('images/background-lab.jpg') }}');">

        <!-- Dark Overlay (Adjust the 'bg-black/60' if you want it darker or lighter) -->
        <div class="absolute inset-0 bg-black/60"></div>

        <!-- Content Container -->
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
            
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-8 tracking-tight drop-shadow-lg">
                Sistem Peminjaman Alat Lab
            </h1>

            <!-- Tombol Search -->
            <a href="{{ route('equipments.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-blue-600 border border-transparent rounded-lg font-bold text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none transition shadow-[0_0_15px_rgba(37,99,235,0.5)] hover:shadow-[0_0_25px_rgba(37,99,235,0.8)] text-lg transform hover:-translate-y-1">
                <!-- Icon Search -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Cari Alat
            </a>

        </div>
    </div>
</x-app-layout>