<div class="card">
    <div class="card-header">Generate Report</div>
    <div class="row ml-0 mr-0 pt-3 pb-0">
        <div class="col-md-12 mb-3">
            <a class="btn btn-primary" href="#!/reportParent"><i class="fas fa-user-secret"></i> Parent</a>
            <a class="btn btn-success" href="#!/reportStudent"><i class="fas fa-user-graduate"></i> Student</a>
            <a class="btn btn-info" href="#!/reportTeacher"><i class="fas fa-chalkboard-teacher"></i> Teacher</a>
            <a class="btn btn-dark" href="#!/reportSchool"><i class="fas fa-school"></i> School</a>
            <a class="btn btn-warning" href="#!/reportDriver"><i class="fas fa-car"></i> Driver</a>
            <a class="btn btn-danger" href="#!/reportRevenue"><i class="fas fa-file-invoice-dollar"></i> Revenue</a>
            
        </div>
    </div>
</div>

<div class="card filter-card">
    <div class="card-header"><i class="icon-funnel"></i> Filter</div>
    <div class="row ml-0 mr-0 pt-3 pb-0">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <div class="controls"> 
                    
                    <ui-select multiple ng-model="parent.countryCodes" ng-disabled="parent.countryCodes.disabled" ng-change="getAllSchool(parent.countryCodes)" close-on-select="false" theme="select2" title="Select" style="width:300px;">  
                        <ui-select-match placeholder="Select Country">{{$item.country}}</ui-select-match>
                        <ui-select-choices repeat="cc.id as cc in countryCodes | propsFilter: {country: $select.search}">
                            <div>{{cc.country}} </div>                                         
                        </ui-select-choices>
                    </ui-select>
                 </div>
            </div>
        </div>      
        
        
        
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <div class="controls"> 
                    
                    <ui-select multiple ng-model="parent.schoolLists" ng-disabled="parent.schoolLists.disabled" ng-change="getAllSectionClass(parent.schoolLists)" close-on-select="false" theme="select2" title="Select" style="width:300px;">  
                        <ui-select-match placeholder="Select School">{{$item.school}}</ui-select-match>
                        <ui-select-choices repeat="sc.id as sc in schoolLists | propsFilter: {school: $select.search}">
                            <div>{{sc.school}} </div>                                         
                        </ui-select-choices>
                    </ui-select>
                 </div>
            </div>
        </div>
        
           <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <div class="controls"> 
                    
                    <ui-select multiple ng-model="parent.classSectionList" ng-disabled="parent.schoolList.disabled" close-on-select="false" theme="select2" title="Select" style="width:300px;">  
                        <ui-select-match placeholder="Select Class & Section">{{$item.class}}{{$item.section}}</ui-select-match>
                        <ui-select-choices repeat="lc.id as lc in classSectionList | propsFilter: {class: $select.search}">
                            <div>{{lc.class}} {{lc.section}}</div>                                         
                        </ui-select-choices>
                    </ui-select>
                 </div>
            </div>
        </div>
        
        
        
<!--        <input ng-model="parent.fromdate" id="fromdate" type="hidden" class="form-control"  />
        <input ng-model="parent.todate" id="todate"  type="hidden" class="form-control" />-->
        
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
                <label class="form-label">From Date</label> <input ng-model="parent.fromdate" id="fromdate" type="date" class="form-control"  />
            </div>
             
        </div>
        
         
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="form-group">
               <label class="form-label">To Date</label> <input ng-model="parent.todate" id="todate"  type="date" class="form-control" />
            </div>
             
        </div>
        
        

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <input class="btn btn-primary" type="button" ng-click="getReport(parent)" value="Search">
               
            </div>
        </div>

    </div>
</div>

