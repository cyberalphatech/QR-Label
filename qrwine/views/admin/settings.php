<style>
        .business-card {
            width: 50%;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin: 20px auto;
        }
        .card-header {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .card-url {
            font-size: 14px;
            color: #337ab7;
            word-break: break-all;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            border-radius: 3px;
            box-shadow: none;
            border: 1px solid #ddd;
        }
        .logo-placeholder {
            height: 200px;
            margin-bottom: 15px;
            align-items: center;
            justify-content: center;
            color: #999;
            font-weight: bold;
        }
    </style>
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <h3><?= _l('qr_settings') ?></h3>

                <div class="row">
                    <div class="col-md-12">
                            <div class="business-card">
                            <div class="panel_s">
                            <div class="panel-body">
                            <?php 
                            if(!file_exists($login_path)){
                            echo form_open_multipart(admin_url('qrwine/login'), ['id' => 'staff_login', 'autocomplete' => 'off']); ?>
                            <h4><?= _l('qr_login_litile') ?></h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= _l('qr_email') ?>:</label>
                                        <input type="text"  name="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><?= _l('qr_password') ?>:</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary form-control"><?= _l('qr_login') ?></button>
                                </div>
                            </div>
                            </form>
                            <?php } else{ ?>
                                <h4><?= _l('qr_login_after') ?></h4>
                                <b style="font-weight:bold;font-size:18px;"><?= _l('qr_company_name') ?>: <b style="color:green;"><?= isset($info)?$info->name:"" ?></b></b> 
                                <br>
                                <a href="<?= admin_url('qrwine/logout') ?>" class="btn btn-primary"><?= _l('qr_logout') ?></a>
                            <?php } ?>
                            <hr style=" border: 3px dotted;">
                           
                            
                            <?php echo form_open_multipart(admin_url('qrwine/update_settings'), ['id' => 'staff_profile_table', 'autocomplete' => 'off']); ?>
                            <div class="card-header">
                                <h4 class="text-muted"><?= _l('qr_alise') ?></h4>
                                <p class="card-url">https://digi-card.co/<?php if(!isset($info)){ ?><input required name="label" type="text"><?php }else{ echo $info->{'url-label'}; } ?></p>
                            </div>
                            <div class="form-group">
                                <label><?= _l('qr_type_of_business') ?>:</label>
                                <?php if(!isset($info)){ ?>
                                <input type="radio"  name="type" required value="1" <?= isset($info) && $info->type==1?"checked":"" ?> id="producer"> <label for="producer"><?= _l('qr_producer') ?></label>
                                <input type="radio"  name="type" required value="2" <?= isset($info) && $info->type==2?"checked":"" ?> id="printing" > <label for="printing"><?= _l('qr_printing') ?></label>
                                <input type="radio"  name="type" required value="3" <?= isset($info) && $info->type==3?"checked":"" ?> id="oenology"> <label for="oenology"><?= _l('qr_oenology') ?></label>
                                <?php }else{ 
                                    if($info->type==1){
                                        echo _l('qr_producer');
                                    }
                                    if($info->type==2){
                                        echo _l('qr_printing');
                                    }
                                    if($info->type==3){
                                        echo _l('qr_oenology');
                                    }
                                } ?>
                            </div>
                            
                            <div class="form-group">
                                <label><?= _l('qr_company_name') ?>:</label>
                                <input type="text"  name="name" value="<?= isset($info)?$info->name:"" ?>" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label><?= _l('qr_address') ?>:</label>
                                <input type="text" name="address" value="<?= isset($info)?$info->address:"" ?>" class="form-control" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label><?= _l('qr_city') ?>:</label>
                                        <input type="text" name="city" value="<?= isset($info)?$info->city:"" ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label><?= _l('qr_zip') ?>:</label>
                                        <input type="text"  name="zip" value="<?= isset($info)?$info->zip:"" ?>" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group">
                                        <label><?= _l('qr_state') ?>:</label>
                                        <input type="text"  name="state" value="<?= isset($info)?$info->state:"" ?>" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="logo-placeholder">

                               <?php
                               $image = QRURL.'icon/no-imge.jpg';
                               if(isset($info->Pic1)){
                                   $image =  QRURL.'store/'.$info->Pic1;
                               }
                               ?>
                                    <img width="200px" height="200px" src="<?= $image ?>">
                                    
                                   
                            </div>
                            <div class="alert alert-warning"><?= _l('qr_ssl_warning') ?></div>
                            <div class="form-group">
                                <input type="file" class="" name="file_1" id="file_1" width="100%" 
                                           onchange="preview1Image()" <?= isset($info) && $info->Pic1!=""?"":"required" ?> >
                            </div>
                            <div class="form-group">
                                <label><?= _l('qr_tel') ?>:</label>
                                <input type="text" name="telephone" value="<?= isset($info)?$info->telephone:"" ?>" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label><?= _l('qr_site') ?>:</label>
                                <input type="text"  name="site" value="<?= isset($info)?$info->site:"" ?>" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label><?= _l('qr_email') ?>:</label>
                                <input type="email" name="email" value="<?= isset($info)?$info->{'e-mail'}:"" ?>" class="form-control" required>
                            </div>
                         
                            <div class="form-group">
                                <label><?= _l('qr_password') ?>:</label>
                                <input type="password" name="password" value="<?= isset($info)?$info->password:"" ?>" class="form-control" required>
                            </div>
                            <?php if(!isset($info) || $info->password == ''){ ?>
                             <div class="form-group">
                                <label><?= _l('qr_password_confirm') ?>:</label>
                                <input type="password" name="password_confirm" value="" class="form-control" required>
                            </div>
                            <?php } ?>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><?= _l('qr_save') ?></button>
                            </div>
                        
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>

<script type="text/javascript">
    function preview1Image() {
        const file = document.getElementById('file_1').files;

        if (file.length > 0) {
            document.getElementById('show_image_pic_1').classList.remove("hidden");
            document.getElementById('show_image_pic_1').src = URL.createObjectURL(file[0]);
        } else {
            console.error('Image element not found or no file selected.');
        }
    }
    
       $('#staff_profile_table').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: admin_url + 'qrwine/update_settings',
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: "json",
                headers: {"<?= $this->security->get_csrf_token_name() ?>": "<?= $this->security->get_csrf_hash() ?>"},
                success: function (data) {
                    alert_float(data.alert, data.message);
                    window.location.href=window.location.href;
                }
            });
        });
    
</script>

</body>

</html>
