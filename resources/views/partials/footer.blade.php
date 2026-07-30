<footer class="bg-white border-t border-slate-200 text-slate-600 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-8 items-start">
            <!-- Col 1: Brand & Deskripsi -->
            <div class="lg:col-span-4 space-y-3">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('assets/images/logo.webp') }}" alt="Logo IKA SMAN Kajuara / IKA SMAN 8 BONE" class="h-11 w-auto object-contain shrink-0">
                    <div>
                        <span class="font-heading font-extrabold text-base text-slate-900 tracking-tight block leading-snug">IKA SMAN KAJUARA</span>
                        <span class="text-xs text-amber-600 font-extrabold tracking-wider block uppercase">IKA SMAN 8 BONE</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed max-w-sm">
                    Wadah silaturahmi, jaringan profesional, dan pengabdian alumni Ikatan Keluarga Alumni SMAN Kajuara / SMAN 8 Bone untuk almamater dan masyarakat.
                </p>
                <div class="flex space-x-2 pt-1">
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-colors text-xs"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-colors text-xs"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-colors text-xs"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-colors text-xs"><i class="fa-solid fa-envelope"></i></a>
                </div>
            </div>

            <!-- Col 2: Sekretariat -->
            <div class="lg:col-span-3">
                <h4 class="font-heading font-bold text-slate-900 text-xs uppercase tracking-wider mb-3">Sekretariat</h4>
                <div class="space-y-2 text-xs">
                    <p class="flex items-start">
                        <i class="fa-solid fa-location-dot text-slate-700 mr-2.5 mt-0.5 shrink-0"></i>
                        <span>Jl. H. Abd. Hamid, Kajuara, Kab. Bone, Sulsel 92776</span>
                    </p>
                    <p class="flex items-center">
                        <i class="fa-solid fa-envelope text-slate-700 mr-2.5 shrink-0"></i>
                        <span>info@ikasman8bone.org</span>
                    </p>
                    <p class="flex items-center">
                        <i class="fa-solid fa-phone text-slate-700 mr-2.5 shrink-0"></i>
                        <span>+62 812-3456-7890</span>
                    </p>
                </div>
            </div>

            <!-- Col 3: Layanan KTA Alumni -->
            <div class="lg:col-span-2">
                <h4 class="font-heading font-bold text-slate-900 text-xs uppercase tracking-wider mb-3 flex items-center">
                    <i class="fa-solid fa-id-card text-amber-500 mr-1.5"></i>KTA Alumni
                </h4>
                <div class="space-y-2 text-xs">
                    <p class="flex items-center text-slate-700">
                        <i class="fa-solid fa-address-card text-slate-700 mr-2 shrink-0"></i>
                        <span>E-KTA Digital Alumni</span>
                    </p>
                    <p class="flex items-center text-slate-700">
                        <i class="fa-solid fa-shield-check text-emerald-600 mr-2 shrink-0"></i>
                        <span>Terverifikasi Sistem</span>
                    </p>
                    <p class="flex items-center text-slate-700">
                        <i class="fa-solid fa-qrcode text-slate-700 mr-2 shrink-0"></i>
                        <span>Integrasi QR Anggota</span>
                    </p>
                </div>
            </div>

            <!-- Col 4: Peta Lokasi -->
            <div class="lg:col-span-3">
                <h4 class="font-heading font-bold text-slate-900 text-xs uppercase tracking-wider mb-3 flex items-center">
                    <i class="fa-solid fa-map-location-dot text-amber-500 mr-1.5"></i>Lokasi Sekretariat
                </h4>
                <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition duration-300">
                    <iframe 
                        src="https://maps.google.com/maps?q=SMA+Negeri+8+Bone+Kajuara+Sulawesi+Selatan&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                        class="w-full h-44 border-0" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200 mt-12 pt-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-3">
            <p class="text-center sm:text-left">&copy; {{ date('Y') }} IKA SMAN Kajuara / IKA SMAN 8 Bone. All rights reserved.</p>
            <p class="shrink-0">Powered by <span class="text-slate-900 font-bold">Alexa Enterprise Engine</span></p>
        </div>
    </div>
</footer>
