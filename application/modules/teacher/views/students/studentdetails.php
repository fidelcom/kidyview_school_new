<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 align-self-center">
                <div class="page-icon">
            <a href="#!/student-list">	<i class="icon-arrow-back"></i></a>
                </div>
                <div class="page-title">
                    <h5>Student Detail</h5>
                </div>
            </div>
            
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
    <div class="card">
        <div class="card-body">
            <div class="row">
    
                <div class="col-md-12 col-sm-12">
                    <div class="mn_box mt-0 w-100">
                        <div>
                            <div class="childeren_bx w-100">
                            
                                <ul>
                                    <li><strong> Student Name:</strong> {{studentinfo.childname}}</li>
                                    <li><strong> Class Name:</strong> {{studentinfo.classname}}</li>
                                    <li><strong>Hobby:</strong> {{studentinfo.hobie?studentinfo.hobie:'N/A'}}</li>
                                    <li><strong> Father's Name:</strong> {{studentinfo.parentData.fname}}</li>
                                    <li><strong> Father's Email:</strong> {{studentinfo.parentData.fatheremail}}</li>
                                    <li class="mt-3">
                                        <a href="#!/conversation/{{chatUserID}}" class="btn-primary btn btn-md">
                                            <i class="icon-eye2"></i> Send message
                                        </a>
                                    </li>	
                                </ul>
                                <div class="profileimg">
                                    <img src="<?php echo base_url();?>img/child/{{studentinfo.childphoto}}" alt="User profile" />
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
        
                                <a class="btn btn-secondary" href="#!/student-list">Back To List</a>
                     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->