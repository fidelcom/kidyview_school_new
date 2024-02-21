<!-- BEGIN .app-main -->
<div class="app-main">
		<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-wallet"></i>
							</div>
							<div class="page-title">
								<h5>Invoice</h5>
							</div>
						</div>
						 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							<!-- <div class="right-actions add-2px d-flex">
									<a href="/" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
							</div> -->
						</div>
					</div>
				</div>
			</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
<div class="main-content" id="printableArea">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center" style="margin-bottom: 40px;margin-top: 20px;">
                                <h2 class="text-uppercase" style="line-height: 1.1;">
                                    <span style="line-height: 1.1;">invoice</span><br>
                                    <span style="line-height: 1.1;">--------</span>
                                </h2>
                            </div>
                            
                            <table width="100%" class="invoice-tbl-head" style="margin-top: 15px;">
                                <tbody><tr>
                                    <td align="right" valign="top">
                                        <table width="100%" class="invoice-tbl-head-inner">
                                            <tbody><tr>
                                                <td align="left" valign="top" style="width:200px">
                                                    <img width="180" src="img/brandlogo.png" alt="brandlogo">
                                                </td>
                                                <td align="left" valign="top">
                                                    <div class="invoice-header">
                                                        <div class="h5">Aljezur International School</div>
                                                        <div class="h6">123, Your Street, City, State, Country, Zip Code </div>
                                                        <div class="sm-text-invoice">
                                                            <div class="contactinfo-no">565-5555-1234</div>
                                                            <div class="school-website-email"><span>Website: kidyview.com</span> | <span>Email: kidyview@example.com</span></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                    <td align="right" valign="top">
                                        <ul>
                                            <li><span>Slip Number:</span> 1121</li>
                                            <li><span>Bill For:</span> First Term</li>
                                            <li><span>Session:</span> 2020-2021</li>
                                            <li><span>Date:</span> 02-03-2021</li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody></table>
                            <table class="table table-striped table-bordered" style="margin-top: 30px;">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Payee</th>
                                        <th>Class</th>
                                        <th>Type</th>
                                        <th>Bank Name</th>
                                        <th>Account Name</th>
                                        <th>Account Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Robert Williams</td>
                                        <td>Mr. Williams</td>
                                        <td>IInd B</td>
                                        <td>School Type</td>
                                        <td>ICICI Bank</td>
                                        <td>Williams</td>
                                        <td>1234567890</td>
                                    </tr>
                                </tbody>
                             </table>

                             <table class="table table-striped" style="margin-top: 50px;">
                                <thead>
                                    <tr>
                                        <th>S. No.</th>
                                        <th>Fee Description</th>
                                        <th class="text-right">Unit Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Tution Fee</td>
                                        <td class="text-right">1000</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Registration Fee</td>
                                        <td class="text-right">1500</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Transportation Fee</td>
                                        <td class="text-right">1800</td>
                                    </tr>
                                    <tr class="footerResult">
                                        <td></td>
                                        <td></td>
                                        <td class="text-right"><span>Gross Total:</span> 4300</td>
                                    </tr>
                                    <tr class="removebg">
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr class="last-tbrow">
                                        <td colspan="3" class="text-right" style="padding-top: 30px !important;">School Stamp</td>
                                    </tr>
                                    
                                </tbody>
                             </table>
                             
                        </div>
                    </div>
                    <div class="text-right mb-3">
                        <button type="button" class="btn btn-primary btn-print" onclick="printDiv('printableArea')">Print</button>
                     </div>
                    <!-- Row end -->
                </div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->
<script type="text/javascript">
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
	}
</script>