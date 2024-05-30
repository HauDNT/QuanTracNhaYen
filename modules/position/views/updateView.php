<!-- Header -->
<?php require "./layout/header.php"; ?>

<!-- Modal update Position-->
<div class="modal fade" id="updatePositionModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cập nhật Tầng</h1>
                <button type="button" class="btn ms-auto" data-bs-dismiss="modal" aria-label="Close">
                    <a href="?mod=position" class="text-light text-decoration-none btn-close"></a>
                </button>
            </div>
            <form action="?mod=position&action=updatePosition&id=<?php echo $position_update['id'] ?> >" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="update-position" class="col-form-label">Sửa Tầng</label>
                        <input type="text" class="form-control" id="update-position" name="Position" value="<?php echo $position_update['Position']; ?>" placeholder="Nhập tầng">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <a href="?mod=position" class="text-light text-decoration-none">Trở lại</a>
                    </button>
                    <button type="submit" class="btn btn-primary" name="update_position">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal JS Script -->
<script type="text/javascript">
    window.onload = () => {
        $('#updatePositionModal').modal('show');
    }
</script>

<!-- Footer -->
<?php require "./layout/footer.php"; ?>
