<section class = "storepage">
   <h1 class = 'title'><?= $game_info[0]?> - Rating: <?= $rating?></h1>

   <div class="slideshow-container" id = "slideshow">
      <a class="prev" onclick="change_slide(-1)">&#10094;</a>
      <a class="next" onclick="change_slide(1)">&#10095;</a>
   </div>

   <h3 class = 'description'><?= $game_info[3]?></h3>

   <a id = "upload" href="<?php echo base_url(); ?>upload/images/<?php echo $game_info[1]?>"> Upload Images for this game</a>

   <section id = 'reviews'>
   </section>

   <div id = "reviewed"> </div>
   <div class="col-4 offset-4" id = "add_review">
      <?php echo form_open(base_url().'store/add_review/'.$game_info[1]); ?>
         <h2 class="text-center">Review <?=$game_info[0]?> </h2>       
            <div class="form-group">
               <label for="rating">Rating</label>
               <input type="number" id="rating" name="rating" min="0" max="10">   
            </div>
            <div class="form-group">
               <label for="review">Review...</label>
               <textarea id="review" name="review" rows="8" cols="80"> </textarea>
            </div>
            <div class="form-group">
               <button type="submit" class="btn btn-primary btn-block">Submit Review</button>
            </div>   
      <?php echo form_close(); ?>
   </div>
</section>

<script>
var currentSlide = 0;
review_handler();
create_slideshow();
setInterval(auto_slide, 3000);

   function create_slideshow() {
      var images = <?php echo json_encode($images); ?>;
      for (i = 0; i < images.length; i++) {
         var html = "<div class = slide> <img src =" + images[i] + "></div>";
         document.getElementById("slideshow").innerHTML += html;
      }
      change_slide(0);  
   }

   function auto_slide() {
      change_slide(1);
   }

   function change_slide(n) {
      var slideArray = document.getElementsByClassName("slide");
      var nextSlide = currentSlide + n;
      if (nextSlide == slideArray.length) {
         nextSlide = 0;
      }
      if (nextSlide < 0) {
         nextSlide = slideArray.length - 1;
      }
      for (i = 0; i < slideArray.length; i++) {
         slideArray[i].style.display = "none";
      }
      currentSlide = nextSlide;
      slideArray[nextSlide].style.display = "block";
}


   function review_handler() {
      var reviews = <?php echo json_encode($reviews); ?>;
      var user = <?php echo json_encode($user_status); ?>;
      console.log(user);
      reviews.forEach(display_reviews);
      if (!user) {
         hide();
      } else {
         show();
      }
   }

   function display_reviews(item, index) {
      var html = "<div class = review><h1> Rating " + item[1] + " out of 10</h1><h2> Review by: " + item[0] + "</h2><p>" + item[2] + "</p></div>";
      document.getElementById("reviews").innerHTML += html;
   }

   function hide() {
      document.getElementById("upload").style.display="none";
      document.getElementById("add_review").style.display="none";
   }

   function show() {
      var user_review = <?php echo json_encode($has_reviewed); ?>;
      document.getElementById("upload").style.display="inline-block";  
      console.log(user_review); 
      if (user_review == false) {
         document.getElementById("add_review").style.display="block";  
      } else {
         document.getElementById("add_review").style.display="none";
         document.getElementById("reviewed").innerHTML = "<h2> Sorry, you cannot review a game more than once and you have already reviewed this game! </h2>";
      } 
   }
</script>

<style>

#upload {
   margin-top: 2%;
   background-color: #4CAF50; 
   border: none;
   color: white;
   padding: 1em 2em;
   text-align: center;
   display: inline-block;
   font-size: 2em;
}

.review {
   border-style: solid;
   width: 50%;
   margin: auto;
   margin-top: 1%;
   padding: 1%;
}

.storepage {
  text-align: center;
}

#reviews {
   padding: 5%;
}

.slide img {
   height: 35vw;
   max-width: 65vw;
}

.title {
   text-align: center;
   font-size: 4em;
   margin: 1%;

}

.description {
   margin: 5%;
   text-align: center;
   font-size: 2em;
}


* {box-sizing:border-box}

/* Slideshow container */
.slideshow-container {
  position: relative;
  margin: auto;
}

/* Hide the images by default */
.slide {
  display: none;
}

.prev, .next {
  cursor: pointer;
  position: absolute;
  width: 2vw;
  top: 50%;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

.prev {
   left: 10%;

}

.next {
  right: 10%;
  border-radius: 3px 0 0 3px;
}

.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}

</style>