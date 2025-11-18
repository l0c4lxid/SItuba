{{-- SIgap Form snippet --}}
<form {{ $attributes->merge(['class' => 'row g-3']) }}>
  @csrf
  <div class="col-12 col-md-6">
    <label class="form-label">Nama Pasien</label>
    <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
  </div>
  <div class="col-12 col-md-6">
    <label class="form-label">NIK / ID</label>
    <input type="text" name="id_number" class="form-control" placeholder="Nomor identitas">
  </div>
  <div class="col-12">
    <label class="form-label">Riwayat Gejala</label>
    <textarea name="symptoms" class="form-control" rows="3" placeholder="Deskripsi singkat"></textarea>
  </div>
  <div class="col-12 d-flex gap-2 justify-content-end">
    <button type="submit" class="btn btn-si-primary">Simpan</button>
    <button type="reset" class="btn btn-outline-si">Reset</button>
  </div>
</form>
