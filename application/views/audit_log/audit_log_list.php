<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Helper untuk warna badge aksi -->
<?php
function aksi_badge_class($aksi) {
    switch ($aksi) {
        case 'login':          return 'bg-emerald-100 text-emerald-800';
        case 'login_gagal':    return 'bg-rose-100 text-rose-800';
        case 'logout':         return 'bg-slate-100 text-slate-600';
        case 'create':         return 'bg-blue-100 text-blue-800';
        case 'update':         return 'bg-amber-100 text-amber-800';
        case 'update_status':  return 'bg-amber-100 text-amber-800';
        case 'update_profile': return 'bg-amber-100 text-amber-800';
        case 'delete':         return 'bg-rose-100 text-rose-800';
        default:               return 'bg-slate-100 text-slate-600';
    }
}

function aksi_label($aksi) {
    $map = array(
        'login'          => 'Login',
        'login_gagal'    => 'Login Gagal',
        'logout'         => 'Logout',
        'create'         => 'Tambah',
        'update'         => 'Ubah',
        'update_status'  => 'Ubah Status',
        'update_profile' => 'Ubah Profil',
        'delete'         => 'Hapus',
    );
    return isset($map[$aksi]) ? $map[$aksi] : ucfirst($aksi);
}

// Bangun query string untuk link pagination (pertahankan filter)
$qs = array();
if (!empty($filter['modul']))   $qs['modul']   = $filter['modul'];
if (!empty($filter['aksi']))    $qs['aksi']    = $filter['aksi'];
if (!empty($filter['tanggal'])) $qs['tanggal'] = $filter['tanggal'];
$qs_base = http_build_query($qs);
$sep = $qs_base ? '&' : '';
?>

<!-- Page Header -->
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 font-outfit tracking-tight">Log Aktivitas</h1>
        <p class="text-xs text-slate-500 mt-1">Jejak aktivitas admin: login, tambah, ubah, & hapus data</p>
    </div>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
    <!-- Filter Area (auto-submit: realtime saat nilai berubah) -->
    <form method="GET" action="<?php echo base_url('audit_log'); ?>" class="p-6 border-b border-slate-100 bg-slate-50/30 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="flex flex-col sm:flex-row gap-4 md:gap-5 flex-1">
            <select name="modul" onchange="this.form.submit()"
                    class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Modul</option>
                <?php foreach ($modules as $m): ?>
                    <option value="<?php echo htmlspecialchars($m['modul']); ?>" <?php echo ($filter['modul'] === $m['modul']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($m['modul']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="aksi" onchange="this.form.submit()"
                    class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Aksi</option>
                <?php
                $aksi_options = array('login', 'login_gagal', 'logout', 'create', 'update', 'update_status', 'update_profile', 'delete');
                foreach ($aksi_options as $a):
                ?>
                    <option value="<?php echo $a; ?>" <?php echo ($filter['aksi'] === $a) ? 'selected' : ''; ?>>
                        <?php echo aksi_label($a); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="date" name="tanggal" value="<?php echo htmlspecialchars($filter['tanggal']); ?>" onchange="this.form.submit()"
                   class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="flex items-center space-x-2">
            <a href="<?php echo base_url('audit_log'); ?>" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-xs px-4 py-2.5 rounded-xl transition">Reset</a>
        </div>
    </form>

    <!-- Desktop/Tablet Table -->
    <div class="hidden md:block overflow-x-auto bg-slate-50/50 p-6 border-b border-slate-100">
        <table class="w-full text-left text-sm text-slate-600 border-separate border-spacing-y-3" id="auditTable">
            <thead>
                <tr class="text-xs font-bold text-slate-400 uppercase">
                    <th class="pb-1 px-6">Waktu</th>
                    <th class="pb-1 px-4">Admin</th>
                    <th class="pb-1 px-4">Aksi</th>
                    <th class="pb-1 px-4">Modul</th>
                    <th class="pb-1 px-6">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($logs)): ?>
                    <?php foreach ($logs as $l): ?>
                        <tr class="bg-white hover:shadow-md transition-shadow duration-200">
                            <td class="py-4 pl-6 pr-4 border-y border-l border-slate-200 rounded-l-2xl shadow-sm text-xs font-medium text-slate-500 whitespace-nowrap">
                                <?php echo date('d M Y', strtotime($l['created_at'])); ?><br>
                                <span class="text-slate-400"><?php echo date('H:i:s', strtotime($l['created_at'])); ?></span>
                            </td>
                            <td class="py-4 px-4 border-y border-slate-200 shadow-sm">
                                <h4 class="font-bold text-slate-800 tracking-tight leading-snug"><?php echo htmlspecialchars($l['nama_admin'] ?: 'Tidak diketahui'); ?></h4>
                                <p class="text-xs text-slate-400 font-medium">@<?php echo htmlspecialchars($l['username'] ?: '-'); ?></p>
                            </td>
                            <td class="py-4 px-4 border-y border-slate-200 shadow-sm">
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full <?php echo aksi_badge_class($l['aksi']); ?>">
                                    <?php echo aksi_label($l['aksi']); ?>
                                </span>
                            </td>
                            <td class="py-4 px-4 border-y border-slate-200 shadow-sm">
                                <span class="text-xs font-semibold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg"><?php echo htmlspecialchars($l['modul']); ?></span>
                            </td>
                            <td class="py-4 pl-4 pr-6 border-y border-r border-slate-200 rounded-r-2xl shadow-sm text-xs text-slate-600">
                                <?php echo htmlspecialchars($l['deskripsi']); ?>
                                <p class="text-[10px] text-slate-400 mt-1">IP: <?php echo htmlspecialchars($l['ip_address']); ?></p>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400 border border-slate-200 rounded-2xl bg-white shadow-sm">
                            <i class="fa-solid fa-clipboard-list text-4xl mb-3 text-slate-300"></i>
                            <p class="text-xs font-medium">Belum ada aktivitas tercatat.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Mobile Cards -->
    <div class="block md:hidden p-6 bg-slate-50/50 space-y-4">
        <?php if (!empty($logs)): ?>
            <?php foreach ($logs as $l): ?>
                <div class="p-5 bg-white border border-slate-200 rounded-2xl shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h4 class="font-bold text-slate-800 tracking-tight leading-snug"><?php echo htmlspecialchars($l['nama_admin'] ?: 'Tidak diketahui'); ?></h4>
                            <p class="text-xs text-slate-400 font-medium">@<?php echo htmlspecialchars($l['username'] ?: '-'); ?></p>
                        </div>
                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full <?php echo aksi_badge_class($l['aksi']); ?>">
                            <?php echo aksi_label($l['aksi']); ?>
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-xs border-y border-slate-100 py-3 my-3">
                        <div>
                            <span class="text-slate-400 block mb-0.5">Waktu</span>
                            <span class="font-semibold text-slate-700 whitespace-nowrap"><?php echo date('d M Y, H:i', strtotime($l['created_at'])); ?></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5">Modul</span>
                            <span class="font-semibold text-slate-700"><?php echo htmlspecialchars($l['modul']); ?></span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600"><?php echo htmlspecialchars($l['deskripsi']); ?></p>
                    <p class="text-[10px] text-slate-400 mt-2">IP: <?php echo htmlspecialchars($l['ip_address']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="py-12 text-center text-slate-400">
                <i class="fa-solid fa-clipboard-list text-4xl mb-3 text-slate-300"></i>
                <p class="text-xs font-medium">Belum ada aktivitas tercatat.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination Footer -->
    <?php if ($total_pages > 1): ?>
        <div class="px-6 py-4 border-t border-slate-100 bg-white flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-slate-400">
                Menampilkan <?php echo count($logs); ?> dari <?php echo $total; ?> aktivitas &middot;
                Halaman <?php echo $page; ?> / <?php echo $total_pages; ?>
            </p>
            <div class="flex items-center space-x-2">
                <?php if ($page > 1): ?>
                    <a href="<?php echo base_url('audit_log?' . $qs_base . $sep . 'page=' . ($page - 1)); ?>"
                       class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">&larr; Sebelumnya</a>
                <?php endif; ?>
                <?php if ($page < $total_pages): ?>
                    <a href="<?php echo base_url('audit_log?' . $qs_base . $sep . 'page=' . ($page + 1)); ?>"
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold transition">Berikutnya &rarr;</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
