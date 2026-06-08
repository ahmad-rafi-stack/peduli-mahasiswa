<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Back Link Button -->
<div class="mb-6">
    <a href="<?php echo base_url('mahasiswa'); ?>" class="inline-flex items-center space-x-2 text-slate-500 hover:text-blue-600 transition text-xs font-semibold">
        <i class="fa-solid fa-arrow-left-long"></i>
        <span>Kembali ke Daftar Mahasiswa</span>
    </a>
</div>

<!-- Main Details Layout (2 Columns) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left Column: Quick Profile Info Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 text-center h-fit">
        <div class="relative w-32 h-32 mx-auto mb-4 rounded-3xl overflow-hidden bg-slate-100 border border-slate-200">
            <?php if (!empty($student['foto']) && file_exists('uploads/' . $student['foto'])): ?>
                <img src="<?php echo base_url('uploads/' . $student['foto']); ?>" alt="Foto" class="w-full h-full object-cover">
            <?php else: ?>
                <div class="w-full h-full flex items-center justify-center text-slate-400">
                    <i class="fa-solid fa-user text-5xl"></i>
                </div>
            <?php endif; ?>
        </div>

        <h2 class="text-xl font-bold text-slate-800 font-outfit tracking-tight leading-snug"><?php echo htmlspecialchars($student['nama_lengkap']); ?></h2>
        <p class="text-xs text-slate-400 font-semibold mt-0.5">NIM <?php echo htmlspecialchars($student['nim']); ?></p>

        <!-- Department Badge -->
        <span class="inline-block text-xs font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full mt-3">
            <?php echo htmlspecialchars($student['jurusan']); ?>
        </span>

        <!-- Quick Contacts -->
        <div class="mt-6 border-t border-slate-100 pt-6 space-y-3.5 text-left text-xs">
            <div class="flex items-center space-x-3 text-slate-600">
                <i class="fa-solid fa-phone text-blue-500 w-5 text-center text-sm"></i>
                <span><?php echo htmlspecialchars($student['no_telepon']); ?></span>
            </div>
            <div class="flex items-center space-x-3 text-slate-600">
                <i class="fa-solid fa-graduation-cap text-blue-500 w-5 text-center text-sm"></i>
                <span>Semester <?php echo $student['semester']; ?></span>
            </div>
            <div class="flex items-center space-x-3 text-slate-600">
                <i class="fa-solid fa-venus-mars text-blue-500 w-5 text-center text-sm"></i>
                <span><?php echo htmlspecialchars($student['jenis_kelamin']); ?></span>
            </div>
        </div>

        <!-- Action Edit Button -->
        <button onclick="openEditModal()"
                class="w-full mt-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl shadow-lg shadow-slate-900/10 transition transform active:scale-95 flex items-center justify-center space-x-2">
            <i class="fa-solid fa-user-pen"></i>
            <span>Edit Profil & Data Ekonomi</span>
        </button>
    </div>

    <!-- Right Column: Tabs Detail (Bio, Ekonomi, Bantuan) -->
    <div class="lg:col-span-2 space-y-8">
        
        <!-- Part 1: Biodata & Data Ekonomi -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 text-base font-outfit mb-4 flex items-center space-x-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-circle-info text-blue-600"></i>
                <span>Detail Informasi Keluarga & Ekonomi</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6 text-sm">
                <!-- Row 1: TTL -->
                <div class="border-b border-slate-50 pb-2">
                    <span class="text-xs text-slate-400 block mb-0.5">Tempat, Tanggal Lahir</span>
                    <span class="font-semibold text-slate-700"><?php echo htmlspecialchars($student['tempat_lahir']); ?>, <?php echo date('d F Y', strtotime($student['tanggal_lahir'])); ?></span>
                </div>
                <!-- Row 2: Alamat -->
                <div class="border-b border-slate-50 pb-2">
                    <span class="text-xs text-slate-400 block mb-0.5">Alamat Lengkap</span>
                    <span class="font-semibold text-slate-700"><?php echo htmlspecialchars($student['alamat']); ?></span>
                </div>
                <!-- Row 3: Nama Orang Tua -->
                <div class="border-b border-slate-50 pb-2">
                    <span class="text-xs text-slate-400 block mb-0.5">Nama Orang Tua (Ayah / Ibu)</span>
                    <span class="font-semibold text-slate-700"><?php echo htmlspecialchars($student['nama_ayah']); ?> / <?php echo htmlspecialchars($student['nama_ibu']); ?></span>
                </div>
                <!-- Row 4: Pekerjaan Orang Tua -->
                <div class="border-b border-slate-50 pb-2">
                    <span class="text-xs text-slate-400 block mb-0.5">Pekerjaan Orang Tua (Ayah / Ibu)</span>
                    <span class="font-semibold text-slate-700"><?php echo htmlspecialchars($student['pekerjaan_ayah']); ?> / <?php echo htmlspecialchars($student['pekerjaan_ibu']); ?></span>
                </div>
                <!-- Row 5: Penghasilan Bulanan -->
                <div class="border-b border-slate-50 pb-2">
                    <span class="text-xs text-slate-400 block mb-0.5">Penghasilan Gabungan Bulanan</span>
                    <span class="font-bold text-rose-600 text-base">Rp <?php echo number_format($student['penghasilan_bulanan'], 0, ',', '.'); ?></span>
                </div>
                <!-- Row 6: Tanggungan -->
                <div class="border-b border-slate-50 pb-2">
                    <span class="text-xs text-slate-400 block mb-0.5">Jumlah Tanggungan Anak</span>
                    <span class="font-semibold text-slate-700"><?php echo $student['jumlah_tanggungan']; ?> orang</span>
                </div>
                <!-- Row 7: Status Rumah -->
                <div class="border-b border-slate-50 pb-2">
                    <span class="text-xs text-slate-400 block mb-0.5">Status Kepemilikan Rumah</span>
                    <span class="font-semibold text-slate-700"><?php echo htmlspecialchars($student['status_rumah']); ?></span>
                </div>
                <!-- Row 8: Keterangan -->
                <div class="border-b border-slate-50 pb-2">
                    <span class="text-xs text-slate-400 block mb-0.5">Keterangan Ekonomi Tambahan</span>
                    <span class="text-slate-500 italic"><?php echo !empty($student['ket_ekonomi']) ? htmlspecialchars($student['ket_ekonomi']) : 'Tidak ada keterangan.'; ?></span>
                </div>
            </div>
        </div>

        <!-- Part 2: Riwayat Bantuan Sosial -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 text-base font-outfit mb-4 flex items-center space-x-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-hand-holding-dollar text-blue-600"></i>
                <span>Riwayat Bantuan yang Diterima</span>
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600 border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs font-bold text-slate-400 uppercase bg-slate-50/50">
                            <th class="py-3 px-4">Jenis Bantuan</th>
                            <th class="py-3 px-4">Nominal</th>
                            <th class="py-3 px-4">Tanggal Penyerahan</th>
                            <th class="py-3 px-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (!empty($student['bantuan_history'])): ?>
                            <?php foreach ($student['bantuan_history'] as $bantuan): ?>
                                <tr class="hover:bg-slate-50/30 transition-colors">
                                    <td class="py-4 px-4 font-semibold text-slate-700">
                                        <?php echo htmlspecialchars($bantuan['jenis_bantuan']); ?>
                                    </td>
                                    <td class="py-4 px-4 font-bold text-indigo-600">
                                        Rp <?php echo number_format($bantuan['jumlah_bantuan'], 0, ',', '.'); ?>
                                    </td>
                                    <td class="py-4 px-4 text-xs">
                                        <?php echo date('d M Y', strtotime($bantuan['tanggal_bantuan'])); ?>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="text-[10px] font-bold px-2.5 py-1 rounded-full
                                            <?php 
                                                if ($bantuan['status'] == 'Diterima') echo 'bg-emerald-100 text-emerald-800';
                                                elseif ($bantuan['status'] == 'Ditolak') echo 'bg-rose-100 text-rose-800';
                                                else echo 'bg-amber-100 text-amber-800';
                                            ?>">
                                            <?php echo $bantuan['status']; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-400">
                                    <i class="fa-solid fa-clock-rotate-left text-3xl mb-2 text-slate-300"></i>
                                    <p class="text-xs">Belum ada riwayat penerimaan beasiswa/bantuan.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- MODAL EDIT DATA MAHASISWA & EKONOMI -->
<div id="editModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 overflow-y-auto">
    <div class="bg-white w-full max-w-2xl rounded-3xl border border-slate-200 shadow-2xl overflow-hidden transform transition duration-200 my-8">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="font-bold text-slate-800 text-lg font-outfit flex items-center space-x-2">
                <i class="fa-solid fa-user-pen text-blue-600"></i>
                <span>Edit Profil & Data Ekonomi</span>
            </h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <form action="<?php echo base_url('mahasiswa/update/' . $student['id_mahasiswa']); ?>" method="POST" enctype="multipart/form-data" class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
            
            <!-- SECTION 1: BIODATA MAHASISWA -->
            <div>
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-widest border-b border-slate-100 pb-2 mb-4">1. Biodata Mahasiswa</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nomor Induk Mahasiswa (NIM)</label>
                        <input type="text" value="<?php echo htmlspecialchars($student['nim']); ?>" disabled
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-100 bg-slate-50 text-slate-400 text-sm font-semibold focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="<?php echo htmlspecialchars($student['nama_lengkap']); ?>" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="Laki-laki" <?php echo ($student['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="Perempuan" <?php echo ($student['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="<?php echo htmlspecialchars($student['tempat_lahir']); ?>" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="<?php echo $student['tanggal_lahir']; ?>" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jurusan</label>
                        <select name="jurusan" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="Informatika" <?php echo ($student['jurusan'] == 'Informatika') ? 'selected' : ''; ?>>Informatika</option>
                            <option value="Sistem Informasi" <?php echo ($student['jurusan'] == 'Sistem Informasi') ? 'selected' : ''; ?>>Sistem Informasi</option>
                            <option value="Teknik Komputer" <?php echo ($student['jurusan'] == 'Teknik Komputer') ? 'selected' : ''; ?>>Teknik Komputer</option>
                            <option value="Teknologi Informasi" <?php echo ($student['jurusan'] == 'Teknologi Informasi') ? 'selected' : ''; ?>>Teknologi Informasi</option>
                            <option value="Sains Data" <?php echo ($student['jurusan'] == 'Sains Data') ? 'selected' : ''; ?>>Sains Data</option>
                            <option value="Rekayasa Perangkat Lunak" <?php echo ($student['jurusan'] == 'Rekayasa Perangkat Lunak') ? 'selected' : ''; ?>>Rekayasa Perangkat Lunak</option>
                            <option value="Sistem Komputer" <?php echo ($student['jurusan'] == 'Sistem Komputer') ? 'selected' : ''; ?>>Sistem Komputer</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Semester</label>
                        <input type="number" name="semester" value="<?php echo $student['semester']; ?>" required min="1" max="14"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">No. Telepon / WA</label>
                        <input type="text" name="no_telepon" value="<?php echo htmlspecialchars($student['no_telepon']); ?>" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Ganti Foto Berkas</label>
                        <input type="file" name="foto" accept="image/*"
                               class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:outline-none">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat Tempat Tinggal</label>
                    <textarea name="alamat" required rows="2"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"><?php echo htmlspecialchars($student['alamat']); ?></textarea>
                </div>
            </div>

            <!-- SECTION 2: KONDISI EKONOMI KELUARGA -->
            <div>
                <h4 class="text-xs font-bold text-blue-600 uppercase tracking-widest border-b border-slate-100 pb-2 mb-4">2. Kondisi Ekonomi Keluarga</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Ayah</label>
                        <input type="text" name="nama_ayah" value="<?php echo htmlspecialchars($student['nama_ayah']); ?>" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Ibu</label>
                        <input type="text" name="nama_ibu" value="<?php echo htmlspecialchars($student['nama_ibu']); ?>" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" value="<?php echo htmlspecialchars($student['pekerjaan_ayah']); ?>" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" value="<?php echo htmlspecialchars($student['pekerjaan_ibu']); ?>" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Penghasilan Bulanan Gabungan (Rp)</label>
                        <input type="text" name="penghasilan_bulanan" id="rupiahInput" value="<?php echo number_format($student['penghasilan_bulanan'], 0, ',', '.'); ?>" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition font-semibold text-rose-600">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jumlah Tanggungan Anak</label>
                        <input type="number" name="jumlah_tanggungan" value="<?php echo $student['jumlah_tanggungan']; ?>" required min="1"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status Kepemilikan Rumah</label>
                        <select name="status_rumah" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="Milik Sendiri" <?php echo ($student['status_rumah'] == 'Milik Sendiri') ? 'selected' : ''; ?>>Milik Sendiri</option>
                            <option value="Sewa/Kontrak" <?php echo ($student['status_rumah'] == 'Sewa/Kontrak') ? 'selected' : ''; ?>>Sewa/Kontrak</option>
                            <option value="Menumpang" <?php echo ($student['status_rumah'] == 'Menumpang') ? 'selected' : ''; ?>>Menumpang</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Keterangan Tambahan Ekonomi (Jika Ada)</label>
                    <textarea name="keterangan" rows="2"
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"><?php echo htmlspecialchars($student['ket_ekonomi']); ?></textarea>
                </div>
            </div>

            <!-- Modal Action Buttons -->
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
    // Edit Modal toggles
    function openEditModal() {
        document.getElementById('editModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
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
