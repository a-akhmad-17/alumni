<footer class="bg-white border-t border-slate-200 text-slate-600 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 items-start">
            <!-- Col 1: Brand & Deskripsi (Kiri) -->
            <div class="md:col-span-5 lg:col-span-5 space-y-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/images/logo.webp') }}" alt="Logo IKA SMAN Kajuara / IKA SMAN 8 BONE" class="h-11 w-auto object-contain shrink-0">
                    <div>
                        <span class="font-heading font-extrabold text-base text-slate-900 tracking-tight block leading-snug">IKA SMAN KAJUARA</span>
                        <span class="text-xs text-amber-700 font-extrabold tracking-wider block uppercase">IKA SMAN 8 BONE</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed max-w-md">
                    Wadah resmi silaturahmi, jaringan profesional, dan pengabdian alumni Ikatan Keluarga Alumni SMAN Kajuara / SMAN 8 Bone untuk almamater dan masyarakat.
                </p>
                <div class="flex space-x-2 pt-1">
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-colors text-xs" title="Instagram" aria-label="Instagram IKA SMAN Kajuara / SMAN 8 Bone">
                        <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                        <span class="sr-only">Instagram IKA SMAN Kajuara / SMAN 8 Bone</span>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-colors text-xs" title="Facebook" aria-label="Facebook IKA SMAN Kajuara / SMAN 8 Bone">
                        <i class="fa-brands fa-facebook" aria-hidden="true"></i>
                        <span class="sr-only">Facebook IKA SMAN Kajuara / SMAN 8 Bone</span>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-colors text-xs" title="YouTube" aria-label="YouTube IKA SMAN Kajuara / SMAN 8 Bone">
                        <i class="fa-brands fa-youtube" aria-hidden="true"></i>
                        <span class="sr-only">YouTube IKA SMAN Kajuara / SMAN 8 Bone</span>
                    </a>
                    <a href="mailto:info@ikasman8bone.org" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-colors text-xs" title="Email" aria-label="Email IKA SMAN Kajuara / SMAN 8 Bone">
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i>
                        <span class="sr-only">Email IKA SMAN Kajuara / SMAN 8 Bone</span>
                    </a>
                </div>
            </div>

            <!-- Col 2: Sekretariat (Tengah) -->
            <div class="md:col-span-3 lg:col-span-3 space-y-3">
                <h4 class="font-heading font-bold text-slate-900 text-xs uppercase tracking-wider mb-3 flex items-center">
                    <i class="fa-solid fa-building text-amber-500 mr-2"></i>Sekretariat
                </h4>
                <div class="space-y-3 text-xs">
                    <p class="flex items-start">
                        <i class="fa-solid fa-location-dot text-slate-700 mr-2.5 mt-0.5 shrink-0"></i>
                        <span class="leading-relaxed">Jl. Pahlawan No.Kel, Awang Tangka, Kec. Kajuara, Kabupaten Bone, Sulawesi Selatan 92776, Indonesia</span>
                    </p>
                    <p class="flex items-center">
                        <i class="fa-solid fa-envelope text-slate-700 mr-2.5 shrink-0"></i>
                        <span>info@ikasman8bone.org</span>
                    </p>
                </div>
            </div>

            <!-- Col 3: Peta Lokasi Sekretariat (Kanan) -->
            <div class="md:col-span-4 lg:col-span-4 space-y-3">
                <h4 class="font-heading font-bold text-slate-900 text-xs uppercase tracking-wider mb-3 flex items-center">
                    <i class="fa-solid fa-map-location-dot text-amber-500 mr-2"></i>Lokasi Sekretariat
                </h4>
                <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition duration-300">
                    <iframe 
                        src="https://maps.google.com/maps?q=SMA+Negeri+8+Bone+Kajuara+Sulawesi+Selatan&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                        class="w-full h-44 border-0" 
                        title="Peta Lokasi Sekretariat IKA SMAN Kajuara / SMAN 8 Bone di Kajuara, Kabupaten Bone"
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200 mt-12 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-600 gap-3">
            <p class="text-center sm:text-left">&copy; {{ date('Y') }} IKA SMAN Kajuara / IKA SMAN 8 Bone. All rights reserved.</p>
            <div class="flex items-center space-x-4">
                <a href="{{ route('profil') }}" class="hover:text-slate-900 transition">Tentang Kami</a>
                <a href="{{ route('ad-art') }}" class="hover:text-slate-900 transition font-bold text-slate-700">AD / ART Organisasi</a>
                <a href="{{ route('struktur') }}" class="hover:text-slate-900 transition">Struktur Pengurus</a>
            </div>
        </div>
    </div>
</footer>
