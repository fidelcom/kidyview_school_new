<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-flex">
    <div class="page-icon">
    <i class="icon-user-tie"></i>
    </div>
    <div class="page-title ml-3 align-self-center">
        <h5>Exam</h5>
    </div>
</div>
</div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
<div class="card">
<div class="card-header mb-3">
<div class="row">
    <div class="col-md-8">
        <h4 class="mb-0 mt-1">{{examinfo.name}}</h4>
    </div>
    <div class="col-md-4 text-left text-md-right">
    {{examinfo.exam_status}}
    </div>
    
</div>
</div>
<div class="card-body small-font">
<div class="row">
<!--<div class="col-md-4 mb-3">
        <span class="text-mdm mr-2">Exam Code:</span>{{examinfo.exam_code}}
    </div>-->
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Class:</span>{{examinfo.classname}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Subject:</span> {{examinfo.subject}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Exam Duration:</span> {{examinfo.examduration}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Exam Session:</span> {{examinfo.session}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Exam Mode:</span> {{examinfo.exam_mode}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Exam Type:</span> {{examinfo.exam_type}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Exam Category:</span> {{examinfo.exam_category}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm mr-2">Exam Date:</span> {{(examinfo.exam_date|myDate)+' '+examinfo.exam_time}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Exam Date:</span> {{(examinfo.exam_date|myDate)+' '+examinfo.exam_time}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Total Marks:</span> {{examinfo.total_marks}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Total Questions:</span> {{examinfo.total_question}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Attempt Allowed:</span> {{examinfo.exam_attempt_no}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Last Submission Date:</span> {{examinfo.last_submission_date|myDate}}
    </div>
    <div class="col-md-6 mb-3">
        <span class="text-mdm text-mdm-h mr-2">Instruction:</span> {{examinfo.exam_instruction}}
    </div>
</div>
</div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->