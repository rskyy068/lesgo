@extends('layouts.admin') {{-- Sesuaikan dengan nama layout master admin Anda --}}

@push('style')
<!-- Pastikan Anda memuat Bootstrap 5 & Bootstrap Icons di layout utama -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    :root {
        --lesgo-bg: #EEF6F5;
        --lesgo-primary: #93E1D8;
        --lesgo-secondary: #DDFFF7;
        --lesgo-accent: #FFA69E;
        --lesgo-text: #2F4858;
    }

    body {
        background-color: var(--lesgo-bg);
        color: var(--lesgo-text);
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    /* Card & Container Styles */
    .modern-card {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 8px 30px rgba(47, 72, 88, 0.04);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    /* Buttons */
    .btn-lesgo {
        background-color: var(--lesgo-primary);
        color: var(--lesgo-text);
        border: none;
        border-radius: 12px;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-lesgo:hover {
        background-color: #7BCAC1;
        color: var(--lesgo-text);
        transform: translateY(-2px);
    }
    
    .btn-outline-lesgo {
        background-color: transparent;
        border: 2px solid var(--lesgo-primary);
        color: var(--lesgo-text);
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-outline-lesgo:hover {
        background-color: var(--lesgo-primary);
    }

    /* Tables */
    .table-modern {
        vertical-align: middle;
        margin-bottom: 0;
    }
    .table-modern thead th {
        border-bottom: 2px solid var(--lesgo-bg);
        color: var(--lesgo-text);
        font-weight: 600;
        padding: 1rem;
        background: transparent;
    }
    .table-modern tbody td {
        padding: 1rem;
        border-bottom: 1px solid var(--lesgo-bg);
        color: var(--lesgo-text);
    }
    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }
    .table-modern tbody tr {
        transition: background-color 0.2s ease;
    }
    .table-modern tbody tr:hover {
        background-color: #FAFCFC;
    }

    /* Mini Preview & Live Preview Card */
    .mapel-preview-card {
        width: 100px;
        height: 100px;
        border-radius: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
    }
    .mapel-preview-card:hover {
        transform: translateY(-3px);
    }
    .mapel-preview-card img {
        max-width: 40px;
        max-height: 40px;
        object-fit: contain;
        margin-bottom: 8px;
    }
    .mapel-preview-card span {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--lesgo-text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
    }

    .live-preview-container {
        background: var(--lesgo-bg);
        border-radius: 16px;
        padding: 2rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Drag & Drop Upload */
    .dropzone-area {
        border: 2px dashed var(--lesgo-primary);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        background: #FAFCFC;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .dropzone-area:hover, .dropzone-area.dragover {
        background: var(--lesgo-secondary);
        border-color: var(--lesgo-text);
    }
    .dropzone-icon {
        font-size: 2rem;
        color: var(--lesgo-primary);
        margin-bottom: 10px;
    }

    /* Form Controls */
    .form-control-modern {
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        padding: 0.75rem 1rem;
    }
    .form-control-modern:focus {
        border-color: var(--lesgo-primary);
        box-shadow: 0 0 0 3px var(--lesgo-secondary);
    }
    .form-control-color {
        height: 50px;
        border-radius: 12px;
        padding: 5px;
    }
    
    /* Action Buttons */
    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .btn-edit { background: var(--lesgo-secondary); color: var(--lesgo-text); }
    .btn-edit:hover { background: var(--lesgo-primary); color: white; }
    .btn-delete { background: #FFE5E3; color: #D63333; }
    .btn-delete:hover { background: var(--lesgo-accent); color: white; }

    /* Badge */
    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0" style="background-color: var(--lesgo-secondary); color: var(--lesgo-text); border-radius: 12px;" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger border-0" style="border-radius: 12px;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header & Action -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Manajemen Mata Pelajaran</h3>
        <button type="button" class="btn btn-lesgo" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Mapel
        </button>
    </div>

    <!-- Main Card -->
    <div class="modern-card">
        <!-- Search -->
        <div class="row mb-4">
            <div class="col-md-4">
                <form action="{{ route('admin.mapel.index') }}" method="GET">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-4" style="border-color: #E2E8F0;">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control form-control-modern border-start-0 rounded-end-4" placeholder="Cari mapel..." value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-modern table-hover align-middle">
                <thead>
                    <tr>
                        <th width="120">Preview</th>
                        <th>Nama Mapel</th>
                        <th>Jumlah Bimbel</th>
                        <th>Status</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapels as $mapel)
                    <tr>
                        <td>
                            <div class="mapel-preview-card" style="background-color: {{ $mapel->warna }}">
                                <img src="{{ asset('storage/' . $mapel->icon) }}" alt="{{ $mapel->nama }}">
                                <span>{{ $mapel->nama }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold fs-6">{{ $mapel->nama }}</span>
                        </td>
                        <td>
                            <!-- Contoh data statis, sesuaikan jika ada relasi bimbels_count -->
                            <span class="text-muted">0 Bimbel</span> 
                        </td>
                        <td>
                            @if($mapel->status === 'aktif')
                                <span class="badge badge-modern" style="background: var(--lesgo-secondary); color: var(--lesgo-text);">Aktif</span>
                            @else
                                <span class="badge badge-modern bg-light text-muted">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-icon btn-edit border-0 me-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEdit"
                                data-id="{{ $mapel->id }}"
                                data-nama="{{ $mapel->nama }}"
                                data-warna="{{ $mapel->warna }}"
                                data-icon="{{ asset('storage/' . $mapel->icon) }}"
                                data-status="{{ $mapel->status }}"
                                title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('admin.mapel.destroy', $mapel->id) }}" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-icon btn-delete border-0" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                            Belum ada data Mata Pelajaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL TAMBAH MAPEL -->
<!-- ============================================== -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-bottom-0 pb-0 mt-2 mx-2">
                <h5 class="modal-title fw-bold">Tambah Mapel Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.mapel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Form Inputs -->
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Mapel</label>
                                <input type="text" name="nama" id="addNama" class="form-control form-control-modern" placeholder="Contoh: Matematika" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Warna Background Card</label>
                                <input type="color" name="warna" id="addWarna" class="form-control form-control-color w-100" value="#DDFFF7" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Icon Mapel (PNG, JPG, WebP)</label>
                                <!-- Drag & Drop Area -->
                                <div class="dropzone-area" id="addDropzone">
                                    <i class="bi bi-cloud-arrow-up dropzone-icon"></i>
                                    <p class="mb-0 fw-medium">Drag & Drop icon di sini</p>
                                    <p class="text-muted small mt-1">atau klik untuk memilih file</p>
                                </div>
                                <input type="file" name="icon" id="addIconInput" class="d-none" accept="image/*" required>
                                <div id="addFileName" class="mt-2 small text-success fw-bold text-center d-none">
                                    <i class="bi bi-check-circle"></i> <span class="file-name-text">filename.png</span> terpilih.
                                </div>
                            </div>
                        </div>
                        
                        <!-- Live Preview -->
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Live Preview</label>
                            <div class="live-preview-container h-100 mt-0">
                                <div class="mapel-preview-card" id="addPreviewCard" style="background-color: #DDFFF7; width: 140px; height: 140px; border-radius: 24px;">
                                    <img src="" id="addPreviewImage" alt="" style="display: none; max-width: 60px; max-height: 60px; margin-bottom: 12px;">
                                    <div id="addPreviewPlaceholder" style="width: 60px; height: 60px; border: 2px dashed #B0C4DF; border-radius: 50%; margin-bottom: 12px; display: flex; align-items:center; justify-content:center;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                    <span id="addPreviewText" style="font-size: 0.9rem;">Nama Mapel</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 mx-2 mb-2">
                    <button type="button" class="btn btn-outline-lesgo px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-lesgo px-4">Simpan Mapel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODAL EDIT MAPEL -->
<!-- ============================================== -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-bottom-0 pb-0 mt-2 mx-2">
                <h5 class="modal-title fw-bold">Edit Mapel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEdit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Form Inputs -->
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Mapel</label>
                                <input type="text" name="nama" id="editNama" class="form-control form-control-modern" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Warna Background Card</label>
                                <input type="color" name="warna" id="editWarna" class="form-control form-control-color w-100" required>
                            </div>
                             <div class="mb-3">
                                <label class="form-label fw-semibold">Icon Mapel (PNG, JPG, WebP)</label>
                                <div class="dropzone-area" id="editDropzone">
                                    <i class="bi bi-cloud-arrow-up dropzone-icon"></i>
                                    <p class="mb-0 fw-medium">Drag & Drop icon baru</p>
                                    <p class="text-muted small mt-1">Kosongkan jika tidak ingin mengubah icon</p>
                                </div>
                                <input type="file" name="icon" id="editIconInput" class="d-none" accept="image/*">
                                <div id="editFileName" class="mt-2 small text-success fw-bold text-center d-none">
                                    <i class="bi bi-check-circle"></i> <span class="file-name-text">filename.png</span> terpilih.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" id="editStatus" class="form-select form-control-modern">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Live Preview -->
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Live Preview</label>
                            <div class="live-preview-container h-100 mt-0">
                                <div class="mapel-preview-card" id="editPreviewCard" style="width: 140px; height: 140px; border-radius: 24px;">
                                    <img src="" id="editPreviewImage" alt="" style="max-width: 60px; max-height: 60px; margin-bottom: 12px;">
                                    <span id="editPreviewText" style="font-size: 0.9rem;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0 mx-2 mb-2">
                    <button type="button" class="btn btn-outline-lesgo px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-lesgo px-4">Update Mapel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- COMMON FILE UPLOADER & PREVIEW HELPER ---
    function handleFileUpload(file, imageElement, placeholderElement, fileNameContainer, fileNameText) {
        if (!file.type.startsWith('image/')) {
            Swal.fire({
                icon: 'error',
                title: 'Format Tidak Sesuai',
                text: 'Harap upload file gambar (PNG, JPG, dll.).',
                confirmButtonColor: '#93E1D8'
            });
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            if (imageElement) {
                imageElement.src = e.target.result;
                imageElement.style.display = 'block';
            }
            if (placeholderElement) {
                placeholderElement.style.display = 'none';
            }
            
            if (fileNameText) fileNameText.textContent = file.name;
            if (fileNameContainer) fileNameContainer.classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }

    // ==========================================
    // LOGIKA LIVE PREVIEW & DRAG-DROP (TAMBAH)
    // ==========================================
    const addNama = document.getElementById('addNama');
    const addWarna = document.getElementById('addWarna');
    const addPreviewText = document.getElementById('addPreviewText');
    const addPreviewCard = document.getElementById('addPreviewCard');
    const addDropzone = document.getElementById('addDropzone');
    const addIconInput = document.getElementById('addIconInput');
    const addPreviewImage = document.getElementById('addPreviewImage');
    const addPreviewPlaceholder = document.getElementById('addPreviewPlaceholder');
    const addFileName = document.getElementById('addFileName');
    const addFileNameText = addFileName?.querySelector('.file-name-text');

    if (addNama && addPreviewText) {
        addNama.addEventListener('input', e => {
            addPreviewText.textContent = e.target.value || 'Nama Mapel';
        });
    }
    if (addWarna && addPreviewCard) {
        addWarna.addEventListener('input', e => {
            addPreviewCard.style.backgroundColor = e.target.value;
        });
    }

    if (addDropzone && addIconInput) {
        addDropzone.addEventListener('click', () => addIconInput.click());

        ['dragover', 'dragleave', 'drop'].forEach(evt => {
            addDropzone.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        addDropzone.addEventListener('dragover', () => addDropzone.classList.add('dragover'));
        addDropzone.addEventListener('dragleave', () => addDropzone.classList.remove('dragover'));
        addDropzone.addEventListener('drop', e => {
            addDropzone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                addIconInput.files = e.dataTransfer.files;
                handleFileUpload(addIconInput.files[0], addPreviewImage, addPreviewPlaceholder, addFileName, addFileNameText);
            }
        });

        addIconInput.addEventListener('change', function() {
            if (this.files.length) {
                handleFileUpload(this.files[0], addPreviewImage, addPreviewPlaceholder, addFileName, addFileNameText);
            }
        });
    }

    // ==========================================
    // LOGIKA LIVE PREVIEW & DRAG-DROP (EDIT)
    // ==========================================
    const editNama = document.getElementById('editNama');
    const editWarna = document.getElementById('editWarna');
    const editPreviewText = document.getElementById('editPreviewText');
    const editPreviewCard = document.getElementById('editPreviewCard');
    const editDropzone = document.getElementById('editDropzone');
    const editIconInput = document.getElementById('editIconInput');
    const editPreviewImage = document.getElementById('editPreviewImage');
    const editFileName = document.getElementById('editFileName');
    const editFileNameText = editFileName?.querySelector('.file-name-text');

    if (editNama && editPreviewText) {
        editNama.addEventListener('input', e => {
            editPreviewText.textContent = e.target.value || 'Nama Mapel';
        });
    }
    if (editWarna && editPreviewCard) {
        editWarna.addEventListener('input', e => {
            editPreviewCard.style.backgroundColor = e.target.value;
        });
    }

    if (editDropzone && editIconInput) {
        editDropzone.addEventListener('click', () => editIconInput.click());

        ['dragover', 'dragleave', 'drop'].forEach(evt => {
            editDropzone.addEventListener(evt, e => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        editDropzone.addEventListener('dragover', () => editDropzone.classList.add('dragover'));
        editDropzone.addEventListener('dragleave', () => editDropzone.classList.remove('dragover'));
        editDropzone.addEventListener('drop', e => {
            editDropzone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                editIconInput.files = e.dataTransfer.files;
                handleFileUpload(editIconInput.files[0], editPreviewImage, null, editFileName, editFileNameText);
            }
        });

        editIconInput.addEventListener('change', function() {
            if (this.files.length) {
                handleFileUpload(this.files[0], editPreviewImage, null, editFileName, editFileNameText);
            }
        });
    }

    // ==========================================
    // POPULATE DATA KE MODAL EDIT
    // ==========================================
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const warna = this.getAttribute('data-warna');
            const iconUrl = this.getAttribute('data-icon');
            const status = this.getAttribute('data-status');

            const formEdit = document.getElementById('formEdit');
            if (formEdit) formEdit.action = `/admin/mapel/${id}`;

            if (document.getElementById('editNama')) document.getElementById('editNama').value = nama;
            if (document.getElementById('editWarna')) document.getElementById('editWarna').value = warna;
            if (document.getElementById('editStatus')) document.getElementById('editStatus').value = status;
            
            // Set Preview
            if (editPreviewText) editPreviewText.textContent = nama;
            if (editPreviewCard) editPreviewCard.style.backgroundColor = warna;
            if (editPreviewImage) {
                editPreviewImage.src = iconUrl;
                editPreviewImage.style.display = 'block';
            }

            // Reset File input state
            if (editIconInput) editIconInput.value = '';
            if (editFileName) editFileName.classList.add('d-none');
        });
    });

    // ==========================================
    // SWEETALERT DELETE CONFIRMATION
    // ==========================================
    const deleteForms = document.querySelectorAll('.form-delete');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus Mata Pelajaran?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FFA69E',
                cancelButtonColor: '#2F4858',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

});
</script>
@endpush