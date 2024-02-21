<!-- BEGIN .app-main -->
<style type="text/css">

@import url(https://fonts.googleapis.com/css?family=Lato);

@import url(https://fonts.googleapis.com/css?family=Open Sans);

.faq-heading {
  font-family: Lato;   
  font-weight: 400;
  font-size: 19px;
   -webkit-transition: text-indent 0.2s;
  text-indent: 20px;
  color: #333;
}

.faq-text {
  font-family: Open Sans;   
  font-weight: 400;
  color: #919191;
  width:95%;
  padding-left:20px;
  margin-bottom:30px;
}

.faq {
  width: 1000px;
  margin: 0 auto;
  background: white;
  border-radius: 4px;
  position: relative;
  border: 1px solid #E1E1E1;
}
.faq label {
  display: block;
  position: relative;
  overflow: hidden;
  cursor: pointer;
  height: 56px;
  padding-top:1px;
 
  background-color: #FAFAFA;
  border-bottom: 1px solid #E1E1E1;
}

.faq input[type="checkbox"] {
  display: none;
}

.faq .faq-arrow {
  width: 5px;
  height: 5px;
  transition: -webkit-transform 0.8s;
  transition: transform 0.8s;
  transition: transform 0.8s, -webkit-transform 0.8s;
  -webkit-transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
  border-top: 2px solid rgba(0, 0, 0, 0.33);
  border-right: 2px solid rgba(0, 0, 0, 0.33);
  float: right;
  position: relative;
  top: -30px;
  right: 27px;
  -webkit-transform: rotate(45deg);
          transform: rotate(45deg);
}

 .faq input[type="checkbox"]:checked + label > .faq-arrow {
  transition: -webkit-transform 0.8s;
  transition: transform 0.8s;
  transition: transform 0.8s, -webkit-transform 0.8s;
  -webkit-transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
  -webkit-transform: rotate(135deg);
          transform: rotate(135deg);
}
 .faq input[type="checkbox"]:checked + label {
  display: block;
  background: rgba(255,255,255,255) !important;
  color: #4f7351;
  height: 225px;
  transition: height 0.8s;
  -webkit-transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

 .faq input[type='checkbox']:not(:checked) + label {
  display: block;
  transition: height 0.8s;
  height: 60px;
  -webkit-transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

::-webkit-scrollbar {
  display: none;
}


</style>
<div class="app-main">

	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 d-flex">
					<div class="page-icon">
						<i class="fas fa-comments mt-2"></i>
					</div>
					<div class="page-title ml-3 align-self-center">
						<h5>FAQs</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions mt-2">
					<a href="#!/add-faq" class="btn btn-primary"> <i class="icon-plus2"></i> Add FAQ</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="card">
			<div class="card-body faq_list">
				<div class='faq' ng-repeat="fq in faqData track by $index">
				  <input id='faq-{{$index}}' type='checkbox'>
				  <label for='faq-{{$index}}'>
					<div class="faq-heading">{{$index+1}}.  {{fq.question}}
						<div class="edit_del_btns">
							<a ng-click="faqEdit(fq)" class="edit bg-success" title="Edit"><i class="icon-edit2"></i></a>
							<a ng-click="faqDelete(fq.faq_id)" class="delete bg-danger" title="Delete"><i class="icon-trash"></i></a>
							<div class='faq-arrow'></div>
						</div>
					</div>
					<div class="faq-answer">
						<span class="text-success">Answer:</span> {{fq.answer}}
					</div>
				  </label>
				</div>
			</div>
		</div>
	</div>
		<!-- Modal -->
	  <div class="modal fade custom_modal" id="myModal" role="dialog">
		<div class="modal-dialog">			    
	  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Edit FAQs</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label>Question</label>
						<textarea  ng-model="faqEdit.question" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<label>Answer</label>
						<textarea  ng-model="faqEdit.answer" class="form-control"></textarea>
					</div>
					<div class="form-group mt-3">
						<button ng-click="updateFAQs()" class="btn btn-primary">Update</button>
						<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger">Cancel</a>
					</div>
				</form>
			</div>
		  </div>
		</div>
	   </div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->