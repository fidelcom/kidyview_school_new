



            <!--Slider section--> 

            <div class="home_banner"> 

                <div id="myCarousel" class="carousel slide" data-ride="carousel" style="visibility: visible; animation-name: fadeInUp;">

                    <ol class="carousel-indicators">

                        <?php

                        $i=0;

                        foreach($home_slider as $slider)

                        {?>

                         <li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i==0)?'active':''; ?>"></li>

                        <?php

                        $i++;

                        }

                        ?>

                        

                    </ol>  

                    <!-- Wrapper for slides -->  

                    <div class="carousel-inner" role="listbox">

                        <?php

                        $i=0;

                        foreach($home_slider as $slider)

                        {?>

                         <div class="item <?php echo ($i==0)?'active':''; ?>"> <img src="<?php echo base_url() ?>data/images/<?php echo $slider->image?>" alt="jacket" width="100%" height="100%">

                            <div class="carousel-caption wow animated fadeInLeft delay-05s animated" >

                                <h3><?php echo $slider->title?></h3>

                                <p><?php echo $slider->description?></p>

                                <p><a href="<?php echo $slider->button_link?>"><?php echo $slider->button_text?></a></p>

                            </div>

                        </div>

                        <?php

                        $i++;

                        }

                        ?>

                       

                        

                    </div>  

                    <!-- Left and right controls -->   

                    <a class="left carousel-control carou1" href="<?php base_url() ?>data/#myCarousel" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control carou1" href="<?php base_url() ?>data/#myCarousel" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>

                </div>

            </div> 



            <div class="our_services">

                <ul>

				<?php foreach($home_section1 as $homesection1) {?>

				  <li class="wow animated fadeInLeft delay-02s animated"><a href="<?php echo $homesection1->link?>"><img src="<?php echo base_url().'data/images/'.$homesection1->icon?>" alt="icon"/><br> <?php echo $homesection1->image_text?></a></li>

                 <?php } ?>  

				 </ul>

                <div class="clr"></div>

            </div>

            <!-- Body Container -->

            <div class="body_container">

                <div class="container">

                    <div class="row">

                        <div class="about_section">

                <?php foreach($home_section2 as $homesection2) {?>

				<h1><?php echo $homesection2->title?></h1>

                            <p><?php echo $homesection2->sectiontext?></p>

                            <?php echo $homesection2->sectioncontent?> 

				 <?php } ?>

							

							

                        </div>

                    </div>

                </div>

                <?php /* ?>

					<div class="manag_wrapper">

                    <div class="container">

                        <div class="row">

				<?php foreach($home_section3 as $homesection3) {?>

				 

                            <div class="col-md-6 manag_left">

                                <img src="<?php  echo base_url() ?>data/images/<?php echo $homesection3->image?>" alt="image"/>

                            </div>

                            <div class="col-md-6 manag_right">

                                <h3><?php echo $homesection3->title?></h3>

                                <?php echo $homesection3->sectioncontent ?>

                            </div>

							<?php } ?>

                            <div class="clr"></div>

                        </div>	

                    </div>

                </div>

				

                <div class="container">

                    <div class="row">

                        <div class="manag_wrapper_2">

                            <div class="col-md-7 manag_right">

                              <?php foreach($home_section4 as $homesection4) {?>  

								<?php  echo $homesection4->title ?>

                                <form action="" method="get">

                                   <a class="sub_btn" href="<?php echo base_url(); ?>signup" value="Get STarted"></a>

                                </form>

								<!--form action="" method="get">

                                    <input name="" placeholder="Email Address" type="text" /><input class="sub_btn" name="" type="button" value="Get STarted" />

                                </form-->

                                <?php  echo $homesection4->sectioncontent ?>

							  <?php } ?>

							</div>

                            <div class="col-md-5 manag_left">

                                <img src="<?php base_url() ?>data/images/team_leader_pic.png" alt="image"/>

                            </div>

                            <div class="clr"></div>

                        </div>

                    </div>

                </div> <?php */ ?>

               <!-- <div class="manag_wrapper">

                    <div class="container">

                        <div class="row">

							<?php //foreach($home_section5 as $homesection5) {?> 

                            <div class="col-md-6 manag_left">

                                <img src="<?php //echo base_url().'data/images/'. $homesection5->image ?>" alt="image"/>

                            </div>

                            <div class="col-md-6 manag_right">

                                <h3><?php //echo $homesection5->title ?></h3>

                               <?php //echo $homesection5->sectioncontent ?>

                            </div>

                            <div class="clr"></div>

							<?php //} ?>

						</div>	

                    </div>

                </div>-->

                <div class="teams_leagues_wrapper">

                    <div class="container">

                        <div class="row team_txt_wp">

						<?php foreach($home_section6 as $homesection6) {?> 

                            <?php echo $homesection6->sectioncontent ?>

                            <a href="<?php echo $homesection6->downloadlink ?>">Download <span>on the App Store</span></a>

                        <?php } ?>

						</div>

                    </div>

                </div>

                <!-- Testimonials -->



                <!--<div class="testimonial_wrap">

                    <h2>Implants Testimonials</h2>

                    <p class="title_txt">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>        			

                    <div id="testimonial4" class="carousel slide testimonial4_indicators testimonial4_control_button thumb_scroll_x swipe_x" data-ride="carousel" data-pause="hover" data-interval="5000" data-duration="2000">

                       

                       <ol class="carousel-indicators">

                        <?php /*

                        $i=0;

                        foreach($testimonials as $testimonial)

                        {?>

                         <li data-target="#myCarousel" data-slide-to="<?php$i?>" class="<?php echo ($i==0)?'active':''; ?>"></li>

                        <?php

                        $i++;

                        }

                        ?></ol>

                        <div class="carousel-inner" role="listbox">		

                            <?php

                        $i=0;

                        foreach($testimonials as $testimonial)

                        {?>

                         <div class="item <?php echo ($i==0)?'active':''; ?>">

                            <div class="testimonial4_slide">

                               <?php$testimonial->description?>

								 <h6><?php$testimonial->title?> <span><?php$testimonial->information?></span></h6>

                            </div>

                        </div>

                        <?php

                        $i++;

                        } */

                        ?>

						</div>		

                    </div>

                </div>-->

  <div class="container">				

				<div class="row contact_wp">

      <div class="col-md-7">

	<?php $attributes = array("name" => "contact","class" => "form-horizontal");

          echo form_open("", $attributes); ?>

<fieldset>

<h3>Contact Us Today!</h3>

<div class="form-group">

  <div class="col-md-6 inputGroupContainer">

  <div class="input-group">

  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

  <input name="first_name" placeholder="First Name" class="form-control" type="text" value="<?php echo set_value('first_name'); ?>">

    </div>

	<span class="text-danger"><?php echo form_error('first_name'); ?></span>

  </div>

   <div class="col-md-6 inputGroupContainer">

    <div class="input-group">

  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

  <input name="last_name" placeholder="Last Name" class="form-control" type="text" value="<?php echo set_value('last_name'); ?>">

	</div>

  </div>

</div>



<!-- Text input-->

       <div class="form-group"> 

    <div class="col-md-6 inputGroupContainer">

    <div class="input-group">

        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>

  <input name="email" placeholder="E-Mail Address" class="form-control" type="text" value="<?php echo set_value('email'); ?>">

	</div>

	<span class="text-danger"><?php echo form_error('email'); ?></span>

  </div>

    <div class="col-md-6 inputGroupContainer">

    <div class="input-group">

        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>

  <input name="phone_number" placeholder="(845)555-1212" class="form-control" type="text" value="<?php echo set_value('phone_number'); ?>">

    </div>

	<span class="text-danger"><?php echo form_error('phone_number'); ?></span>

  </div>

</div>  

<div class="form-group">

    <div class="col-md-6 inputGroupContainer">

    <div class="input-group">

        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>

  <input name="address" placeholder="Address" class="form-control" type="text" value="<?php echo set_value('address'); ?>">

    </div>

  </div>

    <div class="col-md-6 inputGroupContainer">

    <div class="input-group">

        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>

  <input name="city" placeholder="city" class="form-control" type="text" value="<?php echo set_value('city'); ?>">

    </div>

  </div>

</div>

<div class="form-group"> 

    <div class="col-md-6 selectContainer">

    <div class="input-group">

        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>

    <select name="state" class="form-control selectpicker" value="<?php echo set_value('state'); ?>">

      <option value=" ">Please select your state</option>

      <option>Alabama</option>

      <option>Alaska</option>

      <option>Arizona</option>

      <option>Arkansas</option>

      <option>California</option>

      <option>Colorado</option>

      <option>Connecticut</option>

      <option>Delaware</option>

      <option>District of Columbia</option>

      <option> Florida</option>

      <option>Georgia</option>

      <option>Hawaii</option>

      <option>daho</option>

      <option>Illinois</option>

      <option>Indiana</option>

      <option>Iowa</option>

      <option> Kansas</option>

      <option>Kentucky</option>

      <option>Louisiana</option>

      <option>Maine</option>

      <option>Maryland</option>

      <option> Mass</option>

      <option>Michigan</option>

      <option>Minnesota</option>

      <option>Mississippi</option>

      <option>Missouri</option>

      <option>Montana</option>

      <option>Nebraska</option>

      <option>Nevada</option>

      <option>New Hampshire</option>

      <option>New Jersey</option>

      <option>New Mexico</option>

      <option>New York</option>

      <option>North Carolina</option>

      <option>North Dakota</option>

      <option>Ohio</option>

      <option>Oklahoma</option>

      <option>Oregon</option>

      <option>Pennsylvania</option>

      <option>Rhode Island</option>

      <option>South Carolina</option>

      <option>South Dakota</option>

      <option>Tennessee</option>

      <option>Texas</option>

      <option> Uttah</option>

      <option>Vermont</option>

      <option>Virginia</option>

      <option>Washington</option>

      <option>West Virginia</option>

      <option>Wisconsin</option>

      <option>Wyoming</option>

    </select>

  </div>

</div>

    <div class="col-md-6 inputGroupContainer">

    <div class="input-group">

        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>

  <input name="zip_code" placeholder="Zip Code" class="form-control" type="text" value="<?php echo set_value('zip_code'); ?>">

    </div>

</div>

</div>

<div class="form-group">

    <div class="col-md-12 inputGroupContainer">

    <div class="input-group">

        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>

        	<textarea class="form-control" name="description" placeholder="Description" value="<?php echo set_value('description'); ?>"></textarea>

    </div>

	<span class="text-danger"><?php echo form_error('description'); ?></span>

  </div>

  </div>

  <div class="g-recaptcha" data-sitekey="6LfjjIEUAAAAAMVaXlvbG5VVGbboG9lmJRKbgBvT"></div>

  <?php echo form_error('g-recaptcha-response','<div style="color:#a94442;">','</div>').'<br>'; ?>

  <div class="input-group">

  

  

    <button type="submit" name="btnContact" value="submit" class="btn btn-warning">Send <span class="glyphicon glyphicon-send"></span></button>

</div>

</fieldset>

<?php echo form_close(); 

 echo $this->session->flashdata('emailmsg').'<br>';

 echo $this->session->flashdata('msg'); ?>

</div>

<div class="col-md-5 address_sec">

<h3 style="padding-top: 30px;"></h3>

<div class="col-md-1"><span class="glyphicon glyphicon-envelope"></span></div>

<div class="col-md-11"><a href="mailto:help@amistos.com">help@amistos.com</a></div>

<?php //echo $page_detail_contact->description; ?>

</div>

	</div>

            </div>

            </div>