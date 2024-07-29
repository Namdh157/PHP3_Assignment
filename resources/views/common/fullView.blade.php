<div class="modal fade" id="full-view-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog my-0 d-flex align-items-center h-100" style="width: max-content; max-width: 90vw">
        <div class="modal-content">
            <img src="" alt="" class="object-fit-contain rounded" style="max-width: 90vw; max-height: 90vh; width: fit-content; height:fit-content;">
        </div>
    </div>
</div>
<script>
    function showFullViewImage(imageUrl) {
        document.querySelector('#full-view-modal img').src = imageUrl;
        const modal = new bootstrap.Modal(document.getElementById('full-view-modal'), {
            keyboard: false
        });
        modal.show();
    }
</script>