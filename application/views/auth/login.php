<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Peduli Mahasiswa</title>
    <!-- Tailwind CSS Local Build (Highly Optimized & Offline-friendly) -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/tailwind.css'); ?>">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="bg-gradient-to-tr from-slate-900 via-indigo-950 to-blue-900 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>

    <div class="w-full max-w-md glass rounded-3xl shadow-2xl p-8 md:p-10 relative z-10">
        <!-- Logo/Icon -->
        <div class="flex flex-col items-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg shadow-indigo-500/30 mb-4">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Peduli Mahasiswa</h1>
            <p class="text-sm text-slate-500 text-center mt-1">Sistem Pendataan Mahasiswa Kurang Mampu</p>
        </div>

        <!-- Form -->
        <form action="<?php echo base_url('auth/login_process'); ?>" method="POST" class="space-y-6">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <input type="text" name="username" id="username" required
                           class="block w-full pl-10 pr-4 py-3 bg-white/70 border border-slate-200 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                           placeholder="Masukkan username">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <input type="password" name="password" id="password" required
                           class="block w-full pl-10 pr-4 py-3 bg-white/70 border border-slate-200 rounded-2xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                           placeholder="••••••••">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-2xl shadow-lg shadow-indigo-500/20 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 transform active:scale-[0.98]">
                Masuk ke Sistem <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
            </button>
        </form>

        <!-- Footer Copyright -->
        <div class="mt-8 text-center text-xs text-slate-400">
            &copy; 2026 Peduli Mahasiswa. All Rights Reserved.
        </div>
    </div>

    <!-- SweetAlert2 Handling -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Flashdata Error
            <?php if ($this->session->flashdata('error')): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Masuk',
                    text: <?php echo json_encode($this->session->flashdata('error')); ?>,
                    confirmButtonColor: '#3b82f6',
                    customClass: {
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-2xl px-6 py-2.5 font-semibold text-sm'
                    }
                });
            <?php endif; ?>

            // URL Parameter Status
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const message = urlParams.get('message');
            
            if (status === 'success' && message) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: message,
                    timer: 2000,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-3xl'
                    }
                });
            }
        });
    </script>
</body>
</html>
