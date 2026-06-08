<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Page Header -->
<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 font-outfit tracking-tight">Pencatatan Bantuan Sosial</h1>
        <p class="text-xs text-slate-500 mt-1">Kelola data distribusi dana beasiswa dan bantuan mahasiswa kurang mampu</p>
    </div>
    <button onclick="openAddModal()" 
            class="mt-4 sm:mt-0 inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs px-5 py-3 rounded-xl shadow-lg shadow-blue-500/20 transition duration-150 transform active:scale-95">
        <i class="fa-solid fa-plus text-sm"></i>
        <span>Input Bantuan Baru</span>
    </button>
</div>

<!-- Table Card -->
<div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
    <!-- Search / Filter Area -->
    <div class="p-6 border-b border-slate-100 bg-slate-50/30 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" id="searchInput" onkeyup="filterTable()"
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                   placeholder="Cari penerima, jenis bantuan...">
        </div>
        <div class="flex items-center space-x-3">
            <select id="filterStatus" onchange="filterTable()"
                    class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="Diproses">Diproses</option>
                <option value="Diterima">Diterima</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>
    </div>

    <!-- Table content -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600 border-collapse" id="bantuanTable">
            <thead>
                <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase bg-slate-50/50">
                    <th class="py-4 px-6">Mahasiswa</th>
                    <th class="py-4 px-4">Jenis Bantuan</th>
                    <th class="py-4 px-4 text-right">Nominal</th>
                    <th class="py-4 px-4">Tanggal Terima</th>
                    <th class="py-4 px-4 text-center">Status</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (!empty($bantuan_list)): ?>
                    <?php foreach ($bantuan_list as $item): ?>
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="py-4 px-6">
                                <a href="<?php echo base_url('mahasiswa/detail/' . $item['id_mahasiswa']); ?>" class="hover:text-blue-600 group transition">
                                    <h4 class="font-bold text-slate-800 tracking-tight leading-snug group-hover:text-blue-600"><?php echo htmlspecialchars($item['nama_lengkap']); ?></h4>
                                    <p class="text-xs text-slate-400 font-medium">NIM <?php echo htmlspecialchars($item['nim']); ?></p>
                                </a>
                            </td>
                            <td class="py-4 px-4">
                                <span class="text-xs font-semibold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg">
                                    <?php echo htmlspecialchars($item['jenis_bantuan']); ?>
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right font-bold text-indigo-600">
                                Rp <?php echo number_format($item['jumlah_bantuan'], 0, ',', '.'); ?>
                            </td>
                            <td class="py-4 px-4 text-xs font-medium text-slate-500">
                                <?php echo date('d M Y', strtotime($item['tanggal_bantuan'])); ?>
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full
                                    <?php 
                                        if ($item['status'] == 'Diterima') echo 'bg-emerald-100 text-emerald-800';
                                        elseif ($item['status'] == 'Ditolak') echo 'bg-rose-100 text-rose-800';
                                        else echo 'bg-amber-100 text-amber-800';
                                    ?>">
                                    <?php echo $item['status']; ?>
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center space-x-2.5">
                                    <!-- Quick Actions for pending status -->
                                    <?php if ($item['status'] == 'Diproses'): ?>
                                        <a href="<?php echo base_url('bantuan/update_status/' . $item['id_bantuan'] . '/Diterima'); ?>" 
                                           class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-xl transition" title="Terima Pengajuan">
                                            <i class="fa-solid fa-circle-check text-lg"></i>
                                        </a>
                                        <a href="<?php echo base_url('bantuan/update_status/' . $item['id_bantuan'] . '/Ditolak'); ?>" 
                                           class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition" title="Tolak Pengajuan">
                                            <i class="fa-solid fa-circle-xmark text-lg"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode($item)); ?>)" 
                                            class="p-2 text-slate-500 hover:bg-slate-50 rounded-xl transition" title="Edit Data">
                                        <i class="fa-solid fa-pen-to-square text-base"></i>
                                    </button>
                                    <button onclick="konfirmasiHapus('<?php echo base_url('bantuan/delete/' . $item['id_bantuan']); ?>', 'riwayat bantuan <?php echo htmlspecialchars($item['nama_lengkap']); ?>')" 
                                            class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition" title="Hapus Data">
                                        <i class="fa-solid fa-trash-can text-base"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-clock-rotate-left text-4xl mb-3 text-slate-300"></i>
                            <p class="text-xs font-medium">Belum ada pencatatan bantuan sosial.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL INPUT BANTUAN BARU -->
<div id="addModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-3xl border border-slate-200 shadow-2xl overflow-hidden transform transition duration-200">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg font-outfit flex items-center space-x-2">
                <i class="fa-solid fa-plus text-blue-600"></i>
                <span>Input Bantuan Baru</span>
            </h3>
            <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form action="<?php echo base_url('bantuan/add'); ?>" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Pilih Mahasiswa</label>
                <select name="id_mahasiswa" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    <option value="" disabled selected>-- Pilih Mahasiswa --</option>
                    <?php foreach ($mahasiswa_list as $mhs): ?>
                        <option value="<?php echo $mhs['id_mahasiswa']; ?>">
                            <?php echo htmlspecialchars($mhs['nama_lengkap']); ?> (NIM <?php echo htmlspecialchars($mhs['nim']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Bantuan / Beasiswa</label>
                <input type="text" name="jenis_bantuan" required placeholder="Contoh: KIP Kuliah, Bantuan UKT, dll"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nominal Bantuan (Rp)</label>
                    <input type="text" name="jumlah_bantuan" id="rupiahInput" required placeholder="0"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition font-semibold text-indigo-600">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tanggal Penyerahan</label>
                    <input type="date" name="tanggal_bantuan" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status Awal</label>
                <select name="status" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition font-semibold">
                    <option value="Diproses" class="text-amber-600">Diproses (Menunggu Verifikasi)</option>
                    <option value="Diterima" class="text-emerald-600">Diterima (Langsung Disalurkan)</option>
                    <option value="Ditolak" class="text-rose-600">Ditolak</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Keterangan / Catatan</label>
                <textarea name="keterangan" rows="2" placeholder="Catatan tambahan..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"></textarea>
            </div>

            <div class="pt-4 flex space-x-3 border-t border-slate-100">
                <button type="button" onclick="closeAddModal()"
                        class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold py-3 rounded-2xl text-xs transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-2xl text-xs shadow-lg shadow-blue-500/10 transition">
                    Simpan Data Bantuan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT DATA BANTUAN -->
<div id="editModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-3xl border border-slate-200 shadow-2xl overflow-hidden transform transition duration-200">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg font-outfit flex items-center space-x-2">
                <i class="fa-solid fa-pen-to-square text-blue-600"></i>
                <span>Edit Data Bantuan</span>
            </h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form id="editForm" action="" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Mahasiswa (Tidak Dapat Diubah)</label>
                <input type="text" id="editNamaMhs" disabled 
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-100 bg-slate-50 text-slate-400 text-sm font-semibold focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Bantuan / Beasiswa</label>
                <input type="text" name="jenis_bantuan" id="editJenisBantuan" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nominal Bantuan (Rp)</label>
                    <input type="text" name="jumlah_bantuan" id="editRupiahInput" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition font-semibold text-indigo-600">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tanggal Penyerahan</label>
                    <input type="date" name="tanggal_bantuan" id="editTanggalBantuan" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status Penyaluran</label>
                <select name="status" id="editStatus" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition font-semibold">
                    <option value="Diproses" class="text-amber-600">Diproses</option>
                    <option value="Diterima" class="text-emerald-600">Diterima</option>
                    <option value="Ditolak" class="text-rose-600">Ditolak</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Keterangan / Catatan</label>
                <textarea name="keterangan" id="editKeterangan" rows="2"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition"></textarea>
            </div>

            <div class="pt-4 flex space-x-3 border-t border-slate-100">
                <button type="button" onclick="closeEditModal()"
                        class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold py-3 rounded-2xl text-xs transition">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-2xl text-xs shadow-lg shadow-blue-500/10 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Add Modal Toggles
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Edit Modal Toggles & Populating Data
    function openEditModal(item) {
        document.getElementById('editForm').action = "<?php echo base_url('bantuan/update/'); ?>" + item.id_bantuan;
        document.getElementById('editNamaMhs').value = item.nama_lengkap + " (NIM " + item.nim + ")";
        document.getElementById('editJenisBantuan').value = item.jenis_bantuan;
        document.getElementById('editRupiahInput').value = formatRupiah(item.jumlah_bantuan);
        document.getElementById('editTanggalBantuan').value = item.tanggal_bantuan;
        document.getElementById('editStatus').value = item.status;
        document.getElementById('editKeterangan').value = item.keterangan;

        document.getElementById('editModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Table Filter Search
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toUpperCase();
        const select = document.getElementById("filterStatus");
        const filterSt = select.value.toUpperCase();
        const table = document.getElementById("bantuanTable");
        const tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let tdMhs = tr[i].getElementsByTagName("td")[0];
            let tdJenis = tr[i].getElementsByTagName("td")[1];
            let tdStatus = tr[i].getElementsByTagName("td")[4];
            
            if (tdMhs && tdJenis && tdStatus) {
                let txtMhs = tdMhs.textContent || tdMhs.innerText;
                let txtJenis = tdJenis.textContent || tdJenis.innerText;
                let txtStatus = tdStatus.textContent || tdStatus.innerText;
                
                let matchesSearch = (txtMhs.toUpperCase().indexOf(filter) > -1) || (txtJenis.toUpperCase().indexOf(filter) > -1);
                let matchesStatus = filterSt === "" || txtStatus.toUpperCase().trim() === filterSt;
                
                if (matchesSearch && matchesStatus) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    // Currency Formatting logic
    const rupiah = document.getElementById('rupiahInput');
    if (rupiah) {
        rupiah.addEventListener('keyup', function(e) {
            rupiah.value = formatRupiah(this.value);
        });
    }

    const editRupiah = document.getElementById('editRupiahInput');
    if (editRupiah) {
        editRupiah.addEventListener('keyup', function(e) {
            editRupiah.value = formatRupiah(this.value);
        });
    }

    function formatRupiah(angka, prefix) {
        let number_string = angka.toString().replace(/[^,\d]/g, ''),
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
