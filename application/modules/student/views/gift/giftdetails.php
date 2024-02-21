<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-flex">
            <div class="page-icon">
            <i class="fas fa-gift"></i>
            </div>
            <div class="page-title align-self-center ml-3">
                <h5>Gift Details</h5>
            </div>
        </div>
    </div>
</div>
</header>
<!-- END: .main-heading -->

<!-- BEGIN .main-content -->
<div class="main-content">
<div class="row same-height-card">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card dataTables_wrapper">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <img class="img-fluid" src="{{giftinfo.image}}" />
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <span class="text-mdm">Gift Name</span>
                    </div>
                    <div class="col-md-7">
                        <h4>{{giftinfo.name}}</h4>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <span class="text-mdm">Gift Code</span>
                    </div>
                    <div class="col-md-7">
                        {{giftinfo.code}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <span class="text-mdm">Brand Name</span>
                    </div>
                    <div class="col-md-7">
                    {{giftinfo.brand}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <span class="text-mdm">Points</span>
                    </div>
                    <div class="col-md-7">
                    {{giftinfo.points}}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-3">
                        <span class="text-mdm">Amount</span>
                    </div>
                    <div class="col-md-7">
                    {{giftinfo.amount}}
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-md-12">
                    {{giftinfo.description}}
                    </div>
                </div>
                
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <a class="btn btn-secondary" href="#!/gifts">Back To List</a>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->