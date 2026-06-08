            </main>

            <!-- Footer Hak Cipta -->
            <footer class="bg-white border-t border-slate-100 py-4 px-6 text-center text-xs text-slate-400">
                <p>&copy; <?php echo date('Y'); ?> www.peduli-mahasiswa.com. All Rights Reserved.</p>
                <p class="mt-1 text-[10px] text-slate-300">Dibuat dengan Tailwind CSS & SweetAlert2</p>
            </footer>

        </div>
    </div>

    <!-- Script Javascript untuk Interaksi Client-Side -->
    <script>
        // Logika Toggle Sidebar untuk Layar Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                if (overlay) overlay.classList.remove('hidden');
            } else {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                if (overlay) overlay.classList.add('hidden');
            }
        }

        // Toggles Dropdown Notifikasi & Profil
        function toggleNotificationDropdown() {
            const notif = document.getElementById('notif-dropdown');
            const profile = document.getElementById('profile-dropdown');
            if (profile) profile.classList.add('hidden');
            if (notif) notif.classList.toggle('hidden');
        }

        // Toggles Profile Dropdown
        function toggleProfileDropdown() {
            const notif = document.getElementById('notif-dropdown');
            const profile = document.getElementById('profile-dropdown');
            if (notif) notif.classList.add('hidden');
            if (profile) profile.classList.toggle('hidden');
        }

        // Menutup dropdown ketika klik di luar elemen
        window.addEventListener('click', function(e) {
            const notif = document.getElementById('notif-dropdown');
            const profile = document.getElementById('profile-dropdown');
            
            if (notif && !notif.classList.contains('hidden')) {
                const btn = notif.previousElementSibling || document.querySelector('[onclick="toggleNotificationDropdown()"]');
                if (!notif.contains(e.target) && !btn.contains(e.target)) {
                    notif.classList.add('hidden');
                }
            }
            
            if (profile && !profile.classList.contains('hidden')) {
                const btn = profile.previousElementSibling || document.querySelector('[onclick="toggleProfileDropdown()"]');
                if (!profile.contains(e.target) && !btn.contains(e.target)) {
                    profile.classList.add('hidden');
                }
            }
        });

        // Modals Open/Close
        function openProfileModal() {
            const profileDropdown = document.getElementById('profile-dropdown');
            if (profileDropdown) profileDropdown.classList.add('hidden');
            document.getElementById('profile-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeProfileModal() {
            document.getElementById('profile-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Confirm Logout
        function confirmLogout(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar dari sistem?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb', // Blue-600
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl border-2 border-slate-200 font-sans'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Berhasil Keluar',
                        text: 'Sesi admin berhasil ditutup.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-3xl border-2 border-slate-200 font-sans'
                        }
                    }).then(() => {
                        window.location.href = '<?php echo base_url("auth/logout"); ?>';
                    });
                }
            });
        }

        // Penanganan Notifikasi SweetAlert2 dari URL Parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            
            if (urlParams.has('status')) {
                const status = urlParams.get('status');
                let icon = 'info';
                let title = 'Informasi';
                let text = '';

                if (status === 'success_profile') {
                    icon = 'success';
                    title = 'Profil Diperbarui!';
                    text = 'Profil admin berhasil diperbarui.';
                } else if (status === 'error_profile') {
                    icon = 'error';
                    title = 'Gagal!';
                    text = 'Terjadi kesalahan saat memperbarui profil admin.';
                } else if (urlParams.has('message')) {
                    const statusParam = urlParams.get('status');
                    icon = statusParam === 'success' ? 'success' : (statusParam === 'error' ? 'error' : (statusParam === 'warning' ? 'warning' : 'info'));
                    title = statusParam === 'success' ? 'Berhasil!' : (statusParam === 'error' ? 'Gagal!' : (statusParam === 'warning' ? 'Peringatan!' : 'Informasi'));
                    text = urlParams.get('message');
                } else {
                    return;
                }

                Swal.fire({
                    icon: icon,
                    title: title,
                    text: text,
                    confirmButtonColor: '#2563eb',
                    customClass: {
                        popup: 'rounded-3xl border-2 border-slate-200 font-sans',
                        confirmButton: 'px-5 py-2.5 rounded-xl font-medium text-sm'
                    }
                });
                
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });

        // Konfirmasi Hapus Data menggunakan SweetAlert2
        function konfirmasiHapus(url, itemNama = 'data ini') {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan menghapus " + itemNama + ". Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl border-2 border-slate-200 font-sans',
                    confirmButton: 'px-5 py-2.5 rounded-xl font-medium text-sm mr-2',
                    cancelButton: 'px-5 py-2.5 rounded-xl font-medium text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
</body>
</html>
