<!-- Header -->
<?php require "./layout/header.php" ?>

<!-- Modal update Station-->
<div class="modal fade" id="updateStationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cập nhật thông tin người dùng</h1>
                <button type="button" class="btn ms-auto p-0" data-bs-dismiss="modal" aria-label="Close">
                <a href="?mod=users" class="text-light text-decoration-none btn-close d-block"></a>
                </button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST">
                    <input type="hidden" id="sensor-id" name="sensor_id">
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Họ tên</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="update-recipient-name" 
                            name="fullname" 
                            value="<?php if (!empty($user_info['fullname'])) echo $user_info['fullname'];?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Username</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="update-recipient-name" 
                            name="username"
                            value="<?php if (!empty($user_info['username'])) echo $user_info['username'];?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="station-longtitude" class="col-form-label">Email</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="station-longtitude" 
                            name="email"
                            value="<?php if (!empty($user_info['email'])) echo $user_info['email'];?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Số điện thoại</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="station-langtitude" 
                            name="phone_number"
                            value="<?php if (!empty($user_info['phone_number'])) echo $user_info['phone_number'];?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="station-langtitude" class="col-form-label">Ngày sinh</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="station-langtitude" 
                            name="birthday"
                            value="<?php if (!empty($user_info['birthday'])) echo $user_info['birthday'];?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Giới tính</label>
                        <select class="form-select" name="gender" aria-label="Default select example">
                            <option selected hidden>-- Chọn giới tính --</option>
                            <option value="0" <?php if ($user_info['gender'] == 0) echo "selected" ?> >Nữ</option>
                            <option value="1" <?php if ($user_info['gender'] == 1) echo "selected" ?> >Nam</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="message-text" class="col-form-label">Chọn Quyền</label>
                        <select class="form-select" name="role" aria-label="Default select example">
                        <?php foreach($roles as $item) {
                            ?>
                                <option value="<?php echo $item['id'] ?>" <?php if ($item['id'] == $user_info['role_id']) echo 'selected' ?> ><?php echo $item['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb3 mt-8 d-flex modal-footer">
                        <button type="button" class="btn btn-secondary ms-auto mr-4 p-0" data-bs-dismiss="modal"><a href="?mod=users" class="text-light text-decoration-none d-block p-2">Trở lại</a></button>
                        <button type="submit" class="btn btn-primary ms-2" name="update_user">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Modal JS Script -->
<script type="text/javascript">
    window.onload = () => {
        $('#updateStationModal').modal('show');
    }
</script>

<!-- Footer -->
<?php require "./layout/footer.php" ?>