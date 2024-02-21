<!-- BEGIN .app-main -->
<div class="app-main">
   <!-- BEGIN .main-heading -->
   <header class="main-heading">
      <div class="container-fluid">
         <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 d-flex">
               <div class="page-icon">
                  <i class="icon-laptop_windows"></i>
               </div>
               <div class="page-title align-self-center ml-3">
                  <h5>Submitted Exam List</h5>
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
              <!-- <div class="card-header">
                  <div class="row">
                     <div class="col-md-3 col-sm-6">
                        <div class="form-group mb-3 mb-md-0">
                           <label>Search</label>
                           <div class="srch-group">
                              <input type="text" class="form-control" />
                              <button type="submit" class="btn btn-primary"><i class="icon-search"></i></button>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-6">
                        <div class="form-group mb-3 mb-md-0">
                           <label>Subject</label>
                           <select class="form-control">
                              <option value="">Select Subject</option>
                              <option value="sub1">English</option>
                              <option value="sub2">Computer Science</option>
                              <option value="sub1">Zoology</option>
                              <option value="sub1">Botany</option>
                              <option value="sub1">Mathematics</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-6">
                        <div class="form-group mb-3 mb-md-0">
                           <label>Class</label>
                           <select class="form-control">
                              <option value="">Select Class</option>
                              <option value="cls1">1st A</option>
                              <option value="cls2">1st B</option>
                              <option value="cls3">2nd A</option>
                              <option value="cls4">2nd B</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3 col-sm-6">
                        <div class="form-group mb-1">
                           <label>Status</label>
                           <select class="form-control">
                              <option value="">Select Status</option>
                              <option value="sts1">Not started</option>
                              <option value="sts2">Ongoing</option>
                              <option value="sts3">Submitted</option>
                              <option value="sts4">Graded</option>
                           </select>
                        </div>
                     </div>
                  </div>
               </div>-->
               <div class="card-body small-font">
                  <div class="table-responsive white-space-nowrap">
                     <table datatable="ng" class="table table-striped table-bordered white-space-nowrap">
                        <thead>
                           <tr>
                              <th>S.No.</th>
                              <th>Exam Name</th>
                              <th>Exam Mode</th>
                              <th>Exam Category</th>
                              <th>Exam Date</th>
                              <th>Exam Duration</th>
                              <th>Student Name</th>
                              <th>Class</th>
                              <th>Subject</th>
                              <!--<th>Attempts Allowed</th>-->
                              <th>Submitted Date</th>
                              <th class="text-right">Exam Status</th>
                              <!--<th>Status</th>-->
                              <th class="text-right">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr ng-repeat="exam in examData">
                              <td>{{$index+1}}</td>
                              <td>{{exam.name}}</td>
                              <td>{{exam.exam_mode}}</td>
                              <td>{{exam.exam_category}}</td>
                              <td>{{(exam.exam_date|myDate)+' '+exam.exam_time}}</td>
                              <td>{{exam.examduration}}</td>
                              <td>{{exam.studentname}}</td>
                              <td>{{exam.classname}}</td>
                              <td>{{exam.subject}}</td>
                              <!--<td>{{exam.exam_attempt_no}}</td>-->
                              <td>{{exam.submitted_date}}</td>
                              <td><span class="text-green">{{exam.exam_status}}</span></td>
                              <!--<td>{{exam.exam_status}}</td>-->
                              <td class="action text-right">
                                 <a href="#!submitted-exam-details/{{exam.examID}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>
                              </td>
                           </tr>
                        </tbody>
                     </table>
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