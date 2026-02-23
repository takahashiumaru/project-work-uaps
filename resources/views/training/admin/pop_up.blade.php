<div class="modal fade" id="certModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Sertifikat</h5>
      </div>
      <div class="modal-body">
        <form id="certForm" method="POST" action="{{ route('training.certificate.save') }}">
          @csrf
          <input type="hidden" name="user_id" id="user_id">
          <input type="hidden"  name="field" id="field">

          <div class="form-group">
            <label>Tanggal Registered</label>
            <input type="date" name="registered" id="registered" class="form-control">
          </div>

          <div class="form-group">
            <label>Tanggal Expired</label>
            <input type="date" name="expired" id="expired" class="form-control">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".cert-cell").forEach(cell => {
        cell.addEventListener("click", function() {
            const userId = this.dataset.user;
            const field = this.dataset.field;
            const registered = this.dataset.registered;
            const expired = this.dataset.expired;

            document.getElementById("user_id").value = userId;
            document.getElementById("field").value = field;
            document.getElementById("registered").value = registered || '';
            document.getElementById("expired").value = expired || '';

            const title = document.querySelector("#certModal .modal-title");
            title.textContent = 'Detail Sertifikat ' + field
                .replace(/_/g, ' ')
                .replace(/\b\w/g, l => l.toUpperCase());

            $("#certModal").modal("show");
        });
    });
});
</script>
