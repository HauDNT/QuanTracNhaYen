<!-- Header -->
<?php require "./layout/header.php" ?>

<!-- Modal add user -->
<div class="modal fade" id="addUserModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thêm người dùng</h1>
                <button type="button" class="btn ms-auto p-0" data-bs-dismiss="modal" aria-label="Close">
                <a href="?mod=users" class="text-light text-decoration-none btn-close d-block"></a>
                </button>
            </div>
            
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST" action="?mod=users&action=addUser">
                    <input type="hidden" id="sensor-id" name="sensor_id">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Họ tên</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="update-recipient-name" 
                            name="fullname"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Username</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="update-recipient-name" 
                            name="username" 
                        >
                    </div>
                    <div class="mb-3">
                        <label for="station-longtitude" class="col-form-label">Email</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="station-longtitude" 
                            name="email"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Số điện thoại</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="station-langtitude" 
                            name="phone_number"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Ngày sinh</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="station-langtitude" 
                            name="birthday"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Giới tính</label>
                        <select class="form-select" name="gender" aria-label="Default select example">
                            <option selected hidden>-- Chọn giới tính --</option>
                            <option value="0">Nữ</option>
                            <option value="1">Nam</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Chọn Quyền</label>
                        <select class="form-select" name="role" aria-label="Default select example">
                        <option selected hidden>-- Chọn quyền --</option>
                            <?php foreach($roles as $item) {
                                echo $item;
                            ?>
                                <option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Mật khẩu</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="station-langtitude" 
                            name="password" 
                        >
                    </div>
                    
                    <div class="mb3 mt-8 d-flex modal-footer">
                        <button type="button" class="btn btn-secondary ms-auto mr-4 p-0" data-bs-dismiss="modal"><a href="?mod=users" class="text-light text-decoration-none d-block p-2">Trở lại</a></button>
                        <button type="submit" class="btn btn-primary ms-2" name="add_user">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Modal JS Script -->
<script type="text/javascript">
    window.onload = () => {
        $('#addUserModal').modal('show');
    }
</script>

<!-- Footer -->
<?php require "./layout/footer.php" ?>