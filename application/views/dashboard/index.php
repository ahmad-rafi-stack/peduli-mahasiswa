<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Header Welcome Area -->
<div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-slate-800 tracking-tight font-outfit">Dashboard Portal</h1>
        <p class="text-[11px] md:text-sm text-slate-500 mt-1">
            <span class="md:hidden">Selamat datang, <span class="font-semibold text-blue-600"><?php echo htmlspecialchars($admin['nama_admin']); ?></span>. Ringkasan data beasiswa.</span>
            <span class="hidden md:inline">Selamat datang kembali, <span class="font-semibold text-blue-600"><?php echo htmlspecialchars($admin['nama_admin']); ?></span>. Berikut adalah ringkasan pendataan sosial mahasiswa.</span>
        </p>
    </div>
    <div class="self-start md:self-auto flex items-center space-x-3 text-xs bg-white py-2.5 px-4 rounded-xl border border-slate-200 shadow-sm text-slate-500 font-medium">
        <i class="fa-regular fa-calendar-days text-blue-600 text-sm"></i>
        <span>Hari ini: <?php echo date('d M Y'); ?></span>
    </div>
</div>

<!-- Stats Dashboard Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat 1: Total Mahasiswa -->
    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl p-6 text-white shadow-xl shadow-blue-500/10 hover:scale-[1.02] transition duration-200 relative overflow-hidden group">
        <div class="absolute -right-6 -bottom-6 text-white/10 text-9xl group-hover:scale-110 transition duration-300 pointer-events-none">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-semibold text-blue-100 uppercase tracking-wider">Total Mahasiswa</span>
            <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center backdrop-blur-md">
                <i class="fa-solid fa-users text-lg"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold font-outfit tracking-tight"><?php echo number_format($total_mahasiswa, 0, ',', '.'); ?></h3>
        <p class="text-xs text-blue-100 mt-1">Mahasiswa terdaftar</p>
    </div>

    <!-- Stat 2: Total Dana Bantuan -->
    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-6 text-white shadow-xl shadow-emerald-500/10 hover:scale-[1.02] transition duration-200 relative overflow-hidden group">
        <div class="absolute -right-6 -bottom-6 text-white/10 text-9xl group-hover:scale-110 transition duration-300 pointer-events-none">
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-semibold text-emerald-100 uppercase tracking-wider">Total Dana Bantuan</span>
            <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center backdrop-blur-md">
                <i class="fa-solid fa-hand-holding-dollar text-lg"></i>
            </div>
        </div>
        <h3 class="text-2xl font-bold font-outfit tracking-tight">Rp <?php echo number_format($total_dana_bantuan, 0, ',', '.'); ?></h3>
        <p class="text-xs text-emerald-100 mt-1">Telah disalurkan</p>
    </div>

    <!-- Stat 3: Penerima Bantuan -->
    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl p-6 text-white shadow-xl shadow-indigo-500/10 hover:scale-[1.02] transition duration-200 relative overflow-hidden group">
        <div class="absolute -right-6 -bottom-6 text-white/10 text-9xl group-hover:scale-110 transition duration-300 pointer-events-none">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-semibold text-indigo-100 uppercase tracking-wider">Penerima Bantuan</span>
            <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center backdrop-blur-md">
                <i class="fa-solid fa-circle-check text-lg"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold font-outfit tracking-tight"><?php echo number_format($penerima_bantuan_count, 0, ',', '.'); ?></h3>
        <p class="text-xs text-indigo-100 mt-1">Pengajuan diterima</p>
    </div>

    <!-- Stat 4: Antrean Proses -->
    <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-3xl p-6 text-white shadow-xl shadow-amber-500/10 hover:scale-[1.02] transition duration-200 relative overflow-hidden group">
        <div class="absolute -right-6 -bottom-6 text-white/10 text-9xl group-hover:scale-110 transition duration-300 pointer-events-none">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-semibold text-amber-100 uppercase tracking-wider">Menunggu Proses</span>
            <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center backdrop-blur-md">
                <i class="fa-solid fa-spinner text-lg animate-spin-slow"></i>
            </div>
        </div>
        <h3 class="text-3xl font-bold font-outfit tracking-tight"><?php echo number_format($bantuan_pending_count, 0, ',', '.'); ?></h3>
        <p class="text-xs text-amber-100 mt-1">Butuh verifikasi</p>
    </div>
</div>

<!-- Content Grid (2 Columns) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left Column: Poorest Students (Prioritas Pendataan) -->
    <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-slate-800 text-lg font-outfit">Prioritas Pendataan</h3>
                <p class="text-xs text-slate-400 mt-0.5">5 Mahasiswa dengan penghasilan keluarga terendah</p>
            </div>
            <a href="<?php echo base_url('mahasiswa'); ?>" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center space-x-1">
                <span>Semua Mahasiswa</span>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </a>
        </div>

        <!-- Table layout for Desktop and Tablet (md to lg) -->
        <div class="hidden md:block overflow-x-auto bg-slate-50/50 p-4 border border-slate-100 rounded-2xl">
            <table class="w-full text-left text-sm text-slate-600 border-separate border-spacing-y-2.5">
                <thead>
                    <tr class="text-xs font-bold text-slate-400 uppercase">
                        <th class="pb-1 px-6">Mahasiswa</th>
                        <th class="pb-1 px-4">Jurusan</th>
                        <th class="pb-1 px-4 text-right">Penghasilan Ortu</th>
                        <th class="pb-1 px-6 text-center">Tanggungan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($poorest_students)): ?>
                        <?php foreach ($poorest_students as $student): ?>
                            <tr class="bg-white hover:shadow-md transition-shadow duration-200">
                                <td class="py-4 pl-6 pr-4 border-y border-l border-slate-200 rounded-l-2xl shadow-sm">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 flex items-center justify-center border border-slate-200">
                                            <?php if (!empty($student['foto']) && file_exists('uploads/' . $student['foto'])): ?>
                                                <img src="<?php echo base_url('uploads/' . $student['foto']); ?>" alt="Foto" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <i class="fa-solid fa-user text-slate-400"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-slate-800 line-clamp-1"><?php echo htmlspecialchars($student['nama_lengkap']); ?></h4>
                                            <p class="text-xs text-slate-400">NIM <?php echo htmlspecialchars($student['nim']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 border-y border-slate-200 shadow-sm">
                                    <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full"><?php echo htmlspecialchars($student['jurusan']); ?></span>
                                </td>
                                <td class="py-4 px-4 text-right font-semibold text-rose-600 border-y border-slate-200 shadow-sm">
                                    Rp <?php echo number_format($student['penghasilan_bulanan'], 0, ',', '.'); ?>
                                </td>
                                <td class="py-4 pl-4 pr-6 text-center font-bold text-slate-700 border-y border-r border-slate-200 rounded-r-2xl shadow-sm">
                                    <?php echo $student['jumlah_tanggungan']; ?> <span class="text-xs font-medium text-slate-400">orang</span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 border border-slate-200 rounded-2xl bg-white shadow-sm">
                                <i class="fa-solid fa-folder-open text-3xl mb-2 text-slate-300"></i>
                                <p class="text-xs">Belum ada data mahasiswa terdaftar.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Card layout for Mobile Only (< md) -->
        <div class="block md:hidden p-4 bg-slate-50/50 border border-slate-100 rounded-2xl space-y-3">
            <?php if (!empty($poorest_students)): ?>
                <?php foreach ($poorest_students as $student): ?>
                    <div class="bg-white border border-slate-200 rounded-2xl p-4 flex items-center justify-between shadow-sm hover:shadow transition-shadow">
                        <div class="flex items-center space-x-3">
                            <div class="w-11 h-11 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 flex items-center justify-center border border-slate-200">
                                <?php if (!empty($student['foto']) && file_exists('uploads/' . $student['foto'])): ?>
                                    <img src="<?php echo base_url('uploads/' . $student['foto']); ?>" alt="Foto" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <i class="fa-solid fa-user text-slate-400 text-lg"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm tracking-tight leading-snug"><?php echo htmlspecialchars($student['nama_lengkap']); ?></h4>
                                <div class="flex flex-wrap items-center gap-1.5 mt-1">
                                    <span class="text-[10px] font-semibold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md"><?php echo htmlspecialchars($student['jurusan']); ?></span>
                                    <span class="text-[10px] text-slate-400 font-medium">Tanggungan: <?php echo $student['jumlah_tanggungan']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] text-slate-400 font-medium block">Pemasukan Ortu</span>
                            <span class="text-xs font-bold text-rose-600">Rp <?php echo number_format($student['penghasilan_bulanan'], 0, ',', '.'); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="py-8 text-center text-slate-400 border border-dashed border-slate-200 rounded-2xl bg-white shadow-sm">
                    <i class="fa-solid fa-folder-open text-2xl mb-2 text-slate-300"></i>
                    <p class="text-[11px] font-medium">Belum ada data mahasiswa terdaftar.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Column: Recent Bantuan Events (Riwayat Penyaluran Terbaru) -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-slate-800 text-lg font-outfit">Penyaluran Terbaru</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Log bantuan sosial mahasiswa terupdate</p>
                </div>
                <a href="<?php echo base_url('bantuan'); ?>" class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                    <i class="fa-solid fa-sliders text-base"></i>
                </a>
            </div>

            <!-- Timeline -->
            <div class="relative pl-6 border-l-2 border-slate-100 space-y-6">
                <?php if (!empty($recent_bantuan)): ?>
                    <?php foreach ($recent_bantuan as $item): ?>
                        <div class="relative">
                            <!-- Dot -->
                            <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full border-2 border-white flex items-center justify-center shadow-sm 
                                <?php 
                                    if ($item['status'] == 'Diterima') echo 'bg-emerald-500';
                                    elseif ($item['status'] == 'Ditolak') echo 'bg-rose-500';
                                    else echo 'bg-amber-500';
                                ?>">
                            </div>
                            
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-xs font-bold text-slate-800"><?php echo htmlspecialchars($item['nama_lengkap']); ?></h4>
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full
                                        <?php 
                                            if ($item['status'] == 'Diterima') echo 'bg-emerald-100 text-emerald-800';
                                            elseif ($item['status'] == 'Ditolak') echo 'bg-rose-100 text-rose-800';
                                            else echo 'bg-amber-100 text-amber-800';
                                        ?>">
                                        <?php echo $item['status']; ?>
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500"><?php echo htmlspecialchars($item['jenis_bantuan']); ?> - <span class="font-semibold text-blue-600">Rp <?php echo number_format($item['jumlah_bantuan'], 0, ',', '.'); ?></span></p>
                                <span class="text-[9px] text-slate-400 block mt-1"><?php echo date('d M Y', strtotime($item['tanggal_bantuan'])); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="py-12 text-center text-slate-400 -ml-6">
                        <i class="fa-solid fa-clock text-3xl mb-2 text-slate-300"></i>
                        <p class="text-xs">Belum ada riwayat bantuan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="pt-6 border-t border-slate-100 mt-6 text-center">
            <a href="<?php echo base_url('bantuan'); ?>" class="text-xs font-semibold text-blue-600 hover:text-blue-700 inline-flex items-center space-x-1">
                <span>Kelola Semua Log Bantuan</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>
</div>
