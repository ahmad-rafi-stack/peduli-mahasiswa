<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header Welcome -->
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-xl sm:text-2xl font-bold text-slate-800 font-outfit tracking-tight">Data Mahasiswa Kurang Mampu</h1>
        <p class="text-[11px] sm:text-xs text-slate-500 mt-1">
            <span class="sm:hidden">Kelola data perekonomian & profil mahasiswa.</span>
            <span class="hidden sm:inline">Daftar lengkap beserta indikator perekonomian orang tua mahasiswa.</span>
        </p>
    </div>
    <div class="flex">
        <button onclick="openAddModal()" 
                class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold text-xs px-5 py-3.5 rounded-xl shadow-lg shadow-blue-500/10 transition duration-150 transform active:scale-95">
            <i class="fa-solid fa-user-plus text-sm"></i>
            <span>Tambah Mahasiswa Baru</span>
        </button>
    </div>
</div>

<!-- Table Container Card -->
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
    <!-- Search / Filter Area -->
    <div class="p-6 border-b border-slate-100 bg-slate-50/30 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" id="searchInput" onkeyup="filterTable()"
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                   placeholder="Cari berdasarkan NIM, Nama, atau Jurusan...">
        </div>
        <div class="flex items-center space-x-3">
            <select id="filterJurusan" onchange="filterTable()"
                    class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Jurusan</option>
                <option value="Informatika">Informatika</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
                <option value="Teknik Komputer">Teknik Komputer</option>
                <option value="Teknologi Informasi">Teknologi Informasi</option>
                <option value="Sains Data">Sains Data</option>
                <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                <option value="Sistem Komputer">Sistem Komputer</option>
            </select>
        </div>
    </div>

    <!-- Table layout for Desktop and Tablet (md to lg) -->
    <div class="hidden md:block overflow-x-auto bg-slate-50/50 p-6 border-b border-slate-100">
        <table class="w-full text-left text-sm text-slate-600 border-separate border-spacing-y-3" id="mhsTable">
            <thead>
                <tr class="text-xs font-bold text-slate-400 uppercase">
                    <th class="pb-1 px-6">Mahasiswa</th>
                    <th class="pb-1 px-4">Jurusan</th>
                    <th class="pb-1 px-4 text-right">Penghasilan Ortu</th>
                    <th class="pb-1 px-4 text-center">Tanggungan</th>
                    <th class="pb-1 px-4">Kontak</th>
                    <th class="pb-1 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($mahasiswa_list)): ?>
                    <?php foreach ($mahasiswa_list as $mhs): ?>
                        <tr class="bg-white hover:shadow-md transition-shadow duration-200 student-row">
                            <td class="py-4 pl-6 pr-4 border-y border-l border-slate-200 rounded-l-2xl shadow-sm">
                                <div class="flex items-center space-x-3">
                                    <div class="w-11 h-11 rounded-2xl bg-slate-100 overflow-hidden flex-shrink-0 flex items-center justify-center border border-slate-200">
                                        <?php if (!empty($mhs['foto']) && file_exists('uploads/' . $mhs['foto'])): ?>
                                            <img src="<?php echo base_url('uploads/' . $mhs['foto']); ?>" alt="Foto" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <i class="fa-solid fa-user text-slate-400 text-lg"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 tracking-tight leading-snug"><?php echo htmlspecialchars($mhs['nama_lengkap']); ?></h4>
                                        <p class="text-xs text-slate-400 font-medium">NIM <?php echo htmlspecialchars($mhs['nim']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 border-y border-slate-200 shadow-sm">
                                <div class="text-xs font-semibold text-slate-600"><?php echo htmlspecialchars($mhs['jurusan']); ?></div>
                                <div class="text-[10px] text-slate-400 font-medium">Semester <?php echo $mhs['semester']; ?></div>
                            </td>
                            <td class="py-4 px-4 text-right font-semibold text-rose-600 border-y border-slate-200 shadow-sm">
                                Rp <?php echo number_format($mhs['penghasilan_bulanan'], 0, ',', '.'); ?>
                            </td>
                            <td class="py-4 px-4 text-center font-bold text-slate-700 border-y border-slate-200 shadow-sm">
                                <?php echo $mhs['jumlah_tanggungan']; ?> <span class="text-xs font-normal text-slate-400">org</span>
                            </td>
                            <td class="py-4 px-4 text-xs font-medium text-slate-500 border-y border-slate-200 shadow-sm">
                                <?php echo htmlspecialchars($mhs['no_telepon']); ?>
                            </td>
                            <td class="py-4 pl-4 pr-6 text-center border-y border-r border-slate-200 rounded-r-2xl shadow-sm">
                                <div class="flex items-center justify-center space-x-2.5">
                                    <a href="<?php echo base_url('mahasiswa/detail/' . $mhs['id_mahasiswa']); ?>" 
                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition" title="Detail Profil">
                                        <i class="fa-solid fa-eye text-base"></i>
                                    </a>
                                    <button onclick="konfirmasiHapus('<?php echo base_url('mahasiswa/delete/' . $mhs['id_mahasiswa']); ?>', '<?php echo htmlspecialchars($mhs['nama_lengkap']); ?>')" 
                                            class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition" title="Hapus Data">
                                        <i class="fa-solid fa-trash-can text-base"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="empty-db-row">
                        <td colspan="6" class="py-12 text-center text-slate-400 border border-slate-200 rounded-2xl bg-white shadow-sm">
                            <i class="fa-solid fa-folder-open text-4xl mb-3 text-slate-300"></i>
                            <p class="text-xs font-medium">Belum ada data mahasiswa terdaftar.</p>
                        </td>
                    </tr>
                <?php endif; ?>
                <!-- Empty state row for search/filter -->
                <tr class="empty-row bg-white" style="display: none;">
                    <td colspan="6" class="py-12 text-center text-slate-400 border border-slate-200 rounded-2xl shadow-sm">
                        <i class="fa-solid fa-magnifying-glass text-4xl mb-3 text-slate-300"></i>
                        <p class="text-xs font-semibold">Tidak ada data mahasiswa yang cocok dengan pencarian.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Card layout for Mobile Only (< md) -->
    <div class="block md:hidden p-6 bg-slate-50/50 space-y-4" id="mhsCardsContainer">
        <?php if (!empty($mahasiswa_list)): ?>
            <?php foreach ($mahasiswa_list as $mhs): ?>
                <div class="mhs-card p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow transition duration-200">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 overflow-hidden flex-shrink-0 flex items-center justify-center border border-slate-200">
                            <?php if (!empty($mhs['foto']) && file_exists('uploads/' . $mhs['foto'])): ?>
                                <img src="<?php echo base_url('uploads/' . $mhs['foto']); ?>" alt="Foto" class="w-full h-full object-cover">
                            <?php else: ?>
                                <i class="fa-solid fa-user text-slate-400 text-lg"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h4 class="mhs-name font-bold text-slate-800 tracking-tight leading-snug"><?php echo htmlspecialchars($mhs['nama_lengkap']); ?></h4>
                            <p class="mhs-nim text-xs text-slate-400 font-semibold">NIM <?php echo htmlspecialchars($mhs['nim']); ?></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-xs border-y border-slate-100 py-3 my-3">
                        <div>
                            <span class="text-slate-400 block mb-0.5">Jurusan / Sem</span>
                            <span class="mhs-jurusan font-semibold text-slate-700"><?php echo htmlspecialchars($mhs['jurusan']); ?></span>
                            <span class="text-slate-400 font-medium">(Smt <?php echo $mhs['semester']; ?>)</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block mb-0.5">Penghasilan Ortu</span>
                            <span class="font-bold text-rose-600">Rp <?php echo number_format($mhs['penghasilan_bulanan'], 0, ',', '.'); ?></span>
                            <span class="text-[10px] text-slate-400 block font-medium"><?php echo $mhs['jumlah_tanggungan']; ?> tanggungan</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-3">
                        <div class="text-xs text-slate-500 font-medium">
                            <i class="fa-solid fa-phone text-blue-500 mr-1"></i>
                            <?php echo htmlspecialchars($mhs['no_telepon']); ?>
                        </div>
                        <div class="flex space-x-2">
                            <a href="<?php echo base_url('mahasiswa/detail/' . $mhs['id_mahasiswa']); ?>" 
                               class="p-2.5 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-xl transition flex items-center justify-center" title="Detail Profil">
                                <i class="fa-solid fa-eye text-sm"></i>
                            </a>
                            <button onclick="konfirmasiHapus('<?php echo base_url('mahasiswa/delete/' . $mhs['id_mahasiswa']); ?>', '<?php echo htmlspecialchars($mhs['nama_lengkap']); ?>')" 
                                    class="p-2.5 text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-xl transition flex items-center justify-center" title="Hapus Data">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="py-12 text-center text-slate-400 empty-db-card">
                <i class="fa-solid fa-folder-open text-4xl mb-3 text-slate-300"></i>
                <p class="text-xs font-medium">Belum ada data mahasiswa terdaftar.</p>
            </div>
        <?php endif; ?>
        <div id="emptyMobileCard" class="py-12 text-center text-slate-400 bg-white border border-slate-200 rounded-2xl shadow-sm" style="display: none;">
            <i class="fa-solid fa-magnifying-glass text-4xl mb-3 text-slate-300"></i>
            <p class="text-xs font-semibold">Tidak ada data mahasiswa yang cocok dengan pencarian.</p>
        </div>
    </div>

    <!-- Pagination Footer -->
    <div id="mahasiswaPagination" class="px-6 py-4 border-t border-slate-100 bg-white flex flex-col sm:flex-row items-center justify-between gap-3" style="display: none;">
        <!-- Will be populated by JS -->
    </div>
</div>

<!-- MODAL TAMBAH MAHASISWA & EKONOMI -->
<div id="addModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 overflow-y-auto">
    <div class="bg-white w-full max-w-2xl rounded-3xl border border-slate-200 shadow-2xl overflow-hidden transform transition duration-200 my-8">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg font-outfit flex items-center space-x-2">
                <i class="fa-solid fa-user-plus text-blue-600"></i>
                <span>Tambah Mahasiswa Kurang Mampu</span>
            </h3>
            <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form action="<?php echo base_url('mahasiswa/add'); ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            
            <!-- SECTION 1: BIODATA MAHASISWA -->
            <div>
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-widest border-b border-slate-100 pb-2 mb-4">1. Biodata Mahasiswa</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nomor Induk Mahasiswa (NIM)</label>
                        <input type="text" name="nim" required placeholder="Contoh: 24552011"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" required placeholder="Nama lengkap mahasiswa"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" required placeholder="Kota"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jurusan</label>
                        <select name="jurusan" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="Informatika">Informatika</option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Teknik Komputer">Teknik Komputer</option>
                            <option value="Teknologi Informasi">Teknologi Informasi</option>
                            <option value="Sains Data">Sains Data</option>
                            <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                            <option value="Sistem Komputer">Sistem Komputer</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Semester</label>
                        <input type="number" name="semester" required min="1" max="14" placeholder="1"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">No. Telepon / WA</label>
                        <input type="text" name="no_telepon" required placeholder="08xxxxxxxxxx"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Unggah Foto Berkas</label>
                        <input type="file" name="foto" accept="image/*"
                               class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:outline-none">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat Tempat Tinggal</label>
                    <textarea name="alamat" required rows="2" placeholder="Alamat lengkap rumah asal"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"></textarea>
                </div>
            </div>

            <!-- SECTION 2: KONDISI EKONOMI KELUARGA -->
            <div>
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-widest border-b border-slate-100 pb-2 mb-4">2. Kondisi Ekonomi Keluarga</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Ayah</label>
                        <input type="text" name="nama_ayah" required placeholder="Nama lengkap Ayah"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Ibu</label>
                        <input type="text" name="nama_ibu" required placeholder="Nama lengkap Ibu"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" required placeholder="Buruh, Tani, PNS, dll"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" required placeholder="IRT, Buruh, dll"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Penghasilan Bulanan Gabungan (Rp)</label>
                        <input type="text" name="penghasilan_bulanan" id="rupiahInput" required placeholder="0"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition font-semibold text-rose-600">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jumlah Tanggungan Anak</label>
                        <input type="number" name="jumlah_tanggungan" required min="1" placeholder="1"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status Kepemilikan Rumah</label>
                        <select name="status_rumah" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="Milik Sendiri">Milik Sendiri</option>
                            <option value="Sewa/Kontrak">Sewa/Kontrak</option>
                            <option value="Menumpang">Menumpang</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Keterangan Tambahan Ekonomi (Jika Ada)</label>
                    <textarea name="keterangan" rows="2" placeholder="Catatan khusus, misal: Rumah tidak layak huni, dll"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"></textarea>
                </div>
            </div>

            <!-- Modal Action Buttons -->
            <div class="pt-4 flex space-x-3 border-t border-slate-100">
                <button type="button" onclick="closeAddModal()"
                        class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold py-3 rounded-2xl text-xs transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-2xl text-xs shadow-lg shadow-blue-500/10 transition">
                    Simpan Data Mahasiswa
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Javascript table search/filter and currency input formatting -->
<script>
    // Toggles Modal Add
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    let currentPage = 1;
    let itemsPerPage = 5;

    // Dynamic Filter Table (Live Search)
    function filterTable() {
        updatePagination(true);
    }

    function updatePagination(resetPage = false) {
        if (resetPage) {
            currentPage = 1;
        }

        const searchInput = document.getElementById("searchInput");
        const filter = searchInput ? searchInput.value.toUpperCase() : "";
        const select = document.getElementById("filterJurusan");
        const filterJur = select ? select.value.toUpperCase() : "";

        // 1. Process Desktop Rows
        const table = document.getElementById("mhsTable");
        let matchedDesktopRows = [];
        if (table) {
            const trs = table.querySelectorAll("tbody tr.student-row");
            trs.forEach(tr => {
                let tdMhs = tr.getElementsByTagName("td")[0];
                let tdJur = tr.getElementsByTagName("td")[1];
                
                if (tdMhs && tdJur) {
                    let txtMhs = tdMhs.textContent || tdMhs.innerText;
                    let txtJur = tdJur.textContent || tdJur.innerText;
                    
                    let matchesSearch = txtMhs.toUpperCase().indexOf(filter) > -1;
                    let matchesJurusan = filterJur === "" || txtJur.toUpperCase().indexOf(filterJur) > -1;
                    
                    if (matchesSearch && matchesJurusan) {
                        matchedDesktopRows.push(tr);
                    } else {
                        tr.style.display = "none";
                    }
                }
            });

            // Hide desktop empty placeholder if we have matches, otherwise show it
            const emptyRow = table.querySelector("tbody tr.empty-row");
            if (emptyRow) {
                if (matchedDesktopRows.length === 0) {
                    emptyRow.style.display = "";
                } else {
                    emptyRow.style.display = "none";
                }
            }
        }

        // 2. Process Mobile Cards
        const cards = document.querySelectorAll("#mhsCardsContainer .mhs-card");
        let matchedMobileCards = [];
        cards.forEach(card => {
            const nameEl = card.querySelector(".mhs-name");
            const nimEl = card.querySelector(".mhs-nim");
            const jurEl = card.querySelector(".mhs-jurusan");
            
            if (nameEl && nimEl && jurEl) {
                let nameTxt = nameEl.textContent || nameEl.innerText;
                let nimTxt = nimEl.textContent || nimEl.innerText;
                let jurTxt = jurEl.textContent || jurEl.innerText;
                
                let matchesSearch = (nameTxt.toUpperCase().indexOf(filter) > -1) || (nimTxt.toUpperCase().indexOf(filter) > -1);
                let matchesJurusan = filterJur === "" || jurTxt.toUpperCase().indexOf(filterJur) > -1;
                
                if (matchesSearch && matchesJurusan) {
                    matchedMobileCards.push(card);
                } else {
                    card.style.setProperty('display', 'none', 'important');
                }
            }
        });

        // Hide mobile empty placeholder if we have matches, otherwise show it
        const emptyMobile = document.getElementById("emptyMobileCard");
        if (emptyMobile) {
            if (matchedMobileCards.length === 0) {
                emptyMobile.style.display = "";
            } else {
                emptyMobile.style.display = "none";
            }
        }

        // 3. Paginate Desktop
        const totalDesktop = matchedDesktopRows.length;
        const totalDesktopPages = Math.ceil(totalDesktop / itemsPerPage);
        if (currentPage > totalDesktopPages && totalDesktopPages > 0) {
            currentPage = totalDesktopPages;
        }
        
        const startDesktopIdx = (currentPage - 1) * itemsPerPage;
        const endDesktopIdx = startDesktopIdx + itemsPerPage;
        
        matchedDesktopRows.forEach((tr, index) => {
            if (index >= startDesktopIdx && index < endDesktopIdx) {
                tr.style.display = "";
            } else {
                tr.style.display = "none";
            }
        });

        // 4. Paginate Mobile
        const totalMobile = matchedMobileCards.length;
        const totalMobilePages = Math.ceil(totalMobile / itemsPerPage);
        
        const startMobileIdx = (currentPage - 1) * itemsPerPage;
        const endMobileIdx = startMobileIdx + itemsPerPage;
        
        matchedMobileCards.forEach((card, index) => {
            if (index >= startMobileIdx && index < endMobileIdx) {
                card.style.setProperty('display', 'block', 'important');
            } else {
                card.style.setProperty('display', 'none', 'important');
            }
        });

        // 5. Render Pagination Controls
        const paginationContainer = document.getElementById("mahasiswaPagination");
        if (paginationContainer) {
            const totalItems = Math.max(totalDesktop, totalMobile);
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            
            if (totalItems === 0) {
                paginationContainer.style.display = "none";
                return;
            }
            paginationContainer.style.display = "flex";
            
            const fromItem = totalItems > 0 ? startDesktopIdx + 1 : 0;
            const toItem = Math.min(startDesktopIdx + itemsPerPage, totalItems);
            
            let html = `
                <div class="flex flex-col sm:flex-row items-center justify-between w-full gap-4">
                    <div class="flex items-center space-x-4">
                        <p class="text-xs text-slate-500">
                            Menampilkan <span class="font-semibold text-slate-700">${fromItem}</span> - <span class="font-semibold text-slate-700">${toItem}</span> dari <span class="font-semibold text-slate-700">${totalItems}</span> mahasiswa
                        </p>
                        <div class="flex items-center space-x-1.5 bg-slate-50 border border-slate-200/80 rounded-xl px-2 py-1">
                            <span class="text-[10px] font-semibold text-slate-400">Tampilkan:</span>
                            <select onchange="changeItemsPerPage(this.value)" class="bg-transparent border-none text-[10px] font-bold text-slate-600 focus:outline-none cursor-pointer">
                                <option value="5" ${itemsPerPage === 5 ? 'selected' : ''}>5</option>
                                <option value="10" ${itemsPerPage === 10 ? 'selected' : ''}>10</option>
                                <option value="25" ${itemsPerPage === 25 ? 'selected' : ''}>25</option>
                                <option value="50" ${itemsPerPage === 50 ? 'selected' : ''}>50</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center space-x-1">
            `;
            
            // Previous Button
            if (currentPage > 1) {
                html += `
                    <button type="button" onclick="goToPage(${currentPage - 1})" class="p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800 rounded-xl transition flex items-center justify-center" title="Sebelumnya">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                `;
            } else {
                html += `
                    <button type="button" disabled class="p-2 text-slate-300 cursor-not-allowed rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                    </button>
                `;
            }
            
            // Page Numbers
            const maxPageVisible = 5;
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + maxPageVisible - 1);
            if (endPage - startPage + 1 < maxPageVisible) {
                startPage = Math.max(1, endPage - maxPageVisible + 1);
            }
            
            if (startPage > 1) {
                html += `
                    <button type="button" onclick="goToPage(1)" class="w-8 h-8 flex items-center justify-center text-xs font-semibold rounded-xl transition ${currentPage === 1 ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100'}">1</button>
                `;
                if (startPage > 2) {
                    html += `<span class="text-slate-400 text-xs px-1">...</span>`;
                }
            }
            
            for (let p = startPage; p <= endPage; p++) {
                if (p === 1 && startPage > 1) continue; // Skip to avoid duplicate
                html += `
                    <button type="button" onclick="goToPage(${p})" class="w-8 h-8 flex items-center justify-center text-xs font-semibold rounded-xl transition ${currentPage === p ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100'}">${p}</button>
                `;
            }
            
            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    html += `<span class="text-slate-400 text-xs px-1">...</span>`;
                }
                html += `
                    <button type="button" onclick="goToPage(${totalPages})" class="w-8 h-8 flex items-center justify-center text-xs font-semibold rounded-xl transition ${currentPage === totalPages ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-500 hover:bg-slate-100'}">${totalPages}</button>
                `;
            }
            
            // Next Button
            if (currentPage < totalPages) {
                html += `
                    <button type="button" onclick="goToPage(${currentPage + 1})" class="p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800 rounded-xl transition flex items-center justify-center" title="Berikutnya">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                `;
            } else {
                html += `
                    <button type="button" disabled class="p-2 text-slate-300 cursor-not-allowed rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </button>
                `;
            }
            
            html += `
                    </div>
                </div>
            `;
            
            paginationContainer.innerHTML = html;
        }
    }

    function goToPage(page) {
        currentPage = page;
        updatePagination(false);
        // Smooth scroll to top of table
        const tableContainer = document.getElementById("mhsTable");
        if (tableContainer) {
            tableContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function changeItemsPerPage(val) {
        itemsPerPage = parseInt(val);
        updatePagination(true);
    }

    // Initialize pagination on DOM load
    if (document.readyState !== 'loading') {
        updatePagination(true);
    } else {
        document.addEventListener('DOMContentLoaded', function() {
            updatePagination(true);
        });
    }

    // Format Currency Input (Rupiah)
    const rupiah = document.getElementById('rupiahInput');
    if (rupiah) {
        rupiah.addEventListener('keyup', function(e) {
            rupiah.value = formatRupiah(this.value);
        });
    }

    function formatRupiah(angka, prefix) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
