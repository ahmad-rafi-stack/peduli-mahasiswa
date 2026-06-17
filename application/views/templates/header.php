<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$current_controller = $this->uri->segment(1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peduli Mahasiswa | Portal Admin</title>
    
    <!-- Web Favicon / Tab Logo -->
    <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/logo.png'); ?>">
    
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS Local Build (Highly Optimized & Offline-friendly) -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/tailwind.css'); ?>">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Cropper.js CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .sidebar-dark {
            background: linear-gradient(180deg, #0f172a 0%, #1e1b4b 50%, #030712 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            overflow: hidden;
        }
        .sidebar-dark::before {
            content: '';
            position: absolute;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, rgba(59, 130, 246, 0) 70%);
            top: 10%;
            left: -80px;
            pointer-events: none;
            z-index: 0;
        }
        .active-glass-capsule {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(147, 197, 253, 0.25);
            color: #ffffff !important;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.25), inset 0 0 10px rgba(255, 255, 255, 0.05);
        }
        /* Custom Cropper.js agar area potong berbentuk lingkaran */
        .cropper-view-box,
        .cropper-face {
            border-radius: 50%;
        }
    </style>
</head>
<body class="text-slate-800">

    <!-- Wrapper Layout Utama -->
    <div class="min-h-screen flex flex-col md:flex-row">
        
        <!-- Overlay Backdrop for Mobile -->
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-40 md:hidden transition-all"></div>

        <!-- Sidebar Navigation -->
        <aside id="sidebar" class="sidebar-dark fixed md:relative inset-y-0 left-0 z-50 w-64 md:w-64 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col justify-between flex-shrink-0">
            <div class="relative z-10">
                <!-- Logo -->
                <div class="p-6 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden shadow-lg shadow-blue-500/25 flex items-center justify-center border border-white/10 bg-slate-800">
                            <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="Logo" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h1 class="font-bold text-white text-base leading-tight tracking-tight font-outfit">Peduli Mhs</h1>
                            <span class="text-[10px] text-slate-400 font-medium tracking-wide uppercase">Admin Portal</span>
                        </div>
                    </div>
                    <!-- Mobile Close Btn -->
                    <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-white">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                
                <nav class="px-4 py-2 space-y-1">
                    <!-- Dashboard Link -->
                    <a href="<?php echo base_url('dashboard'); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all <?php echo ($current_controller == '' || $current_controller == 'dashboard') ? 'active-glass-capsule text-white font-semibold' : 'text-slate-400 hover:bg-white/5 hover:text-white'; ?>">
                        <i class="fa-solid fa-chart-pie w-5 text-center text-lg"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <!-- Mahasiswa Link -->
                    <a href="<?php echo base_url('mahasiswa'); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all <?php echo ($current_controller == 'mahasiswa') ? 'active-glass-capsule text-white font-semibold' : 'text-slate-400 hover:bg-white/5 hover:text-white'; ?>">
                        <i class="fa-solid fa-users w-5 text-center text-lg"></i>
                        <span>Data Mahasiswa</span>
                    </a>
                    
                    <!-- Bantuan Link -->
                    <a href="<?php echo base_url('bantuan'); ?>" class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all <?php echo ($current_controller == 'bantuan') ? 'active-glass-capsule text-white font-semibold' : 'text-slate-400 hover:bg-white/5 hover:text-white'; ?>">
                        <i class="fa-solid fa-hand-holding-dollar w-5 text-center text-lg"></i>
                        <span>Bantuan Sosial</span>
                    </a>
                </nav>
            </div>
            
            <!-- Bottom Sidebar Action (+ New Mahasiswa) -->
            <div class="p-4 border-t border-white/5 relative z-10">
                <a href="<?php echo base_url('mahasiswa'); ?>" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white flex items-center justify-center space-x-2 py-3 px-4 rounded-xl shadow-lg shadow-blue-500/20 transition-all duration-300 font-medium text-sm">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Tambah Mahasiswa</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Topbar Header -->
            <header class="bg-white/80 backdrop-blur-md px-4 md:px-8 py-5 flex items-center justify-between sticky top-0 z-10 border-b border-slate-100/50">
                <div class="flex items-center space-x-4">
                    <button onclick="toggleSidebar()" class="md:hidden text-slate-500 hover:text-slate-800 p-2 rounded-lg hover:bg-slate-100">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <div class="hidden md:block">
                        <h2 class="text-sm font-semibold text-slate-500 uppercase tracking-wider font-outfit">Sistem Pendataan Mahasiswa Miskin</h2>
                    </div>
                </div>
                
                <!-- Right Header Actions (Bell, Avatar) -->
                <div class="flex items-center space-x-3 md:space-x-6">
                    
                    <!-- Bell Notifications Dropdown -->
                    <div class="relative">
                        <button onclick="toggleNotificationDropdown()" class="text-slate-400 hover:text-slate-600 transition-colors relative focus:outline-none flex items-center justify-center">
                            <i class="fa-regular fa-bell text-xl"></i>
                            <?php if ($notif_count > 0): ?>
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-rose-500 text-[10px] font-bold text-white rounded-full flex items-center justify-center animate-pulse">
                                    <?php echo $notif_count; ?>
                                </span>
                            <?php endif; ?>
                        </button>
                        
                        <!-- Popover Notifikasi Bantuan Diproses -->
                        <div id="notif-dropdown" class="hidden fixed md:absolute left-4 right-4 md:left-auto md:right-0 mt-3 md:w-80 bg-white rounded-2xl border-2 border-slate-200 shadow-xl overflow-hidden z-50 transform origin-top-right transition-all duration-200 top-16 md:top-auto">
                            <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                                <h4 class="font-semibold text-slate-800 text-sm">Bantuan Butuh Konfirmasi</h4>
                                <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-bold">
                                    <?php echo $notif_count; ?> Pengajuan
                                </span>
                            </div>
                            <div class="max-h-64 overflow-y-auto divide-y divide-slate-100">
                                <?php if ($notif_count > 0): ?>
                                    <?php foreach ($pending_bantuan as $item): ?>
                                        <div class="p-4 hover:bg-slate-50 transition-colors">
                                            <div class="flex justify-between items-start mb-1">
                                                <span class="text-xs font-semibold text-slate-800"><?php echo htmlspecialchars($item['nama_lengkap']); ?></span>
                                                <span class="text-[10px] bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded font-medium">Diproses</span>
                                            </div>
                                            <p class="text-xs text-slate-500 line-clamp-1 mb-2">Bantuan: <?php echo htmlspecialchars($item['jenis_bantuan']); ?></p>
                                            <div class="flex justify-between text-[10px] text-slate-400">
                                                <span>Tanggal: <?php echo date('d M Y', strtotime($item['tanggal_bantuan'])); ?></span>
                                                <span class="font-semibold text-indigo-600">Rp <?php echo number_format($item['jumlah_bantuan'], 0, ',', '.'); ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="p-8 text-center text-slate-400">
                                        <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="fa-solid fa-circle-check text-2xl text-emerald-500"></i>
                                        </div>
                                        <p class="text-xs">Semua pengajuan bantuan selesai diproses.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="px-4 py-2.5 border-t border-slate-100 text-center bg-slate-50/50">
                                <a href="<?php echo base_url('bantuan'); ?>" class="text-xs text-blue-600 font-semibold hover:text-blue-700">Kelola Semua Bantuan</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Profile Dropdown Container -->
                    <div class="relative">
                        <button onclick="toggleProfileDropdown()" class="flex items-center space-x-3 border-l pl-6 border-slate-100 focus:outline-none text-left">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-semibold text-slate-800 leading-none"><?php echo htmlspecialchars($admin['nama_admin']); ?></p>
                                <span class="text-[10px] text-slate-400 font-medium">@<?php echo htmlspecialchars($admin['username']); ?></span>
                            </div>
                            <img src="<?php echo $foto_profil; ?>" 
                                 alt="Avatar" 
                                 class="w-10 h-10 rounded-full border-2 border-blue-500/20 object-cover shadow-sm">
                        </button>
                        
                        <!-- Dropdown Menu Profil -->
                        <div id="profile-dropdown" class="hidden absolute right-0 mt-3 w-52 bg-white rounded-2xl border-2 border-slate-200 shadow-xl overflow-hidden z-50 transform origin-top-right transition-all duration-200">
                            <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                                <p class="text-xs text-slate-400 font-medium leading-none mb-1">Administrator</p>
                                <p class="text-xs font-semibold text-slate-800 truncate"><?php echo htmlspecialchars($admin['nama_admin']); ?></p>
                            </div>
                            <div class="py-1">
                                <button onclick="openProfileModal()" class="w-full text-left px-4 py-2.5 text-xs text-slate-600 hover:bg-slate-50 hover:text-slate-800 flex items-center space-x-2 transition-colors">
                                    <i class="fa-regular fa-user text-sm text-slate-400"></i>
                                    <span>Edit Profil</span>
                                </button>
                            </div>
                            <div class="border-t border-slate-100 py-1 bg-slate-50/50">
                                <a href="#" onclick="confirmLogout(event)" class="px-4 py-2.5 text-xs text-red-600 hover:bg-red-50 hover:text-red-700 flex items-center space-x-2 transition-colors font-medium">
                                    <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- MODAL EDIT PROFIL ADMIN -->
            <div id="profile-modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
                <div class="bg-white w-full max-w-md rounded-3xl border-2 border-slate-200 shadow-2xl overflow-hidden transform transition-all duration-300">
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 text-base flex items-center space-x-2">
                            <i class="fa-regular fa-user text-blue-600"></i>
                            <span>Edit Profil Administrator</span>
                        </h3>
                        <button onclick="closeProfileModal()" class="text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    
                    <form id="profile-form" action="<?php echo base_url('admin/update_profile'); ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="cropped_foto" id="cropped_foto">
                        
                        <!-- Foto Profil Admin -->
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="<?php echo $foto_profil; ?>" alt="Current Avatar" class="w-16 h-16 rounded-full object-cover border-2 border-blue-500/20 shadow-sm">
                            <div class="flex-1">
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Ubah Foto Profil</label>
                                <input type="file" name="foto_admin" accept="image/gif, image/jpeg, image/png, image/jpg"
                                       class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                                <span class="text-[10px] text-slate-400 mt-1 block">Format: JPG, JPEG, PNG, GIF. Maks: 2MB.</span>
                            </div>
                        </div>

                        <!-- Crop Preview Container -->
                        <div id="crop-area-container" class="hidden border border-slate-200 rounded-2xl p-4 bg-slate-50 space-y-3">
                            <label class="block text-xs font-semibold text-slate-700">Atur Posisi & Potong Foto</label>
                            <div class="overflow-hidden rounded-xl max-h-[240px] bg-slate-200 flex items-center justify-center">
                                <img id="image-to-crop" class="max-w-full h-auto">
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" id="btn-crop-cancel" class="px-3 py-1.5 bg-slate-200 hover:bg-slate-300 rounded-lg text-[11px] font-semibold text-slate-600 transition">
                                    Batal Potong
                                </button>
                                <button type="button" id="btn-crop-confirm" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 rounded-lg text-[11px] font-semibold text-white transition">
                                    Konfirmasi Potongan
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="nama_admin" value="<?php echo htmlspecialchars($admin['nama_admin']); ?>" required
                                   class="w-full px-4 py-2.5 rounded-xl border-2 border-slate-200 text-sm focus:outline-none focus:border-blue-500 transition-colors">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Username</label>
                            <input type="text" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required
                                   class="w-full px-4 py-2.5 rounded-xl border-2 border-slate-200 text-sm focus:outline-none focus:border-blue-500 transition-colors">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password Baru (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" placeholder="••••••••"
                                   class="w-full px-4 py-2.5 rounded-xl border-2 border-slate-200 text-sm focus:outline-none focus:border-blue-500 transition-colors">
                        </div>
                        
                        <div class="pt-4 flex space-x-3">
                            <button type="button" onclick="closeProfileModal()"
                                    class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium py-3 rounded-xl text-sm transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 rounded-xl text-sm shadow-md shadow-blue-500/10 transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Content Container -->
            <main class="flex-1 p-6 md:p-8 max-w-7xl w-full mx-auto">
