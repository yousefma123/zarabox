<?php
    require("../init.php");
    use App\Helpers\Statement;
    $page_title = "لوحة التحكم | الأقسام";
    $page_name = "categories.show";
    $dash = true;
    require( PUBLIC_PATH . '/components/dashboard/header.php' );
    include( PUBLIC_PATH . '/components/dashboard/navbar.php' );
    $statement  = new Statement();
    $categories = new Categories();
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-12 sidebar-container">
                <?php include( PUBLIC_PATH . '/components/dashboard/sidebar.php' ); ?>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="customer-content p-4">
                    <div class="row">
                        
                        <div class="col-md-12 mb-3">
                            <div class="card rounded-4 p-4 h-100">
                                <div class="card-title mb-1 text-center mt-2">
                                    <h5 class="fw-bold card-title-header">أضف موظف الآن</h5>
                                    <p class="text-small text-muted">يرجى مراعاة إدخال الحقول الإجبارية كاملة </p>
                                </div>
                                <?php
                                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['store'])) $categories->store();
                                ?>
                                <div class="card-body p-1 mt-3 add-new-service">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="token" class="form-control" value="<?= $_SESSION['token'] ?>">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="fs-7 fw-bold" for="">اختر الفروع *</label>
                                                <select name="branch" class="form-control bg-ddd rounded-4" required>
                                                    <option data-placeholder="true">اختر الفروع</option>
                                                    <?php 
                                                        $getBranches = $statement->select("*", "`branches`", "fetchAll", "WHERE `status` = 1");
                                                        foreach($getBranches['fetchAll'] as $branch){
                                                    ?>
                                                        <option value="<?= $branch['id'] ?>"><?= $branch['name'] ?></option>
                                                    <?php 
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="fs-7 fw-bold" for="">اختر حالة الموظف *</label>
                                                <select name="manager_status"  class="form-control rounded-4 bg-ddd" required>
                                                    <option value="0" selected>موظف عادي</option>
                                                    <option value="1">مدير فرع</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="fs-7 fw-bold" for="">اختر الهيكل الإداري *</label>
                                                <select name="structure" onchange="_getJobs(this.value)" class="form-control rounded-4 bg-ddd" required>
                                                    <option data-placeholder="true" value="">اختر القسم</option>
                                                    <?php 
                                                        $getStructures = $statement->select("*", "`structures`", "fetchAll", "WHERE `status` = 1");
                                                        foreach($getStructures['fetchAll'] as $structure){
                                                    ?>
                                                        <option value="<?= $structure['id'] ?>"><?= $structure['name'] ?></option>
                                                    <?php 
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-12" id="job" style="display:none;">
                                                <label class="fs-7 fw-bold" for="">اختر الوظيفة *</label>
                                                <select name="job" class="form-control rounded-4 bg-ddd" required>
                                                    <option data-placeholder="true">اختر الوظيفة</option>
                                                </select>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="fs-7 fw-bold" for="">الاسم الأول *</label>
                                                        <input type="text" name="first_name" class="form-control mt-3 rounded-4 bg-ddd" placeholder="اسم الموظف الأول" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="fs-7 fw-bold" for="">الاسم الأوسط</label>
                                                        <input type="text" name="middel_name" class="form-control mt-3 rounded-4 bg-ddd" placeholder="اسم الموظف الأوسط" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="fs-7 fw-bold" for="">الاسم الأخير *</label>
                                                        <input type="text" name="last_name" class="form-control mt-3 rounded-4 bg-ddd" placeholder="اسم الموظف الأخير" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="">رقم الجوال *</label>
                                                        <input type="tel" name="phone" class="form-control mt-3 rounded-4 bg-ddd" placeholder="رقم الجوال" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="">البريد الإلكتروني *</label>
                                                        <input type="email" name="email" class="form-control mt-3 rounded-4 bg-ddd" placeholder="البريد الإلكتروني" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="fs-7 fw-bold" for="">المرتب الأساسي</label>
                                                        <input type="text" name="salary" class="form-control mt-3 rounded-4 bg-ddd" placeholder="المرتب الأساسي" value="0">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="">اسم المكافأة</label>
                                                        <input type="text" name="gift_name" class="form-control mt-3 rounded-4 bg-ddd" placeholder="اسم المكافأة">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="">قيمة المكافأة</label>
                                                        <input type="number" name="gift_value" class="form-control mt-3 rounded-4 bg-ddd" placeholder="قيمة المكافأة">
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <label class="fs-7 fw-bold" for="">البدلات *</label>
                                                        <div class="row align-items-center">
                                                            <div class="col-md-11">
                                                                <div class="row" id="addNewInput">
                                                                    <div class="col-md-6">
                                                                        <select name="allowances_names[]" class="form-control mt-3 rounded-4 bg-ddd">
                                                                            <option value="">اختر نوع البدل</option>
                                                                            <option value="1">بدل سكن</option>
                                                                            <option value="2">بدل انتقال</option>
                                                                            <option value="3">بدل اتصال</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="number" name="allowances_values[]" class="form-control mt-3 rounded-4 bg-ddd" placeholder="قيمة البدل" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="button" class="btn btn-primary rounded-4 w-100 repeated-inputs shadow-sm" onclick="_add_other_inputs()">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="">تاريخ بداية العقد</label>
                                                        <input type="date" name="contract_start_date" class="form-control mt-3 rounded-4 bg-ddd" placeholder="تاريخ بداية العقد">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="">تاريخ نهاية العقد</label>
                                                        <input type="date" name="contract_end_date" class="form-control mt-3 rounded-4 bg-ddd" placeholder="تاريخ نهاية العقد">
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <label for="contract" id="contract_label" class="uploadFileND p-5 text-center w-100 rounded-4">
                                                            <span class="fa fa-cloud-arrow-up mb-3"></span>
                                                            <div class="fw-bold">ملف العقد</div>
                                                        </label>
                                                        <input type="file" id="contract" name="contract" onchange="_upload_files(this, '', '[png, jpg, jpeg, webp, pdf]', '#contract_label')" accept="image/png, image/jpg, image/jpeg, image/webp, aaplication/pdf" class="mt-1 form-control d-none">
                                                        <div class="alert alert-warning rounded-4 shadow-sm mt-3 fs-7"> الملفات المسموح برفعها هي: <br>  (jpeg - webp - png - jpeg - pdf) <br> علما أن حجم الملف يجب أن لا يتجاوز <span class="fw-bold me-1"> 1MB </span></div>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label for="identification" id="identification_label" class="uploadFileND p-5 text-center w-100 rounded-4">
                                                            <span class="fa fa-cloud-arrow-up mb-3"></span>
                                                            <div class="fw-bold">ملف الإقامة - الهوية</div>
                                                        </label>
                                                        <input type="file" id="identification" name="identification" onchange="_upload_files(this, '', '[png, jpg, jpeg, webp, pdf]', '#identification_label')" accept="image/png, image/jpg, image/jpeg, image/webp, aaplication/pdf" class="mt-1 form-control d-none">
                                                        <div class="alert alert-warning rounded-4 shadow-sm mt-3 fs-7"> الملفات المسموح برفعها هي: <br>  (jpeg - webp - png - jpeg - pdf) <br> علما أن حجم الملف يجب أن لا يتجاوز <span class="fw-bold me-1"> 1MB </span></div>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label for="passport" id="passport_label" class="uploadFileND p-5 text-center w-100 rounded-4">
                                                            <span class="fa fa-cloud-arrow-up mb-3"></span>
                                                            <div class="fw-bold">ملف جواز السفر</div>
                                                        </label>
                                                        <input type="file" id="passport" name="passport" onchange="_upload_files(this, '', '[png, jpg, jpeg, webp, pdf]', '#passport_label')" accept="image/png, image/jpg, image/jpeg, image/webp, aaplication/pdf" class="mt-1 form-control d-none">
                                                        <div class="alert alert-warning rounded-4 shadow-sm mt-3 fs-7"> الملفات المسموح برفعها هي: <br>  (jpeg - webp - png - jpeg - pdf) <br> علما أن حجم الملف يجب أن لا يتجاوز <span class="fw-bold me-1"> 1MB </span></div>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label for="certificates" id="certificates_label" class="uploadFileND p-5 text-center w-100 rounded-4">
                                                            <span class="fa fa-cloud-arrow-up mb-3"></span>
                                                            <div class="fw-bold">ملفات الشهادات</div>
                                                        </label>
                                                        <input type="file" id="certificates" name="certificates[]" onchange="_upload_files(this, '', '[png, jpg, jpeg, webp, pdf]', '#certificates_label')" accept="image/png, image/jpg, image/jpeg, image/webp, aaplication/pdf" class="mt-1 form-control d-none" multiple>
                                                        <div class="alert alert-warning rounded-4 shadow-sm mt-3 fs-7"> الملفات المسموح برفعها هي: <br>  (jpeg - webp - png - jpeg - pdf) <br> علما أن حجم الملف يجب أن لا يتجاوز <span class="fw-bold me-1"> 1MB </span></div>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <label for="cv" id="cv_label" class="uploadFileND p-5 text-center w-100 rounded-4">
                                                            <span class="fa fa-cloud-arrow-up mb-3"></span>
                                                            <div class="fw-bold">ملف السيرة الذاتية</div>
                                                        </label>
                                                        <input type="file" id="cv" name="cv" onchange="_upload_files(this, '', '[png, jpg, jpeg, webp, pdf]', '#cv_label')" accept="image/png, image/jpg, image/jpeg, image/webp, aaplication/pdf" class="mt-1 form-control d-none">
                                                        <div class="alert alert-warning rounded-4 shadow-sm mt-3 fs-7"> الملفات المسموح برفعها هي: <br>  (jpeg - webp - png - jpeg - pdf) <br> علما أن حجم الملف يجب أن لا يتجاوز <span class="fw-bold me-1"> 1MB </span></div>
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <label for="other_files" id="other_files_label" class="uploadFileND p-5 text-center w-100 rounded-4">
                                                            <span class="fa fa-cloud-arrow-up mb-3"></span>
                                                            <div class="fw-bold">ملفات أخرى كحد أقصى ٣ ملفات</div>
                                                        </label>
                                                        <input type="file" id="other_files" name="other_files[]" onchange="_upload_files(this, '', '[png, jpg, jpeg, webp, pdf]', '#other_files_label')" accept="image/png, image/jpg, image/jpeg, image/webp, aaplication/pdf" class="mt-1 form-control d-none" multiple>
                                                        <div class="alert alert-warning rounded-4 shadow-sm mt-3 fs-7"> الملفات المسموح برفعها هي: <br>  (jpeg - webp - png - jpeg - pdf) <br> علما أن حجم الملف يجب أن لا يتجاوز <span class="fw-bold me-1"> 1MB </span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <button type="submit" name="addNewEmployee" class="btn btn-default w-100 rounded-pill p-3 btn-bg-system fw-bold shadow-sm">أضف الموظف</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


<?php 
    include( PUBLIC_PATH . '/components/dashboard/footer.php' );
?>