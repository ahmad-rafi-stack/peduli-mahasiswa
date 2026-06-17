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
            if (typeof cropper !== 'undefined' && cropper) {
                cropper.destroy();
                cropper = null;
            }
            const cropAreaContainer = document.getElementById('crop-area-container');
            const fileInput = document.querySelector('input[name="foto_admin"]');
            const imageToCrop = document.getElementById('image-to-crop');
            const croppedFotoInput = document.getElementById('cropped_foto');
            if (cropAreaContainer) cropAreaContainer.classList.add('hidden');
            if (imageToCrop) imageToCrop.src = '';
            if (fileInput) fileInput.value = '';
            if (croppedFotoInput) croppedFotoInput.value = '';
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
        // Mengirim via POST form (CSRF-protected) untuk mencegah CSRF bypass via GET
        function konfirmasiHapus(url, itemNama = 'data ini', idField = 'id') {
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
                    submitDeleteForm(url, idField);
                }
            });
        }

        // Read CSRF hash from cookie set by CodeIgniter (token regenerated per request)
        function getCsrfHash() {
            const name = '<?php echo config_item('csrf_cookie_name'); ?>';
            const match = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
            return match ? decodeURIComponent(match.pop()) : '';
        }

        // Submit a hidden POST form to a delete endpoint (CSRF-protected)
        function submitDeleteForm(actionUrl, idField) {
            let form = document.getElementById('globalDeleteForm');
            if (!form) {
                form = document.createElement('form');
                form.id = 'globalDeleteForm';
                form.method = 'POST';
                form.style.display = 'none';
                document.body.appendChild(form);
            }
            form.action = actionUrl;
            form.innerHTML =
                '<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="' + getCsrfHash() + '">' +
                '<input type="hidden" name="' + idField + '" value="1">';
            form.submit();
        }

        // Penanganan Cropper.js untuk Foto Profil Admin
        var cropper = null;
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.querySelector('input[name="foto_admin"]');
            const cropAreaContainer = document.getElementById('crop-area-container');
            const imageToCrop = document.getElementById('image-to-crop');
            const btnCropCancel = document.getElementById('btn-crop-cancel');
            const btnCropConfirm = document.getElementById('btn-crop-confirm');
            const croppedFotoInput = document.getElementById('cropped_foto');
            const profileForm = document.getElementById('profile-form');

            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const files = e.target.files;
                    if (files && files.length > 0) {
                        const file = files[0];
                        if (file.size > 2 * 1024 * 1024) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ukuran File Terlalu Besar',
                                text: 'Maksimal ukuran file adalah 2MB.',
                                confirmButtonColor: '#2563eb',
                                customClass: { popup: 'rounded-3xl border-2 border-slate-200 font-sans' }
                            });
                            fileInput.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imageToCrop.src = e.target.result;
                            cropAreaContainer.classList.remove('hidden');
                            
                            if (cropper) {
                                cropper.destroy();
                            }
                            
                            cropper = new Cropper(imageToCrop, {
                                aspectRatio: 1,
                                viewMode: 1,
                                dragMode: 'move',
                                autoCropArea: 1,
                                restore: false,
                                guides: false,
                                center: true,
                                highlight: false,
                                cropBoxMovable: true,
                                cropBoxResizable: true,
                                toggleDragModeOnDblclick: false,
                            });
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            if (btnCropCancel) {
                btnCropCancel.addEventListener('click', function() {
                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }
                    imageToCrop.src = '';
                    cropAreaContainer.classList.add('hidden');
                    fileInput.value = '';
                    croppedFotoInput.value = '';
                });
            }

            if (btnCropConfirm) {
                btnCropConfirm.addEventListener('click', function() {
                    if (cropper) {
                        const canvas = cropper.getCroppedCanvas({
                            width: 300,
                            height: 300
                        });
                        
                        croppedFotoInput.value = canvas.toDataURL('image/jpeg', 0.9);
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Foto Terpotong!',
                            text: 'Foto profil berhasil disesuaikan. Klik Simpan Perubahan untuk mengunggah.',
                            timer: 1500,
                            showConfirmButton: false,
                            customClass: { popup: 'rounded-3xl border-2 border-slate-200 font-sans' }
                        });
                        
                        cropper.destroy();
                        cropper = null;
                        cropAreaContainer.classList.add('hidden');
                    }
                });
            }

            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    if (cropper) {
                        const canvas = cropper.getCroppedCanvas({
                            width: 300,
                            height: 300
                        });
                        croppedFotoInput.value = canvas.toDataURL('image/jpeg', 0.9);
                    }
                });
            }
        });
    </script>
</body>
</html>
