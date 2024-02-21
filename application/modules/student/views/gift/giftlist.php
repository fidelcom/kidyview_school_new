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
        <h5>Gifts</h5>
    </div>
</div>
</div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">

<!-- Row start -->

<div class="row same-height-card">

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
<div class="card dataTables_wrapper">
    <div class="card-body">
    <div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-lg-6 col-md-4">
					<form class="">
						<div class="form-group">
							<input type="text" ng-model="search" class="form-control" placeholder="Search">
						</div>
					</form>
				</div>
				<div class="col-lg-6 col-md-8">
					<div class="form-inline form-block form-group float-left float-md-right">
						<label for="search">items per page:</label>
						<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
					</div>
				</div>
			</div>
		</div>
    </div>
        <div class="row">
            <div class="col-md-3 mb-4" dir-paginate="gift in giftData|filter:search|itemsPerPage:pageSize">
                <div class="gift-m-block">
                   <a href="#!gift-details/{{gift.giftID}}"> 
                   <figure class="gift-img">
                        <img class="img-fluid" src="{{gift.image}}" />
                    </figure>
                    <figcaption>
                        <h3>{{gift.name}}</h3>
                        <div class="price"> {{gift.points}} Pt.</div>
                        <div class="company">{{gift.brand}}</div>
                        <div class="company">Gift Code: {{gift.code}}</div>
                    </figcaption>
                    </a>
                </div>
            </div>
            
        </div>
        <dir-pagination-controls max-size="10" class="mb-3 float-left" direction-links="true" boundary-links="true"></dir-pagination-controls>
        <dir-pagination-controls
				max-size="10"
				direction-links="true" class="float-left"
				boundary-links="true"
				template-url="<?php echo base_url();?>asset/js/dirPagination.tpl.html">
				</dir-pagination-controls>
        <div class="clearfix"></div>
    </div>
</div>
</div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->