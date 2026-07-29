// assets/js/app.js - Interactive Scripts for Alumni IKA SMAN 8 Bone

document.addEventListener('DOMContentLoaded', () => {
    // Mobile Nav Toggle
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navLinks = document.querySelector('.nav-links');

    if (mobileToggle && navLinks) {
        mobileToggle.addEventListener('click', () => {
            if (navLinks.style.display === 'flex') {
                navLinks.style.display = 'none';
            } else {
                navLinks.style.display = 'flex';
                navLinks.style.flexDirection = 'column';
                navLinks.style.position = 'absolute';
                navLinks.style.top = '100%';
                navLinks.style.left = '0';
                navLinks.style.width = '100%';
                navLinks.style.background = '#ffffff';
                navLinks.style.padding = '1.5rem';
                navLinks.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
            }
        });
    }

    // Modal Details for Pengurus
    const modalBackdrop = document.getElementById('pengurusModal');
    const modalClose = document.querySelector('.modal-close');

    if (modalBackdrop) {
        const modalPhoto = document.getElementById('modalPhoto');
        const modalName = document.getElementById('modalName');
        const modalJabatan = document.getElementById('modalJabatan');
        const modalTugas = document.getElementById('modalTugas');
        const modalIg = document.getElementById('modalIg');
        const modalLi = document.getElementById('modalLi');

        document.querySelectorAll('[data-pengurus-id]').forEach(card => {
            card.addEventListener('click', () => {
                const name = card.dataset.nama || 'Pengurus IKA';
                const jabatan = card.dataset.jabatan || '';
                const foto = card.dataset.foto || '';
                const tugas = card.dataset.tugas || 'Bertanggung jawab atas pelaksanaan program kerja sesuai amanah organisasi.';
                const ig = card.dataset.ig || '';
                const li = card.dataset.li || '';

                if (modalName) modalName.textContent = name;
                if (modalJabatan) modalJabatan.textContent = jabatan;
                if (modalTugas) modalTugas.textContent = tugas;

                if (modalPhoto) {
                    modalPhoto.src = foto ? foto : 'assets/images/logo.webp';
                }

                if (modalIg) {
                    if (ig) {
                        modalIg.href = 'https://instagram.com/' + ig.replace('@', '');
                        modalIg.style.display = 'inline-flex';
                        modalIg.innerHTML = '📷 ' + ig;
                    } else {
                        modalIg.style.display = 'none';
                    }
                }

                if (modalLi) {
                    if (li) {
                        modalLi.href = li.startsWith('http') ? li : 'https://' + li;
                        modalLi.style.display = 'inline-flex';
                        modalLi.innerHTML = '💼 LinkedIn';
                    } else {
                        modalLi.style.display = 'none';
                    }
                }

                modalBackdrop.classList.add('active');
            });
        });

        if (modalClose) {
            modalClose.addEventListener('click', () => {
                modalBackdrop.classList.remove('active');
            });
        }

        modalBackdrop.addEventListener('click', (e) => {
            if (e.target === modalBackdrop) {
                modalBackdrop.classList.remove('active');
            }
        });
    }

    // Alumni Search Filter
    const alumniSearchInput = document.getElementById('alumniSearch');
    const angkatanFilter = document.getElementById('angkatanFilter');
    const alumniRows = document.querySelectorAll('.alumni-row');

    function filterAlumni() {
        if (!alumniRows.length) return;
        const query = (alumniSearchInput?.value || '').toLowerCase();
        const selectedAngkatan = angkatanFilter?.value || '';

        alumniRows.forEach(row => {
            const nama = row.dataset.nama.toLowerCase();
            const angkatan = row.dataset.angkatan;
            const profesi = row.dataset.profesi.toLowerCase();
            const domisili = row.dataset.domisili.toLowerCase();

            const matchQuery = nama.includes(query) || profesi.includes(query) || domisili.includes(query);
            const matchAngkatan = !selectedAngkatan || angkatan === selectedAngkatan;

            if (matchQuery && matchAngkatan) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (alumniSearchInput) alumniSearchInput.addEventListener('input', filterAlumni);
    if (angkatanFilter) angkatanFilter.addEventListener('change', filterAlumni);
});
