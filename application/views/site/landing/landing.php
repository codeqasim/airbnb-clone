<?php $this->load->view('site/templates/header'); ?>
<style>
  table.table-condensed {
  background-color: transparent;
  max-width: 100%;
  float: left;
  width: 100%;
  }
  table.table-condensed td{border-top:1px solid #ccc; border-right: 1px solid #ccc;}
  div.datepicker.datepicker-dropdown.dropdown-menu{padding: 0}
  .datepicker-days{  height: 227px;}
  .datepicker.datepicker-dropdown.dropdown-menu {
  min-height: 179px;
  overflow: hidden !important;
  padding: 4px 0 0 8px;
  width: 220px !important;
  border-radius: 0;
  }
  .datepicker th{font-weight: normal; color: #aaa;}
  .datepicker td, .datepicker th{width: 30px; height: 30px;}
  .datepicker.datepicker-dropdown.dropdown-menu{min-height: 225px;}
  .datepicker tr:first-child th{height: 20px;}
  .datepicker td, .datepicker th {
  height: 30px !important;
  width: 33px !important;
  }
  div.datepicker thead tr:first-child th, div.datepicker tfoot tr:first-child th {
  border-radius: 0;
  cursor: pointer;
  height: 24px !important;
  }
  .table-condensed > thead > tr > th, .table-condensed > tbody > tr > th, .table-condensed > tfoot > tr > th, .table-condensed > thead > tr > td, .table-condensed > tbody > tr > td, .table-condensed > tfoot > tr > td {
  padding: 8.3px 5px !important;
  }
  @media screen (max-width: 567px){
  .datepicker.datepicker-dropdown.dropdown-menu {
  min-height: 200px;
  overflow: hidden !important;
  padding: 4px 0 0 8px;
  width: 226px !important;
  left: 25% !important;
  right: 25% !important;
  }
  }
  @media screen (max-width: 375px){
  .datepicker.datepicker-dropdown.dropdown-menu {
  left: auto !important;
  right: 10px !important;
  }
  }
  header {
  position: absolute;
  z-index: 999;
  }
  .header {
  padding: 7px 0 0 !important;
  transition-duration: 0.3s;
  z-index: 999;
  background:none;
  position: relative;
  border: none;
  }
  .caret{
  border-top: 4px solid #fff;
  }
  .text-center{
  z-index: 99;
  }
  .logo a img {
  float: left;
  margin: -21px 6px 0 0;
  width: 100%;
  }
  .brows-loop{
  margin: 0 0 0 100px;
  }

  .zoomClass {  animation : 100s linear 5s normal none infinite zoominout  }
            @keyframes zoominout{
              0%{  transform:scale(1) }
              25%{ transform:scale(1.5) }
              50%{  transform:scale(2)  }
              75%{  transform:scale(1.5) }
              100%{  transform:scale(1)  }
            }

</style>
<link rel="stylesheet" href="css/site/datepicker.css" type="text/css">

<script typ="text/javascript">
  $.getScript("<?php echo base_url();?>js/site/bootstrap-datepicker.js", function(){







  var startDate = '<?php echo date('m/d/Y');?>';



  var FromEndDate = new Date();



  var ToEndDate = new Date();







  ToEndDate.setDate(ToEndDate.getDate()+365);







  $('.from_date').datepicker({







      weekStart: 1,



      startDate: '<?php echo date('m/d/Y');?>',



      //endDate: FromEndDate,



      autoclose: true



  })



      .on('changeDate', function(selected){



          startDate = new Date(selected.date.valueOf());



          startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));



          $('.to_date').datepicker('setStartDate', startDate);



      });



  $('.to_date')



      .datepicker({







          weekStart: 1,



          startDate: startDate,



          endDate: ToEndDate,



          autoclose: true



      })



      .on('changeDate', function(selected){



          FromEndDate = new Date(selected.date.valueOf());



          FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));



          $('.from_date').datepicker('setEndDate', FromEndDate);



      });























  });



</script>



  <div id="Slider" style="background-color:#000;margin-top:-0px" class="carousel carousel-fade slide" data-ride="carousel">


  <div class="carousel-inner">
        <div class="item active">
      <div class="zoomClass">
        <img class="wow fadeIn animated img-rtl animated" src="<?php echo base_url(); ?>images/bg.jpg" alt="" style="visibility: visible; animation-name: fadeIn;">
      </div>
      <div class="container hidden-xs">
        <div class="carousel-caption" style="padding-bottom: 300px;">
          <div class="row hidden-sm">
            <div class="block-center" >
              <h1 class="text-center" style="font-size: 46px; font-weight:bold; visibility: visible; animation-name: fadeInUp;"><strong>

                <?php
                if($adminList->home_title_1 != ''){
                	echo $adminList->home_title_1;
                }
                else{
                if($this->lang->line('WELCOMEHOME') != '') { echo stripslashes($this->lang->line('WELCOMEHOME')); } else echo "WELCOME HOME";} ?>

              </strong></h1><div class="clearfix"></div>
              <p style="font-size: 26px; visibility: visible; animation-name: flash;" class="text-center">

                <?php
                if($adminList->home_title_2 != ''){
                echo $adminList->home_title_2;
                }
                else{

                if($this->lang->line('Rentuniqueplacestostay') != '') { echo stripslashes($this->lang->line('Rentuniqueplacestostay')); } else echo "Rent unique places to stay"; } ?>


               </p>
            </div>
          </div>
        </div>
      </div>
    </div>
      </div>
</div>
  <div class="clearfix"></div>


<script>

    $(function() {

    /* google places starts */
    google.maps.event.addDomListener(window,"load",function(){new google.maps.places.Autocomplete(document.getElementById("HotelsPlaces"))});
});
</script>

  <div class="hidden-xs">
          <div class="col-md-12">


            <div class="searching-section">
              <div class="container">
                <form method="get" action="property" id="property_search_form"  >
                  <input name="city" id="HotelsPlaces" class="where" placeholder="<?php if($this->lang->line('search_where') != '') { echo stripslashes($this->lang->line('search_where')); } else echo "Where do you want to go?"; ?>"  type="text"  >
                  <input  name="datefrom" class="chek from_date" placeholder="<?php if($this->lang->line('check_in') != '') { echo stripslashes($this->lang->line('check_in')); } else echo "Check in"; ?>" type="text" contenteditable="false">
                  <input  name="dateto" class="chek-in to_date" placeholder="<?php if($this->lang->line('check_out') != '') { echo stripslashes($this->lang->line('check_out')); } else echo "Check out"; ?>" type="text" contenteditable="false">
                  <!--<input name="guests" class="guest" placeholder="Number of guest" type="text">-->
                  <?php if($accommodates !='' && count($accommodates)){
                    ?>
                  <select name="guests" class="home_select">
                    <option value=""><?php if($this->lang->line('guest') != '') { echo stripslashes($this->lang->line('guest')); } else echo "Guest";?></option>
                    <?php foreach($accommodates as $accommodate) {
                      if($accommodate==1){

                      ?>
                    <option value="<?php echo $accommodate;?>"><?php echo $accommodate.' Guest'?></option>
                    <?php } else { ?>
                    <option value="<?php echo $accommodate;?>">
                      <?php echo $accommodate.' Guests';?>
                    </option>
                    <?php } ?>
                    <?php }?>
                  </select>
                  <?php } ?>
                  <input class="fom-subm" value="<?php if($this->lang->line('Submit') != '') { echo stripslashes($this->lang->line('Submit')); } else echo "Submit"; ?>" type="submit" >
                </form>
                <span id="city_warn"></span>
              </div>
            </div>
          </div>
        </div>


<section>

  <div id="push">
  </div>
</section>


<section>
  <div class="center-page">
    <div class="container">
      <div class="top-title-structure">
        <h2 class="find-a-place">
          <?php
            if($adminList->home_title_3 != ''){
            	echo $adminList->home_title_3;
            }
            else{
            if($this->lang->line('ExploretheWorld') != '') { echo stripslashes($this->lang->line('ExploretheWorld')); } else echo "Explore the World"; } ?>
        </h2>
        <span class="discover-place">
        <?php
          if($adminList->home_title_4 != ''){
          	echo $adminList->home_title_4;
          }
          else{
          if($this->lang->line('Seewherepeoplearetraveling') != '') { echo stripslashes($this->lang->line('Seewherepeoplearetraveling')); } else echo "See where people are traveling, all around the world."; } ?>
        </span>
      </div>
      <ul class="hme-container">
        <?php if($CityDetails->result() > 0){
          $i = 1;



          foreach($CityDetails->result() as $CityRows){



          $Cityname=str_replace(' ','+',$CityRows->name);



          ?>
        <li class="col-md-<?php if ($i%10 == 1 || $i%10 == 7)echo "8"; else echo "4"; $i++;?>">
          <a href="property?city=<?php echo $Cityname; ?>">
            <div class="image-container">
              <img src="images/city/<?php echo trim(stripslashes($CityRows->citythumb)); ?>">
            </div>
            <div class="overlay-text">
              <span><?php echo trim(stripslashes($CityRows->name)); ?></span>
            </div>
          </a>
        </li>
        <?php } }?>
      </ul>
    </div>
  </div>
</section>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript">
  $("#property_search_form").validate({



        // Specify the validation rules

        rules: {

            city: "required",



            agree: "required"

        },



        // Specify the validation error messages

        messages: {

  		city: '',

            agree: "Please accept our policy"

        },



        submitHandler: function(form) {

            form.submit();

        }

    });

</script>

<style>
  .buttonBar{opacity:0};
  .main-text {
  color: #fff;
  position: absolute;
  top: 60%;
  width: 99.667%;
  }
</style>
<?php $this->load->view('site/templates/footer'); ?>